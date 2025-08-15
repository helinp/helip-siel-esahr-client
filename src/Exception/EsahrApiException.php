<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Exception;

use Helip\SielEsahrClient\Dto\Common\ErrorResponseDto;
use RuntimeException;
use Throwable;

final class EsahrApiException extends RuntimeException
{
    public function __construct(
        public readonly ErrorResponseDto $problemDetails,
        ?Throwable $previous = null
    ) {
        parent::__construct($problemDetails->detail ?? 'ESAHR API error', $problemDetails->status, $previous);
    }

    /**
     * Retourne un message formaté incluant les invalidParams (texte brut).
     * Exemple :
     * [400] Invalid Request — One or more parameters are invalid. (/api/communes)
     * - header.Authorization: Missing or invalid token (value: {"description":"Bearer xyz..."})
     * - path.idCommune: Commune not found (value: {"description":"99999"})
     */
    public function formatMessage(): string
    {
        $pd = $this->problemDetails;

        $header = sprintf(
            '[%d] %s%s%s',
            $pd->status,
            $pd->title ?? 'HTTP Error',
            isset($pd->detail)   && $pd->detail     !== '' ? ' — ' . $pd->detail : '',
            isset($pd->instance) && $pd->instance !== '' ? ' (' . $pd->instance . ')' : ''
        );

        $items = $this->formatInvalidParamsLines();

        return $items === [] ? $header : $header . PHP_EOL . implode(PHP_EOL, $items);
    }

    /**
     * Même information que formatMessage(), mais en HTML simple (ul/li).
     */
    public function formatMessageHtml(): string
    {
        $pd = $this->problemDetails;

        $title    = htmlspecialchars($pd->title ?? 'HTTP Error', ENT_QUOTES, 'UTF-8');
        $detail   = $pd->detail ? ' — ' . htmlspecialchars($pd->detail, ENT_QUOTES, 'UTF-8') : '';
        $instance = $pd->instance ? ' (' . htmlspecialchars($pd->instance, ENT_QUOTES, 'UTF-8') . ')' : '';

        $header = sprintf('[%d] %s%s%s', $pd->status, $title, $detail, $instance);

        $lis = '';
        foreach ($this->normalizedInvalidParams() as $p) {
            $in        = htmlspecialchars((string)($p['in'] ?? ''), ENT_QUOTES, 'UTF-8');
            $name      = htmlspecialchars((string)($p['name'] ?? ''), ENT_QUOTES, 'UTF-8');
            $reason    = htmlspecialchars((string)($p['reason'] ?? ''), ENT_QUOTES, 'UTF-8');
            $value     = array_key_exists('value', $p) ? $this->stringifyValue($p['value']) : null;
            $valueHtml = $value !== null ? ' (value: ' . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . ')' : '';
            $lis .= sprintf('<li>%s.%s: %s%s</li>', $in, $name, $reason, $valueHtml);
        }

        return $lis === '' ? '<p>' . $header . '</p>' : '<p>' . $header . '</p><ul>' . $lis . '</ul>';
    }

    /**
     * Retourne la liste normalisée des invalidParams.
     * @return array<int, array{in?:string,name?:string,reason?:string,value?:mixed}>
     */
    public function normalizedInvalidParams(): array
    {
        $raw = $this->problemDetails->invalidParams ?? [];

        // Accepte objet unique ou liste
        if ($raw !== [] && array_is_list($raw)) {
            $list = $raw;
        } else {
            $list = [$raw];
        }

        // Ne garde que les éléments tableaux
        $out = [];
        foreach ($list as $item) {
            if (is_array($item)) {
                $out[] = $item;
            }
        }
        return $out;
    }

    /**
     * Construit les lignes "- in.name: reason (value: ...)" pour le format texte.
     * @return array<int,string>
     */
    private function formatInvalidParamsLines(): array
    {
        $lines = [];
        foreach ($this->normalizedInvalidParams() as $p) {
            $in     = (string)($p['in'] ?? '');
            $name   = (string)($p['name'] ?? '');
            $reason = (string)($p['reason'] ?? '');
            $value  = array_key_exists('value', $p) ? $this->stringifyValue($p['value']) : null;

            $prefix = trim($in . '.' . $name, '.');
            $suffix = $value !== null ? ' (value: ' . $value . ')' : '';

            $lines[] = sprintf('- %s: %s%s', $prefix, $reason, $suffix);
        }
        return $lines;
    }

    /**
     * Convertit une valeur quelconque en chaîne lisible (JSON compact le cas échéant).
     */
    private function stringifyValue(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }
        if (is_scalar($value)) {
            return (string)$value;
        }
        // JSON compact, sans échappement inutile
        $json = json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        return $json === false ? '[unserializable]' : $json;
    }
}

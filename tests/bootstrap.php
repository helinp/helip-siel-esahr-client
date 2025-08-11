<?php
declare(strict_types=1);
use Dotenv\Dotenv;

require dirname(__DIR__) . '/vendor/autoload.php';

// Load .env file
if (file_exists(dirname(__DIR__) . '/.env.local')) {
    $dotenv = Dotenv::createImmutable(dirname(__DIR__), '.env.local');
    $dotenv->load();
}

// Load .env.test.local if present (overrides .env.local)
if (file_exists(dirname(__DIR__) . '/.env.test.local')) {
    $dotenv = Dotenv::createImmutable(dirname(__DIR__), '.env.test.local');
    $dotenv->load();
}
<?php

declare(strict_types=1);

use Dotenv\Dotenv;

require dirname(__DIR__) . '/vendor/autoload.php';

// Load the .env.test.local file first to prioritize test environment variables
if (file_exists(dirname(__DIR__) . '/.env.test.local')) {
    $dotenvTest = Dotenv::createImmutable(dirname(__DIR__), '.env.test.local');
    $dotenvTest->load();
}

// Then, load the main .env file (will load default or empty values)
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

// Optionally load the .env.local file if it exists
if (file_exists(dirname(__DIR__) . '/.env.local')) {
    $dotenvLocal = Dotenv::createImmutable(dirname(__DIR__), '.env.local');
    $dotenvLocal->load();
}

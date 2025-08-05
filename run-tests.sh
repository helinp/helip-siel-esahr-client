#!/bin/sh

# rewrite autoload files
composer dump-autoload

# Fix coding standards issues
composer cs-fix

# Fix coding standards to adhere to PSR-12
composer fix-psr12

# Run static analysis tools
composer analyse-1

# Run test suite
composer test
#!/bin/bash

set -e

echo "Waiting for database migrations..."
php artisan migrate --force

echo "Generating Filament Shield permissions..."
php artisan shield:generate --all --panel=admin

echo "Seeding database..."
php artisan db:seed --force

echo "Initialization completed successfully!"
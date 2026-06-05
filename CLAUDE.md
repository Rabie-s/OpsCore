# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

OpsCore is an inventory management system built with Laravel and Filament. It tracks products, warehouses, stock movements, users, departments, and devices.

## Tech Stack

- **Framework**: Laravel 13.x
- **Admin Panel**: Filament 5.x (accessible at `/admin`)
- **Testing**: Pest 4.x
- **Frontend**: Vite + TailwindCSS 4.x
- **Database**: SQLite (default), uses in-memory SQLite for tests

## Common Commands

### Development
```bash
# Full development stack (server, queue, logs, vite)
composer dev

# Install dependencies and setup
composer setup

# Run only the dev server
php artisan serve

# Build frontend assets
npm run build
npm run dev
```

### Testing
```bash
# Run all tests
composer test
# or
php artisan test

# Run Pest directly
./vendor/bin/pest

# Run specific test file
./vendor/bin/pest tests/Feature/ExampleTest.php
```

### Database
```bash
# Run migrations
php artisan migrate

# Fresh migration with seeding
php artisan migrate:fresh --seed

# Create new migration
php artisan make:migration create_table_name
```

### Code Quality
```bash
# Laravel Pint (code formatter)
./vendor/bin/pint

# Laravel Pao (static analysis)
./vendor/bin/pao
```

## Architecture

### Domain Models

**Inventory Core**:
- `Product` - Inventory items with `product_type`, `stock_unit`, `image`, `note`, `is_active`
- `StockUnit` - Units of measurement for products (e.g., pieces, boxes, kg) with `name` and `symbol`
- `Warehouse` - Storage locations with `qr_token` for scanning
- `StockMovement` - Tracks all stock changes (In/Out/Init) with quantity, notes, and references

**Stock Calculation**:
Stock is NOT stored directly. It's calculated dynamically from `stock_movements`:
```php
current_stock = sum('in') + sum('init') - sum('out')
```
Implemented in `Product::getStockInWarehouse(int $warehouseId)`. The `warehouse_id` was migrated from products to stock_movements (see git history).

**User Management**:
- `Admin` - Filament panel users (access at `/admin`, auth guard: `admin`)
- `User` - Regular employees assigned to departments
- `Department` - Organizational units

**Device Management**:
- `DeviceType` - Categories of devices
- `Device` - Physical devices with IP and device_number
- `Counter` - Service counters within departments
- Hierarchy: `Department` → `Counter` → `Device`

### Enums

- `StockMovementType` - `In`, `Out`, `Init` (stored as lowercase strings)

### Filament Admin Panel

- Panel ID: `admin`, Path: `/admin`, Auth Guard: `admin`
- Resources auto-discovered from `app/Filament/Resources/`
- Pages auto-discovered from `app/Filament/Pages/`
- Widgets auto-discovered from `app/Filament/Widgets/`
- Theme color: Amber

### Testing Configuration

- Uses Pest with `tests/Pest.php` configuration
- Feature tests run in `Feature` directory
- Uses `RefreshDatabase` trait (currently commented out in Pest.php)
- Database: SQLite in-memory for tests

### Key Relationships

```
product_types ──< products >── stock_movements ──< warehouses
     │                     │
     └── stock_units       └── admins

departments ──< counters ──< devices
     │                    │
     └── users         device_types
```

## Important Notes

- All foreign keys use `CASCADE DELETE`
- Stock movements are the source of truth for inventory quantities
- When adding features related to stock, always update via `StockMovement` records
- `Product::warehouses()` and `Warehouse::products()` use many-to-many through `stock_movements` with `distinct()`

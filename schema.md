# OpsCore Database Schema

This document describes the database structure for the OpsCore inventory management system.

---

## Table of Contents

1. [Core Entities](#core-entities)
   - [warehouses](#warehouses)
   - [products](#products)
   - [stock_movements](#stock_movements)
2. [Product Classification](#product-classification)
   - [product_types](#product_types)
   - [stock_units](#stock_units)
3. [User Management](#user-management)
   - [admins](#admins)
   - [users](#users)
   - [departments](#departments)
4. [Device Management](#device-management)
   - [device_types](#device_types)
   - [devices](#devices)
   - [counters](#counters)
5. [System Tables](#system-tables)

---

## Core Entities

### warehouses

Stores physical warehouse locations for inventory storage.

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| `id` | BIGINT UNSIGNED | Primary Key, Auto Increment | Unique identifier |
| `name` | VARCHAR(255) | NOT NULL | Warehouse name |
| `location` | VARCHAR(255) | NOT NULL | Physical location |
| `qr_token` | VARCHAR(255) | UNIQUE, NOT NULL | QR code identifier for scanning |
| `created_at` | TIMESTAMP | NULL | Creation timestamp |
| `updated_at` | TIMESTAMP | NULL | Last update timestamp |

**Relationships:**
- Has many `stock_movements`
- Belongs to many `products` (through `stock_movements`)

---

### products

Stores inventory products/items.

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| `id` | BIGINT UNSIGNED | Primary Key, Auto Increment | Unique identifier |
| `name` | VARCHAR(255) | NOT NULL | Product name |
| `image` | VARCHAR(255) | NULLABLE | Product image URL/path |
| `note` | TEXT | NULLABLE | Additional notes |
| `is_active` | BOOLEAN | Default: TRUE | Active status |
| `product_type_id` | BIGINT UNSIGNED | Foreign Key, NOT NULL | Reference to product_types |
| `stock_unit_id` | BIGINT UNSIGNED | Foreign Key, NOT NULL | Reference to stock_units |
| `created_at` | TIMESTAMP | NULL | Creation timestamp |
| `updated_at` | TIMESTAMP | NULL | Last update timestamp |

**Relationships:**
- Belongs to `product_type`
- Belongs to `stock_unit`
- Has many `stock_movements`
- Belongs to many `warehouses` (through `stock_movements`)

**Constraints:**
- Foreign key: `product_type_id` → `product_types.id` (CASCADE DELETE)
- Foreign key: `stock_unit_id` → `stock_units.id` (CASCADE DELETE)

---

### stock_movements

Tracks all inventory movements (in, out, initial stock).

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| `id` | BIGINT UNSIGNED | Primary Key, Auto Increment | Unique identifier |
| `type` | VARCHAR(255) | NOT NULL | Movement type (enum: 'in', 'out', 'init') |
| `quantity` | INTEGER | NOT NULL | Quantity moved |
| `note` | TEXT | NULLABLE | Movement notes |
| `product_id` | BIGINT UNSIGNED | Foreign Key, NOT NULL | Reference to products |
| `warehouse_id` | BIGINT UNSIGNED | Foreign Key, NOT NULL | Reference to warehouses |
| `admin_id` | BIGINT UNSIGNED | Foreign Key, NOT NULL | Reference to admins |
| `created_at` | TIMESTAMP | NULL | Creation timestamp |
| `updated_at` | TIMESTAMP | NULL | Last update timestamp |

**Movement Types:**
- `in` - Stock addition
- `out` - Stock removal
- `init` - Initial stock setup

**Relationships:**
- Belongs to `product`
- Belongs to `warehouse`
- Belongs to `admin`

**Constraints:**
- Foreign key: `product_id` → `products.id` (CASCADE DELETE)
- Foreign key: `warehouse_id` → `warehouses.id` (CASCADE DELETE)
- Foreign key: `admin_id` → `admins.id` (CASCADE DELETE)

**Stock Calculation:**
Current stock = SUM('in' + 'init') - SUM('out')

---

## Product Classification

### product_types

Categories for organizing products.

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| `id` | BIGINT UNSIGNED | Primary Key, Auto Increment | Unique identifier |
| `name` | VARCHAR(255) | NOT NULL | Type name |
| `created_at` | TIMESTAMP | NULL | Creation timestamp |
| `updated_at` | TIMESTAMP | NULL | Last update timestamp |

**Relationships:**
- Has many `products`

---

### stock_units

Units of measurement for inventory products (e.g., pieces, boxes, kilograms, liters).

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| `id` | BIGINT UNSIGNED | Primary Key, Auto Increment | Unique identifier |
| `name` | VARCHAR(255) | NOT NULL | Unit name (e.g., "Piece", "Box", "Kilogram") |
| `symbol` | VARCHAR(255) | NOT NULL | Unit symbol (e.g., "pcs", "box", "kg") |
| `created_at` | TIMESTAMP | NULL | Creation timestamp |
| `updated_at` | TIMESTAMP | NULL | Last update timestamp |

**Relationships:**
- Has many `products`

---

## User Management

### admins

Administrative users who manage inventory (Filament panel access).

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| `id` | BIGINT UNSIGNED | Primary Key, Auto Increment | Unique identifier |
| `name` | VARCHAR(255) | NOT NULL | Admin name |
| `email` | VARCHAR(255) | UNIQUE, NOT NULL | Email address |
| `password` | VARCHAR(255) | NOT NULL | Hashed password |
| `remember_token` | VARCHAR(100) | NULLABLE | "Remember me" token |
| `created_at` | TIMESTAMP | NULL | Creation timestamp |
| `updated_at` | TIMESTAMP | NULL | Last update timestamp |

**Relationships:**
- Has many `stock_movements`

---

### users

Regular users/employees assigned to departments.

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| `id` | BIGINT UNSIGNED | Primary Key, Auto Increment | Unique identifier |
| `name` | VARCHAR(255) | NOT NULL | User name |
| `email` | VARCHAR(255) | UNIQUE, NOT NULL | Email address |
| `email_verified_at` | TIMESTAMP | NULLABLE | Email verification timestamp |
| `password` | VARCHAR(255) | NOT NULL | Hashed password |
| `department_id` | BIGINT UNSIGNED | Foreign Key, NOT NULL | Reference to departments |
| `remember_token` | VARCHAR(100) | NULLABLE | "Remember me" token |
| `created_at` | TIMESTAMP | NULL | Creation timestamp |
| `updated_at` | TIMESTAMP | NULL | Last update timestamp |

**Relationships:**
- Belongs to `department`

**Constraints:**
- Foreign key: `department_id` → `departments.id` (CASCADE DELETE)

---

### departments

Organizational departments for grouping users and counters.

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| `id` | BIGINT UNSIGNED | Primary Key, Auto Increment | Unique identifier |
| `name` | VARCHAR(255) | NOT NULL | Department name |
| `created_at` | TIMESTAMP | NULL | Creation timestamp |
| `updated_at` | TIMESTAMP | NULL | Last update timestamp |

**Relationships:**
- Has many `counters`
- Has many `users` (referred as `employees`)

---

## Device Management

### device_types

Types/categories of devices (e.g., POS terminals, scanners).

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| `id` | BIGINT UNSIGNED | Primary Key, Auto Increment | Unique identifier |
| `name` | VARCHAR(255) | NOT NULL | Device type name |
| `created_at` | TIMESTAMP | NULL | Creation timestamp |
| `updated_at` | TIMESTAMP | NULL | Last update timestamp |

**Relationships:**
- Has many `devices`

---

### devices

Physical devices assigned to counters.

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| `id` | BIGINT UNSIGNED | Primary Key, Auto Increment | Unique identifier |
| `ip` | VARCHAR(255) | NULLABLE | Device IP address |
| `device_number` | VARCHAR(255) | NOT NULL | Device identifier number |
| `counter_id` | BIGINT UNSIGNED | Foreign Key, NOT NULL | Reference to counters |
| `device_type` | BIGINT UNSIGNED | Foreign Key, NOT NULL | Reference to device_types |
| `created_at` | TIMESTAMP | NULL | Creation timestamp |
| `updated_at` | TIMESTAMP | NULL | Last update timestamp |

**Relationships:**
- Belongs to `counter`
- Belongs to `device_type`

**Constraints:**
- Foreign key: `counter_id` → `counters.id` (CASCADE DELETE)
- Foreign key: `device_type` → `device_types.id` (CASCADE DELETE)

---

### counters

Service counters within departments that hold devices.

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| `id` | BIGINT UNSIGNED | Primary Key, Auto Increment | Unique identifier |
| `counter_number` | INTEGER | NOT NULL | Counter number |
| `department_id` | BIGINT UNSIGNED | Foreign Key, NOT NULL | Reference to departments |
| `created_at` | TIMESTAMP | NULL | Creation timestamp |
| `updated_at` | TIMESTAMP | NULL | Last update timestamp |

**Relationships:**
- Belongs to `department`
- Has many `devices`

**Constraints:**
- Foreign key: `department_id` → `departments.id` (CASCADE DELETE)

---

## System Tables

### cache

Laravel cache table (standard).

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| `key` | VARCHAR(255) | PRIMARY KEY | Cache key |
| `value` | LONGTEXT | NOT NULL | Cached data |
| `expiration` | INTEGER | NULLABLE | Expiration timestamp |

---

### jobs

Laravel queue jobs table (standard).

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| `id` | BIGINT UNSIGNED | Primary Key, Auto Increment | Unique identifier |
| `queue` | VARCHAR(255) | NOT NULL | Queue name |
| `payload` | LONGTEXT | NOT NULL | Job data |
| `attempts` | UNSIGNED SMALLINT | Default: 0 | Retry attempts |
| `reserved_at` | INTEGER | NULLABLE | Reservation timestamp |
| `available_at` | INTEGER | NOT NULL | Available timestamp |
| `created_at` | INTEGER | NOT NULL | Creation timestamp |

---

### sessions

User sessions table (standard).

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| `id` | VARCHAR(255) | PRIMARY KEY | Session ID |
| `user_id` | BIGINT UNSIGNED | Foreign Key, NULLABLE, INDEXED | Reference to users |
| `ip_address` | VARCHAR(45) | NULLABLE | Client IP address |
| `user_agent` | TEXT | NULLABLE | Client user agent |
| `payload` | LONGTEXT | NOT NULL | Session data |
| `last_activity` | INTEGER | INDEXED | Last activity timestamp |

---

### password_reset_tokens

Password reset tokens (standard).

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| `email` | VARCHAR(255) | PRIMARY KEY | User email |
| `token` | VARCHAR(255) | NOT NULL | Reset token |
| `created_at` | TIMESTAMP | NULLABLE | Creation timestamp |

---

## Entity Relationship Diagram

```
┌─────────────────┐
│  product_types  │
└────────┬────────┘
         │ 1
         │
         │ *
┌────────▼────────┐         ┌──────────────┐         ┌─────────────┐
│    products     │◄────────│stock_movements│────────►│  warehouses │
└────────┬────────┘    *    └──────┬────────┘    *    └─────────────┘
         │ 1                 1     │ 1                    1
         │                         │ *
         │ *                       │
┌────────▼─────────┐             ┌─▼─────┐
│   stock_units   │             │admins │
└─────────────────┘             └───────┘

┌──────────────┐         ┌──────────────┐         ┌──────────────┐
│ departments  │◄────────│   counters   │◄────────│   devices    │
└──────┬───────┘    *    └──────────────┘    1    └──────┬───────┘
       │ 1                                            │ *
       │                                              │
       │ *                                            │ *
┌──────▼───────┐                              ┌──────▼───────┐
│    users     │                              │ device_types │
└──────────────┘                              └──────────────┘
```

---

## Key Business Logic

### Stock Calculation

The current stock of a product in a warehouse is calculated as:

```
current_stock = (sum of 'in' quantities) + (sum of 'init' quantities) - (sum of 'out' quantities)
```

This is implemented in `Product::getStockInWarehouse(int $warehouseId)` method.

---

## Notes

- All foreign key relationships use `CASCADE DELETE`
- All tables use Laravel's default timestamps (`created_at`, `updated_at`)
- Primary keys are auto-incrementing `BIGINT UNSIGNED`
- The system uses Laravel's authentication for both Admin (Filament) and User models

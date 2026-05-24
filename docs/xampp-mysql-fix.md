# XAMPP MySQL — "Shutdown unexpectedly" fix

## Cause (your PC)

Hundreds of corrupt **`master-*.info`** and **`relay-log-*.info`** files were in `C:\xampp\mysql\data\`. MariaDB treated them as replication config and crashed with:

`Failed to initialize multi master structures` → `Aborting`

These files are **not** part of your retail project; they built up after earlier MySQL crashes.

## Fix applied

1. Stopped MySQL
2. Deleted corrupt `master-*`, `relay-log-*`, `mysql-relay-bin*` files
3. Reset `mysql_error.log`
4. Added `skip-slave-start` to `C:\xampp\mysql\bin\my.ini`

## If it happens again

1. Stop MySQL in XAMPP
2. Delete files in `C:\xampp\mysql\data\` matching:
   - `master-*`
   - `relay-log-*`
   - `mysql-relay-bin*`
3. Start MySQL again

**Do not** delete `ibdata1`, `ib_logfile*`, or database folders (`retail_shop`, `mysql`, etc.) unless you intend to reset all data.

## Restore database (if empty)

Import `database.sql` from the project root in phpMyAdmin.

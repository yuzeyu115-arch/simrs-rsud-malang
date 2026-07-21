This folder contains helper scripts to create a local MySQL database and wire the Laravel .env file.

Files:

- `update-env.php` : PHP helper that copies `.env.example` to `.env` (if needed) and updates DB_* values.
- `setup-db.sh` : Bash script for macOS/Linux. Usage: `./scripts/setup-db.sh [db_name] [sql_path] [db_user] [db_pass]`.
- `setup-db.bat` : Windows batch script. Usage: `scripts\setup-db.bat [db_name] [sql_path] [db_user] [db_pass]`.
- `setup-db.ps1` : PowerShell script. Usage: `.	ools\setup-db.ps1 -DbName simpleok -SqlPath "..\schema_database_simpleok.sql" -DbUser root -DbPass ""`.

Default behavior:
- Database name: `simpleok`
- SQL file: `schema_database_simpleok.sql` in repo root
- DB user: `root`
- DB password: empty

Examples:

Windows (cmd):

    scripts\setup-db.bat

PowerShell:

    .\scripts\setup-db.ps1 -DbName simpleok -DbUser root -DbPass ''

Linux/macOS:

    ./scripts/setup-db.sh

Notes:
- These scripts call the `mysql` CLI; ensure MySQL (or MariaDB) client is installed and in `PATH` (Laragon provides it).
- The scripts will create the database if it doesn't exist and import the schema file.
- Scripts will create `.env` from `.env.example` and update DB settings using `php`.
- The repo's `.env` is gitignored; do not commit real credentials.

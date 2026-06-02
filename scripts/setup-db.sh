#!/usr/bin/env bash
# Setup database and import schema (Unix/macOS)
# Usage: ./setup-db.sh [db_name] [sql_path] [db_user] [db_pass]

DB_NAME=${1:-simpleok}
SQL_PATH=${2:-"$(dirname "$0")/../schema_database_simpleok.sql"}
DB_USER=${3:-root}
DB_PASS=${4:-}

echo "Creating database $DB_NAME..."
if [ -z "$DB_PASS" ]; then
  mysql -u "$DB_USER" -e "CREATE DATABASE IF NOT EXISTS \`$DB_NAME\` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"
  mysql -u "$DB_USER" "$DB_NAME" < "$SQL_PATH"
else
  mysql -u "$DB_USER" -p"$DB_PASS" -e "CREATE DATABASE IF NOT EXISTS \`$DB_NAME\` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"
  mysql -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" < "$SQL_PATH"
fi

if [ ! -f .env ]; then
  cp .env.example .env
fi

php "$(dirname "$0")/update-env.php" "$DB_NAME" "$DB_USER" "$DB_PASS"

echo "Done."

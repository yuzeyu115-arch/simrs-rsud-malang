@echo off
REM Setup database and import schema (Windows batch)
REM Usage: setup-db.bat [db_name] [sql_path] [db_user] [db_pass]

SETLOCAL ENABLEDELAYEDEXPANSION
set DB_NAME=%1
if "%DB_NAME%"=="" set DB_NAME=simpleok
set SQL_PATH=%2
if "%SQL_PATH%"=="" set SQL_PATH=%~dp0\..\schema_database_simpleok.sql
set DB_USER=%3
if "%DB_USER%"=="" set DB_USER=root
set DB_PASS=%4

echo Creating database %DB_NAME%...
if "%DB_PASS%"=="" (
    mysql -u %DB_USER% -e "CREATE DATABASE IF NOT EXISTS `%DB_NAME%` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"
    mysql -u %DB_USER% %DB_NAME% < "%SQL_PATH%"
) else (
    mysql -u %DB_USER% -p%DB_PASS% -e "CREATE DATABASE IF NOT EXISTS `%DB_NAME%` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"
    mysql -u %DB_USER% -p%DB_PASS% %DB_NAME% < "%SQL_PATH%"
)

if exist .env (
    echo .env exists, skipping copy
) else (
    copy .env.example .env >nul
    echo Updating .env database settings...
    php "%~dp0update-env.php" %DB_NAME% %DB_USER% %DB_PASS%
)

echo Done.

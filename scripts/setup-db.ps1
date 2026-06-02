param(
    [string]$DbName = 'simpleok',
    [string]$SqlPath = "$PSScriptRoot\..\schema_database_simpleok.sql",
    [string]$DbUser = 'root',
    [string]$DbPass = ''
)

Write-Host "Creating database $DbName..."
if ([string]::IsNullOrEmpty($DbPass)) {
    & mysql -u $DbUser -e "CREATE DATABASE IF NOT EXISTS `$DbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"
    & cmd /c "mysql -u $DbUser $DbName < \"$SqlPath\""
} else {
    & mysql -u $DbUser "-p$DbPass" -e "CREATE DATABASE IF NOT EXISTS `$DbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"
    & cmd /c "mysql -u $DbUser -p$DbPass $DbName < \"$SqlPath\""
}

if (-not (Test-Path .env)) { Copy-Item .env.example .env }
php "$PSScriptRoot\update-env.php" $DbName $DbUser $DbPass
Write-Host "Done."
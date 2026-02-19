$path = 'C:\php\php.ini'
try {
    $content = Get-Content $path -Raw
    $newContent = $content -replace ';extension=pdo_pgsql', 'extension=pdo_pgsql' -replace ';extension=pgsql', 'extension=pgsql'
    Set-Content $path $newContent
    Write-Host "Successfully enabled pdo_pgsql and pgsql extensions."
} catch {
    Write-Error "Failed to modify php.ini. You may need to run this as Administrator."
    Write-Error $_
}

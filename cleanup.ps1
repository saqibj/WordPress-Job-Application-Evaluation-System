# Clean up trailing spaces in PHP files
Get-ChildItem -Path . -Filter *.php -Recurse | ForEach-Object {
    $content = Get-Content $_.FullName -Raw
    $content = $content -replace '\s+$', ''
    Set-Content $_.FullName $content -NoNewline
    Write-Host "Cleaned: $($_.FullName)"
} 
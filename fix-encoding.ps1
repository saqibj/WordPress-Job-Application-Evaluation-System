# Fix file encoding and line endings in PHP files
Get-ChildItem -Path . -Filter *.php -Recurse | ForEach-Object {
    $content = Get-Content $_.FullName -Raw
    # Remove BOM if present
    if ($content.StartsWith([char]0xFEFF)) {
        $content = $content.Substring(1)
    }
    # Convert to UTF-8 without BOM and LF line endings
    $content = [System.Text.Encoding]::UTF8.GetBytes($content)
    [System.IO.File]::WriteAllBytes($_.FullName, $content)
    Write-Host "Fixed encoding: $($_.FullName)"
} 
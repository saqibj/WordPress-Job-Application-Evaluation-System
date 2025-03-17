<#
.SYNOPSIS
Path-corrected PowerShell build script
#>

# Get plugin root directory
$PLUGIN_ROOT = (Get-Item $PSScriptRoot).Parent.FullName

# Configuration
$PLUGIN_SLUG = "job-eval-system"
$VERSION = (Select-String -Path "$PLUGIN_ROOT\job-eval-system.php" -Pattern "Version:").Line.Split(":")[1].Trim()
$BUILD_ROOT = "$PLUGIN_ROOT\build"
$DIST_DIR = "$BUILD_ROOT\dist\$VERSION"
$TEMP_DIR = "$BUILD_ROOT\temp"

# Clean previous artifacts
Write-Host "🧹 Cleaning previous build artifacts..." -ForegroundColor Cyan
Remove-Item -Path $DIST_DIR, $TEMP_DIR -Recurse -ErrorAction SilentlyContinue

# Create directories
Write-Host "📂 Creating directory structure..." -ForegroundColor Cyan
New-Item -ItemType Directory -Path $DIST_DIR, $TEMP_DIR | Out-Null

# Update the exclusion patterns
$excludePatterns = @(
    'build',
    '.git*',
    '.github',
    'node_modules',
    'tests',
    'phpcs.xml*',  # Added wildcard
    'composer.*',
    'package*.json',
    'webpack.config.js',
    '*.log',
    '.idea',
    '.vscode',
    '.DS_Store',
    'docs/developer-api.md'
)

# Copy plugin files
Write-Host "📦 Copying plugin files..." -ForegroundColor Cyan
Get-ChildItem -Path $PLUGIN_ROOT -Exclude $excludePatterns | 
    Copy-Item -Destination $TEMP_DIR -Recurse

# Create production archive
Write-Host "📦 Creating production archive (v$VERSION)..." -ForegroundColor Cyan
Compress-Archive -Path "$TEMP_DIR\*" -DestinationPath "$DIST_DIR\$PLUGIN_SLUG-$VERSION.zip" -CompressionLevel Optimal

# Generate checksum
Write-Host "🔐 Creating verification checksums..." -ForegroundColor Cyan
$Hash = Get-FileHash -Path "$DIST_DIR\$PLUGIN_SLUG-$VERSION.zip" -Algorithm SHA256
"$($Hash.Hash)  $PLUGIN_SLUG-$VERSION.zip" | Out-File -FilePath "$DIST_DIR\$PLUGIN_SLUG-$VERSION.zip.sha256"

# Final cleanup
Write-Host "🧹 Final cleanup..." -ForegroundColor Cyan
Remove-Item -Path $TEMP_DIR -Recurse -ErrorAction SilentlyContinue

Write-Host "`n✅ Build successful!" -ForegroundColor Green
Write-Host "📦 Production ZIP: $DIST_DIR\$PLUGIN_SLUG-$VERSION.zip" -ForegroundColor White
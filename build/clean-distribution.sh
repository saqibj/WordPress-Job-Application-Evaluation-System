#!/bin/bash
# Path-corrected build script
# Version: 1.0.4

# Get plugin root directory
PLUGIN_ROOT=$(dirname "$0")/..
PLUGIN_ROOT=$(realpath "$PLUGIN_ROOT")

# Configuration
PLUGIN_SLUG="job-eval-system"
VERSION=$(grep "Version:" "${PLUGIN_ROOT}/job-eval-system.php" | awk '{print $2}')
BUILD_ROOT="${PLUGIN_ROOT}/build"
DIST_DIR="${BUILD_ROOT}/dist/${VERSION}"
TEMP_DIR="${BUILD_ROOT}/temp"

# Clean previous artifacts
echo "🧹 Cleaning previous build artifacts..."
rm -rf "${DIST_DIR}" "${TEMP_DIR}"

# Create fresh directories
echo "📂 Creating directory structure..."
mkdir -p "${DIST_DIR}" "${TEMP_DIR}"

# Copy plugin files (excluding build system)
echo "📦 Copying plugin files..."
rsync -av --progress "${PLUGIN_ROOT}/" "${TEMP_DIR}/" \
  --exclude="build/" \
  --exclude=".git*" \
  --exclude=".github/" \
  --exclude="node_modules/" \
  --exclude="tests/" \
  --exclude="*phpcs.xml*" \
  --exclude="composer.*" \
  --exclude="package*.json" \
  --exclude="webpack.config.js" \
  --exclude="*.log" \
  --exclude=".idea/" \
  --exclude=".vscode/" \
  --exclude=".DS_Store" \
  --exclude="docs/developer-api.md"

# Create production archive
echo "📦 Creating production archive (v${VERSION})..."
cd "${TEMP_DIR}" || exit
zip -rq "${DIST_DIR}/${PLUGIN_SLUG}-${VERSION}.zip" ./*

# Generate checksums
echo "🔐 Creating verification checksums..."
cd "${DIST_DIR}" || exit
shasum -a 256 "${PLUGIN_SLUG}-${VERSION}.zip" > "${PLUGIN_SLUG}-${VERSION}.zip.sha256"

# Final cleanup
echo "🧹 Final cleanup..."
rm -rf "${TEMP_DIR}"

echo -e "\n✅ Build successful!"
echo "📦 Production ZIP: ${DIST_DIR}/${PLUGIN_SLUG}-${VERSION}.zip"
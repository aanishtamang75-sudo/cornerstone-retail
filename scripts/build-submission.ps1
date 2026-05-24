# Build A3-Submission folder and retail-shop.zip
$projectRoot = (Resolve-Path (Join-Path $PSScriptRoot "..")).Path
$parentDir = Split-Path $projectRoot -Parent
$outDir = Join-Path $parentDir "A3-Submission"
$zipPath = Join-Path $outDir "retail-shop.zip"
$tempZip = Join-Path $env:TEMP "retail-shop-build"

Write-Host "Project: $projectRoot"
Write-Host "Output:  $outDir"

if (Test-Path $outDir) { Remove-Item $outDir -Recurse -Force }
New-Item -ItemType Directory -Path $outDir | Out-Null
New-Item -ItemType Directory -Path "$outDir\docs\screenshots" -Force | Out-Null

Copy-Item "$projectRoot\README.md" $outDir -Force
Copy-Item "$projectRoot\database.sql" $outDir -Force
if (Test-Path "$projectRoot\github-link.txt") {
    Copy-Item "$projectRoot\github-link.txt" $outDir -Force
} else {
    "https://github.com/YOUR_USERNAME/cornerstone-retail" | Set-Content "$outDir\github-link.txt"
}
Copy-Item "$projectRoot\docs\*.md" "$outDir\docs\" -Force
Get-ChildItem "$projectRoot\docs\screenshots" -File -ErrorAction SilentlyContinue | Copy-Item -Destination "$outDir\docs\screenshots\" -Force

if (Test-Path $tempZip) { Remove-Item $tempZip -Recurse -Force }
New-Item -ItemType Directory -Path $tempZip | Out-Null

Get-ChildItem $projectRoot -Force | Where-Object { $_.Name -ne 'A3-Submission' } | ForEach-Object {
    Copy-Item $_.FullName (Join-Path $tempZip $_.Name) -Recurse -Force
}

if (Test-Path "$tempZip\public\setup.php") {
    Remove-Item "$tempZip\public\setup.php" -Force
    Write-Host "Removed setup.php from zip"
}

if (Test-Path $zipPath) { Remove-Item $zipPath -Force }
Compress-Archive -Path "$tempZip\*" -DestinationPath $zipPath -Force
Remove-Item $tempZip -Recurse -Force

Write-Host "Done: $zipPath"

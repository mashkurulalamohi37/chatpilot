$ErrorActionPreference = "Stop"

$sourceDir = "d:\Test project\chatpilot"
$destDir = "d:\Test project\ChatPilot_v1.0_UNZIP_FIRST"
$mainFileDir = "$destDir\Main_File"
$docsDir = "$destDir\Documentation"
$licenseDir = "$destDir\Licensing"

Write-Host "Cleaning up previous build..."
if (Test-Path $destDir) { Remove-Item -Recurse -Force $destDir }

Write-Host "Creating directory structure..."
New-Item -ItemType Directory -Force -Path $mainFileDir | Out-Null
New-Item -ItemType Directory -Force -Path $docsDir | Out-Null
New-Item -ItemType Directory -Force -Path $licenseDir | Out-Null

Write-Host "Copying Source Code to Main_File..."
# Robocopy is reliable for excluding folders
# /MIR mirrors (copy all, delete extras), /XD excludes directories, /XF excludes files
robocopy $sourceDir $mainFileDir /MIR /XD node_modules .git .gemini .idea ChatPilot_v1.0_UNZIP_FIRST /XF .env package_for_release.ps1 .DS_Store /R:0 /W:0

Write-Host "Copying Documentation..."
Copy-Item "$sourceDir\documentation\index.html" -Destination $docsDir

Write-Host "Copying License..."
Copy-Item "$sourceDir\license.txt" -Destination $licenseDir

Write-Host "Packaging Complete!"
Write-Host "You can now ZIP the folder: $destDir"

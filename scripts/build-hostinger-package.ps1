param(
    [string]$OutputZip = "hostinger-deploy.zip"
)

$ErrorActionPreference = 'Stop'

$projectRoot = Split-Path -Parent $PSScriptRoot
$staging = Join-Path $projectRoot '.deploy_tmp'
$zipPath = Join-Path $projectRoot $OutputZip

if (Test-Path $staging) {
    Remove-Item $staging -Recurse -Force
}

New-Item -ItemType Directory -Path $staging | Out-Null

$excludeDirs = @('.git', 'node_modules', '.deploy_tmp')
$excludeFiles = @('.env', '*.log')

Get-ChildItem -Path $projectRoot -Force | Where-Object {
    $name = $_.Name
    -not ($excludeDirs -contains $name) -and -not ($excludeFiles | Where-Object { $name -like $_ })
} | ForEach-Object {
    Copy-Item -Path $_.FullName -Destination $staging -Recurse -Force
}

if (Test-Path $zipPath) {
    Remove-Item $zipPath -Force
}

Compress-Archive -Path (Join-Path $staging '*') -DestinationPath $zipPath -Force
Remove-Item $staging -Recurse -Force

Write-Host "Deployment package created: $zipPath"

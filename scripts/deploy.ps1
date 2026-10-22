# =============================================================================
# scripts/deploy.ps1
# Deploy TechPro WordPress stack
# =============================================================================

param(
    [switch]$Clean
)

$ProjectRoot = Split-Path $PSScriptRoot -Parent
Set-Location $ProjectRoot

Write-Host "=== TechPro WordPress Deployment ===" -ForegroundColor Cyan
Write-Host "Student ID: DTC245200863" -ForegroundColor Gray

# 1. Check .env
if (-not (Test-Path ".env")) {
    Write-Host "[INFO] Creating .env from .env.example..." -ForegroundColor Yellow
    Copy-Item ".env.example" ".env"
    Write-Host "[WARN] Please edit .env and set strong passwords before production use!" -ForegroundColor Yellow
}

# 2. Generate a development certificate if one is not present
$crt = "nginx\certs\localhost.crt"
$key = "nginx\certs\localhost.key"
if (-not (Test-Path $crt) -or -not (Test-Path $key)) {
    Write-Host "[INFO] Generating a self-signed development certificate..." -ForegroundColor Cyan
    & ".\scripts\generate-cert.ps1"
    if ($LASTEXITCODE -ne 0) {
        throw "Certificate generation failed."
    }
}

# 3. Pull images
Write-Host "[INFO] Pulling Docker images..." -ForegroundColor Cyan
docker compose pull
if ($LASTEXITCODE -ne 0) {
    throw "Docker image pull failed."
}

# 4. Deploy
if ($Clean) {
    Write-Host "[WARN] Clean mode: removing containers and images (NOT volumes)..." -ForegroundColor Yellow
    docker compose down --remove-orphans
}

Write-Host "[INFO] Starting services..." -ForegroundColor Cyan
docker compose up -d --wait --wait-timeout 180
if ($LASTEXITCODE -ne 0) {
    docker compose logs --tail 80
    throw "Docker Compose could not start the stack."
}

Write-Host ""
Write-Host "=== Services Ready ===" -ForegroundColor Green
Write-Host "Website:    Set WORDPRESS_SITE_URL in .env (default http://localhost)" -ForegroundColor Cyan
Write-Host "phpMyAdmin: http://localhost:8080" -ForegroundColor Cyan
Write-Host "Grafana:    http://localhost:3000" -ForegroundColor Cyan
Write-Host "Prometheus: http://localhost:9090" -ForegroundColor Cyan
Write-Host "Loki:       http://localhost:3100" -ForegroundColor Cyan
Write-Host ""
Write-Host "WordPress admin: <WORDPRESS_SITE_URL>/wp-admin" -ForegroundColor Yellow
Write-Host "HTTPS uses a self-signed development certificate; browsers will show a warning." -ForegroundColor Yellow
Write-Host "Run: docker compose logs -f to watch logs" -ForegroundColor Gray

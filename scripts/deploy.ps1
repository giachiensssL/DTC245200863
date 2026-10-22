# =============================================================================
# scripts/deploy.ps1
# Deploy TechPro WordPress stack
# =============================================================================

param(
    [switch]$Clean,
    [switch]$SkipCert
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

# 2. Generate SSL certificate
if (-not $SkipCert) {
    $crt = "nginx\certs\localhost.crt"
    $key = "nginx\certs\localhost.key"
    if (-not (Test-Path $crt) -or -not (Test-Path $key)) {
        Write-Host "[INFO] Generating SSL certificate..." -ForegroundColor Cyan
        & ".\scripts\generate-cert.ps1"
    } else {
        Write-Host "[OK] SSL certificate already exists." -ForegroundColor Green
    }
}

# 3. Pull images
Write-Host "[INFO] Pulling Docker images..." -ForegroundColor Cyan
docker compose pull

# 4. Deploy
if ($Clean) {
    Write-Host "[WARN] Clean mode: removing containers and images (NOT volumes)..." -ForegroundColor Yellow
    docker compose down --remove-orphans
}

Write-Host "[INFO] Starting services..." -ForegroundColor Cyan
docker compose up -d

# 5. Wait for health
Write-Host "[INFO] Waiting for services to become healthy..." -ForegroundColor Cyan
$timeout = 120
$elapsed = 0
do {
    Start-Sleep -Seconds 10
    $elapsed += 10
    $healthy = docker compose ps --format json 2>/dev/null | ConvertFrom-Json | Where-Object { $_.Health -eq 'healthy' } | Measure-Object | Select-Object -ExpandProperty Count
    $total   = docker compose ps --format json 2>/dev/null | ConvertFrom-Json | Measure-Object | Select-Object -ExpandProperty Count
    Write-Host "[INFO] $elapsed s — $healthy/$total services healthy" -ForegroundColor Gray
} while ($elapsed -lt $timeout -and $healthy -lt $total)

Write-Host ""
Write-Host "=== Services Ready ===" -ForegroundColor Green
Write-Host "Website:    https://localhost" -ForegroundColor Cyan
Write-Host "phpMyAdmin: http://localhost:8080" -ForegroundColor Cyan
Write-Host "Grafana:    http://localhost:3000" -ForegroundColor Cyan
Write-Host "Prometheus: http://localhost:9090" -ForegroundColor Cyan
Write-Host "Loki:       http://localhost:3100" -ForegroundColor Cyan
Write-Host ""
Write-Host "WordPress admin: https://localhost/wp-admin" -ForegroundColor Yellow
Write-Host "Run: docker compose logs -f to watch logs" -ForegroundColor Gray

# =============================================================================
# scripts/generate-cert.ps1
# Generate self-signed SSL certificate for local development
# Run from project root: .\scripts\generate-cert.ps1
# =============================================================================

param(
    [string]$CN = "localhost",
    [int]$Days = 365
)

$CertsDir = Join-Path $PSScriptRoot "..\nginx\certs"
New-Item -ItemType Directory -Force -Path $CertsDir | Out-Null

$CertFile = Join-Path $CertsDir "localhost.crt"
$KeyFile  = Join-Path $CertsDir "localhost.key"

# Try openssl first
if (Get-Command openssl -ErrorAction SilentlyContinue) {
    Write-Host "[INFO] Generating certificate with openssl..." -ForegroundColor Cyan
    openssl req -x509 -nodes -days $Days -newkey rsa:2048 `
        -keyout $KeyFile `
        -out $CertFile `
        -subj "/C=VN/ST=HoChiMinh/L=HoChiMinh/O=TechPro/OU=Dev/CN=$CN" `
        -addext "subjectAltName=DNS:localhost,IP:127.0.0.1"
    if ($LASTEXITCODE -eq 0) {
        Write-Host "[OK] Certificate generated:" -ForegroundColor Green
        Write-Host "     CRT: $CertFile" -ForegroundColor Green
        Write-Host "     KEY: $KeyFile" -ForegroundColor Green
    } else {
        Write-Error "openssl failed. Check openssl installation."
    }
} elseif ($IsWindows -or [System.Environment]::OSVersion.Platform -eq 'Win32NT') {
    Write-Host "[INFO] openssl not found. Trying Windows PowerShell certificate..." -ForegroundColor Yellow
    try {
        $cert = New-SelfSignedCertificate `
            -DnsName $CN `
            -CertStoreLocation Cert:\LocalMachine\My `
            -NotAfter (Get-Date).AddDays($Days) `
            -KeyAlgorithm RSA `
            -KeyLength 2048 `
            -HashAlgorithm SHA256 `
            -FriendlyName "TechPro Local Dev"

        # Export PFX then convert (requires openssl or certutil)
        Write-Host "[WARN] To export PEM format, install openssl and re-run this script." -ForegroundColor Yellow
        Write-Host "[INFO] Certificate thumbprint: $($cert.Thumbprint)" -ForegroundColor Cyan
    } catch {
        Write-Error "Certificate generation failed: $_"
    }
} else {
    Write-Error "openssl not found. Install openssl and retry."
}

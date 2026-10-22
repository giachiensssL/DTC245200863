param(
    [string]$DnsName = "localhost",
    [string]$IpAddress = "127.0.0.1",
    [int]$Days = 365
)

$ErrorActionPreference = "Stop"

$certsDir = Join-Path $PSScriptRoot "..\nginx\certs"
New-Item -ItemType Directory -Force -Path $certsDir | Out-Null
$certFile = Join-Path $certsDir "localhost.crt"
$keyFile = Join-Path $certsDir "localhost.key"
$openssl = Get-Command openssl -ErrorAction SilentlyContinue
$subjectAltName = "DNS:$DnsName"
if ($IpAddress) {
    $subjectAltName += ",IP:$IpAddress"
}

if ($openssl) {
    & $openssl.Source req -x509 -nodes -days $Days -newkey rsa:2048 `
        -keyout $keyFile `
        -out $certFile `
        -subj "/C=VN/O=TechPro/OU=Development/CN=$DnsName" `
        -addext "subjectAltName=$subjectAltName"
    if ($LASTEXITCODE -ne 0) {
        throw "OpenSSL could not generate the local TLS certificate."
    }
} else {
    $docker = Get-Command docker -ErrorAction SilentlyContinue
    if (-not $docker) {
        throw "OpenSSL or Docker is required to generate the development certificate."
    }

    $certsPath = (Resolve-Path $certsDir).Path
    $containerCommand = "apk add --no-cache openssl >/dev/null && openssl req -x509 -nodes -days $Days -newkey rsa:2048 -keyout /certs/localhost.key -out /certs/localhost.crt -subj '/C=VN/O=TechPro/OU=Development/CN=$DnsName' -addext 'subjectAltName=$subjectAltName'"
    & $docker.Source run --rm --mount "type=bind,source=$certsPath,target=/certs" alpine:3.21 sh -c $containerCommand
    if ($LASTEXITCODE -ne 0) {
        throw "Docker could not generate the local TLS certificate."
    }
}

Write-Host "Self-signed certificate created at $certFile"
Write-Host "SAN: $subjectAltName"
Write-Host "Browsers will show a trust warning. Use a trusted certificate for public deployment."

#!/usr/bin/env sh
set -eu

PROJECT_ROOT=$(CDPATH= cd -- "$(dirname -- "$0")/.." && pwd)
cd "$PROJECT_ROOT"

if ! command -v docker >/dev/null 2>&1; then
    echo "Docker is required. Install Docker Desktop or Docker Engine with the Compose plugin." >&2
    exit 1
fi
if ! docker compose version >/dev/null 2>&1; then
    echo "Docker Compose v2 is required." >&2
    exit 1
fi

if [ ! -f .env ]; then
    cp .env.example .env
    echo "Created .env from .env.example; change all sample passwords before sharing this host."
fi

if [ ! -s nginx/certs/localhost.crt ] || [ ! -s nginx/certs/localhost.key ]; then
    sh "$PROJECT_ROOT/scripts/generate-cert.sh"
fi

docker compose config --quiet
docker compose pull
docker compose up -d --wait --wait-timeout 180

echo "TechPro containers are running."
echo "Set WORDPRESS_SITE_URL in .env to the address users will open, then recreate WordPress:"
echo "  docker compose up -d --force-recreate wordpress"
echo "HTTP website: the URL configured in WORDPRESS_SITE_URL"
echo "HTTPS uses a self-signed development certificate; browsers will show a warning."

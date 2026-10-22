#!/usr/bin/env bash
# =============================================================================
# scripts/health-check.sh — Service health verification
# =============================================================================
set -euo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$ROOT"

PASS=0
FAIL=0

check() {
    local name="$1"
    local cmd="$2"
    if eval "$cmd" &>/dev/null; then
        echo -e "\033[32m[PASS]\033[0m $name"
        PASS=$((PASS + 1))
    else
        echo -e "\033[31m[FAIL]\033[0m $name"
        FAIL=$((FAIL + 1))
    fi
}

echo "=== TechPro Health Checks ==="
check "Nginx HTTP health (port 80)" "curl -s -o /dev/null -w '%{http_code}' http://localhost/health | grep -q 200"
check "WordPress over HTTP" "curl -s -o /dev/null -w '%{http_code}' http://localhost/ | grep -qE '2[0-9][0-9]|3[0-9][0-9]'"
check "WordPress over HTTPS (self-signed)" "curl -sk -o /dev/null -w '%{http_code}' https://localhost/ | grep -qE '2[0-9][0-9]|3[0-9][0-9]'"
check "phpMyAdmin (port 8080)" "curl -s -o /dev/null -w '%{http_code}' http://localhost:8080/ | grep -qE '2[0-9][0-9]|3[0-9][0-9]'"
check "Prometheus (port 9090)" "curl -s http://localhost:9090/-/healthy | grep -qi healthy"
check "Grafana (port 3000)" "curl -s http://localhost:3000/api/health | grep -q ok"
check "Loki (port 3100)" "curl -s http://localhost:3100/ready | grep -q ready"
check "MySQL container healthy" "docker inspect --format '{{.State.Health.Status}}' techpro_mysql | grep -q '^healthy$'"
check "Nginx container running" "docker compose ps nginx | grep -q 'running\|Up'"
check "WordPress container running" "docker compose ps wordpress | grep -q 'running\|Up'"

echo ""
echo "Results: $PASS passed, $FAIL failed"
[ "$FAIL" -eq 0 ] && exit 0 || exit 1

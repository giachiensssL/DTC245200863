#!/usr/bin/env sh
set -eu

SCRIPT_DIR=$(CDPATH= cd -- "$(dirname -- "$0")" && pwd)
CERTS_DIR="$SCRIPT_DIR/../nginx/certs"
DNS_NAME=${1:-localhost}
IP_ADDRESS=${2:-127.0.0.1}
DAYS=${3:-365}

if ! command -v openssl >/dev/null 2>&1; then
    echo "OpenSSL is required. Install OpenSSL or use HTTP for local/LAN development." >&2
    exit 1
fi

mkdir -p "$CERTS_DIR"
SUBJECT_ALT_NAME="DNS:$DNS_NAME"
if [ -n "$IP_ADDRESS" ]; then
    SUBJECT_ALT_NAME="$SUBJECT_ALT_NAME,IP:$IP_ADDRESS"
fi

openssl req -x509 -nodes -days "$DAYS" -newkey rsa:2048 \
    -keyout "$CERTS_DIR/localhost.key" \
    -out "$CERTS_DIR/localhost.crt" \
    -subj "/C=VN/O=TechPro/OU=Development/CN=$DNS_NAME" \
    -addext "subjectAltName=$SUBJECT_ALT_NAME"

echo "Self-signed certificate created in $CERTS_DIR"
echo "SAN: $SUBJECT_ALT_NAME"
echo "Browsers will show a trust warning. Use a trusted certificate for public deployment."

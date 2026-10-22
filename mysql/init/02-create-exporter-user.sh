#!/bin/bash
set -e

: "${MYSQL_ROOT_PASSWORD:?MYSQL_ROOT_PASSWORD is required}"
: "${MYSQL_EXPORTER_USER:?MYSQL_EXPORTER_USER is required}"
: "${MYSQL_EXPORTER_PASSWORD:?MYSQL_EXPORTER_PASSWORD is required}"

escape_sql_string() {
    local value=${1//\\/\\\\}
    printf '%s' "${value//\'/\'\'}"
}

exporter_user=$(escape_sql_string "$MYSQL_EXPORTER_USER")
exporter_password=$(escape_sql_string "$MYSQL_EXPORTER_PASSWORD")

mysql --protocol=socket -uroot -p"$MYSQL_ROOT_PASSWORD" <<EOSQL
CREATE USER IF NOT EXISTS '${exporter_user}'@'%' IDENTIFIED BY '${exporter_password}';
ALTER USER '${exporter_user}'@'%' IDENTIFIED BY '${exporter_password}';
GRANT PROCESS, REPLICATION CLIENT, SELECT ON *.* TO '${exporter_user}'@'%';
GRANT SELECT ON performance_schema.* TO '${exporter_user}'@'%';
FLUSH PRIVILEGES;
EOSQL

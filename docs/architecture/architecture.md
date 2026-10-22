# Architecture Diagram — TechPro WordPress

## Mermaid Source

```mermaid
graph TB
    subgraph Internet["🌐 Internet / User Browser"]
        Browser["👤 Browser"]
    end

    subgraph Docker["🐳 Docker Host — DTC245200863"]
        subgraph FrontendNet["frontend_net"]
            Nginx["nginx:1.25-alpine\n🔀 Reverse Proxy\nPort: 80, 443, 8080"]
        end

        subgraph AppNet["app_net"]
            WordPress["wordpress:7.1.3-php8.3-fpm-alpine\n📝 WordPress CMS\nPort: 9000 (FPM)"]
            phpMyAdmin["phpmyadmin:5.2.1\n🗄️ DB Admin UI\nPort: 80"]
        end

        subgraph DBNet["db_net (internal)"]
            MySQL["mysql:8.0.46\n💾 Database\nPort: 3306"]
        end

        subgraph MonNet["monitoring_net"]
            Prometheus["prom/prometheus:v3.15.1\n📊 Metrics Store\nPort: 9090"]
            Grafana["grafana/grafana:13.2.4\n📈 Dashboards\nPort: 3000"]
            Loki["grafana/loki:2.9.4\n📋 Log Store\nPort: 3100"]
            Promtail["grafana/promtail:2.9.4\n🔍 Log Collector"]
            cAdvisor["cadvisor:0.49\n📦 Container Metrics\nPort: 8080"]
            NodeExp["node-exporter:1.7\n🖥️ Host Metrics\nPort: 9100"]
            NginxExp["nginx-exporter:1.1\n⚙️ Nginx Metrics\nPort: 9113"]
            MySQLExp["mysqld-exporter:0.15\n🔌 MySQL Metrics\nPort: 9104"]
        end

        subgraph Volumes["📁 Named Volumes"]
            V1[(mysql_data)]
            V2[(wordpress_data)]
            V3[(grafana_data)]
            V4[(prometheus_data)]
            V5[(loki_data)]
        end
    end

    Browser -->|"HTTP :80 / HTTPS :443"| Nginx
    Browser -->|"HTTP :8080"| Nginx
    Nginx -->|"FastCGI :9000"| WordPress
    Nginx -->|"HTTP proxy"| phpMyAdmin
    WordPress -->|"MySQL :3306"| MySQL
    phpMyAdmin -->|"MySQL :3306"| MySQL
    MySQL --- V1
    WordPress --- V2

    Prometheus -->|"scrape"| cAdvisor
    Prometheus -->|"scrape"| NodeExp
    Prometheus -->|"scrape"| NginxExp
    Prometheus -->|"scrape"| MySQLExp
    Prometheus --- V4
    Grafana -->|"query"| Prometheus
    Grafana -->|"query"| Loki
    Grafana --- V3
    Promtail -->|"push logs"| Loki
    Loki --- V5
    NginxExp -->|"stub_status :8081"| Nginx
    MySQLExp -->|"read-only"| MySQL
```

## Service Responsibilities

| Service | Image | Role | Network |
|---|---|---|---|
| nginx | nginx:1.25-alpine | Reverse proxy, HTTPS termination, security headers | frontend_net, app_net |
| wordpress | wordpress:7.1.3-php8.3-fpm-alpine | WordPress PHP-FPM application | app_net, db_net |
| mysql | mysql:8.0.46 | Relational database | db_net (internal) |
| phpmyadmin | phpmyadmin:5.2.1 | Database management UI | app_net, db_net |
| prometheus | prom/prometheus:v3.15.1 | Metrics collection and storage | monitoring_net |
| grafana | grafana/grafana:13.2.4 | Dashboards and visualization | monitoring_net |
| loki | grafana/loki:2.9.4 | Log aggregation and query | monitoring_net |
| promtail | grafana/promtail:2.9.4 | Log collector (EOL, academic use) | monitoring_net |
| cadvisor | gcr.io/cadvisor/cadvisor:v0.49.1 | Container CPU/memory metrics | monitoring_net |
| node_exporter | prom/node-exporter:v1.7.0 | Host OS metrics | monitoring_net |
| nginx_exporter | nginx/nginx-prometheus-exporter:1.5.0 | Nginx stub_status metrics | monitoring_net, frontend_net |
| mysql_exporter | prom/mysqld-exporter:v0.15.1 | MySQL performance metrics | monitoring_net, db_net |

## Network Isolation

- **frontend_net**: Only Nginx is exposed externally. Browser → Nginx only.
- **app_net**: Nginx ↔ WordPress ↔ phpMyAdmin communication.
- **db_net** (internal): MySQL only reachable from app_net services. NOT exposed to host.
- **monitoring_net**: Isolated monitoring stack. Prometheus, Grafana, Loki, exporters.

## Port Exposure Summary

| Port | Service | Binding | Purpose |
|---|---|---|---|
| 80 | nginx | 0.0.0.0 (configurable) | HTTP (local/LAN development) |
| 443 | nginx | 0.0.0.0 (configurable) | HTTPS (self-signed by default) |
| 8080 | nginx | 127.0.0.1 | phpMyAdmin (local only) |
| 9090 | prometheus | 127.0.0.1 | Prometheus UI (local only) |
| 3000 | grafana | 127.0.0.1 | Grafana UI (local only) |
| 3100 | loki | 127.0.0.1 | Loki API (local only) |
| 3306 | mysql | NOT EXPOSED | Internal only |
| 9100 | node_exporter | NOT EXPOSED | Internal only |
| 9104 | mysql_exporter | NOT EXPOSED | Internal only |
| 9113 | nginx_exporter | NOT EXPOSED | Internal only |

The WordPress canonical URL is configured with `WORDPRESS_SITE_URL`. On Windows/macOS, Docker Desktop runs Linux containers in a VM; cAdvisor and Node Exporter metrics describe that VM rather than the complete host OS.

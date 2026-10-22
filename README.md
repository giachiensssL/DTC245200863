# TechPro — Website Giới Thiệu Sản Phẩm Công Nghệ

> **Môn học:** Triển Khai và Quản Trị Hệ Thống Phần Mềm  
> **Đề tài 3:** Website Quảng Bá Sản Phẩm Sử Dụng WordPress  
> **MSSV:** DTC245200863  
> **Trường:** [Tên trường đại học]  

---

## 📑 Mục lục

- [1. Tổng quan dự án](#1-tổng-quan-dự-án)
- [2. Công nghệ sử dụng](#2-công-nghệ-sử-dụng)
- [3. Kiến trúc hệ thống](#3-kiến-trúc-hệ-thống)
- [4. Cấu trúc thư mục](#4-cấu-trúc-thư-mục)
- [5. Yêu cầu hệ thống](#5-yêu-cầu-hệ-thống)
- [6. Cài đặt và cấu hình](#6-cài-đặt-và-cấu-hình)
- [7. Khởi động hệ thống](#7-khởi-động-hệ-thống)
- [8. Truy cập các dịch vụ](#8-truy-cập-các-dịch-vụ)
- [9. Khởi tạo WordPress](#9-khởi-tạo-wordpress)
- [10. Giám sát Prometheus & Grafana](#10-giám-sát-prometheus--grafana)
- [11. Logging Loki & Promtail](#11-logging-loki--promtail)
- [12. Bảo mật](#12-bảo-mật)
- [13. Kiểm thử](#13-kiểm-thử)
- [14. Git milestones](#14-git-milestones)
- [15. Khắc phục sự cố](#15-khắc-phục-sự-cố)
- [16. Dọn dẹp](#16-dọn-dẹp)

---

## 1. Tổng quan dự án

**TechPro** là website quảng bá sản phẩm công nghệ (thương hiệu học thuật), được xây dựng bằng WordPress và triển khai hoàn toàn bằng Docker. Dự án thỏa mãn 9 yêu cầu kỹ thuật của môn học:

| # | Yêu cầu | Công nghệ |
|---|---|---|
| 1 | Quản lý mã nguồn | Git + GitHub |
| 2 | Website WordPress | WordPress 6.4 + Custom Theme |
| 3 | Cơ sở dữ liệu | MySQL 8.0 + phpMyAdmin |
| 4 | Reverse Proxy | Nginx + HTTPS (self-signed) |
| 5 | Giám sát metrics | Prometheus + Exporters |
| 6 | Dashboard | Grafana |
| 7 | Logging tập trung | Loki + Promtail |
| 8 | Bảo mật | Network isolation, security headers, least-privilege |
| 9 | Docker Compose | 12 services, 4 networks, 5 volumes |

---

## 2. Công nghệ sử dụng

| Thành phần | Image/Phiên bản | Mục đích |
|---|---|---|
| **WordPress** | wordpress:6.4.3-php8.1-fpm-alpine | CMS chính |
| **MySQL** | mysql:8.0.36 | Cơ sở dữ liệu |
| **phpMyAdmin** | phpmyadmin:5.2.1-apache | Quản trị database |
| **Nginx** | nginx:1.25-alpine | Reverse proxy + HTTPS |
| **Prometheus** | prom/prometheus:v2.50.1 | Thu thập metrics |
| **Grafana** | grafana/grafana:10.3.3 | Dashboard trực quan |
| **Loki** | grafana/loki:2.9.4 | Lưu trữ logs |
| **Promtail** | grafana/promtail:2.9.4 | Thu thập logs (EOL*) |
| **cAdvisor** | gcr.io/cadvisor/cadvisor:v0.49.1 | Container metrics |
| **Node Exporter** | prom/node-exporter:v1.7.0 | Host metrics |
| **Nginx Exporter** | nginx/nginx-prometheus-exporter:1.1.0 | Nginx metrics |
| **MySQL Exporter** | prom/mysqld-exporter:v0.15.1 | MySQL metrics |

> ⚠️ *Promtail đã đạt End-of-Life. Được sử dụng theo yêu cầu học thuật của bài tập. Phiên bản thay thế trong production: [Grafana Alloy](https://grafana.com/docs/alloy/).

---

## 3. Kiến trúc hệ thống

```
Browser
  │
  ▼
[Nginx :80/:443/:8080] ──── frontend_net
  │                              │
  ├─ FastCGI :9000 ──── app_net ─┤
  │     │                        │
  │  [WordPress]         [phpMyAdmin]
  │     │                    │
  └─────┼────── db_net ──────┘
        │       (internal)
        │
      [MySQL]
        │
        └── db_net ── [MySQL Exporter] ── monitoring_net
                                               │
                              [Prometheus] ────┤
                              [cAdvisor]       │
                              [Node Exporter]  │
                              [Nginx Exporter] │
                                    │
                              [Grafana] ────── [Loki]
                                               │
                                          [Promtail]
```

**Xem sơ đồ chi tiết:** `docs/architecture/architecture.md`

### Mạng Docker

| Network | Loại | Dịch vụ | Ghi chú |
|---|---|---|---|
| `techpro_frontend` | bridge | nginx | Entry point công cộng |
| `techpro_app` | bridge | nginx, wordpress, phpmyadmin | Tầng ứng dụng |
| `techpro_db` | bridge (internal) | mysql, wordpress, phpmyadmin, mysql_exporter | Cô lập, không public |
| `techpro_monitoring` | bridge | prometheus, grafana, loki, promtail, exporters | Giám sát nội bộ |

---

## 4. Cấu trúc thư mục

```
DTC245200863-topic3-wordpress-product/
├── docker-compose.yml          # Cấu hình toàn bộ stack
├── .env.example                # Mẫu biến môi trường
├── .env                        # Biến thực (KHÔNG commit)
├── .gitignore
├── README.md
│
├── nginx/
│   ├── conf.d/
│   │   └── default.conf        # Reverse proxy + HTTPS + security headers
│   ├── certs/                  # SSL certificates (KHÔNG commit)
│   │   ├── README.md
│   │   ├── localhost.crt       # (tạo cục bộ)
│   │   └── localhost.key       # (tạo cục bộ)
│   └── logs/                   # Access/error logs (KHÔNG commit)
│
├── wordpress/
│   └── wp-content/
│       └── themes/
│           └── techpro/        # Custom theme TechPro
│               ├── style.css
│               ├── functions.php
│               ├── header.php
│               ├── footer.php
│               ├── index.php
│               ├── single.php
│               ├── archive.php
│               ├── page-contact.php
│               ├── page-about.php
│               └── assets/js/main.js
│
├── mysql/
│   └── init/
│       └── 01-init.sql         # DB init: privileges, monitoring user
│
├── prometheus/
│   └── prometheus.yml          # Scrape jobs cấu hình
│
├── grafana/
│   ├── provisioning/
│   │   ├── datasources/
│   │   │   └── datasources.yml # Prometheus + Loki auto-provision
│   │   └── dashboards/
│   │       └── dashboards.yml  # Dashboard provider
│   └── dashboards/
│       └── techpro-main.json   # Main dashboard
│
├── loki/
│   └── loki-config.yml         # Loki storage + retention config
│
├── promtail/
│   └── promtail-config.yml     # Log scrape: Nginx + Docker containers
│
├── scripts/
│   ├── deploy.ps1              # Deployment script (PowerShell)
│   ├── generate-cert.ps1       # SSL cert generation
│   └── health-check.sh         # Health check script
│
├── tests/
│   └── test-plan.md            # Test cases + LogQL examples
│
└── docs/
    ├── architecture/
    │   └── architecture.md     # Mermaid diagram + service table
    ├── screenshots/            # Screenshots bằng chứng
    └── report/                 # Báo cáo kỹ thuật
```

---

## 5. Yêu cầu hệ thống

| Yêu cầu | Tối thiểu | Khuyến nghị |
|---|---|---|
| RAM | 4 GB | 8 GB |
| CPU | 2 cores | 4 cores |
| Disk | 20 GB free | 40 GB free |
| OS | Windows 10/11, macOS, Linux | Linux/macOS |
| Docker | 24.0+ | 26.0+ |
| Docker Compose | 2.20+ | 2.27+ |
| OpenSSL | 3.x | 3.x (để tạo cert) |

---

## 6. Cài đặt và cấu hình

### Bước 1: Clone repository

```bash
git clone https://github.com/YOUR_GITHUB_USERNAME/DTC245200863-topic3-wordpress-product.git
cd DTC245200863-topic3-wordpress-product
```

### Bước 2: Tạo file .env

```bash
# Linux/macOS
cp .env.example .env

# Windows PowerShell
Copy-Item .env.example .env
```

Chỉnh sửa `.env` và thay thế các password mặc định:

```env
MYSQL_ROOT_PASSWORD=<mật_khẩu_mạnh>
MYSQL_PASSWORD=<mật_khẩu_wordpress>
GF_SECURITY_ADMIN_PASSWORD=<mật_khẩu_grafana>
MYSQL_EXPORTER_PASSWORD=<mật_khẩu_exporter>
```

> ⚠️ **QUAN TRỌNG:** KHÔNG commit file `.env` vào Git!

### Bước 3: Tạo SSL certificate

**Windows (PowerShell):**
```powershell
.\scripts\generate-cert.ps1
```

**Linux/macOS:**
```bash
mkdir -p nginx/certs
openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
  -keyout nginx/certs/localhost.key \
  -out nginx/certs/localhost.crt \
  -subj "/C=VN/ST=HoChiMinh/L=HoChiMinh/O=TechPro/CN=localhost" \
  -addext "subjectAltName=DNS:localhost,IP:127.0.0.1"
```

> ℹ️ Certificate tự ký cho môi trường phát triển cục bộ. Browser sẽ hiển thị cảnh báo bảo mật — đây là hành vi bình thường đối với self-signed certificate.

### Bước 4: Tạo thư mục logs và data

```bash
mkdir -p nginx/logs
```

---

## 7. Khởi động hệ thống

### Khởi động toàn bộ stack

```bash
docker compose up -d
```

### Chờ services healthy (khoảng 2-3 phút)

```bash
# Theo dõi trạng thái
docker compose ps

# Xem logs
docker compose logs -f

# Chỉ xem logs WordPress
docker compose logs -f wordpress
```

### Dừng hệ thống

```bash
docker compose down
```

### Khởi động lại

```bash
docker compose restart
```

---

## 8. Truy cập các dịch vụ

| Dịch vụ | URL | Tài khoản |
|---|---|---|
| **Website WordPress** | https://localhost | Cấu hình lúc setup |
| **WordPress Admin** | https://localhost/wp-admin | admin / (setup) |
| **phpMyAdmin** | http://localhost:8080 | root / MYSQL_ROOT_PASSWORD |
| **Grafana** | http://localhost:3000 | admin / GF_SECURITY_ADMIN_PASSWORD |
| **Prometheus** | http://localhost:9090 | Không cần auth |
| **Loki API** | http://localhost:3100 | Không cần auth |

> ℹ️ Prometheus, Grafana, Loki chỉ bind vào 127.0.0.1 — không thể truy cập từ mạng ngoài.

---

## 9. Khởi tạo WordPress

### Lần đầu setup

1. Mở https://localhost
2. Bỏ qua cảnh báo SSL (certificate self-signed)
3. Chọn ngôn ngữ: **Tiếng Việt**
4. Nhập thông tin site:
   - **Tên site:** TechPro — Thiết Bị Công Nghệ
   - **Tên đăng nhập:** `admin`
   - **Mật khẩu:** (mạnh)
   - **Email:** `admin@techpro.vn`
5. Nhấn **Cài đặt WordPress**

### Kích hoạt theme TechPro

```
WP Admin → Giao diện → Themes → TechPro → Activate
```

### Tạo Custom Post Types

Theme tự động đăng ký CPT `product` và taxonomy `product_cat` khi activate.

### Tạo trang mẫu

```
WP Admin → Pages → Add New
- Trang Liên Hệ: Template = "Trang Liên Hệ"
- Về Chúng Tôi: Template = "Trang Về Chúng Tôi"
```

---

## 10. Giám sát Prometheus & Grafana

### Kiểm tra Prometheus Targets

1. Mở http://localhost:9090/targets
2. Xác nhận tất cả targets đều ở trạng thái **UP**:
   - `prometheus` (self)
   - `cadvisor`
   - `node_exporter`
   - `nginx`
   - `mysql`

### Đăng nhập Grafana

1. Mở http://localhost:3000
2. Tài khoản: `admin` / `GF_SECURITY_ADMIN_PASSWORD` (trong .env)
3. Dashboard tự động được provision tại: **TechPro WordPress → TechPro WordPress — Hệ Thống Giám Sát**

### Panels trong Dashboard

| Panel | Metric | Mô tả |
|---|---|---|
| Container CPU Usage | `container_cpu_usage_seconds_total` | CPU từng container |
| Container Memory | `container_memory_working_set_bytes` | RAM từng container |
| Host CPU | `node_cpu_seconds_total` | CPU tổng host |
| Host Memory | `node_memory_MemAvailable_bytes` | RAM host khả dụng |
| Nginx Connections | `nginx_connections_active` | Kết nối Nginx |
| MySQL Uptime | `mysql_global_status_uptime` | Thời gian MySQL chạy |
| Nginx Request Rate | `nginx_http_requests_total` | Requests/s |
| MySQL Connections | `mysql_global_status_threads_connected` | Threads connected |

---

## 11. Logging Loki & Promtail

### Kiểm tra Loki

```bash
curl -s http://localhost:3100/ready
# Output: ready
```

### Xem logs trong Grafana

1. Grafana → **Explore**
2. Chọn data source: **Loki**
3. Chạy các LogQL queries:

### LogQL Examples

```logql
# Query 1: Tất cả Nginx access logs
{job="nginx"}
```

```logql
# Query 2: Lọc POST requests
{job="nginx"} |= "POST"
```

```logql
# Query 3: Lọc HTTP 5xx errors
{job="nginx"} |= " 5"
```

```logql
# Query 4: Parse access log và lọc status >= 500
{job="nginx", log_type="access"} 
  | pattern `<ip> - - [<_>] "<method> <uri> <_>" <status> <_>`
  | status >= "500"
```

```logql
# Query 5: WordPress container errors
{job="docker_containers", service="wordpress"} |~ "error|Error|WARNING"
```

```logql
# Query 6: Tất cả container logs dự án
{compose_project="techpro_wp"} | line_format "{{.service}}: {{.line}}"
```

> ℹ️ **Lưu ý:** Promtail 2.9.4 là phiên bản EOL, được sử dụng theo yêu cầu học thuật. Production alternative: Grafana Alloy.

---

## 12. Bảo mật

### Checklist bảo mật

| # | Biện pháp | Cách kiểm tra | Trạng thái |
|---|---|---|---|
| 1 | **Network isolation** — db_net là internal network | `docker network inspect techpro_db` | ✅ |
| 2 | **Non-root users** — Prometheus (nobody), Grafana (472), Loki (10001) | `docker inspect --format '{{.Config.User}}' <container>` | ✅ |
| 3 | **Least-privilege DB** — wordpress_user chỉ có quyền cần thiết | `mysql -u root -e "SHOW GRANTS FOR 'wordpress_user'@'%'"` | ✅ |
| 4 | **Monitoring account read-only** — exporter chỉ PROCESS, REPLICATION CLIENT, SELECT | `SHOW GRANTS FOR 'exporter'@'%'` | ✅ |
| 5 | **Nginx security headers** — X-Frame-Options, X-Content-Type-Options, etc. | `curl -skI https://localhost/` | ✅ |
| 6 | **HTTPS bắt buộc** — HTTP redirect sang HTTPS | `curl -si http://localhost/` → 301 | ✅ |
| 7 | **Ports tối thiểu** — Monitoring chỉ bind 127.0.0.1 | `docker compose ps` | ✅ |
| 8 | **no-new-privileges** — Tất cả services trừ cAdvisor | `security_opt: [no-new-privileges:true]` | ✅ |
| 9 | **Secrets qua .env** — Không hardcode trong code | `git log --all -p | grep -i password` | ✅ |
| 10 | **Image version pinned** — Không dùng :latest | `grep image: docker-compose.yml` | ✅ |
| 11 | **Health checks** — MySQL, WordPress, Nginx | `docker compose ps` (health column) | ✅ |
| 12 | **Restart policies** — `unless-stopped` trên all services | `grep restart docker-compose.yml` | ✅ |

### Headers bảo mật Nginx

```
X-Frame-Options: SAMEORIGIN
X-Content-Type-Options: nosniff
X-XSS-Protection: 1; mode=block
Referrer-Policy: strict-origin-when-cross-origin
Permissions-Policy: geolocation=(), microphone=(), camera=()
Strict-Transport-Security: max-age=31536000; includeSubDomains
Content-Security-Policy: default-src 'self' https: data: 'unsafe-inline' 'unsafe-eval';
```

### Kiểm tra headers

```bash
curl -skI https://localhost/ | grep -E "X-Frame|X-Content|X-XSS|Strict|Referrer|Content-Security"
```

---

## 13. Kiểm thử

### Chạy health check script

```bash
# Linux/macOS
bash scripts/health-check.sh

# Windows (manual checks)
curl -sk https://localhost/health
curl -s http://localhost:9090/-/healthy
curl -s http://localhost:3000/api/health
curl -s http://localhost:3100/ready
```

### Kiểm tra MySQL

```bash
docker compose exec mysql mysqladmin ping -h localhost -u root -p
docker compose exec mysql mysql -u root -p -e "SHOW DATABASES;"
```

### Kiểm tra persistence

```bash
# 1. Ghi nhớ số bài viết
curl -sk https://localhost/wp-json/wp/v2/posts | python -m json.tool

# 2. Restart MySQL
docker compose restart mysql
sleep 30

# 3. Kiểm tra dữ liệu còn nguyên
curl -sk https://localhost/wp-json/wp/v2/posts | python -m json.tool
```

**Test matrix chi tiết:** `tests/test-plan.md`

---

## 14. Git milestones

```bash
# Milestone 1: Base deployment
git commit -m "feat: deploy WordPress MySQL phpMyAdmin and Nginx"

# Milestone 2: Monitoring
git commit -m "feat: add Prometheus exporters and Grafana monitoring"

# Milestone 3: Logging
git commit -m "feat: add Loki Promtail and LogQL centralized logging"

# Milestone 4: Security
git commit -m "security: harden containers and isolate networks"

# Milestone 5: Testing & docs
git commit -m "docs: complete Vietnamese deployment report and README"
```

---

## 15. Khắc phục sự cố

### WordPress không kết nối được MySQL

```bash
# Kiểm tra MySQL healthy
docker compose ps mysql
docker compose logs mysql

# Test connectivity
docker compose exec wordpress ping mysql
```

### Nginx 502 Bad Gateway

```bash
# Kiểm tra WordPress FPM đang chạy
docker compose logs wordpress
docker compose exec nginx nginx -t
```

### Prometheus target DOWN

```bash
# Kiểm tra exporter logs
docker compose logs mysql_exporter
docker compose logs nginx_exporter

# Test kết nối nội bộ từ Prometheus container
docker compose exec prometheus wget -qO- http://nginx_exporter:9113/metrics | head -20
```

### Loki không nhận logs

```bash
# Kiểm tra Promtail
docker compose logs promtail

# Kiểm tra Loki ready
curl -s http://localhost:3100/ready

# Kiểm tra labels
curl -s http://localhost:3100/loki/api/v1/labels | python -m json.tool
```

### SSL certificate error

```bash
# Tạo lại certificate
.\scripts\generate-cert.ps1  # Windows

# Kiểm tra cert tồn tại
ls nginx/certs/
```

### Grafana không thấy data

```bash
# Kiểm tra Prometheus có dữ liệu
curl -s "http://localhost:9090/api/v1/query?query=up" | python -m json.tool

# Reload Grafana datasource
curl -X POST http://admin:password@localhost:3000/api/datasources
```

---

## 16. Dọn dẹp

### Dừng và xóa containers (GIỮ volumes)

```bash
docker compose down
```

### Dừng và xóa containers + images

```bash
docker compose down --rmi local
```

### ⚠️ XÓA TOÀN BỘ bao gồm volumes (MẤT DỮ LIỆU DATABASE)

```bash
# CẢNH BÁO: Lệnh này sẽ XÓA TOÀN BỘ dữ liệu WordPress và MySQL!
# Không thể hoàn tác!
docker compose down -v --remove-orphans
```

### Xóa images đã pull

```bash
docker compose down --rmi all
```

---

## 📝 Thông tin học thuật

- **Sinh viên:** [Họ tên] — MSSV: DTC245200863
- **Môn học:** Triển Khai và Quản Trị Hệ Thống Phần Mềm
- **Đề tài:** 3 — Website Quảng Bá Sản Phẩm Sử Dụng WordPress
- **Thương hiệu:** TechPro — Thương hiệu học thuật, không phải doanh nghiệp thực
- **Repository:** `DTC245200863-topic3-wordpress-product`

---

*© 2024 Dự án học thuật — Triển Khai & Quản Trị Hệ Thống Phần Mềm*

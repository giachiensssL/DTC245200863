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
| 2 | Website WordPress | WordPress 7.1 + Custom Theme |
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
| **WordPress** | wordpress:7.1.3-php8.3-fpm-alpine | CMS chính |
| **MySQL** | mysql:8.0.46 | Cơ sở dữ liệu |
| **phpMyAdmin** | phpmyadmin:5.2.1-apache | Quản trị database |
| **Nginx** | nginx:1.25-alpine | Reverse proxy + HTTPS |
| **Prometheus** | prom/prometheus:v3.15.1 | Thu thập metrics |
| **Grafana** | grafana/grafana:13.2.4 | Dashboard trực quan |
| **Loki** | grafana/loki:2.9.4 | Lưu trữ logs |
| **Promtail** | grafana/promtail:2.9.4 | Thu thập logs (EOL*) |
| **cAdvisor** | gcr.io/cadvisor/cadvisor:v0.49.1 | Container metrics |
| **Node Exporter** | prom/node-exporter:v1.7.0 | Host metrics |
| **Nginx Exporter** | nginx/nginx-prometheus-exporter:1.5.0 | Nginx metrics |
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
│   └── promtail-config.yml     # Log scrape: Nginx access/error logs
│
├── scripts/
│   ├── deploy.ps1              # Deployment script (PowerShell)
│   ├── deploy.sh               # Deployment script (Linux/macOS)
│   ├── generate-cert.ps1       # Development certificate (PowerShell)
│   ├── generate-cert.sh        # Development certificate (Linux/macOS)
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
| OpenSSL | Tùy chọn | 3.x; hoặc Docker để tạo cert |

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

Đặt URL website theo địa chỉ người dùng sẽ mở:

```env
WORDPRESS_SITE_URL=http://localhost
WEB_BIND_ADDRESS=127.0.0.1
```

### Bước 3: Tạo SSL certificate

**Windows (PowerShell):**
```powershell
.\scripts\generate-cert.ps1
```

**Linux/macOS:**
```bash
sh scripts/generate-cert.sh
```

Để tạo chứng chỉ dev có tên host và IP trong SAN:

```powershell
.\scripts\generate-cert.ps1 -DnsName techpro.local -IpAddress 192.168.1.20
```

```bash
sh scripts/generate-cert.sh techpro.local 192.168.1.20
```

> ℹ️ Chứng chỉ tự ký dùng cho phát triển sẽ hiện cảnh báo trình duyệt. Triển khai Internet cần domain và chứng chỉ TLS được CA tin cậy cấp.

### Bước 4: Tạo thư mục logs và data

```bash
mkdir -p nginx/logs
```

---

## 7. Khởi động hệ thống

### Khởi động toàn bộ stack

Windows PowerShell:
```powershell
.\scripts\deploy.ps1
```

Linux/macOS:
```bash
sh scripts/deploy.sh
```

Hoặc sau khi đã tạo certificate:
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
| **Website WordPress** | URL trong `WORDPRESS_SITE_URL` (mặc định `http://localhost`) | Cấu hình lúc setup |
| **WordPress Admin** | `<WORDPRESS_SITE_URL>/wp-admin` | Tài khoản tạo lúc setup |
| **phpMyAdmin** | http://localhost:8080 | root / MYSQL_ROOT_PASSWORD |
| **Grafana** | http://localhost:3000 | admin / GF_SECURITY_ADMIN_PASSWORD |
| **Prometheus** | http://localhost:9090 | Không cần auth |
| **Loki API** | http://localhost:3100 | Không cần auth |

> ℹ️ phpMyAdmin, Prometheus, Grafana và Loki chỉ bind vào `127.0.0.1`. Không mở các cổng quản trị này ra mạng ngoài.

### Truy cập từ thiết bị khác cùng mạng LAN

1. Lấy IPv4 LAN của máy chạy Docker (ví dụ `192.168.1.20`): `ipconfig` (Windows), `ipconfig getifaddr en0` (macOS), hoặc `hostname -I` (Linux).
2. Đặt trong `.env`:

   ```env
   WORDPRESS_SITE_URL=http://192.168.1.20
   WEB_BIND_ADDRESS=0.0.0.0
   ```

3. Cho phép cổng HTTP (mặc định `80`) qua firewall của máy chủ.
4. Áp dụng URL mới bằng `docker compose up -d --force-recreate wordpress nginx`.
5. Mở `http://192.168.1.20` ở thiết bị khác.

`localhost` luôn trỏ về thiết bị đang mở trình duyệt. HTTP không mã hóa dữ liệu, chỉ dùng trong mạng tin cậy; không đưa cấu hình này ra Internet. HTTPS hiện dùng chứng chỉ tự ký. Để HTTPS không cảnh báo, cần domain/IP cùng chứng chỉ hợp lệ được CA tin cậy cấp và đặt `WORDPRESS_SITE_URL` đúng domain.

Docker images không bị ghim vào AMD64, cho phép Docker chọn kiến trúc image phù hợp với máy chủ. Windows/macOS cần Docker Desktop ở chế độ Linux containers. Với Docker Desktop, số liệu cAdvisor/Node Exporter phản ánh Linux VM của Docker, không đại diện đầy đủ cho Windows/macOS host.

Các image đang dùng đều cung cấp manifest `linux/amd64` và `linux/arm64`; máy Apple Silicon/Raspberry Pi không cần giả lập AMD64. Nếu trình duyệt từng lưu HSTS cho `localhost` từ cấu hình cũ, có thể xóa chính sách HSTS của `localhost` trong trình duyệt hoặc dùng hostname/IP LAN đã cấu hình.

---

## 9. Khởi tạo WordPress

### Lần đầu setup

1. Mở địa chỉ trong `WORDPRESS_SITE_URL` (mặc định `http://localhost`)
3. Chọn ngôn ngữ: **Tiếng Việt**
4. Nhập thông tin site:
   - **Tên site:** TechPro — Thiết Bị Công Nghệ
   - **Tên đăng nhập:** `admin`
   - **Mật khẩu:** (mạnh)
   - **Email:** `admin@techpro.vn`
5. Nhấn **Cài đặt WordPress**

### Kích hoạt theme TechPro

Sau khi hoàn tất cài đặt WordPress lần đầu, có thể khởi tạo theme, các trang, menu và 8 sản phẩm demo tự động bằng PowerShell:

```powershell
docker cp .\scripts\initialize-wordpress.php techpro_wordpress:/tmp/initialize-wordpress.php
docker compose exec -T wordpress php /tmp/initialize-wordpress.php
```

Script có thể chạy lại an toàn: cập nhật các nội dung demo theo slug, tạo lại menu TechPro và chỉ xóa bài viết mặc định có slug `chao-moi-nguoi`. Ảnh sản phẩm là SVG nội bộ trong `wordpress/wp-content/themes/techpro/assets/products`.

Theme tự đăng ký Custom Post Type `product` và taxonomy `product_cat`; script tạo trang tĩnh, gán đúng page template, đặt Trang chủ làm front page và gắn menu vào vị trí điều hướng chính.

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

> Trên Docker Desktop for Windows/macOS, Node Exporter và cAdvisor thu thập số liệu từ môi trường Linux của Docker Desktop; chúng không đại diện đầy đủ cho host Windows/macOS.

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

> ℹ️ **Lưu ý:** Promtail thu thập Nginx access/error logs qua thư mục chia sẻ, tránh phụ thuộc vào đường dẫn log nội bộ riêng của Linux. Promtail 2.9.4 đã EOL; production nên dùng Grafana Alloy.

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
| 6 | **HTTP cho LAN/dev, HTTPS tùy chọn** — HTTPS dùng cert tự ký | `curl -si http://localhost/` → 200 | Dev |
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
Content-Security-Policy: default-src 'self' https: data: 'unsafe-inline' 'unsafe-eval';
```

### Kiểm tra headers

```bash
curl -sI http://localhost/ | grep -E "X-Frame|X-Content|X-XSS|Referrer|Content-Security"
```

---

## 13. Kiểm thử

### Chạy health check script

```bash
# Linux/macOS
bash scripts/health-check.sh

# Windows (manual checks)
curl -s http://localhost/health
curl -s http://localhost/
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

- **Sinh viên:** Giàng A Chiến — MSSV: DTC245200863
- **Môn học:** Triển Khai và Quản Trị Hệ Thống Phần Mềm
- **Đề tài:** 3 — Website Quảng Bá Sản Phẩm Sử Dụng WordPress
- **Thương hiệu:** TechPro — Thương hiệu học thuật, không phải doanh nghiệp thực
- **Repository:** `DTC245200863-topic3-wordpress-product`

---

*© 2024 Dự án học thuật — Triển Khai & Quản Trị Hệ Thống Phần Mềm*

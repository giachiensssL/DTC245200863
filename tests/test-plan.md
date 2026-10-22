# Test Plan — TechPro WordPress Deployment
# Student ID: DTC245200863

## Test Matrix

| ID | Tên Test | Mục tiêu | Điều kiện | Thủ tục | Kết quả mong đợi | Kết quả thực tế | Trạng thái |
|---|---|---|---|---|---|---|---|
| TC01 | Website qua Nginx | Nginx phục vụ WordPress | Stack đang chạy | `curl -s http://localhost/` | HTTP 200, WordPress HTML | — | NOT TESTED |
| TC02 | Tạo và lấy nội dung | WordPress + MySQL hoạt động | WP initialized | Tạo bài viết, kiểm tra trên frontend | Nội dung hiển thị | — | NOT TESTED |
| TC03 | WP kết nối MySQL | DB connection | Stack đang chạy | Xem WP logs `docker compose logs wordpress` | Không có lỗi DB | — | NOT TESTED |
| TC04 | phpMyAdmin kết nối MySQL | DB admin UI | Stack đang chạy | Mở http://localhost:8080, đăng nhập | Tables WP hiển thị | — | NOT TESTED |
| TC05 | Data persistence sau restart | Volumes hoạt động | Có dữ liệu WP | `docker compose restart mysql wordpress`, kiểm tra nội dung | Dữ liệu không mất | — | NOT TESTED |
| TC06 | HTTPS tùy chọn và security headers | Nginx SSL | Cert tồn tại | `curl -skI https://localhost/` | 200, headers bảo mật; cert dev tự ký | — | NOT TESTED |
| TC07 | Prometheus targets up | Monitoring | Stack chạy | Mở http://localhost:9090/targets | Tất cả targets UP | — | NOT TESTED |
| TC08 | Grafana hiển thị metrics | Dashboard | Prometheus có data | Mở http://localhost:3000, xem dashboard | Panels có dữ liệu | — | NOT TESTED |
| TC09 | Loki nhận logs | Log ingestion | Stack chạy | Grafana → Explore → Loki → query | Logs hiện thị | — | NOT TESTED |
| TC10 | LogQL queries | Log querying | Loki có logs | Chạy 3 LogQL queries | Kết quả hợp lệ | — | NOT TESTED |
| TC11 | Cổng quản trị chỉ bind local | Port security | Stack chạy | `docker compose ps` | phpMyAdmin/monitoring bind 127.0.0.1; web bind theo WEB_BIND_ADDRESS | — | NOT TESTED |
| TC12 | Services restart và recover | Restart policy | Stack chạy | `docker compose restart nginx`, kiểm tra | Service tự recovery | — | NOT TESTED |
| TC13 | Docker Compose management | Compose control | Docker running | `docker compose up/down/ps/logs` | Commands hoạt động | — | NOT TESTED |

## LogQL Examples

```logql
# Query 1: Tất cả logs từ Nginx
{job="nginx"}

# Query 2: Nginx POST requests
{job="nginx"} |= "POST"

# Query 3: HTTP 5xx errors (text filter)
{job="nginx"} |= " 5"

# Query 4: Nginx access logs với status code parsing
{job="nginx", log_type="access"} | pattern `<ip> - - [<_>] "<method> <uri> <_>" <status> <_>` | status >= 500

```

## Test Commands

```bash
# TC01 - Website reachable over HTTP (default dev mode)
curl -s -o /dev/null -w "%{http_code}" http://localhost/

# TC06 - Security headers over HTTPS
curl -skI https://localhost/ | grep -E "X-Frame|X-Content|X-XSS|Referrer|Content-Security"

# TC07 - Prometheus targets
curl -s http://localhost:9090/api/v1/targets | python -m json.tool | grep -E '"health"|"job"'

# TC11 - Check exposed ports
docker compose ps --format "table {{.Name}}\t{{.Ports}}"

# TC12 - Restart test
docker compose restart nginx
sleep 10
curl -s -o /dev/null -w "%{http_code}" http://localhost/health
```

# 📋 BÁO CÁO REVIEW CODE - DỰ ÁN SHIELD-AI
## Hệ thống phát hiện xâm nhập & phòng thủ an ninh mạng

**Ngày review:** 02/03/2026  
**Dự án:** Du-An-Ngiem-Cuu (SHIELD-AI)  
**Công nghệ:** Laravel 12.0 + PHP 8.2 + TailwindCSS + Leaflet + Chart.js + Google Gemini AI  
**Trạng thái:** Đã sửa các lỗi nghiêm trọng

---

## 1. TỔNG QUAN DỰ ÁN

Dự án SHIELD-AI là một hệ thống bảo mật 3 lớp:
- **Lớp 1 (Honeypot):** Bẫy SSH Cowrie bắt hacker, ghi nhận IP/credentials
- **Lớp 2 (AI Analysis):** Phân tích hành vi bằng Google Gemini AI
- **Lớp 3 (Web Shell Defense):** Phát hiện và cách ly file mã độc
- **Dashboard:** Giám sát thời gian thực với bản đồ địa lý, biểu đồ thống kê

---

## 2. BẢNG THỐNG KÊ CÁC VẤN ĐỀ VÀ GIẢI PHÁP

### 🔴 MỨC ĐỘ NGHIÊM TRỌNG (CRITICAL)

| # | Vấn đề | File | Mô tả chi tiết | Trạng thái | Giải pháp đã áp dụng |
|---|--------|------|-----------------|------------|----------------------|
| 1 | **Backdoor `shell.php`** | `shell.php` | File chứa `<?php system('whoami'); ?>` - đây là web shell thực thi lệnh hệ thống, cho phép kẻ tấn công thực thi bất kỳ lệnh nào trên server | ✅ ĐÃ SỬA | Xóa hoàn toàn file `shell.php` khỏi dự án |
| 2 | **Lỗ hổng XSS (Cross-Site Scripting)** | `layer2.blade.php`, `layer1.blade.php`, `dashboard.blade.php` | Dữ liệu từ API và input người dùng được chèn trực tiếp vào `innerHTML` mà không escape, cho phép injection mã JavaScript độc hại | ✅ ĐÃ SỬA | Thêm hàm `escapeHtml()` để escape tất cả dữ liệu trước khi chèn vào DOM |
| 3 | **Thiếu middleware xác thực (Auth)** | `routes/web.php` | Các route nhạy cảm (`/layer1`, `/layer2`, `/webshell-defense`, `/clear-logs`, `/block-ip`, `/ai-chat`, `/toggle-auto-block`) không yêu cầu đăng nhập → ai cũng có thể truy cập, xóa log, block IP | ✅ ĐÃ SỬA | Đặt tất cả route nhạy cảm trong `Route::middleware('auth')->group()` |
| 4 | **Block IP dùng GET request** | `routes/web.php` | Route `/block-ip/{id}` dùng GET → có thể bị khai thác qua thẻ `<img>`, link, hoặc redirect để tự động block IP mà không cần xác nhận | ✅ ĐÃ SỬA | Đổi sang `Route::post()` với form có CSRF token |
| 5 | **Logout dùng GET request** | `routes/web.php` | Route `/logout` dùng GET → có thể bị khai thác CSRF để đăng xuất người dùng | ✅ ĐÃ SỬA | Đổi sang `Route::post()` |

### 🟠 MỨC ĐỘ CAO (HIGH)

| # | Vấn đề | File | Mô tả chi tiết | Trạng thái | Giải pháp đã áp dụng |
|---|--------|------|-----------------|------------|----------------------|
| 6 | **Sử dụng `env()` ngoài config** | `DashboardController.php`, `IntrusionLog.php`, `TelegramService.php`, `web.php` | Dùng `env()` trực tiếp trong code → sau khi chạy `php artisan config:cache`, `env()` sẽ trả về `null`, gây lỗi toàn bộ hệ thống | ✅ ĐÃ SỬA | Chuyển sang `config('services.*')` và thêm config entries trong `config/services.php` |
| 7 | **API không có validation** | `routes/web.php` | Route `/api/honeypot` nhận dữ liệu từ bên ngoài mà không validate → có thể bị inject dữ liệu xấu | ✅ ĐÃ SỬA | Thêm validation rules: `ip` phải là IP hợp lệ, `username`/`password` giới hạn 255 ký tự |
| 8 | **Thiếu method `chatWithAI`** | `DashboardController.php` | Route `/ai-chat` trỏ đến method `chatWithAI` nhưng method này không tồn tại → lỗi 500 khi sử dụng chat AI | ✅ ĐÃ SỬA | Thêm method `chatWithAI()` đầy đủ với validation input, gọi Gemini API, và escape output |
| 9 | **Thiếu route `/auto-generate-attack`** | `routes/web.php`, `dashboard.blade.php` | Dashboard gọi `fetch('/auto-generate-attack')` mỗi 15 giây nhưng route không tồn tại → lỗi 404 liên tục | ✅ ĐÃ SỬA | Thêm route và method `autoGenerateAttack()` tạo dữ liệu mô phỏng |
| 10 | **`$fillable` thiếu trường** | `IntrusionLog.php` | Model không khai báo `username_attempt`, `password_attempt` trong `$fillable` → lỗi MassAssignment khi tạo log từ Cowrie API | ✅ ĐÃ SỬA | Thêm `username_attempt`, `password_attempt` vào `$fillable` |
| 11 | **SSL Verification bị tắt** | `TelegramService.php`, `DashboardController.php` | `Http::withoutVerifying()` tắt xác minh SSL → dễ bị tấn công Man-in-the-Middle (MITM) | ⚠️ GHI NHẬN | Cần cấu hình certificate đúng trên server production thay vì tắt SSL verify. Giữ nguyên cho môi trường development |

### 🟡 MỨC ĐỘ TRUNG BÌNH (MEDIUM)

| # | Vấn đề | File | Mô tả chi tiết | Trạng thái | Giải pháp đề xuất |
|---|--------|------|-----------------|------------|-------------------|
| 12 | **Thao tác trực tiếp file `.env`** | `routes/web.php` | Route `/toggle-auto-block` đọc/ghi trực tiếp file `.env` bằng `str_replace` → có thể gây hỏng file nếu format không đúng | ⚠️ GHI NHẬN | Nên lưu cấu hình vào database hoặc dùng package quản lý settings |
| 13 | **Không có Rate Limiting** | `routes/web.php` | Không có giới hạn tần suất request cho login, API → dễ bị brute force, DDoS | ⚠️ GHI NHẬN | Thêm `RateLimiter` middleware cho route login và API |
| 14 | **DatabaseSeeder bỏ qua Model events** | `DatabaseSeeder.php` | Dùng `DB::table()->insert()` thay vì Eloquent → bỏ qua `booted()` event, field `status` không được set tự động | ⚠️ GHI NHẬN | Nên dùng `IntrusionLog::create()` hoặc Factory |
| 15 | **Layer1 dùng DB facade thay Model** | `DashboardController.php` | `layer1()` dùng `DB::table('intrusion_logs')` thay vì `IntrusionLog` model → bỏ qua Eloquent features, không nhất quán | ⚠️ GHI NHẬN | Nên dùng `IntrusionLog::orderBy('created_at', 'desc')->get()` |
| 16 | **Không có phân trang (Pagination)** | `DashboardController.php` | `layer1()` lấy toàn bộ records (`->get()` không giới hạn) → gây chậm khi dữ liệu lớn | ⚠️ GHI NHẬN | Nên dùng `->paginate(20)` thay vì `->get()` |
| 17 | **Hardcode tên người dùng** | `LoginController.php` | Message Telegram: "Leader Thịnh vừa đăng nhập thành công!" → hardcode tên cá nhân | ⚠️ GHI NHẬN | Nên dùng `Auth::user()->name` để lấy tên động |
| 18 | **Thiếu `.env.example` config keys** | `.env.example` | Các biến `GEMINI_API_KEY`, `TELEGRAM_BOT_TOKEN`, `TELEGRAM_CHAT_ID`, `AUTO_BLOCK_ENABLED` chưa có trong `.env.example` | ✅ ĐÃ SỬA | Thêm tất cả biến cần thiết vào `.env.example` |

### 🔵 MỨC ĐỘ THẤP (LOW) - CẢI THIỆN CHẤT LƯỢNG CODE

| # | Vấn đề | File | Mô tả chi tiết | Giải pháp đề xuất |
|---|--------|------|-----------------|-------------------|
| 19 | **Không dùng Blade Layout** | Tất cả views | Mỗi view là 1 file HTML đầy đủ, CSS/JS bị lặp lại → khó bảo trì | Tạo `layouts/app.blade.php` làm template chung |
| 20 | **Dùng CDN thay npm** | Tất cả views | Tailwind, Chart.js, Leaflet load từ CDN → không hoạt động offline, phụ thuộc bên ngoài | Cài qua npm và build bằng Vite |
| 21 | **Tests quá đơn giản** | `tests/` | Chỉ có 2 test cơ bản (`assertTrue(true)`, `GET / returns 200`) → không kiểm tra được logic | Viết Feature tests cho login, honeypot, API, block IP, AI chat |
| 22 | **Code formatting không nhất quán** | Nhiều file | Indentation lẫn lộn, method `layer1()` và `catchHoneypot()` thụt lề sai | Chạy `php-cs-fixer` hoặc cấu hình `.editorconfig` |
| 23 | **Không có custom error pages** | Không có | Thiếu trang 404, 500 tùy chỉnh → hiện trang lỗi mặc định Laravel (lộ thông tin debug) | Tạo `resources/views/errors/404.blade.php`, `500.blade.php` |
| 24 | **Comment trùng lặp** | `DashboardController.php` | Method `catchHoneypot()` có comment cũ chưa xóa (dòng 247-250) | Xóa comment thừa |
| 25 | **Thiếu route `telegram-settings`** | `routes/web.php` | Route `/telegram-settings` trỏ đến view `telegram` nhưng view không tồn tại | Tạo view hoặc xóa route (đã xóa trong bản fix vì chưa cần) |

---

## 3. TÓM TẮT

| Mức độ | Số lượng | Đã sửa | Ghi nhận |
|--------|----------|--------|----------|
| 🔴 Critical | 5 | 5 | 0 |
| 🟠 High | 6 | 5 | 1 |
| 🟡 Medium | 7 | 1 | 6 |
| 🔵 Low | 7 | 0 | 7 |
| **Tổng** | **25** | **11** | **14** |

---

## 4. CÁC THAY ĐỔI ĐÃ THỰC HIỆN

### Files đã sửa:
1. **`shell.php`** → XÓA (backdoor)
2. **`routes/web.php`** → Thêm auth middleware, đổi GET→POST, thêm validation, thêm route thiếu
3. **`app/Http/Controllers/DashboardController.php`** → Thêm `chatWithAI()`, `autoGenerateAttack()`, dùng `config()` thay `env()`
4. **`app/Models/IntrusionLog.php`** → Thêm fillable fields, dùng `config()` thay `env()`
5. **`app/Services/TelegramService.php`** → Dùng `config()` thay `env()`
6. **`config/services.php`** → Thêm cấu hình Gemini, Telegram, Shield
7. **`resources/views/dashboard.blade.php`** → Fix XSS, block-ip dùng POST form, dùng `config()`
8. **`resources/views/layer1.blade.php`** → Fix XSS với `escapeHtml()`
9. **`resources/views/layer2.blade.php`** → Fix XSS với `escapeHtml()`
10. **`.env.example`** → Thêm các biến cấu hình cần thiết

---

## 5. KHUYẾN NGHỊ TIẾP THEO

1. **Production:** Bật SSL verification, tắt `APP_DEBUG`, cấu hình HTTPS
2. **Testing:** Viết unit tests và feature tests cho tất cả controllers
3. **Rate Limiting:** Thêm giới hạn tần suất cho login (5 lần/phút) và API
4. **Logging:** Cấu hình audit log cho các hành động admin (block IP, clear logs)
5. **Blade Layouts:** Refactor views sử dụng component/layout system
6. **CI/CD:** Thiết lập pipeline kiểm tra tự động (PHPStan, PHP-CS-Fixer, PHPUnit)

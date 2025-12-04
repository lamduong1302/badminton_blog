# 🏸 Website Chia Sẻ Kinh Nghiệm Cầu Lông
Dự án xây dựng website đơn giản phục vụ mục tiêu chia sẻ kiến thức và kinh nghiệm chơi cầu lông.  
Website cho phép người dùng xem bài viết, tìm kiếm, đọc nội dung và gửi bình luận.  
Quản trị viên (Admin) có quyền đăng bài viết, chỉnh sửa, xóa, quản lý danh mục và duyệt bình luận.

---

## 📌 1. Công nghệ sử dụng
- **Ngôn ngữ:** PHP (thuần)
- **Máy chủ:** XAMPP / Apache
- **CSDL:** MySQL
- **Giao diện:** HTML, CSS, Bootstrap (tùy chọn)
- **Quản lý mã nguồn:** Git + GitHub

---

## 📌 2. Tính năng chính

### 👤 Đối với Người dùng (User)
- Xem danh sách bài viết
- Xem chi tiết bài viết
- Tìm kiếm bài viết
- Lọc theo danh mục
- Gửi bình luận (được duyệt bởi admin)
- Đăng ký tài khoản
- Đăng nhập / đăng xuất

### 🔐 Đối với Quản trị viên (Admin)
- Đăng bài viết mới
- Chỉnh sửa bài viết
- Xóa bài viết
- Quản lý danh mục (thêm / xoá)
- Xem bình luận chờ duyệt
- Duyệt hoặc xoá bình luận
- Xem số liệu thống kê:
  - Tổng bài viết
  - Bình luận chờ duyệt
  - Tổng lượt xem bài viết

---

## 📌 3. Cấu trúc thư mục

```

badminton_blog/
│-- index.php
│-- article.php
│-- login.php
│-- register.php
│-- config.php
│-- comment_submit.php
│-- logout.php
│
├── admin/
│   ├── dashboard.php
│   ├── add_article.php
│   ├── edit_article.php
│   ├── save_article.php
│   ├── update_article.php
│   ├── delete_article.php
│   ├── manage_comments.php
│   ├── manage_category.php
│   ├── save_category.php
│   ├── delete_category.php
│
├── assets/
│   └── style.css
│
└── database/
└── badminton_blog.sql

```

---

## 📌 4. Cách cài đặt và chạy website

### 🔧 Bước 1 — Cài đặt XAMPP
Tải tại: https://www.apachefriends.org/

Bật:
- Apache
- MySQL

### 🔧 Bước 2 — Import Database
1. Mở phpMyAdmin: http://localhost/phpmyadmin
2. Tạo database tên: **badminton_blog**
3. Import file: `database/badminton_blog.sql`

### 🔧 Bước 3 — Copy project vào htdocs
Đường dẫn:

```

C:\xampp\htdocs\badminton_blog

```

### 🔧 Bước 4 — Chạy website
Truy cập:

```

[http://localhost/badminton_blog](http://localhost/badminton_blog)

```

---

## 📌 5. Tài khoản mẫu

### 👑 Admin
```

username: admin
password: 123456

```

### 👤 User
```

username: user1
password: 123456

```

---

## 📌 6. Ảnh giao diện (tuỳ chọn)
<img width="588" height="514" alt="image" src="https://github.com/user-attachments/assets/41b5a00a-0713-4f05-be42-9ebd4a3b3c4a" />
<img width="568" height="429" alt="image" src="https://github.com/user-attachments/assets/7e7400a4-8f4d-4b98-b077-e3d314158cc8" />
<img width="571" height="574" alt="image" src="https://github.com/user-attachments/assets/22e27a3d-9df9-435a-8049-c59d25a092f5" />
<img width="568" height="607" alt="image" src="https://github.com/user-attachments/assets/41dbcb71-3886-4ab7-8dc7-07a8fa1a01a9" />
<img width="568" height="607" alt="image" src="https://github.com/user-attachments/assets/efc5cc3c-d573-434e-ad8d-8cae5a52a5a5" />
<img width="562" height="168" alt="image" src="https://github.com/user-attachments/assets/c38c0376-1931-4fbe-8677-c82ef6d22c2f" />
<img width="574" height="499" alt="image" src="https://github.com/user-attachments/assets/50c48c58-f51b-41d5-b51d-4d479b005499" />
<img width="571" height="783" alt="image" src="https://github.com/user-attachments/assets/c2f9b2e1-85b0-4a08-a3cc-e0b3cad10fa1" />
<img width="574" height="539" alt="image" src="https://github.com/user-attachments/assets/da67f4f9-0efa-4e01-bda1-ffe0d7e11b5c" />
<img width="574" height="525" alt="image" src="https://github.com/user-attachments/assets/1e686fb2-2e80-43c3-bb53-4509f5f3f96e" />
<img width="576" height="544" alt="image" src="https://github.com/user-attachments/assets/a26f00c8-8e3b-42ce-aab5-7b63ed7d3f29" />


---

## 📌 7. Tác giả
- **Họ tên:** Hà Quốc Huy
- **MSSV:** B22DVCN168
- **Trường:** Học viện Công nghệ Bưu chính Viễn thông – PTIT
- **Môn học:** Phân tích và Thiết kế Hệ thống Thông tin

---

## 📌 8. Ghi chú
- Mã nguồn phù hợp với bài tập lớn môn HTTT.
- Có thể mở rộng tính năng: like bài viết, upload ảnh, phân trang,...

---

## 📌 9. Giấy phép
Dự án dùng cho mục đích học tập. Không sử dụng vào thương mại.
```

---


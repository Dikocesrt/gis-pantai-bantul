# Routes Documentation - GIS Pantai Bantul

## Authentication Routes

### 1. Show Register Admin Form

**Route:** `GET /register-admin`  
**Name:** `auth.register-form`  
**Description:** Menampilkan form registrasi admin baru

**Response:** Blade template `auth.register-admin`

---

### 2. Register Admin

**Route:** `POST /register-admin`  
**Name:** `auth.register`  
**Description:** Proses registrasi admin baru

**Form Data:**

-   `name` (required, string, max 255)
-   `email` (required, email, unique)
-   `phone` (required, string, max 20, unique)
-   `password` (required, min 8, confirmed)
-   `password_confirmation` (required)

**Response:** Redirect ke `auth.register-success` dengan success message

**Validation Errors:** Redirect kembali ke form dengan error messages

---

### 3. Show Register Success Page

**Route:** `GET /register-success`  
**Name:** `auth.register-success`  
**Description:** Menampilkan halaman sukses registrasi

**Response:** Blade template `auth.register-success`

---

## Admin Verification Routes (Super Admin Only)

### 1. Show Pending Admins

**Route:** `GET /admin/verification`  
**Name:** `admin.verification.index`  
**Middleware:** `auth`, `role:super_admin`  
**Description:** Menampilkan daftar admin yang menunggu verifikasi

**Response:** Blade template `admin.verification.index` dengan data `$pendingAdmins`

---

### 2. Verify Admin

**Route:** `POST /admin/{userId}/verify`  
**Name:** `admin.verify`  
**Middleware:** `auth`, `role:super_admin`  
**Description:** Verifikasi admin yang menunggu

**Form Data:**

-   `verified_by` (required, uuid, exists in users table)

**Response:** Redirect ke halaman sebelumnya dengan success message

**Validation Errors:** Redirect kembali dengan error message

---

### 3. Reject Admin

**Route:** `POST /admin/{userId}/reject`  
**Name:** `admin.reject`  
**Middleware:** `auth`, `role:super_admin`  
**Description:** Menolak registrasi admin dan menghapusnya

**Form Data:**

-   `reason` (required, string)

**Response:** Redirect ke halaman sebelumnya dengan success message

**Validation Errors:** Redirect kembali dengan error message

---

## Notes

-   Semua routes menggunakan Blade template untuk rendering
-   Middleware `role:super_admin` memastikan hanya super admin yang dapat mengakses verification routes
-   Middleware `auth` memastikan user sudah login
-   Session messages digunakan untuk menampilkan success/error notifications

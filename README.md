# Inventory Management App (CodeIgniter 4)

Aplikasi sederhana untuk manajemen stok barang berbasis **CodeIgniter 4**.  
Fitur utama:
- Barang Masuk (Incoming)
- Barang Keluar (Outgoing)
- Pembelian & Supplier
- Stok Terkini
- Laporan berdasarkan rentang tanggal
- Autentikasi User (role admin)

---

## 📦 Persyaratan
- PHP >= 8.0
- MySQL/MariaDB
- Composer
- Ekstensi PHP: intl, mbstring, json, mysqli

---

## 🚀 Instalasi

1. **Clone repository**
   ```bash
   git clone https://github.com/username/repo-name.git
   cd repo-name
   ```

2. **Install dependency**
   ```bash
   composer install
   ```

3. **Copy konfigurasi environment**
   ```bash
   cp env .env
   ```

   Lalu edit `.env` sesuai database lokal:
   ```env
   database.default.hostname = localhost
   database.default.database = inventory_db
   database.default.username = root
   database.default.password = 
   database.default.DBDriver = MySQLi
   database.default.DBPrefix =
   ```

4. **Buat database**
   ```sql
   CREATE DATABASE inventory_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
   ```

5. **Jalankan migrasi**
   ```bash
   php spark migrate
   ```

6. **Jalankan seeder awal**
   ```bash
   php spark db:seed InitSeeder
   ```

   Seeder ini akan membuat:
   - User admin (username: `admin`, password: `admin123`)
   - Vendor contoh
   - Kategori contoh
   - Produk contoh dengan stok awal

7. **Jalankan server**
   ```bash
   php spark serve
   ```

   Akses aplikasi di:  
   👉 http://localhost:8080

---

## 👤 Akun Default
- **Username:** `admin`  
- **Password:** `admin123`

---

## 📊 Laporan
- Barang Masuk → `Reports > Incoming`
- Barang Keluar → `Reports > Outgoing`
- Stok Barang Terkini → `Reports > Stock`

---

## 📂 Struktur Penting
```
app/
 ├── Controllers/       # Controller utama
 ├── Models/            # Model database
 ├── Views/             # Blade/Twig view CI4
 ├── Database/
 │    ├── Migrations/   # Skema database
 │    └── Seeds/InitSeeder.php
```

---

## ⚖️ Lisensi
MIT License

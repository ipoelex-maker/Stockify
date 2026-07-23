# 📦 Stockify — Sistem Manajemen Inventori

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-10-red?style=for-the-badge&logo=laravel" />
  <img src="https://img.shields.io/badge/PHP-8.3-blue?style=for-the-badge&logo=php" />
  <img src="https://img.shields.io/badge/MySQL-8.0-orange?style=for-the-badge&logo=mysql" />
  <img src="https://img.shields.io/badge/TailwindCSS-3-38bdf8?style=for-the-badge&logo=tailwindcss" />
  <img src="https://img.shields.io/badge/Flowbite-UI-4ade80?style=for-the-badge" />
</p>

> Aplikasi web manajemen stok barang berbasis Laravel 10 dengan tampilan premium dark mode dan fitur lengkap untuk kebutuhan gudang.

---

## ✨ Fitur Utama

- 🔐 **Autentikasi & Role** — Admin, Manajer Gudang, Staff Gudang (Spatie Permission)
- 👥 **Manajemen User** — CRUD pengguna dan assign role
- 📦 **Manajemen Produk** — CRUD produk dengan foto, harga beli/jual, min stok
- 🗂️ **Kategori & Supplier** — CRUD dengan validasi lengkap
- 📥 **Stock In & Stock Out** — Pencatatan barang masuk/keluar dengan validasi min stok
- 📊 **Stock Opname** — Pengecekan stok fisik vs sistem dengan adjustment otomatis
- 📋 **Laporan** — Filter per periode, export CSV, cetak PDF
- 📥 **Import Produk** — Upload massal via CSV dengan template
- 🔔 **Notifikasi** — Peringatan stok menipis otomatis
- 📊 **Dashboard** — Chart.js real-time, stats per role
- 🌙 **OLED Dark Mode** — True black `#000000` untuk hemat baterai
- 📱 **Mobile Responsive** — Hamburger menu & floating glass sidebar

---

## 🛠️ Teknologi

| Teknologi | Versi |
|-----------|-------|
| PHP | 8.3 |
| Laravel | 10 |
| MySQL | 8.0 |
| Tailwind CSS | 3 |
| Flowbite | 2 |
| Chart.js | 4.4 |
| Spatie Permission | 6 |

---

## ⚙️ Cara Instalasi

### Prasyarat
- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL
- Git

### Langkah-langkah

**1. Clone repository**
```bash
git clone https://github.com/ipoelex-maker/Stockify.git
cd Stockify
```

**2. Install dependency PHP**
```bash
composer install
```

**3. Install dependency JavaScript**
```bash
npm install
```

**4. Salin file environment**
```bash
cp .env.example .env
```

**5. Generate app key**
```bash
php artisan key:generate
```

**6. Konfigurasi database**

Buat database baru di phpMyAdmin atau MySQL dengan nama `stockify`, lalu edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=stockify
DB_USERNAME=root
DB_PASSWORD=
```

**7. Jalankan migration**
```bash
php artisan migrate
```

**8. Jalankan seeder**
```bash
php artisan db:seed
```

**9. Buat symlink storage**
```bash
php artisan storage:link
```

**10. Build assets**
```bash
npm run build
```

**11. Jalankan server**
```bash
php artisan serve
```

Buka browser dan akses: **http://127.0.0.1:8000**

---

## 🔑 Akun Default

Setelah menjalankan seeder, gunakan akun berikut untuk login:

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@gmail.com | password |

> Akun Manager dan Staff bisa dibuat melalui menu **Users** setelah login sebagai Admin.

---

## 📁 Struktur Role & Akses

| Fitur | Admin | Manager | Staff |
|-------|-------|---------|-------|
| Dashboard | ✅ | ✅ | ✅ |
| Categories | ✅ | ❌ | ❌ |
| Suppliers | ✅ | ❌ | ❌ |
| Users | ✅ | ❌ | ❌ |
| Products | ✅ | ✅ | ❌ |
| Stock In | ✅ | ✅ | ✅ |
| Stock Out | ✅ | ✅ | ✅ |
| Stock Opname | ✅ | ✅ | ❌ |
| Laporan | ✅ | ✅ | ❌ |

---

## 📸 Screenshot

> Dashboard, Login, dan halaman utama Stockify dengan tampilan OLED dark mode premium.

---

## 👨‍💻 Developer

**Ahmad Syaeful Arif**
- NPM: 23111100070
- Program Studi Informatika
- Universitas PGRI Yogyakarta
- Kerja Praktek @ Seven INC (Magang Jogja) — 2026

---

## 📄 Lisensi

Project ini dibuat untuk keperluan akademik Kerja Praktek.

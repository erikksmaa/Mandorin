# 🏆 SIPORA — Sistem Informasi Program Olahraga dan Kepemudaan

Dokumentasi Resmi Proyek, Konsep Bisnis, Ekosistem Fitur, dan Panduan Instalasi Komprehensif untuk **Dinas Pendidikan, Kepemudaan, dan Olahraga (Dindikpora)**.

---

## 🏛️ 1. Konteks Proyek & Latar Belakang

Pelaksanaan dan tata kelola program kepemudaan serta keolahragaan oleh Organisasi Kepemudaan (OKP) di tingkat daerah seringkali menghadapi berbagai kendala administrasi tradisional:
- **Ketidakseragaman Laporan:** Pencatatan kegiatan harian dan pertanggungjawaban keuangan yang masih manual, tercecer, dan tidak terstandar.
- **Kurangnya Pemantauan Real-Time:** Verifikator Dindikpora kesulitan memantau progres fisik dan dokumentasi lapangan secara aktual selama program berlangsung.
- **Keterlambatan E-LPJ:** Pengajuan Laporan Pertanggungjawaban (E-LPJ) Keuangan seringkali terlambat dan sulit diaudit kecocokannya dengan progres logbook harian.
- **Transparansi Publik:** Masyarakat dan pihak pemangku kepentingan minim mendapatkan informasi mengenai hasil dan dokumentasi nyata dari program-program kepemudaan yang telah diselesaikan.

**SIPORA (Sistem Informasi Program Olahraga dan Kepemudaan)** hadir sebagai platform manajemen administrasi digital terpadu untuk Dindikpora. SIPORA menghubungkan **Dindikpora (Verifikator & Admin)** dengan **Ketua Pelaksana Organisasi Kepemudaan (OKP)** serta **Masyarakat Publik** secara transparan, akuntabel, terintegrasi, dan terstruktur.

---

## 👥 2. Arsitektur Peran & Konsep Konten (Multi-Role Ecosystem)

SIPORA mengadopsi ekosistem **3 Role Autentikasi Utama + 1 Akses Guest Publik**:

```
                              ┌────────────────────────────────┐
                              │         GUEST / PUBLIK         │
                              └───────────────┬────────────────┘
                                              │ Login / Register
                       ┌──────────────────────┼──────────────────────┐
                       ▼                      ▼                      ▼
             ┌──────────────────┐   ┌──────────────────┐   ┌──────────────────┐
             │  ADMINISTRATOR   │   │   VERIFIKATOR    │   │ KETUA PELAKSANA  │
             │   (Dindikpora)   │   │   (Dindikpora)   │   │  (Leader OKP)    │
             └──────────────────┘   └──────────────────┘   └──────────────────┘
```

### Penjelasan Peran & Konsep Konten:

1. **Guest / Masyarakat Publik:**
   - Mengakses Beranda Utama, Direktori Program Kepemudaan, Direktori Organisasi Kepemudaan, dan Galeri Foto Program Selesai.
   - Melihat detail transparansi kegiatan, lokasi, tanggal pelaksanaan, dan hasil dokumentasi foto tanpa wajib login.

2. **Ketua Pelaksana (Leader OKP):**
   - Mengelola profil Organisasi Kepemudaan (OKP) dan daftar Anggota Organisasi beserta jabatannya.
   - Mengajukan Proposal Program Kepemudaan/Olahraga ke Dindikpora.
   - Mengisi Logbook Kegiatan Harian lengkap dengan indikator progress %, kendala, solusi, dan gallery foto dokumentasi dengan Lightbox preview.
   - Mengisi Presensi / Kehadiran Anggota dalam setiap kegiatan program.
   - Mengisi Laporan Pertanggungjawaban Keuangan (E-LPJ) beserta rincian item pengeluaran/pemasukan dan foto bukti nota.

3. **Verifikator Dindikpora:**
   - Melakukan evaluasi & verifikasi proposal program masuk (*Approve, Revision, Reject*).
   - Memantau seluruh Logbook Kegiatan Harian dari berbagai OKP, memberikan catatan revisi, atau menyetujui logbook.
   - Memeriksa Laporan Keuangan E-LPJ, melakukan pengujian nominal realisasi dan foto nota transaksi.
   - Melakukan **Evaluasi & Verifikasi Akhir** untuk menyatakan program resmi `Completed` (100%).

4. **Administrator (Dindikpora / Superadmin):**
   - Melakukan verifikasi pendaftaran akun Organisasi Kepemudaan (OKP).
   - Mengelola Data Master Pengguna (*User Management*), Peran (*Role Management*), Kategori Program, dan Kategori Organisasi.
   - Mengawasi keseluruhan statistik dan antrean verifikasi di platform SIPORA.

---

## ⚙️ 3. Alur Bisnis & Perhitungan Progress Otomatis Berbasis Milestone

Sistem perhitungan progress pada SIPORA dihitung secara **otomatis berbasis milestone bisnis** tanpa input manual, menggunakan accessor model `Program::getProgressAttribute()`:

```
[Draft Program] ──► 0%
       │
[Proposal Submitted] ──► 10%
       │
[Proposal Verified / Approved] ──► 20%
       │
[Program Running] ──► 30%
       │
[Logbook Progress] ──► Dynamic (30% s.d. 94% mengikuti Logbook Terbaru)
       │
[E-LPJ Submitted / Approved] ──► 95%
       │
[Verifikasi Akhir Completed] ──► 100% (Hanya jika SELURUH 4 syarat terpenuhi)
```

### 🔒 Aturan Syarat Ketat Progress 100%:
Progress Pelaksanaan **HANYA BISA** mencapai **100%** apabila **SELURUH 4 SYARAT** berikut terpenuhi:
1. `[x]` Proposal telah diverifikasi (`proposal_status` = `Verified` atau `Approved`)
2. `[x]` Status Program = `Completed` (Ditetapkan melalui menu Verifikasi Akhir Verifikator)
3. `[x]` Progress Logbook terakhir minimal `90%`
4. `[x]` Status E-LPJ Keuangan = `Approved` (Telah disetujui Verifikator)

---

## 🛠️ 4. Arsitektur Teknis & Stack Teknologi

| Komponen Teknis | Teknologi | Penjelasan & Alasan Pemilihan |
|---|---|---|
| **Core Framework** | **Laravel 12 (PHP 8.4)** | Backend PHP modern dengan arsitektur bersih, performa tinggi, dan routing modular. |
| **Authentication** | **Laravel Breeze** | Sistem autentikasi berbasis Blade/Livewire yang aman dan terstandar. |
| **Reactivity Layer** | **Livewire 3 + Volt** | Komponen reaktif tanpa butuh build step Javascript rumit, mendukung *realtime search* dan *pagination*. |
| **Design System & CSS**| **Tailwind CSS + Vanilla CSS** | Custom Palette: Navy (`#0F172A` & `#1E2A4A`), Orange (`#F97316`), Emerald (`#059669`). |
| **Interaktivitas UI** | **Alpine.js & Lightbox** | Menangani toggle modal, gallery preview foto full-screen, dan binding state lokal. |
| **Alerts & Modals** | **SweetAlert2** | Integrasi notifikasi dialog & toast untuk seluruh aksi penting (*Delete, Approve, Reject, Submit, Logout*). |
| **Typography** | **Big Shoulders Display & Inter** | *Big Shoulders Display* untuk judul/heading tegas & *Inter* untuk keterbacaan data yang bersih. |

---

## 🗄️ 5. Rekapitulasi Struktur Model & Relasi Database

```
  [User] ─── (N:1) ─── [Role]
    │
    ├── (1:N) ─── [Organization] (created_by) ─── (N:1) ─── [OrganizationCategory]
    │                   │
    │                   ├── (1:N) ─── [OrganizationMember]
    │                   │
    │                   └── (1:N) ─── [Program] ─── (N:1) ─── [ProgramCategory]
    │                                    │
    │                                    ├── (1:N) ─── [ActivityLog] ─── (1:N) ─── [ActivityPhoto]
    │                                    ├── (1:N) ─── [Attendance]
    │                                    └── (1:1) ─── [FinancialReport] ─── (1:N) ─── [FinancialItem]
    │
    └── (1:N) ─── [Notification]
```

---

## ✨ 6. Rekapitulasi Ekosistem Fitur Lengkap

### A. Fitur Publik & Landing Page (`/`)
- **Hero Showcase & Search Filter:** Pencarian realtime berbasis kata kunci, kategori program, dan lokasi.
- **Katalog Program & Organisasi (`/program`, `/organisasi`):** Direktori program & OKP terdaftar.
- **Galeri Program Selesai (`/galeri`):** Showcase foto kegiatan dari program yang telah berhasil diselesaikan.
- **Detail Program Publik (`/program/{id}`):** Menampilkan timeline logbook, persentase progress, dan gallery foto dengan modal Lightbox.

### B. Fitur Panel Administrator (`/admin/*`)
- **Dashboard Admin:** Ringkasan statistik OKP, program, user, dan grafik aktivitas.
- **Manajemen Pengguna (`/admin/pengguna`):** Pengelolaan akun pengguna, filter role, pencarian realtime, selector per-page (10, 25, 50, 100), dan paginasi.
- **Antrean Verifikasi Organisasi (`/admin/verifikasi-organisasi`):** Audit dan verifikasi status aktif OKP.
- **Data Master Kategori (`/admin/kategori-program`, `/admin/kategori-organisasi`):** Management CRUD kategori.

### C. Fitur Panel Verifikator Dindikpora (`/verifier/*`)
- **Dashboard Verifikator:** Ringkasan proposal masuk, antrean LPJ, dan logbook terisi.
- **Dropdown Navigasi Ringkas:** Menu terstruktur (*Program & Logbook*, *Verifikasi & LPJ*).
- **Daftar Proposal (`/verifier/proposal-masuk`):** Review dan keputusan proposal (*Verified, Revision, Rejected*).
- **Monitoring Logbook (`/verifier/logbook`):** Peninjauan harian seluruh logbook OKP, filter bulan & status, modal ubah status & catatan revisi.
- **Verifikasi E-LPJ (`/verifier/verifikasi-elpj`):** Verifikasi rincian transaksi pengeluaran/pemasukan dan nota bukti transaksi.
- **Verifikasi Akhir Program (`/verifier/evaluasi/{program}`):** Penilaian akhir untuk menyelesaikan program menjadi `Completed` (100%).

### D. Fitur Panel Ketua Pelaksana / Leader OKP (`/leader/*`)
- **Dashboard Leader:** Status ringkasan proposal, progress bar program, dan logbook aktif.
- **Profil & Member Manager (`/leader/profil-organisasi`, `/leader/organisasi/anggota`):** Kelola profil OKP dan CRUD anggota tim.
- **Pengajuan & Kelola Program (`/leader/program`):** Formulir proposal program dan detail timeline.
- **Logbook Kegiatan & Photo Gallery (`/leader/program/{id}/logbook`):** Formulir logbook harian dengan range slider progress 60fps real-time dan upload multiple foto.
- **Presensi Kegiatan (`/leader/program/{id}/absensi`):** Pencatatan daftar hadir anggota.
- **E-LPJ Form (`/leader/program/{id}/e-lpj`):** Formulir Laporan Pertanggungjawaban Keuangan dan rincian nota pengeluaran.

---

## ⚙️ 7. Panduan Instalasi dari Awal Sampai Akhir

Berikut adalah panduan komprehensif langkah demi langkah untuk menginstal dan menjalankan proyek **SIPORA** di lingkungan lokal Anda.

### 📋 Persyaratan Sistem (Prerequisites)
Pastikan perangkat komputer Anda telah terpasang perangkat lunak berikut:
- **PHP** `>= 8.2` (Disarankan PHP 8.4)
- **Composer** `>= 2.x`
- **Node.js** `>= 18.x` & **NPM** `>= 9.x`
- **Database Server**: MySQL / MariaDB (via Laragon / XAMPP) atau SQLite
- **Git**

---

### 🚀 Langkah-Langkah Instalasi:

#### Langkah 1: Clone Repositori Proyek
Buka terminal (Git Bash, Command Prompt, atau PowerShell) dan jalankan perintah:
```bash
git clone https://github.com/erikksmaa/Mandorin.git sipora
cd sipora
```

#### Langkah 2: Install Dependensi PHP (Composer)
Jalankan perintah berikut untuk mengunduh seluruh library backend Laravel & Livewire:
```bash
composer install
```

#### Langkah 3: Salin File Lingkungan (.env)
Buat salinan file `.env` dari template bawaan:
```bash
# Pada OS Windows (PowerShell / Command Prompt):
copy .env.example .env

# Atau pada OS Linux / macOS / Git Bash:
cp .env.example .env
```

#### Langkah 4: Generate Application Key
Generate kunci enkripsi aplikasi Laravel:
```bash
php artisan key:generate
```

#### Langkah 5: Konfigurasi Database pada `.env`
Buka file `.env` menggunakan editor teks (VS Code) dan sesuaikan konfigurasi database Anda.

**Opsi A: Menggunakan MySQL (Laragon / XAMPP)**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mandorin
DB_USERNAME=root
DB_PASSWORD=
```
*(Pastikan Anda telah membuat database kosong bernama `mandorin` di phpMyAdmin / HeidiSQL).*

**Opsi B: Menggunakan SQLite (Praktis)**
```env
DB_CONNECTION=sqlite
```
*(Jika file `database/database.sqlite` belum ada, buat file kosong tersebut terlebih dahulu).*

#### Langkah 6: Jalankan Migrasi & Seeder Database
Jalankan perintah berikut untuk membuat struktur tabel dan mengisi data awal (roles, admin, verifikator, leader, program demo, logbook, LPJ):
```bash
php artisan migrate:fresh --seed
```

#### Langkah 7: Buat Symlink Storage (Media & Foto)
Jalankan perintah ini agar foto dokumentasi, avatar, dan dokumen proposal dapat diakses secara publik oleh browser:
```bash
php artisan storage:link
```

#### Langkah 8: Install Dependensi Frontend (NPM)
Install paket Node.js untuk Tailwind CSS, Vite, dan Alpine.js:
```bash
npm install
```

#### Langkah 9: Kompilasi Aset Frontend (Vite)
Jalankan kompilasi aset frontend untuk produksi:
```bash
npm run build
```
*(Atau jalankan `npm run dev` jika Anda ingin melakukan pengembangan / hot-reloading).*

#### Langkah 10: Jalankan Server Lokal Laravel
Jalankan development server Laravel:
```bash
php artisan serve
```
Aplikasi **SIPORA** kini dapat diakses melalui browser di alamat:
👉 **`http://127.0.0.1:8000`**

---

### 🔑 Kredensial Akun Default Testing (Hasil Seeder):

Anda dapat masuk (*login*) menggunakan kredensial bawaan berikut:

| Peran (Role) | Email | Password | Hak Akses Utama |
|---|---|---|---|
| **Administrator** | `admin@sipora.id` | `password` | Dashboard Admin, Verifikasi OKP, Management Pengguna & Master Kategori |
| **Verifikator Dindikpora** | `verifier@sipora.id` | `password` | Review Proposal, Monitoring Logbook, Verifikasi E-LPJ, Verifikasi Akhir (100%) |
| **Ketua Pelaksana (Leader)** | `leader@sipora.id` | `password` | Profil OKP, Anggota, Proposal Program, Logbook Harian, Presensi, Form E-LPJ |

---

## 🧪 8. Verifikasi & Pengujian Otomatis

Aplikasi ini dilengkapi dengan suite pengujian otomatis (*Unit & Feature Tests*). Anda dapat menjalankannya kapan saja dengan perintah:
```bash
php artisan test
```
**Hasil Pengujian:** `27 passed (83 assertions)` — 100% Lulus.

---
*SIPORA © 2026 — Dinas Pendidikan, Kepemudaan, dan Olahraga (Dindikpora).*

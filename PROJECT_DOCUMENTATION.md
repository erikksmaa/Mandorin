# 🏗️ Laporan Rekapan & Dokumentasi Komprehensif — Mandorin

## 1. Konteks Proyek (Background & Problem Statement)

Industri jasa konstruksi dan pertukangan skala menengah-kecil di Indonesia umumnya masih beroperasi secara konvensional, informal, dan minim transparansi. Masalah utama yang sering dihadapi meliputi:
- **Pemilik Properti (Customer):** Kesulitan menemukan mandor/kontraktor terpercaya, ketakutan akan penyalahgunaan dana/proyek mangkrak, serta kurangnya akses untuk memantau progres pekerjaan harian secara *real-time*.
- **Mandor / Kontraktor:** Kesulitan membangun portofolio digital yang profesional, memperluas jangkauan klien di luar jaringan mulut-ke-mulut, serta mengelola pencatatan tim tukang dan pembayaran termin secara terstruktur.
- **Masalah Keamanan & Legalitas:** Tidak adanya sistem verifikasi identitas mandor yang valid.

**Mandorin** hadir sebagai platform marketplace konstruksi digital (*JobStreet khusus jasa konstruksi*) yang menjembatani hubungan antara **Pelanggan** dan **Mandor/Kontraktor** secara aman, transparan, terverifikasi, dan terintegrasi dari tahap pencarian hingga penyelesaian proyek.

---

## 2. Konsep Platform & Arsitektur Peran (Multi-Role Ecosystem)

Platform Mandorin mengadopsi ekosistem **3 Role Utama + 1 Akses Guest Publik**:

```
                              ┌────────────────────────────────┐
                              │         GUEST / PUBLIK         │
                              └───────────────┬────────────────┘
                                              │ Daftar / Login
                       ┌──────────────────────┼──────────────────────┐
                       ▼                      ▼                      ▼
             ┌──────────────────┐   ┌──────────────────┐   ┌──────────────────┐
             │      ADMIN       │   │    CONTRACTOR    │   │     CUSTOMER     │
             │   (Verifikator)  │   │  (Penyedia Jasa) │   │  (Pemilik Proyek)│
             └──────────────────┘   └──────────────────┘   └──────────────────┘
```

1. **Guest / Publik:** Bebas menjelajahi direktori kontraktor terverifikasi, melihat galeri foto portofolio *before/after*, dan mencari berdasarkan kategori layanan atau lokasi tanpa wajib login.
2. **Customer (Pelanggan):** Mengajukan pesanan proyek ke kontraktor terpilih, memantau progres harian beserta foto *update*, mencatat termin pembayaran, dan menghubungi mandor langsung via WhatsApp.
3. **Contractor (Mandor):** Mengisi profil usaha, memilih keahlian layanan, mengunggah dokumen identitas & sertifikat (KTP/Sertifikat Keahlian), membuat portofolio proyek, mengelola tim pekerja/absensi, serta mengirim laporan harian.
4. **Administrator:** Melakukan audit & verifikasi identitas mandor (Approve/Reject), mengelola pengguna (Customer/Mandor/Admin), dan mengelola master data layanan konstruksi.

---

## 3. Arsitektur Teknis & Stack Teknologi

| Komponen Teknis | Teknologi yang Digunakan | Penjelasan & Alasan Pemilihan |
|---|---|---|
| **Core Framework** | **Laravel 11** | Backend PHP modern dengan performa tinggi, struktur routing modular, dan *built-in authentication* (Breeze). |
| **Reactivity Layer** | **Livewire 3 + Volt** | Arsitektur Single-File Component (SFC) reaktif berbasis Blade tanpa membutuhkan build step Vue/React yang kompleks. |
| **Design System** | **Tailwind CSS** | Custom Design Tokens (Warna Navy `#1E2A4A`, Orange `#FF6B00`, Verified Green, HSL tailored) dengan utilitas responsif. |
| **Interaktivitas UI** | **Alpine.js** | Menangani dropdown reaktif, toggle modal, dan *binding state* lokal secara *lightweight*. |
| **Notifikasi Modals** | **SweetAlert2** | Integrasi global notifikasi toast dan konfirmasi dialog interaktif (*delete*, *approve*, *reject*, *logout*). |
| **Font & Typo** | **Big Shoulders Display & Inter** | *Big Shoulders Display* untuk judul/heading tegas khas konstruksi & *Inter* untuk keterbacaan data yang bersih. |

---

## 4. Struktur Basis Data & Relasi Model (Database Architecture)

Arsitektur database dirancang secara terintegrasi dan ternormalisasi:

```
  [User] ─── (1:1) ─── [ContractorProfile] ─── (1:N) ─── [Portfolio]
    │                        │                               │
    ├── (1:N) [Notification] ├── (N:M) [Service]             └── (1:N) [PortfolioPhoto]
    │                        │
    └── (1:N) [Project] ─────┴─── (1:N) ─── [Worker]
                 │
                 ├── (1:N) ─── [DailyReport]
                 ├── (1:N) ─── [ProjectPayment]
                 └── (1:N) ─── [ProjectStatusHistory]
```

### Penjelasan Model Utama:
- **`User`:** Menyimpan kredensial dasar, email, password, nomor HP/WA, dan enum `role` (`admin`, `contractor`, `customer`).
- **`ContractorProfile`:** Ekstensi data khusus mandor, berisi `bio`, `address`, `rating`, `profile_photo`, `identity_document` (KTP), `certificate_document`, dan `verification_status` (`pending`, `verified`, `rejected`).
- **`Service`:** Master data kategori pekerjaan konstruksi (contoh: *Renovasi Rumah, Instalasi Listrik, Pengecatan, Plumbing*).
- **`Portfolio`:** Menyimpan galeri hasil proyek yang diselesaikan mandor, dilengkapi foto `before_photo` dan `after_photo`.
- **`Project`:** Menyimpan data pesanan/kontrak kerja antara Customer dan Contractor, mencakup judul, lokasi, deskripsi, tanggal mulai/selesai, status (`pending`, `accepted`, `in_progress`, `completed`, `rejected`), dan persentase progres.
- **`Worker`:** Data anggota tim tukang yang dikelola mandor per proyek beserta log absensi.
- **`DailyReport`:** Catatan laporan harian proyek yang dikirim mandor berisi catatan, persentase progres, serta bukti foto *before/after*.
- **`Notification`:** Notifikasi dalam aplikasi (*in-app notification*) yang mencatat pembaruan status verifikasi dan proyek.

---

## 5. Ekosistem Fitur Lengkap dari Awal Sampai Akhir

### A. Akses Publik & Halaman Utama (`/`)
- **Hero Section Fungsional:** Pencarian cepat berbasis dropdown `layanan` (ID) dan filter `lokasi`, dilengkapi statistik platform.
- **Layanan Populer:** Grid 6 kategori layanan dinamis yang langsung menyaring kontraktor saat diklik.
- **Kontraktor & Portofolio Pilihan:** Tampilan data *real* kontraktor terverifikasi dan galeri hasil kerja *before/after*.
- **Cara Kerja & CTA Ganda:** Panduan 3 langkah mudah serta kartu ajakan daftar khusus Pelanggan dan Mandor.
- **Direktori Publik (`/contractors` & `/portfolios`):** Katalog lengkap dengan filter nama, lokasi, kategori layanan, dan rating bintang.

### B. Autentikasi & Registrasi Khusus Role (`/login`, `/register`)
- **Login Split-Screen:** Antarmuka modern beraksen Navy-Orange dengan *floating label*, *password toggle*, dan notifikasi SweetAlert Toast saat berhasil masuk.
- **Register dengan Role Picker:** Pilihan kartu visual peran (Customer vs Mandor). Jika mendaftar sebagai Mandor, sistem memberikan penjelas transparan bahwa profil membutuhkan verifikasi Admin.

### C. Modul Panel Administrator (`/admin/*`)
- **Dashboard Admin:** Ringkasan statistik jumlah pengguna, antrean verifikasi aktif, proyek berjalan, dan grafik cepat.
- **Antrean Verifikasi Mandor (`/admin/verifikasi`):** Daftar mandor yang mendaftar beserta peninjauan dokumen KTP & sertifikat keahlian. Dilengkapi tombol persetujuan (*Approve*) atau penolakan (*Reject*) berbasis SweetAlert.
- **Data Master - Manajemen Pengguna (`/admin/pengguna`):** Tabel daftar seluruh akun pengguna dengan filter role, pencarian reaktif, paginasi, dan proteksi penghapusan akun Admin.
- **Data Master - Kelola Layanan (`/admin/layanan`):** Fitur CRUD penuh untuk menambah, mengedit, dan menghapus master kategori layanan konstruksi.
- **Navigasi Ringkas:** Pengelompokan menu "Manajemen Pengguna" & "Kelola Layanan" dalam satu dropdown **Data Master**.

### D. Modul Panel Mandor / Contractor (`/contractor/*`)
- **Dashboard Mandor:** Tampilan statistik proyek, antrean permintaan baru, dan grafik progres pekerjaan.
- **Profil Compact Multi-Kolom (`/contractor/profile`):** Pengaturan foto profil, bio, alamat, upload dokumen verifikasi, serta pemilihan keahlian layanan (*multi-checkbox*).
- **Manajemen Portofolio:** Tambah/Edit/Hapus portofolio foto *before-after* pekerjaan yang diselesaikan.
- **Kelola Proyek & Permintaan:** Menerima atau menolak permintaan proyek masuk dari pelanggan dengan konfirmasi SweetAlert.
- **Manajemen Pekerja & Absensi:** Pencatatan daftar tukang/pekerja dan rekap kehadiran harian.
- **Laporan Harian (Daily Report):** Pengiriman laporan harian berisi persentase progres dan foto perkembangan di lapangan.

### E. Modul Panel Pelanggan / Customer (`/customer/*`)
- **Dashboard Customer:** Ringkasan proyek aktif dan status pesanan.
- **Proyek Saya (`/customer/projects`):** Daftar riwayat proyek dengan pencarian reaktif, filter status, dan paginasi.
- **Detail Proyek & Laporan Harian:** Memantau riwayat laporan harian dari mandor beserta foto perkembangan fisik proyek.
- **Pencatatan Pembayaran Termin:** Log transaksi bertahap dan pengunggahan bukti pembayaran.
- **Direct WhatsApp Chat:** Tombol pemancing pesan WhatsApp otomatis yang membawa format detail proyek langsung ke nomor WA Mandor.

---

## 6. Standardisasi Sistem Desain & Penyempurnaan (Batch A – D)

Seluruh antarmuka aplikasi telah dipoles dan disatukan mengikuti standar berikut:

```
┌────────────────────────────────────────────────────────────────────────┐
│                        DESIGN SYSTEM MANDORIN                          │
├───────────────────┬────────────────────────────────────────────────────┤
│ Warna Utama       │ Navy (#1E2A4A), Orange (#FF6B00), Slate-50 Background │
│ Tipografi         │ Heading: Big Shoulders Display | Body: Inter       │
│ Radii Komponen    │ Card & Input: rounded-xl | Badge: rounded-full     │
│ Feedback Modals   │ SweetAlert2 (Zero native browser confirm)          │
│ Empty States      │ Reusable <x-empty-state> dengan 11 varian ikon     │
└───────────────────┴────────────────────────────────────────────────────┘
```

1. **BATCH A (UI & UX Polish):** Menghilangkan *white-space* berlebihan, merapikan layout profil mandor menjadi multi-kolom *compact*, serta menyatukan ukuran `rounded-xl` di seluruh card dan button.
2. **BATCH B (Data Table Improvement):** Menambahkan pencarian reaktif Livewire (*debounce* 300ms), filter status, dan paginasi dinamis pada seluruh tabel data tanpa *full page reload*.
3. **BATCH C (Empty State Reusable):** Membuat komponen Blade `<x-empty-state>` seragam dengan 11 ikon SVG kontekstual di seluruh daftar/tabel yang kosong.
4. **BATCH D (Interaction & Navigation):**
   - **SweetAlert2 Full Integration:** Mengganti 100% pop-up konfirmasi browser bawaan (`wire:confirm`) pada aksi hapus data, keluar akun, verifikasi, dan penyelesaian proyek dengan dialog SweetAlert2.
   - **Notification Dropdown:** Lonceng notifikasi fungsional yang terhubung ke database `notifications` lengkap dengan indikator *unread count*.
   - **Form Search GET:** Pencarian Hero Section terhubung penuh menggunakan parameter URL ID layanan (`?layanan=ID`) dan lokasi.

---

## 7. Ringkasan Status Proyek

- **Status Kode & Fungsionalitas:** **100% Selesai & Berfungsi**.
- **Kerapihan UI/UX:** **Konsisten, Responsif, & Standar Lomba**.
- **Kualitas Interaksi:** **Tanpa Reload (Livewire SPA) & SweetAlert Notif**.

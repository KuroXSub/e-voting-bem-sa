# Website E-Voting BEM

Platform digital yang dirancang untuk menyelenggarakan pemilihan umum Badan Eksekutif Mahasiswa (BEM) secara online. Sistem ini memastikan proses pemungutan suara yang aman, transparan, dan efisien, mulai dari pendaftaran pemilih hingga rekapitulasi suara.

Proyek ini dibangun menggunakan **Laravel** dan panel admin modern **Filament v3**.

---

## ✨ Fitur Utama

- **Manajemen Pemilih (Sisi Pengguna)**  
  Pengguna (mahasiswa) dapat mendaftar menggunakan NIM, melihat status verifikasi, dan memberikan suara pada periode pemilihan yang aktif.

- **Sistem Verifikasi Akun**  
  Admin harus memverifikasi akun mahasiswa baru sebelum mereka dapat berpartisipasi dalam pemilihan, memastikan hanya pemilih yang sah yang dapat memberikan suara.

- **Pemisahan Hak Akses (Role-based)**  
  Sistem secara otomatis membedakan antara peran 'Admin' dan 'Mahasiswa', mengarahkan mereka ke halaman yang sesuai (`/admin` atau `/dashboard`) dan membatasi akses ke fitur yang tidak relevan.

- **Dashboard Interaktif**  
  Pengguna akan melihat status pemilihan saat ini (belum dimulai, sedang berlangsung, atau selesai) dan status suara mereka sendiri di halaman dashboard.

---

## 🛠️ Panel Admin Modern (Filament)

- **Manajemen Pengguna Terpusat**  
  Admin dapat melihat, mengedit, dan memverifikasi data semua pengguna yang terdaftar. Status verifikasi dapat diubah langsung dari tabel.

- **Manajemen Periode Pemilihan**  
  CRUD untuk periode pemilihan, memungkinkan admin untuk menjadwalkan kapan pemilihan akan dimulai dan berakhir.

- **Manajemen Kandidat**  
  CRUD untuk data pasangan calon, termasuk mengunggah foto, visi, dan misi untuk setiap kandidat.

- **Monitoring Suara Masuk**  
  Admin dapat memantau data suara yang masuk secara real-time melalui panel admin.

---

## 🧑‍💻 Teknologi yang Digunakan

- ⚙️ **Framework Backend:** Laravel  
- ⚙️ **Admin Panel:** Filament v3  
- ⚙️ **Database:** MySQL / PostgreSQL  
- ⚙️ **UI Interaktif:** Livewire & Volt  
- ⚙️ **Styling:** Tailwind CSS & SCSS  
- ⚙️ **Development Tool:** Vite  
- ⚙️ **Otentikasi:** Laravel Auth  

---

## ⚙️ Petunjuk Instalasi

### 🔧 Konfigurasi Awal

1. **Clone Repository**
    ```bash
    git clone https://github.com/KuroXSub/e-voting-bem-sa.git
    cd e-voting-bem-sa
    ```

2. **Install Dependencies**
    ```bash
    composer install
    npm install
    ```

3. **Setup Environment**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Konfigurasi Database di File `.env`**
    Sesuaikan konfigurasi berikut di `.env`:
    ```dotenv
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=db_evoting_bem
    DB_USERNAME=root
    DB_PASSWORD=
    ```

---

### 🚀 Menjalankan Aplikasi

1. **Migrasi Database & Seeding**
    ```bash
    php artisan migrate --seed
    ```

2. **Kompilasi Assets**
    - Untuk production:
      ```bash
      npm run build
      ```
    - Untuk development (memantau perubahan file):
      ```bash
      npm run dev
      ```

3. **Jalankan Server Lokal**
    ```bash
    php artisan serve
    ```
    Aplikasi akan berjalan di: [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

### 🔐 Akses Admin Panel

1. **Buat User Admin**
    ```bash
    php artisan make:filament-user
    ```
    Isi nama, email, dan password untuk akun admin.

2. **Akses Admin Panel**
    Buka [http://127.0.0.1:8000/admin](http://127.0.0.1:8000/admin) dan login menggunakan akun admin yang telah dibuat.

---

## 📘 Panduan Penggunaan

### 👤 Untuk Admin:

- Login melalui halaman `/admin`.
- Verifikasi pendaftar baru melalui menu **Manajemen Pengguna**.
- Siapkan periode pemilihan dan data kandidat sebelum pemilihan dimulai.
- Pantau hasil suara melalui menu **Votes** atau dashboard Filament.

### 🙋 Untuk Pengguna (Mahasiswa):

- Daftar melalui halaman registrasi menggunakan **NIM** yang valid.
- Tunggu akun diverifikasi oleh admin.
- Setelah diverifikasi, login untuk mengakses dashboard.
- Jika periode pemilihan aktif dan belum memilih, akses halaman pemilihan untuk memberikan suara.

---

**Lisensi dan Kontribusi:**  
Silakan ajukan *issue* atau *pull request* jika ingin berkontribusi atau melaporkan masalah.  

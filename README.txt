TO-DO LIST PHP & MYSQL

Persyaratan:
- XAMPP dengan Apache dan MySQL
- Browser web

Cara memasang:
1. Ekstrak folder todo-list ke C:\xampp\htdocs\todo-list
2. Buka XAMPP Control Panel, lalu klik Start pada Apache dan MySQL.
3. Buka http://localhost/phpmyadmin
4. Pilih tab Import, pilih file database.sql, lalu klik Import/Go.
   Alternatif: buka tab SQL, salin isi database.sql, lalu jalankan.
5. Buka http://localhost/todo-list

Konfigurasi database:
- Host: localhost
- Username: root
- Password: kosong (pengaturan standar XAMPP)
- Database: todo_db

Jika akun MySQL Anda memakai password, ubah variabel $password di koneksi.php.

Fitur:
- Menambah tugas
- Menandai tugas selesai/belum selesai
- Menghapus tugas
- Ringkasan jumlah tugas
- Validasi input, prepared statements, dan token CSRF sederhana

Catatan:
Aplikasi ini dibuat untuk pembelajaran dan berjalan di komputer lokal. Untuk dipasang ke internet, perlu konfigurasi keamanan dan server yang sesuai.

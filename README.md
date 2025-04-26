## Aplikasi Manajemen Stok

Aplikasi ini bertujuan untuk mengelola dan memantau stok barang dalam suatu sistem agar tidak terjadi kehabisan stok secara mendadak. Dengan adanya fitur transaksi stok masuk dan keluar, serta notifikasi stok minim, aplikasi ini memungkinkan admin untuk dengan mudah memantau kondisi stok dan mengambil tindakan yang diperlukan.

## 🎯 **Fitur Utama**
- **Manajemen Produk & Kategori:** Admin dapat menambahkan dan mengelola data produk dan kategori.
- **Transaksi Stok Masuk:** Admin dapat menambah stok produk yang masuk ke sistem.
- **Transaksi Stok Keluar:** Stok otomatis berkurang saat terjadi transaksi (misalnya, penjualan atau penggunaan produk).
- **Notifikasi Stok Minim:** Sistem memberikan pemberitahuan kepada admin saat stok produk mencapai batas minimum.
- **Laporan Stok:** Admin dapat melihat rekap stok dan transaksi, serta mengunduh laporan dalam format **PDF**.

## 👥 **Role Pengguna**
1. **Admin:**
   - Menambah dan mengelola data produk dan kategori.
   - Menginput transaksi stok masuk.
   - Memantau stok dengan notifikasi stok minim.
   - Melihat dan mengunduh laporan stok.
   
2. **Pengguna:**
   - Melakukan transaksi yang mengurangi stok (stok keluar otomatis).
   - Hanya dapat melihat stok produk, tidak dapat menginput stok masuk.

## 📦 **Alur Kerja Sistem**
1. **Produk & Kategori:** Admin menambahkan kategori terlebih dahulu, lalu produk.
2. **Transaksi Stok Masuk:** Admin menambah stok produk.
3. **Transaksi Stok Keluar:** Pengguna melakukan transaksi yang mengurangi stok produk.
4. **Notifikasi Stok Minim:** Sistem memberi notifikasi ketika stok mencapai batas minimum.
5. **Laporan Stok:** Admin dapat melihat riwayat transaksi dan stok produk, serta mengunduh laporan dalam format PDF.

## 🛠️ **Teknologi yang Digunakan**
- **Backend:** Laravel
- **Frontend:** Blade (Laravel templating engine), **StartBootstrap SB Admin 2** (admin dashboard template)
- **Database:** MySQL
- **Notifikasi:** SweetAlert2
- **Laporan:** Export ke PDF

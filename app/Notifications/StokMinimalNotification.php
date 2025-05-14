<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

/**
 * kelas notifikasi untuk peringatan stok minimal
 * mengirim email ketika stok produk mencapai batas minimal
 */
class StokMinimalNotification extends Notification
{
    use Queueable;

    /**
     * menyimpan data produk yang akan dikirim dalam notifikasi
     */
    protected $produk;

    /**
     * membuat instance notifikasi baru
     */
    public function __construct($produk)
    {
        $this->produk = $produk;
    }

    /**
     * menentukan channel pengiriman notifikasi
     * saat ini menggunakan email
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * menyusun pesan email notifikasi
     * berisi informasi produk yang stoknya minimal
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Peringatan Stok Minimal - ' . $this->produk->nama_produk)
            ->greeting('Halo Admin,')
            ->line('Stok produk berikut telah mencapai atau di bawah batas minimal:')
            ->line('Nama Produk: ' . $this->produk->nama_produk)
            ->line('Stok Saat Ini: ' . $this->produk->stok)
            ->line('Stok Minimal: ' . $this->produk->stok_minimal)
            ->action('Lihat Detail Produk', route('produkDetail', $this->produk->id_produk))
            ->line('Mohon segera lakukan pemesanan untuk menambah stok.');
    }
}

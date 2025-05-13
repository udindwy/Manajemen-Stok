<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class StokMinimalNotification extends Notification
{
    use Queueable;

    protected $produk;

    public function __construct($produk)
    {
        $this->produk = $produk;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

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

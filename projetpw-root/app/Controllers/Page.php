<?php

namespace App\Controllers;

class Page extends BaseController
{
    public function about()
    {
        echo "about page";
    }

    public function contact()
    {
        echo "contact page";
    }

    public function faqs()
    {
        echo "faqs page";
    }

    public function tos()
    {
        echo "Halaman Term of Service";
    }

    public function biodata()
    {
        echo "Nama      : Yunita Nur Fadhila</br>";
        echo "TTL       : 17 Juni 2003</br>";
        echo "Alamat    : Ds. Plosogenuk Perak-Jombang</br>";
        echo "Status    : Mahasiswa</br>";
    }
}

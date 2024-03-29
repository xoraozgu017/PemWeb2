<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index(){
        $data = [
            'title' => 'Home | Unipdu Press',
            //'tes' => ['satu','dua','tiga']
        ];
        return view('pages\home', $data);
    }

    public function about(){
        $data = [
            'title' => 'Halaman About | Unipdu Press',
        ];
        return view('pages\about', $data);
    }

    public function contact(){
        $data = [
            'title' => 'Hubungi Kami | Unipdu Press',
            'alamat' => [
                [
                    'tipe' => 'Rumah',
                    'alamat' => 'Jln.KH Sholeh Dusun Banjarkerep',
                    'kota' => 'Jombang'
                ],
                [
                    'tipe' => 'Kantor',
                    'alamat' => 'Komplek Dusun Banjarkerep',
                    'kota' => 'Jombang'
                ]
            ]
        ];
        return view ('pages\contact', $data);  
    }
}
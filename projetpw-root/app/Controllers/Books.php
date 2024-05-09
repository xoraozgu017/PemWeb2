<?php

namespace App\Controllers;

use App\Models\BooksModel;

class Books extends BaseController{
    
    protected $BooksModel;
    
    public function __construct() {
        $this->BooksModel = new BooksModel();
    }
    
    public function index(){
        //$buku = $this->BooksModel->findAll();
        $data = [
            'title' => 'Daftar Buku',
            'buku' => $this->BooksModel->getBuku()
        ];

        return view('books/index', $data); 
    }

    public function detail($slug){
        $data = [
            'title' => 'Detail Buku',
            'buku' => $this->BooksModel->getBuku($slug)
        ];

        //kode jika buku tidak ada
        if(empty($data['buku'])){
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul Buku' . $slug . 'Tidak Ditemukan');
        }

        return view( 'books/detail', $data );
    }

    public function create(){
        $data = [
            'title' => 'Detail buku'
        ];

        return view('books/create', $data);
    }

    public function save(){

        $slug = url_title($this->request->getVar('judul'), '-' , true);
        $this->BooksModel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $this->request->getVar('sampul')
        ]);
        
        session()->setFlashData('pesan','Data berhasil ditambahkan');

        return redirect()->to('/books');
    }

}

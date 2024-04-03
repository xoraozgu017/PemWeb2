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

        return view('books\index', $data); 
    }

    public function detail($slug){
        $data = [
            'title' => 'Detail Buku',
            'buku' => $this->BooksModel->getBuku($slug)
        ];

        return view( 'books\detail', $data );
    }
}
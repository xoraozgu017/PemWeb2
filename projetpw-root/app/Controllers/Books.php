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
            'title' => 'Detail Buku'
        ];
    
        $data = [
            'title' => 'Form Tambah Buku',
            'validation' => session()->getFlashdata('validation') ?? \Config\Services::validation()
        ];

    
        return view('books/create', $data);
    }

    public function save(){

        //validasi input
        if(!$this->validate([
            'judul' => [
                'rules' => 'required|is_unique[books.judul]',
                'errors' => [
                    'required' => '{field} Buku Harus Diisi',
                    'is_unique' => '{field} Buku Sudah dimasukkan'
                ]
            ]
        ])) {
            session()->setFlashdata('validation', \Config\Services::validation());
            return redirect()->to('/books/create')->withInput();
            //$validation = \Config\Services::validation();
            //return redirect()->back()->withInput()->with('validation', $validation);
        }
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

    public function delete($id){
        
        $this->BooksModel->delete($id);
        
        session()->setFlashData('pesan','Data berhasil dihapus');
        
        return redirect()->to('/books');
    }
}

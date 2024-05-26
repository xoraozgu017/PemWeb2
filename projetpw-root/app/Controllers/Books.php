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
                    'required' => '{field} buku harus diisi',
                    'is_unique' => '{field} buku sudah dimasukkan'
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

    public function edit($slug){
        
        //session()

        $data = [
            'title' => 'Form Ubah Data Buku',
            'validation' => \Config\Services::validation(),
            'buku' => $this->BooksModel->getBuku($slug)
        ];

        return view('books/edit', $data);
    }

    public function update($id){

        
        //fungsi cek judul buku yang ada
        $bukuLama = $this->BooksModel->getBuku($this->request->getVar('slug'));
            if($bukuLama['judul'] == $this->request->getVar('judul')){
                $rule_judul = 'required|is_unique[books.judul]';
            }else{
                $rule_judul = 'required';
            }

            if($bukuLama['penulis'] == $this->request->getVar('penulis')){
                $rule_penulis = 'required|is_unique[books.penulis]';
            }else{
                $rule_penulis = 'required';
            }

            if($bukuLama['penerbit'] == $this->request->getVar('penerbit')){
                $rule_penerbit = 'required|is_unique[books.penerbit]';
            }else{
                $rule_penerbit = 'required';
            }
        
        //validasi input
        if(!$this->validate([
            'judul' => [
                'rules' => $rule_judul,
                'errors' => [
                    'required' => '{field} buku harus diisi',
                    'is_unique' => '{field} buku sudah dimasukkan'
                ]
            ],

            'penulis' => [
                'rules' => $rule_penulis,
                'errors' => [
                    'required' => '{field} buku harus diisi',
                    'is_unique' => '{field} buku sudah dimasukkan'
                ]
            ],

            'penerbit' => [
                'rules' => $rule_penerbit,
                'errors' => [
                    'required' => '{field} buku harus diisi',
                    'is_unique' => '{field} buku sudah dimasukkan'
                ]
            ]
        ])){
            $validation = \Config\Services::validation();
            return redirect()->to('/books/edit/'.$this->request->getVar('slug'))->withInput()->with('validation', $validation);
        }   

        $slug = url_title($this->request->getVar('judul'), '-' , true);
        $this->BooksModel->save([
            'id' => $id,
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $this->request->getVar('sampul')
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah');

        return redirect()->to('/books');
    }
}
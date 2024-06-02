<?php

namespace App\Controllers;

use App\Models\BooksModel;

class Books extends BaseController
{
    protected $bukuModel;
    public function __construct()
    {
        $this->bukuModel = new BooksModel();
    }
    public function index()
    {
        //$buku = $this->bukuModel->findAll();
        $data = [
            'title' => 'Daftar Buku',
            'buku' => $this->bukuModel->getBuku()
        ];

        return view('books/index', $data);
    }

    public function detail($slug)
    {
        //$buku = $this->bukuModel->where(['slug' => $slug])->first();


        $data = [
            'title' => 'Detail Buku',
            'buku' => $this->bukuModel->getBuku($slug)
        ];

        if (empty($data['buku'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul Buku' . $slug . 'Tidak ditemukan');
        }

        return view('books/detail', $data);
    }

    public function edit($slug)
    {

        $data = [
            'title' => 'Form Edit Data Buku',
            'validation' => session()->getFlashdata('validation') ?? \Config\Services::validation(),
            'buku' => $this->bukuModel->getBuku($slug)
        ];

        return view('books/edit', $data);
    }

    public function create()
    {

        $data = [
            'title' => 'Form Tambah Buku',
            'validation' => session()->getFlashdata('validation') ?? \Config\Services::validation(),
        ];

        return view('books/create', $data);
    }

    public function update($id)
    {
        $bukuLama = $this->bukuModel->getBuku($this->request->getVar('slug'));
        if ($bukuLama['judul'] == $this->request->getVar('judul')) {
            $rule_judul = 'required';
        } else {
            $rule_judul = 'required|is_unique[books.judul]';
        }

        //validasi inputan
        if (!$this->validate([
            'judul' => [
                'rules' => $rule_judul,
                'errors' => [
                    'required' => '{field} buku harus di isi',
                    'is_unique' => '{field} buku sudah terdaftar'
                ]
            ],
            'penulis' => [
                'rules' => $rule_judul,
                'errors' => [
                    'required' => '{field} buku harus di isi',
                    'is_unique' => '{field} buku sudah terdaftar'
                ]
            ],
            'penerbit' => [
                'rules' => $rule_judul,
                'errors' => [
                    'required' => '{field} buku harus di isi',
                    'is_unique' => '{field} buku sudah terdaftar'
                ]
            ],
            'sampul' => [
                'rules' => 'max_size[sampul,1024|is_image[sampul]|mime_in[sampul, image/jpg, image/jpeg, image/png]',
                'error' => [
                    //'uploaded' => 'Pilihlah gambar yang sesuai',
                    'max_size' => 'Ukuran file kebesaran',
                    'is_image' => 'File anda pilih bukan gambar',
                    'mime_in' => 'File anda pilih bukan gambar'
                ]
            ]
        ])) {
            session()->setFlashdata('validation', \Config\Services::validation());
            return redirect()->to('/books/edit/' . $this->request->getVar('slug'))->withInput();
        }

        $gambarSampul = $this->request->getFile('sampul');

        //cek gambar, apakah tetap gambar lama
        if ($gambarSampul->getError() == 4){
            $namaSampul = $this->request->getVar('sampulLama');
        } else{
            //generate nama gambar
            $namaSampul = $gambarSampul->getRandomName();

            //pindahkan gambar
            $gambarSampul->move('img', $namaSampul);

            //hapus File
            unlink('img/'.$this->request->getVar('sampulLama'));
        }

        $slug = url_title($this->request->getVar('judul'), '-', true);
        
        $this->bukuModel->save([
            'id' => $id,
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $namaSampul
        ]);

        session()->setFlashdata('pesan', 'Data Berhasil di ubah');

        return redirect()->to('/books');
    }

    public function delete($id)
    {
        //cari nama gambar
        $buku = $this->bukuModel->find($id);

        //hapus gambar
       if($buku['sampul' != 'no-cover.jpg']){

            //hapus gambar
            unlink('img/'.$buku['sampul']);

       } 
        
        $this->bukuModel->delete($id);

        session()->setFlashdata('pesan', 'Data berhasil dihapus');

        return redirect()->to('/books');
    }

    public function save()
    {
        if (!$this->validate([
            'judul' => [
                'rules' => 'required|is_unique[books.judul]',
                'errors' => [
                    'required' => '{field} buku harus di isi',
                    'is_unique' => '{field} buku sudah terdaftar'
                ]
            ],
            'penulis' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} buku harus di isi',
                    'is_unique' => '{field} buku sudah terdaftar'
                ]
            ],
            'penerbit' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} buku harus di isi',
                    'is_unique' => '{field} buku sudah terdaftar'
                ]
            ],
            'sampul' => [
                //uploaded[sampul]
                'rules' => 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul, image/jpg, image/jpeg, image/png]',
                'error' => [
                    //'uploaded' => 'Pilihlah gambar yag sesuai',
                    'max_size' => 'Ukuran file kebesaran',
                    'is_image' => 'File anda pilih bukan gambar',
                    'mime_in' => 'File anda pilih bukan gambar'
                ]
            ]
            
        ])) {
            session()->setFlashdata('validation', \Config\Services::validation());
            return redirect()->to('/books/create')->withInput();
        }

        //ambil file gambar
        $gambarSampul = $this->request->getFile('sampul');

        //cek apakah ada file yang diunggah
       if($gambarSampul->getError() == 4){
        $namaSampul = 'no-cover.jpg';
       } else{
        //generate nama gambar
        $namaSampul = $gambarSampul->getRandomName();

        //pindah file gambar ke folder img
        $gambarSampul->move('img', $namaSampul);

        //ambil nama file gambar
        //$namaSampul = $gambarSampul->getError();
       }
       

        //generate nama gambar
        $namaSampul = $gambarSampul->getRandomName();

        //pindah gambar ke folder img
        $gambarSampul->move('img');

        //ambil nama file gambar
        $namaSampul = $gambarSampul->getName();

        $slug = url_title($this->request->getVar('judul'), '-', true);
       
        $this->bukuModel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $this->request->getVar('sampul')
        ]);

        session()->setFlashdata('pesan', 'Data Berhasil ditambahkan');

        return redirect()->to('/books');
    }
}

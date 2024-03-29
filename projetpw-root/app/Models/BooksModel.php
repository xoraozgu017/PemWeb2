<?php

namespace App\Models;

use CodeIgniter\Model;

class BooksModel extends Model{
    protected $table = 'books';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
}
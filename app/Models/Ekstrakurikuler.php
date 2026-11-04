<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ekstrakurikuler extends Model
{
    use HasFactory;

   protected $fillable = [
    'nama_ekskul', 
    'kategori', 
    'hari', 
    'jam', 
    'deskripsi', 
    'pembina', 
    'kuota'
];
}
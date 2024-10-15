<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class todo extends Model
{
    use HasFactory;
    // masukkan nama schema atau tabel di database
    protected $table = 'todo';
    //masukkan atribut apa saja yang ada dalam skema/table
    protected $fillable = ['task', 'is_done'];
}

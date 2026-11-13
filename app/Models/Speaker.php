<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Speaker extends Model
{
    use HasFactory;

    protected $table = 'speakers';
    
    protected $fillable = [
        'name',
        'email',
        'phone',
        'role',
        'status',
        'bio',
        'primary_domain',
        'skills',
        'current_institution',
        'portfolio_url',
    ];

    // Karena tabel tidak memiliki kolom updated_at
    const UPDATED_AT = null;
}
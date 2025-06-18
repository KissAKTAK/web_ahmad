<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Law extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'law_number',
        'year',
        'category',
        'pdf_file',
        'status'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}

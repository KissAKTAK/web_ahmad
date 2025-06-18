<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email', 
        'phone',
        'subject',
        'message',
        'attachment',
        'status',
        'notes'
    ];

    protected $casts = [
        'notes' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'warning',
            'in_progress' => 'info', 
            'resolved' => 'success',
            'closed' => 'secondary'
        ];
        
        return $badges[$this->status] ?? 'secondary';
    }
    
    public function getStatusTextAttribute()
    {
        $statuses = [
            'pending' => 'في الانتظار',
            'in_progress' => 'قيد المراجعة',
            'resolved' => 'تم الحل', 
            'closed' => 'مغلقة'
        ];
        
        return $statuses[$this->status] ?? 'غير محدد';
    }
}

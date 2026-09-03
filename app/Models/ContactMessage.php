<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 
        'email',    
        'subject',  
        'message',  
    ];
    protected $casts = [
        'submitted_at' => 'datetime',
    ];
    public function formattedDate(): string
    {
        return $this->submitted_at->format('d M Y, h:i A');
    }
    public function isNew(): bool
    {
        return $this->submitted_at->diffInHours(now()) < 24;
    }
}
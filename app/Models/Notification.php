<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 
        'type',     
        'message',  
        'link',     
        'is_read',   
    ];
    protected $casts = [
        'is_read' => 'boolean',   
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function markAsRead(): void
    {
        $this->update(['is_read' => true]);
    }

    public function markAsUnread(): void
    {
        $this->update(['is_read' => false]);
    }

    public static function unreadCount(int $userId): int
    {
        return self::where('user_id', $userId)->where('is_read', false)->count();
    }
    public function iconClass(): string
    {
        return match($this->type) {
            'appointment_booked'     => 'bi-calendar-plus',
            'appointment_approved'   => 'bi-check-circle',
            'appointment_rejected'   => 'bi-x-circle',
            'appointment_cancelled'  => 'bi-calendar-x',
            'appointment_completed'  => 'bi-calendar-check',
            'lawyer_approved'        => 'bi-shield-check',
            'new_lawyer_registration'=> 'bi-person-plus',
            'new_message'            => 'bi-envelope',
            default                  => 'bi-bell',
        };
    }
    public function timeAgo(): string
    {
        return $this->created_at->diffForHumans();
    }
}
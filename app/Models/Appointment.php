<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'lawyer_id',
        'customer_id',
        'appointment_date',
        'appointment_time',
        'status',
        'message',
        'customer_rating',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'datetime:H:i',
        'customer_rating'  => 'integer',
    ];

    public function lawyer()
    {
        return $this->belongsTo(User::class, 'lawyer_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    public function isRated(): bool
    {
        return $this->customer_rating !== null;
    }

    public function statusBadge(): string
    {
        return match($this->status) {
            'pending'   => '<span class="badge bg-warning text-dark">Pending</span>',
            'approved'  => '<span class="badge bg-success">Approved</span>',
            'rejected'  => '<span class="badge bg-danger">Rejected</span>',
            'completed' => '<span class="badge bg-info">Completed</span>',
            'cancelled' => '<span class="badge bg-secondary">Cancelled</span>',
            default     => '<span class="badge bg-secondary">' . ucfirst($this->status) . '</span>',
        };
    }

    public function formattedDateTime(): string
    {
        return $this->appointment_date->format('d M Y') . ' at ' .
               $this->appointment_time->format('h:i A');
    }
}

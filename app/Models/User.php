<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;


    protected $fillable = [
        'name',    
        'email',           
        'password',   
        'phone',    
        'city',       
        'address',      
        'role',          
        'specialization',   
        'qualification', 
        'experience_years', 
        'consultation_fee', 
        'bar_council_number',
        'rating',           
        'is_approved',     
        'available_days',   
        'available_time_start',
        'available_time_end',  
    ];


    protected $hidden = [
        'password',        
        'remember_token',    
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',     
        'password' => 'hashed',              
        'is_approved' => 'boolean',          
        'rating' => 'decimal:1',             
        'experience_years' => 'integer',       
        'consultation_fee' => 'integer',    
    ];
    public function lawyerAppointments()
    {
        return $this->hasMany(Appointment::class, 'lawyer_id', 'id');
    }
    public function customerAppointments()
    {
        return $this->hasMany(Appointment::class, 'customer_id', 'id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id', 'id');
    }
    public function isLawyer(): bool
    {
        return $this->role === 'lawyer';
    }
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }
    public function isApproved(): bool 
    {
        return (bool) $this->is_approved; 
    }
    public function getAvailableDays(): array
    {
        $days = json_decode($this->available_days, true);

        return $days ?? [];
    }
    public function getDisplayNameAttribute(): string
    {
        $name = $this->name;

        if ($this->isLawyer() && $this->specialization) {
            $name .= " ({$this->specialization} Lawyer)";
        }

        return $name;
    }
}
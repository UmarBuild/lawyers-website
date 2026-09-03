<?php

namespace App\Models;
use Illuminate\database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
   use HasFactory;
   protected $fillable = ['name'];

   public function lawyers(){
      return $this->hasMany(User::class,'specialization','name')->where('role','lawyer');
   }
    public function getLabelAttribute(): string
    {
        return $this->name;
    }

}

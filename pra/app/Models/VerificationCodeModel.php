<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationCodeModel extends Model
{
    use HasFactory;
    protected $table='verification_codes';
    protected $fillable=[
        'user_phone',
        'otp',
        'user_id',
        'expire_at'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}



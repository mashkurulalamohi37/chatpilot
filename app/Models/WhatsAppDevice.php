<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsAppDevice extends Model
{
    use HasFactory;

    protected $table = 'whatsapp_devices';

    protected $fillable = [
        'user_id',
        'phone_number_id',
        'whatsapp_business_account_id',
        'access_token',
        'phone_number',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

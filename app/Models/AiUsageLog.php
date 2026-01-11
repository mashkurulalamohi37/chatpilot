<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiUsageLog extends Model
{
    protected $fillable = [
        'user_id',
        'request_type',
        'input_tokens',
        'output_tokens',
        'cost',
    ];
}

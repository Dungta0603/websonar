<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerifyEmail extends Model
{
    protected $table = 'verify_email';
    protected $primaryKey = 'id';
    protected $fillable = [
        'email' => 'email',
        'otp' => 'otp',
        'user_id' => 'user_id',
        'setup_time' => 'setup_time',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

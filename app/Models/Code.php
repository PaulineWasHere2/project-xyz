<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Code extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'host_id',
        'code',
    ];
    protected $casts = [
        'consumed_at' => 'timestamp'
    ];
    public function host() :BelongsTo
    {
        return $this->belongsTo(User::class, 'host_id');
    }
    public function guest() :BelongsTo
    {
        return $this->belongsTo(User::class, 'guest_id');
    }

}

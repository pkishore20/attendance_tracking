<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class attendance extends Model
{
    use HasFactory ,SoftDeletes;

    protected $fillable =[
        'users_info_id',
        'date',
        'in_time',
        'out_time',
        'total_hours'
    ];


    protected function Date(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => date("d-m-Y", strtotime($value)),
            set: fn (string $value) => date("Y-m-d", strtotime($value)),
        );
    }

    public function User_info(): BelongsTo
    {
        return $this->belongsTo(Users_info::class, 'users_info_id' );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(user::class);
    }
}

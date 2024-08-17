<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Users_info extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['user_id', 'departments_id', 'add_roles_id'];

    public function attendance(): HasOne
    {
        return $this->hasOne(attendance::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(departments::class, 'department_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(add_roles::class, 'add_roles_id');
    }
}

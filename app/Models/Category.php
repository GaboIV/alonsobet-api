<?php

namespace App\Models;

use App\Models\League;
use App\Traits\ScopeFilterByColumn;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use ScopeFilterByColumn;

    protected $fillable = [
        'name',
        'name_id',
        'acro_3',
        'importance'
    ];

    public function leagues()
    {
        return $this->hasMany(League::class);
    }

    public function searchableColumns(): array
    {
        return [
            'id',
            'name',
            'acro_3',
            'name_id',
            'importance'
        ];
    }
}

<?php

namespace App\Models;

use App\Traits\ScopeFilterByColumn;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use ScopeFilterByColumn;

    protected $fillable = [
        'name',
        'name_id',
        'acro_2',
        'acro_3',
        'importance'
    ];

    public function leagues()
    {
        return $this->hasMany('App\League');
    }

    public function searchableColumns(): array
    {
        return [
            'id',
            'name',
            'acro_2',
            'acro_3',
            'name_id',
            'importance'
        ];
    }
}

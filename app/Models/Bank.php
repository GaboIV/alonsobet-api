<?php

namespace App\Models;

use App\Traits\ScopeFilterByColumn;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use ScopeFilterByColumn;

    protected $fillable = [
        'name',
        'initial'
    ];

    public function searchableColumns(): array
    {
        return [
            'id',
            'name',
            'initial'
        ];
    }
}

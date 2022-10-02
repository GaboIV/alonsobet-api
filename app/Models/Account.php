<?php

namespace App\Models;

use App\Models\Bank;
use App\Traits\ScopeFilterByColumn;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use ScopeFilterByColumn;

    protected $with = ["bank"];

    const AHORRO = 'Ahorro';
    const CORRIENTE = 'Corriente';

    public static $types = [self::AHORRO, self::CORRIENTE];

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id', 'id');
    }

    public function searchableColumns(): array
    {
        return [
            'id',
            'name',
            'number',
            'document',
            'email',
            'type',
            'bank_id'
        ];
    }
}

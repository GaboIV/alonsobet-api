<?php

namespace App\Models;

use App\Traits\ScopeFilterByColumn;
use Illuminate\Database\Eloquent\Model;

class BetType extends Model
{
    use ScopeFilterByColumn;

    protected $fillable = [
        'name',
        'description',
        'importance',
        'category_id'
    ];

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function searchableColumns(): array
    {
        return [
            'name',
            'description',
            'importance',
            'category_id' => ['condition' => '=']
        ];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    /**
     * Новости, принадлежащие тегу.
     *
     * @return BelongsToMany
     */
    public function news(): BelongsToMany
    {
        return $this->belongsToMany(News::class);
    }
}

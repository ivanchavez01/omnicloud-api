<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Book extends Model
{
    use HasFactory;

    /**
     * @return HasOne
     */
    public function editorial(): HasOne
    {
        return $this->hasOne(Editorial::class);
    }

    public function pdfFile(): HasOne
    {
        return $this->hasOne(File::class);
    }

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class);
    }
}

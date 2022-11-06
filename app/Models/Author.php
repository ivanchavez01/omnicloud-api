<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'picture_id',
    ];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'books_authors');
    }

    public function picture(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'editorial_id',
        'pdf_file_id',
        'title',
        'published_at',
        'price'
    ];

    /**
     * @return BelongsTo
     */
    public function editorial(): BelongsTo
    {
        return $this->belongsTo(Editorial::class);
    }

    public function pdfFile(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'books_authors');
    }
}

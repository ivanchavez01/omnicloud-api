<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Editorial;
use App\Models\File;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAnUserRetrieveBook(): void
    {
        $book = Book::find(1);

        $this->assertInstanceOf(Book::class, $book);
        $this->assertInstanceOf(Editorial::class, $book->editorial);
        $this->assertInstanceOf(File::class, $book->pdfFile);
        $this->assertCount(1, $book->authors->toArray());
    }
}

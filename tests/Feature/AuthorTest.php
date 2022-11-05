<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\File;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAnUserCanRetrieveAuthor(): void
    {
        $author = Author::find(1);

        $this->assertInstanceOf(Author::class, $author);
        $this->assertCount(1, $author->books->toArray());
        $this->assertInstanceOf(File::class, $author->picture);
    }
}

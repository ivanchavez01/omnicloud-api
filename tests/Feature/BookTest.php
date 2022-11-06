<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Editorial;
use App\Models\File;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BookTest extends TestCase
{
    private string $email;
    private string $password;

    protected function setUp(): void
    {
        $this->email = 'ichavez9001@gmail.com';
        $this->password = '123456789';

        parent::setUp();
    }

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
    public function testAnUserCanRetrieveSomeBooksViaApi(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Basic '. base64_encode("{$this->email}:{$this->password}")
        ])->get('/api/book');

        $response->assertOk();
    }

    public function testAnUserCanRetrieveOneBookViaApi(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Basic '. base64_encode("{$this->email}:{$this->password}")
        ])->get('/api/book/1');

        $response->assertOk();
    }

    public function testAnUserCanCreateABookViaApi(): void
    {
        Storage::fake('books');

        $file = UploadedFile::fake()->image('cover.jpg');
        $response = $this->withHeaders([
            'Authorization' => 'Basic '. base64_encode("{$this->email}:{$this->password}")
        ])->post('/api/book', [
            'editorial_id' => 1,
            'authors' => [1],
            'pdf_file' => $file,
            'title' => 'Fundamentals of Software Architecture',
            'published_at' => '2022-01-19',
            'price' => 1200,
        ]);

        $response->assertOk();
    }

    public function testAnUserCanUpdateABookViaApi(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Basic '. base64_encode("{$this->email}:{$this->password}")
        ])->put('/api/book/2', [
            'editorial_id' => 1,
            'authors' => [1],
            'title' => 'Fundamentals of Software Architecture 2',
            'published_at' => '2022-01-19',
            'price' => 1200,
        ]);

        $response->assertOk();
    }

    public function testAnUserCanDeleteABookViaApi(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Basic '. base64_encode("{$this->email}:{$this->password}")
        ])->delete('/api/book/2');

        $response->assertOk();
    }
}

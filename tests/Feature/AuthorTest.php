<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\File;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    private string $email;
    private string $password;

    protected function setUp(): void
    {
        $this->email = 'ichavez9001@gmail.com';
        $this->password = '123456789';

        parent::setUp();
    }

    public function testAnUserCanRetrieveAuthor(): void
    {
        $author = Author::find(1);

        $this->assertInstanceOf(Author::class, $author);
        $this->assertCount(1, $author->books->toArray());
        $this->assertInstanceOf(File::class, $author->picture);
    }

    public function testAnUserCanCreateABookViaApi(): void
    {
        Storage::fake('authors');

        $file = UploadedFile::fake()->image('cover.jpg');
        $response = $this->withHeaders([
            'Authorization' => 'Basic '. base64_encode("{$this->email}:{$this->password}")
        ])->post('/api/author', [
            'name' => 'Mark',
            'last_name' => 'Richards',
            'photo' => $file,
            'email' => 'mrichards@oreilly.com',
        ]);

        $response->assertOk();
    }

    public function testAnUserCanUpdateABookViaApi(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Basic '. base64_encode("{$this->email}:{$this->password}")
        ])->put('/api/author/2', [
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
        ])->delete('/api/author/2');

        $response->assertOk();
    }
}

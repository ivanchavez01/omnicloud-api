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

class EditorialTest extends TestCase
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
    public function testAnUserCanRetrieveSomeEditorialsViaApi(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Basic '. base64_encode("{$this->email}:{$this->password}")
        ])->get('/api/editorial');

        $response->assertOk();
    }

    public function testAnUserCanRetrieveOneEditorialViaApi(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Basic '. base64_encode("{$this->email}:{$this->password}")
        ])->get('/api/editorial/1');

        $response->assertOk();
    }

    public function testAnUserCanCreateAnEditorialViaApi(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Basic '. base64_encode("{$this->email}:{$this->password}")
        ])->post('/api/editorial', [
            'name' => 'WILEY',
            'phone_number' => '1243770620'
        ]);

        $response->assertOk();
    }

    public function testAnUserCanUpdateAnEditorialViaApi(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Basic '. base64_encode("{$this->email}:{$this->password}")
        ])->put('/api/editorial/2', [
            'phone_number' => '1243770621'
        ]);

        $response->assertOk();
    }

    public function testAnUserCanDeleteAnEditorialViaApi(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Basic '. base64_encode("{$this->email}:{$this->password}")
        ])->delete('/api/editorial/2');

        $response->assertOk();
    }
}

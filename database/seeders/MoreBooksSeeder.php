<?php

namespace Database\Seeders;

use App\Models\Editorial;
use App\Models\File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MoreBooksSeeder extends Seeder
{
    private array $books = [
        [
            "title" => "Los 7 Hábitos de la gente altamente efectiva",
            "price" => 280.00,
            "published_at" => '2022-11-08',
            "editorial" => "PAIDÓS",
            "file" => "books/D_NQ_NP_2X_729529-MLM31234187747_062019-F.webp",
            "authors" => [
                [
                    "name" => "Stephen",
                    "last_name" => "R. Covey",
                ]
            ]
        ],
        [
            "title" => "Cómo ganar amigos e influir sobre ellos",
            "price" => 349.00,
            "published_at" => '2022-11-08',
            "editorial" => "Penguin Random House",
            "file" => "books/51QrRtC-8NL._SX325_BO1,204,203,200_.jpg",
            "authors" => [
                [
                    "name" => "Dale",
                    "last_name" => "Carnegie",
                ]
            ]
        ],
        [
            "title" => "Las 48 leyes del poder",
            "price" => 344.50,
            "published_at" => '2022-11-08',
            "editorial" => "Oceano",
            "file" => "books/51ZDVQLSOEL._SY344_BO1,204,203,200_QL70_ML2_.jpg",
            "authors" => [
                [
                    "name" => "Robert",
                    "last_name" => "Clausewitz",
                ]
            ]
        ],
        [
            "title" => "Quién se ha llevado mi queso",
            "price" => 706.50,
            "published_at" => '2022-11-08',
            "editorial" => "Empresa Activa",
            "file" => "books/51MrP+VVf0L._SX320_BO1,204,203,200_.jpg",
            "authors" => [
                [
                    "name" => "Spencer",
                    "last_name" => "Johnson",
                ]
            ]
        ],
        [
            "title" => "Domain-Driven Design: Tackling Complexity in the Heart of Software",
            "price" => 1194.50,
            "published_at" => '2022-11-08',
            "editorial" => "Wesley",
            "file" => "books/51nQaF77Y4L.jpg",
            "authors" => [
                [
                    "name" => "Eric",
                    "last_name" => "Evans",
                ]
            ]
        ],
        [
            "title" => "Microservice: Flexible Software Architecture",
            "price" => 1194.50,
            "published_at" => '2022-11-08',
            "editorial" => "Addison-Wesley",
            "file" => "books/51ENZqeVKuL._SX598_BO1,204,203,200_.jpg",
            "authors" => [
                [
                    "name" => "Eberhard",
                    "last_name" => "Wolff",
                ]
            ]
        ],
        [
            "title" => "Pattern-Oriented Software Architecture",
            "price" => 2759.00,
            "published_at" => '2022-11-08',
            "editorial" => "WILEY",
            "file" => "books/51JkW1N8wIL._SX260_.jpg",
            "authors" => [
                [
                    "name" => "Frank",
                    "last_name" => "Buschmann",
                ],
                [
                    "name" => "Regine",
                    "last_name" => "Meunier",
                ],
                [
                    "name" => "Hans",
                    "last_name" => "Rohnert",
                ],
                [
                    "name" => "Peter",
                    "last_name" => "Sommerlad",
                ],
                [
                    "name" => "Michel",
                    "last_name" => "Stal",
                ]
            ]
        ],
        [
            "title" => "Pattern-Oriented Software Architecture for Dummies",
            "price" => 845.45,
            "file" => "books/51pYnusSeaL._SX260_.jpg",
            "published_at" => '2022-11-08',
            "editorial" => "WILEY",
            "authors" => [
                [
                    "name" => "Robert",
                    "last_name" => "Hanmer",
                ]
            ]
        ],
    ];

    public function run()
    {
        DB::beginTransaction();
        try {
            foreach ($this->books as $book) {
                $editorial = Editorial::where("name", $book["editorial"])
                    ->first();

                if ($editorial === null) {
                    $editorial = Editorial::create(
                        [
                            "name" => $book["editorial"],
                            "phone_number" => "6624790767"
                        ]
                    );
                }

                $file = File::create([
                    "file" => $book["file"]
                ]);

                $bookId = DB::table("books")
                    ->insertGetId([
                        'editorial_id' => $editorial->id,
                        'pdf_file_id' => $file->id,
                        'title' => $book["title"],
                        'published_at' => $book["published_at"],
                        'price' => $book["price"]
                    ]);

                foreach ($book["authors"] as $author) {
                    $fileId = DB::table('files')
                        ->insertGetId([
                            "file" => "authors/1c3iCd2M3Fl0o5HiHyNrKzJr1S92Ss6euoIswAFM.jpg"
                        ]);

                    $authorId = DB::table('authors')
                        ->insertGetId([
                            "picture_id" => $fileId,
                            "name" => $author["name"],
                            "last_name" => $author["last_name"],
                            "email" => "author@example.com",
                        ]);

                    DB::table('books_authors')
                        ->insert([
                            "author_id" => $authorId,
                            "book_id" => $bookId
                        ]);
                }
            }
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            throw $ex;
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        DB::beginTransaction();
        try {
            $editorialId = DB::table('editorials')->insertGetId([
                'name' => "O'Reilly Media",
                'phone_number' => '66247907'
            ]);

            $authorId = DB::table('authors')->insertGetId([
                'name' => "Vlad",
                'last_name' => "Khononov",
                'email' => 'vkhononov@oreilly.com'
            ]);

            $bookId = DB::table('books')->insertGetId([
                'editorial_id' => $editorialId,
                'title' => "Learning Domain-Driven Design",
                'published_at' => '2021-04-21',
                'price' => 775.93
            ]);

            DB::table('books_authors')->insert([
                'author_id' => $authorId,
                'book_id' => $bookId
            ]);
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            throw $ex;
        }
    }
}

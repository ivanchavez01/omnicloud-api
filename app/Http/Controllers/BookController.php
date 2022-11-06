<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use App\Models\File;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Diff\Exception;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(Book::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateBookRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function store(CreateBookRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $filePath = $request->file("pdf_file")
                ->store('books');

            $file = File::create([
                "file" => $filePath
            ]);
            /** @var Book $book */
            $book = Book::create(
                collect($request->all())
                    ->except(["pdf_file"])
                    ->merge(["pdf_file_id" => $file->id])
                    ->toArray()
            );

            foreach ($request->post("authors") as $authorId) {
                $book->authors()->attach($authorId);
            }

            DB::commit();
            return response()->json($book);
        } catch (\Exception $ex) {
            DB::rollBack();
            throw $ex;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $book = Book::find($id);
        if ($book === null) {
            return response()->json(["error" => "Book not found"], 404);
        }
        return response()->json($book);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBookRequest $request
     * @param int $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function update(UpdateBookRequest $request, int $id): JsonResponse
    {
        try {
            /** @var Book $book */
            $book = Book::with("authors")
                ->find($id);

            if ($book === null) {
                return response()->json(["error" => "Book not found"], 404);
            }

            $book->update(
                collect($request->all())
                    ->except(['pdf_file_id'])
                    ->toArray()
            );

            foreach ($book->authors as $author) {
                $book->authors()->detach($author->id);
            }

            foreach ($request->post("authors") as $authorId) {
                $book->authors()->attach($authorId);
            }
            DB::commit();
            return response()->json($book->toArray());
        } catch (\Exception $ex) {
            DB::rollBack();
            throw $ex;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(int $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            /** @var Book $book */
            $book = Book::find($id);
            if ($book === null) {
                return response()->json(["error" => "Book not found"], 404);
            }

            foreach ($book->authors as $author) {
                $book->authors()->detach($author->id);
            }

            $book->pdfFile->delete();
            $book->delete();

            DB::commit();
            return response()->json(["deleted" => "ok"]);
        } catch (\Exception $ex) {
            DB::rollBack();
            throw $ex;
        }
    }
}

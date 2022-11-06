<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use App\Models\File;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

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
     * @param  UpdateBookRequest  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(UpdateBookRequest $request, int $id): JsonResponse
    {
        $book = Book::find($id);
        if ($book === null) {
            return response()->json(["error" => "Book not found"], 404);
        }

        $book->update($request->all());

        return response()->json($book->toArray());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        /** @var Book $book */
        $book = Book::find($id);
        if ($book === null) {
            return response()->json(["error" => "Book not found"], 404);
        }
        $book->delete();

        return response()->json(["deleted" => "ok"]);
    }
}

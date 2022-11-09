<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Author;
use App\Models\File;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(
            Author::with("picture")
                ->whereNull('deleted_at')
                ->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateAuthorRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function store(CreateAuthorRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $filePath = $request->file('photo')
                ->store('public/authors');
            $photo = File::create([
                "file" => $filePath
            ]);

            $author = Author::create(
                collect($request->except(['photo']))
                    ->merge(['picture_id' => $photo->id])
                    ->toArray()
            );

            DB::commit();
            return response()->json($author);
        } catch (\Exception $ex) {
            DB::rollback();
            throw $ex;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $author = Author::with("picture")->find($id);
        if ($author === null) {
            response()->json([
                "error" => "Author not found"
            ], 404);
        }

        return response()->json($author);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAuthorRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateAuthorRequest $request, int $id): JsonResponse
    {
        $author = Author::find($id);
        if ($author === null) {
            return response()->json([
                "error" => "Author not found"
            ], 404);
        }

        $author->update($request->all());

        return response()->json($author);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $author = Author::find($id);
        if ($author === null) {
            return response()->json([
                "error" => "Author not found"
            ], 404);
        }

        $author->delete();
        return response()->json(['status' => 'ok']);
    }
}

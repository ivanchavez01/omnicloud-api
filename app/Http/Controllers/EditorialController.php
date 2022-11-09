<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEditorialRequest;
use App\Http\Requests\UpdateEditorialRequest;
use App\Models\Book;
use App\Models\Editorial;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class EditorialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(
            Editorial::with("books")
                ->get()
                ->map(function (Editorial $editorial) {
                    return array_merge(
                        $editorial->toArray(),
                        [ 'books' => $editorial->books?->count() ]
                    );
                })
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateEditorialRequest $request
     * @return JsonResponse
     */
    public function store(CreateEditorialRequest $request): JsonResponse
    {
        $editorial = Editorial::create($request->all());
        return response()->json($editorial);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $editorial = Editorial::find($id);
        if ($editorial === null) {
            return response()->json([
                "error" => "Editorial not found"
            ], 404);
        }
        return response()->json($editorial);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateEditorialRequest $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(UpdateEditorialRequest $request, int $id): JsonResponse
    {
        $editorial = Editorial::find($id);
        if ($editorial === null) {
            return response()->json([
                "error" => "Editorial not found"
            ], 404);
        }

        $editorial->update($request->all());
        return response()->json($editorial);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $editorial = Editorial::find($id);
        if ($editorial === null) {
            return response()->json([
                "error" => "Editorial not found"
            ], 404);
        }

        $editorial->delete();
        return response()->json(['status' => 'ok']);
    }
}

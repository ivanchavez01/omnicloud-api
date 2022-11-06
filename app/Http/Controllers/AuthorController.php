<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAuthorRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Author;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(Author::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateAuthorRequest  $request
     * @return JsonResponse
     */
    public function store(CreateAuthorRequest $request): JsonResponse
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateBookRequest $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(UpdateBookRequest $request, int $id): JsonResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        //
    }
}

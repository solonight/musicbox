<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/albums",tags={"Albums"},
     *     summary="Get all albums",
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function index()
    {
        try {
            $albums = Album::all();
            return response()->json($albums, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch albums'], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/albums",tags={"Albums"},
     *     summary="Create a new album",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "release_year", "genre", "cover_image", "artist_id"},
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="release_year", type="integer"),
     *             @OA\Property(property="genre", type="string"),
     *             @OA\Property(property="cover_image", type="string"),
     *             @OA\Property(property="artist_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Album created")
     * )
     */
    public function store(Request $request)
    {
        try {
            $album = Album::create($request->all());
            return response()->json($album, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create album'], 400);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/albums/{id}",tags={"Albums"},
     *     summary="Get a single album by ID",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=404, description="Album not found")
     * )
     */
    public function show(string $id)
    {
        try {
            $album = Album::findOrFail($id);
            return response()->json($album, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Album not found'], 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/albums/{id}",
     *  tags={"Albums"},
     * 
     *
     *     summary="Update an existing album",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="release_year", type="integer"),
     *             @OA\Property(property="genre", type="string"),
     *             @OA\Property(property="cover_image", type="string"),
     *             @OA\Property(property="artist_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Album updated"),
     *     @OA\Response(response=404, description="Album not found")
     * )
     */
    public function update(Request $request, string $id)
    {
        try {
            $album = Album::findOrFail($id);
            $album->update($request->all());
            return response()->json($album, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update album'], 400);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/albums/{id}",tags={"Albums"},
     *     summary="Delete an album",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Album deleted"),
     *     @OA\Response(response=404, description="Album not found")
     * )
     */
    public function destroy(string $id)
    {
        try {
            $album = Album::findOrFail($id);
            $album->delete();
            return response()->json(['message' => 'Album deleted'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete album'], 400);
        }
    }
}

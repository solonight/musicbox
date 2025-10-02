<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/artists",
     *     tags={"Artists"},
     *     summary="Get all artists",
     *     @OA\Response(response=200, description="Success")
     * )
     */
    // List all artists
    public function index()
    {
        try {
            $artists = Artist::all();
            return response()->json($artists, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch artists'], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/artists",
     *     tags={"Artists"},
     *     summary="Create a new artist",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "genre"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="genre", type="string")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Artist created")
     * )
     */
    // Create a new artist
    public function store(Request $request)
    {
        try {
            $artist = Artist::create($request->all());
            return response()->json($artist, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create artist'], 400);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/artists/{id}",
     *     tags={"Artists"},
     *     summary="Get a single artist by ID",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=404, description="Artist not found")
     * )
     */
    // Show a single artist
    public function show($id)
    {
        try {
            $artist = Artist::findOrFail($id);
            return response()->json($artist, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Artist not found'], 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/artists/{id}",
     *     tags={"Artists"},
     *     summary="Update an existing artist",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="genre", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Artist updated"),
     *     @OA\Response(response=404, description="Artist not found")
     * )
     */
    // Update an artist
    public function update(Request $request, $id)
    {
        try {
            $artist = Artist::findOrFail($id);
            $artist->update($request->all());
            return response()->json($artist, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update artist'], 400);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/artists/{id}",
     *     tags={"Artists"},
     *     summary="Delete an artist",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Artist deleted"),
     *     @OA\Response(response=404, description="Artist not found")
     * )
     */
    // Delete an artist
    public function destroy($id)
    {
        try {
            $artist = Artist::findOrFail($id);
            $artist->delete();
            return response()->json(['message' => 'Artist deleted'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete artist'], 400);
        }
    }
}

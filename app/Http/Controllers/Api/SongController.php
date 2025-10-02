<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Song;
use Illuminate\Http\Request;

class SongController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/songs",
     *     tags={"Songs"},
     *     summary="Get all songs",
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function index()
    {
        try {
            $songs = Song::all();
            return response()->json($songs, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch songs'], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/songs",
     *     tags={"Songs"},
     *     summary="Create a new song",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "duration", "release_date", "genre", "album_id"},
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="duration", type="integer"),
     *             @OA\Property(property="release_date", type="string", format="date"),
     *             @OA\Property(property="genre", type="string"),
     *             @OA\Property(property="album_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Song created")
     * )
     */
    public function store(Request $request)
    {
        try {
            $song = Song::create($request->all());
            return response()->json($song, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create song'], 400);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/songs/{id}",
     *     tags={"Songs"},
     *     summary="Get a single song by ID",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=404, description="Song not found")
     * )
     */
    public function show(string $id)
    {
        try {
            $song = Song::findOrFail($id);
            return response()->json($song, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Song not found'], 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/songs/{id}",
     *     tags={"Songs"},
     *     summary="Update an existing song",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="duration", type="integer"),
     *             @OA\Property(property="release_date", type="string", format="date"),
     *             @OA\Property(property="genre", type="string"),
     *             @OA\Property(property="album_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Song updated"),
     *     @OA\Response(response=404, description="Song not found")
     * )
     */
    public function update(Request $request, string $id)
    {
        try {
            $song = Song::findOrFail($id);
            $song->update($request->all());
            return response()->json($song, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update song'], 400);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/songs/{id}",
     *     tags={"Songs"},
     *     summary="Delete a song",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Song deleted"),
     *     @OA\Response(response=404, description="Song not found")
     * )
     */
    public function destroy(string $id)
    {
        try {
            $song = Song::findOrFail($id);
            $song->delete();
            return response()->json(['message' => 'Song deleted'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete song'], 400);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/songs/search",
     *     tags={"Songs"},
     *     summary="Search for songs",
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function search(Request $request)
    {
        $query = \App\Models\Song::query();

        if ($request->has('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->has('artist')) {
            $query->whereHas('album.artist', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->artist . '%');
            });
        }

        $songs = $query->get();
        return response()->json($songs, 200);
    }
}

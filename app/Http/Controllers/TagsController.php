<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TagsController extends Controller
{
    public function index(Request $request): View
    {
        $tags = Tag::query();

        if (!empty($request->get('search'))) {
            $tags->whereRaw("LOWER(`name`) LIKE ?", ["%" . strtolower($request->get('search')) . "%"]);
        }

        $tags = $tags->orderBy('id', 'desc')->paginate(15);

        return view('tags.list', compact('tags'));
    }

    public function deleteAction($id): JsonResponse
    {
        $tag = Tag::whereId( (int)$id )->first();

        if ($tag instanceof Tag) {

            $result = $tag->delete();

            return response()->json([
                'status' => (bool)$result,
            ]);
        }

        return response()->json([
            'status' => false,
        ]);
    }
}

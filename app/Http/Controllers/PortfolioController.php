<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Portfolio;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PortfolioController extends Controller
{
    
    public function feed()
    {
        $portfolios = Portfolio::with(['user:id,name,image,role', 'tags:id,name'])
            ->latest()
            ->paginate(12);

        return response()->json([
            'status' => 'success',
            'data' => $portfolios
        ], 200);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'media_url' => 'required|url',
            'media_type' => 'required|in:image,video',
            'tags' => 'required|array|min:1',
            'tags.*' => 'exists:tags,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized. Vous devez être connecté pour publier.'
            ], 401);
        }

        $portfolio = $user->portfolios()->create([
            'title' => $request->title,
            'description' => $request->description,
            'media_url' => $request->media_url,
            'media_type' => $request->media_type,
        ]);

        $portfolio->tags()->attach($request->tags);

        return response()->json([
            'status' => 'success',
            'message' => 'Votre réalisation a été publiée avec succès !',
            'data' => $portfolio->load('tags')
        ], 201);
    }
}

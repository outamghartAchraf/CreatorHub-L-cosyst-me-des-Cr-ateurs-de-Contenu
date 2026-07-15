<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Portfolio;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class PortfolioController extends Controller
{
    public function feed(){
        $portFolios = Portfolio::with(['user', 'tags'])
            ->latest()
            ->get();
        return view('feed', compact('portfolios'));
    }

    public function create(){
        $tags = Tag::all();
        return view('portfolios.create', compact('tags'));
    }
    public function store(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'media_url' => 'required|in:image,video',
            'media_type' => 'required|in:image,video',
            'tags' => 'required|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $portfolio = Auth::user()->portfolios()->create([
            'title' => $request->title,
            'description' => $request->description,
            'media_url' => $request->media_url,
            'media_type' => $request->media_type,
        ]);

        $portfolio->tags()->attach($request->tags);
        return redirect()->route('feed')->with('success', 'Votre realisation a ete publiee avec succes !');
    }
}

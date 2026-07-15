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
}

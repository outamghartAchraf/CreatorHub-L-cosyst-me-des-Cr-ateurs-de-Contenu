<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class JobController extends Controller
{
    /**
     * Afficher toutes les offres.
     */
    public function index()
    {
        $jobs = Job::with('user')->latest()->get();

        return response()->json($jobs);
    }

    /**
     * Créer une nouvelle offre.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'budget' => 'required|numeric',
            'deadline' => 'required|date',
        ]);

        $job = Job::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'budget' => $validated['budget'],
            'deadline' => $validated['deadline'],
            'status' => 'open',
        ]);

        return response()->json([
            'message' => 'Offre créée avec succès.',
            'job' => $job
        ], 201);
    }

    /**
     * Afficher une offre.
     */
    public function show(Job $job)
    {
        return response()->json($job->load('user'));
    }

    /**
     * Modifier une offre.
     */
    public function update(Request $request, Job $job)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'budget' => 'sometimes|numeric',
            'deadline' => 'sometimes|date',
            'status' => 'sometimes|in:open,closed',
        ]);

        $job->update($validated);

        return response()->json([
            'message' => 'Offre mise à jour.',
            'job' => $job
        ]);
    }

    /**
     * Supprimer une offre.
     */
    public function destroy(Job $job)
    {
        $job->delete();

        return response()->json([
            'message' => 'Offre supprimée.'
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function apply(Job $job)
    {
        $exists = Application::where('job_id', $job->id)
            ->where('user_id', Auth::id())
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Vous avez déjà postulé à cette offre.'
            ], 409);
        }

        $application = Application::create([
            'job_id' => $job->id,
            'user_id' => Auth::id(),
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Candidature envoyée avec succès.',
            'application' => $application
        ], 201);
    }


    public function index(Job $job)
{
    if ($job->user_id !== Auth::id()) {
        return response()->json([
            'message' => 'Accès interdit.'
        ], 403);
    }

    return response()->json(
        $job->applications()->with('user')->get()
    );
}

    /**
     * Accepter ou refuser une candidature.
     */
   public function update(Application $application)
{
    if ($application->job->user_id !== Auth::id()) {
        return response()->json([
            'message' => 'Accès interdit.'
        ], 403);
    }

    request()->validate([
        'status' => 'required|in:accepted,rejected',
    ]);

    $application->update([
        'status' => request('status'),
    ]);

    return response()->json([
        'message' => 'Statut mis à jour.',
        'application' => $application,
    ]);
}
}

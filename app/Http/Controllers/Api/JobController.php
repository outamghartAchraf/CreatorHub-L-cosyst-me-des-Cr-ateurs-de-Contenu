<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class JobController extends Controller
{

    public function index()
    {
        $jobs = Job::with('user')->latest()->get();

        return response()->json($jobs);
    }


    public function store(StoreJobRequest $request)
{
    $job = Job::create([
        'user_id' => Auth::id(),
        'title' => $request->title,
        'description' => $request->description,
        'budget' => $request->budget,
        'deadline' => $request->deadline,
        'status' => 'open',
    ]);

    return response()->json([
        'message' => 'Offre créée avec succès.',
        'job' => $job
    ], 201);
}

    public function show(Job $job)
    {
        return response()->json($job->load('user'));
    }


    public function update(UpdateJobRequest $request, Job $job)
{
    $job->update($request->validated());

    return response()->json([
        'message' => 'Offre mise à jour.',
        'job' => $job
    ]);
}

    public function destroy(Job $job)
    {
        $job->delete();

        return response()->json([
            'message' => 'Offre supprimée.'
        ]);
    }
}

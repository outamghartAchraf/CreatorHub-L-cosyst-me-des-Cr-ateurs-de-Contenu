<?php

namespace App\Http\Controllers;

use App\Models\Workspace;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\WorkspaceRequest;

class WorkspaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $workspaces = Workspace::with(['creator', 'members', 'tasks'])
            ->latest()
            ->get();

        return response()->json($workspaces);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(WorkspaceRequest $request)
{
    $workspace = Workspace::create([
        'creator_id' => $request->user()->id,
        'title' => $request->title,
        'description' => $request->description,
    ]);

    return response()->json([
        'message' => 'Workspace created successfully',
        'data' => $workspace
    ], 201);
}

    /**
     * Display the specified resource.
     */
    public function show(Workspace $workspace)
    {
        $workspace->load([
            'creator',
            'members',
            'tasks.assignedUser'
        ]);

        return response()->json($workspace);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Workspace $workspace)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        WorkspaceRequest $request,
        Workspace $workspace
    ) {
        if ($workspace->creator_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        $workspace->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return response()->json([
            'message' => 'Workspace updated successfully',
            'data' => $workspace
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Workspace $workspace
    ) {
        if ($workspace->creator_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        $workspace->delete();

        return response()->json([
            'message' => 'Workspace deleted successfully'
        ]);
    }

    public function addMember(Request $request, Workspace $workspace)
{
    $request->validate([
        'user_id' => 'required|exists:users,id'
    ]);

    if ($workspace->creator_id !== $request->user()->id) {

        return response()->json([
            'message' => 'Only creator can invite members'
        ], 403);
    }

    $workspace->members()->syncWithoutDetaching([
        $request->user_id
    ]);

    return response()->json([
        'message' => 'Member added successfully'
    ]);
}

public function removeMember(
    Request $request,
    Workspace $workspace,
    User $user
) {

    if ($workspace->creator_id !== $request->user()->id) {

        return response()->json([
            'message' => 'Only creator can remove members'
        ], 403);
    }

    $workspace->members()->detach(
        $user->id
    );

    return response()->json([
        'message' => 'Member removed successfully'
    ]);
}

}

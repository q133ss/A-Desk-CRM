<?php

namespace App\Http\Controllers;

use App\Http\Requests\CounterpartyGroupController\StoreRequest;
use App\Models\CounterpartyGroup;
use Illuminate\Http\Request;

class CounterpartyGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = CounterpartyGroup::where('user_id', Auth()->id())->get();
        return response()->json($groups);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        return CounterpartyGroup::create([
            'name' => $request->input('name'),
            'user_id' => Auth()->id()
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $group = CounterpartyGroup::where('user_id', Auth()->id())->findOrFail($id);
        return response()->json($group);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request, $id)
    {
        $group = CounterpartyGroup::where('user_id', Auth()->id())->findOrFail($id);
        $group->update($request->validated());

        return response()->json($group);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $group = CounterpartyGroup::where('user_id', Auth()->id())->findOrFail($id);
        $group->delete();

        return response()->json([
            'message' => 'true'
        ]);
    }
}

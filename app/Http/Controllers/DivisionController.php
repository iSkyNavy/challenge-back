<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Http\Requests\StoreDivisionRequest;
use App\Http\Requests\UpdateDivisionRequest;
use App\Http\Resources\DivisionResource;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $divisions = Division::with('divisionSuperior')->withCount(['collaborators', 'subDivisions'])->get();
        return DivisionResource::collection($divisions)->additional($this->defaultStructure());
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
    public function store(StoreDivisionRequest $request)
    {
        return Division::create([
            'name' => $request->name,
            'level' => $request->level,
            'ambassador_name' => $request->ambassador_name,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return Division::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Division $division)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDivisionRequest $request, int $id)
    {
        // $division = Division::where('id', $id)->first();
        $division = Division::findOrFail($id);
        $params = [];
        $request->name ? $params['name'] = $request->name : '';
        $request->level ? $params['level'] = $request->level : '';
        $request->ambassador_name ? $params['ambassador_name'] = $request->ambassador_name : '';
        $request->division_superior_id ? $params['division_superior_id'] = $request->division_superior_id : '';
        $division->update($params);
        return $division;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $division = Division::findOrFail($id);
        $division->delete();
        return $division;
    }
}

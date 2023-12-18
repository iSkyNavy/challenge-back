<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Http\Requests\StoreDivisionRequest;
use App\Http\Requests\UpdateDivisionRequest;
use App\Http\Resources\DivisionResource;
use App\Services\DivisionService;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct(private DivisionService $divisionService)
    {
    }
    public function index(Request $request)
    {
        $withPagination = $request->hasAny(['per_page', 'page']);
        $divisions = $this->divisionService->getDivisions($request->all(), $withPagination);
        return DivisionResource::collection($divisions)->additional($this->defaultStructure());
    }

    public function getNames()
    {
        $divisionsNames = Division::pluck('name')->toArray();
        return response()->json(["data" => $divisionsNames, ...$this->defaultStructure()]);
    }

    public function getDivisionSuperiorNames()
    {
        $divisionsSuperiorNames = Division::where("division_superior_id", "<>", null)->with("divisionSuperior")->get()->unique("division_superior_id")->pluck('divisionSuperior.name')->toArray();
        // return $divisionsSuperiorNames;
        return response()->json(["data" => $divisionsSuperiorNames, ...$this->defaultStructure()]);
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
        $division = $this->divisionService->createDivision($request->all());
        return DivisionResource::make($division)->additional($this->defaultStructure());
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $division = $this->divisionService->showDivision($id);
        $division->load('subDivisions');
        return DivisionResource::make($division)->additional($this->defaultStructure());
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
        $division = $this->divisionService->updateDivision($request, $id);
        return DivisionResource::make($division)->additional($this->defaultStructure());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $division = Division::findOrFail($id);
        $division->delete();
        return DivisionResource::make($division)->additional($this->defaultStructure());
    }
}

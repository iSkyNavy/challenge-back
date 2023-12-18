<?php

namespace App\Services;

use App\Http\Requests\UpdateDivisionRequest;
use App\Models\Division;
use Error;

class DivisionService
{
    public function __construct()
    {
        //
    }

    public function getDivisions(array $params, $withPagination = true)
    {
        try {
            $query = Division::with('divisionSuperior')->withCount(['collaborators', 'subDivisions']);
            if (isset($params['name'])) {
                $query->whereIn('name', $params['name']);
            };
            if (isset($params['divisionSuperiorName'])) {
                $query->whereHas('divisionSuperior', function ($query) use ($params) {
                    $query->whereIn('name', $params['divisionSuperiorName']);
                });
            };
            if (isset($params['sort'])) {
                $sortParams = explode(",", $params['sort']);
                $attr = $sortParams[0];
                if ($attr === "collaboratorsCount") {
                    $attr = "collaborators_count";
                } else if ($attr === "level") {
                    $attr = "level";
                } else if ($attr === "subDivisionsCount") {
                    $attr = "sub_divisions_count";
                }
                $direction = $sortParams[1];
                $query->orderBy($attr, $direction);
            };
            return $withPagination
                ? $query->paginate((int) ($params['per_page'] ?? 10))
                : $query->get();
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    public function createDivision(array $params)
    {
        $values = [];
        if (isset($params['name'])) {
            $values['name'] = $params["name"];
        };
        if (isset($params['level'])) {
            $values['level'] = $params["level"];
        };
        if (isset($params['ambassador_name'])) {
            $values['ambassador_name'] = $params["ambassador_name"];
        };
        if (isset($params['division_superior_id'])) {
            $values['division_superior_id'] = $params["division_superior_id"];
        };
        return Division::create($values);
    }

    public function showDivision(int $id)
    {
        return Division::with('subDivisions')->findOrFail($id);
    }

    public function updateDivision(UpdateDivisionRequest $request, int $id)
    {
        $division = Division::findOrFail($id);
        $params = [];
        $request->name ? $params['name'] = $request->name : '';
        $request->level ? $params['level'] = $request->level : '';
        $request->ambassador_name ? $params['ambassador_name'] = $request->ambassador_name : $params['ambassador_name'] = null;
        $request->division_superior_id ? $params['division_superior_id'] = $request->division_superior_id : $params['division_superior_id'] = null;
        $division->update($params);
        return $division;
    }
}

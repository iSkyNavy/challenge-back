<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DivisionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $division_superior = $this->relationLoaded('divisionSuperior') ? $this->whenLoaded('divisionSuperior') : null;
        $subDivisions = $this->relationLoaded('subDivisions') ? $this->whenLoaded('subDivisions') : null;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'level' => $this->level,
            'ambassadorName' => $this->ambassador_name,
            'divisionSuperiorId' => $this->division_superior_id,
            $this->mergeWhen($this->collaborators_count, fn () => [
                'collaboratorsCount' => $this->collaborators_count,
            ]),
            $this->mergeWhen($this->sub_divisions_count, fn () => [
                'subDivisionsCount' => $this->sub_divisions_count,
            ]),
            $this->mergeWhen($division_superior, fn () => [
                'divisionSuperior' => $this->make($division_superior),
            ]),
            $this->mergeWhen($subDivisions, fn () => [
                'subDivisions' => $this->collection($subDivisions),
            ]),
        ];
    }
}

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
        return [
            'id' => $this->id,
            'name' => $this->name,
            'level' => $this->level,
            'ambassador_name' => $this->ambassador_name,
            'division_superior_id' => $this->division_superior_id,
            $this->mergeWhen($this->collaborators_count, fn () => [
                'collaborators_count' => $this->collaborators_count,
            ]),
            $this->mergeWhen($this->sub_divisions_count, fn () => [
                'sub_divisions_count' => $this->sub_divisions_count,
            ]),
            $this->mergeWhen($division_superior, fn () => [
                'division_superior' => $this->make($division_superior),
            ]),
        ];
    }
}

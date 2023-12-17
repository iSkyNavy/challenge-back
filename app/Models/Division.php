<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Division extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'division_superior_id',
        'level',
        'ambassador_name',
    ];

    public function collaborators(): HasMany
    {
        return $this->hasMany(Collaborator::class);
    }

    public function divisionSuperior(): BelongsTo
    {
        return $this->belongsTo(Division::class, 'division_superior_id', 'id');
    }

    public function subDivisions(): HasMany
    {
        return $this->hasMany(DivisionHasSubDivision::class, 'division_id', 'id');
    }
}

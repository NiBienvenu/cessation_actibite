<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employe extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'matricule',
        'nom',
        'prenom',
        'genre',
        'adresse',
        'email',
        'profil',
        'phone',
        'is_active',
        'location_id',
        'fonction_id',
        'direction_id',
        'commissariat_id',
        'application_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'is_active' => 'boolean',
        'fonction_id' => 'integer',
        'direction_id' => 'integer',
        'commissariat_id' => 'integer',
        'application_id' => 'integer',
    ];

    public function fonction(): BelongsTo
    {
        return $this->belongsTo(Fonction::class);
    }

    public function direction(): BelongsTo
    {
        return $this->belongsTo(Direction::class);
    }

    public function commissariat(): BelongsTo
    {
        return $this->belongsTo(Commissariat::class);
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function cessationActivites(): HasMany
    {
        return $this->hasMany(CessationActivite::class);
    }
}

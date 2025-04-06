<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CessationActivite extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employe_id',
        'date_entree',
        'date_sortie',
        'motif_id',
        'description',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'employe_id' => 'integer',
        'date_entree' => 'date',
        'date_sortie' => 'date',
        'motif_id' => 'integer',
        'user_id' => 'integer',
    ];

    public function employe(): BelongsTo
    {
        return $this->belongsTo(Employe::class);
    }

    public function motif(): BelongsTo
    {
        return $this->belongsTo(Motif::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

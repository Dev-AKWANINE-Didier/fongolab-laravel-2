<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    // le nom de la table de ce model doit utiliser
    protected $table = "categories";

    // il stocke les colonne de la table categories 
    protected $fillable = [
        "id",
        'user_id',
        "name",
        "created_at",
        "updated_at",
    ];

    // la relation N à 1  avac la table users(Model User)
    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }
}
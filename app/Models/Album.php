<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Song;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Album extends Model
{
    use HasFactory;
    protected $fillable = [
        'title','artist_id', 'artwork','genre'
    ];
    public function songs()
    {
        return $this->hasMany(Song::class);
    }

    public function artist()
    {
        return $this->belongsTo(Artist::class, 'artist_id');
    }

}

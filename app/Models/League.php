<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * @method static create(mixed $validated)
 * @property mixed $id
 * @property string $status
 */
class League extends Model
{
    use HasFactory, softDeletes;

    public const TEAMS_MAX = 8;

    public $timestamps = true;

    protected $fillable = [
        'name',
        'slug',
        'status'
    ];

    public function teams(): HasMany
    {
        return $this->hasMany(LeagueTeam::class, 'league_id');
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function finish()
    {
        $this->status = 'finished';
        $this->save();
    }
}

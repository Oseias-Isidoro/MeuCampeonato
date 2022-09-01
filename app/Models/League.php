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

    public function getChampionshipTeam(): Model|HasMany|null
    {
        return $this->teams()->where('status', 'champion')->first();
    }

    public function getSecondPlaceTeam(): Model|HasMany|null
    {
        return $this->teams()->where('status', 'second')->first();
    }

    public function getThirdPlaceTeam(): Model|HasMany|null
    {
        return $this->teams()->where('status', 'third')->first();
    }

    public function matches(): HasMany
    {
        return $this->hasMany(LeagueMatch::class, 'league_id');
    }

    public function finalMatch(): Model|HasMany
    {
        return $this->matches()->where('phase', 'final')->first();
    }

    public function thirdPlaceMatch(): Model|HasMany
    {
        return $this->matches()->where('phase', 'third_place')->first();
    }

    public function semifinalMatch(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->matches()->where('phase', 'semifinals')->get();
    }

    public function quarterfinalsMatches(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->matches()->where('phase', 'quarterfinals')->get();
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function isFinished()
    {
        return $this->status === 'finished';
    }

    public function finish()
    {
        $this->status = 'finished';
        $this->save();
    }
}

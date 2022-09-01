<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * @property mixed $id
 * @method static create(mixed $validated)
 */
class LeagueTeam extends Model
{
    use HasFactory, softDeletes;

    public $timestamps = true;

    protected $fillable = [
        'name',
        'slug',
        'status',
        'phase',
        'goals',
        'goals_taken',
    ];

    public function league(): BelongsTo
    {
        return $this->belongsTo(League::class, 'league_id');
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function markAsEliminated()
    {
        $this->status = 'eliminated';
        $this->save();
    }

    public function markAsThird()
    {
        $this->status = 'third';
        $this->save();
    }

    public function markAsChampion()
    {
        $this->status = 'champion';
        $this->save();
    }

    public function markAsSecond()
    {
        $this->status = 'second';
        $this->save();
    }
}

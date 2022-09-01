<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeagueMatch extends Model
{
    use HasFactory, softDeletes;

    public $timestamps = true;

    protected $fillable = [
        'team_home_id',
        'team_outside_id',
        'winning_team_id',
        'phase',
    ];

    public function getTeamHome(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(LeagueTeam::class, 'team_home_id');
    }

    public function getTeamOutside(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(LeagueTeam::class, 'team_outside_id');
    }
}

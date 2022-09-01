<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLeagueTeamRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['string'],
            'goals' => ['integer'],
            'goals_taken' => ['integer'],
            'phase' => ['in:quarterfinals,semifinals,final,third_place'],
            'status' => ['in:eliminated,active,champion,second,third']
        ];
    }
}

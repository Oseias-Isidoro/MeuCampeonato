@extends('layout.layout')

@section('content')
    <div class="container py-3">
        <h1>campeonato: {{$league->name}}</h1>

        <div class="row">
            <div class="col-7">
                <h3 class="text-center mb-3 mt-5">jogo final</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Em casa</th>
                        <th>placar</th>
                        <th>Fora de casa</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="table-primary">{{$league->finalMatch()->getTeamHome->name}}</td>
                        <td class="table-secondary">{{$league->finalMatch()->team_home_goals .' x '. $league->finalMatch()->team_outside_goals}}</td>
                        <td class="table-success">{{$league->finalMatch()->getTeamOutside->name}}</td>
                    </tr>
                    </tbody>
                </table>

                <h3 class="text-center mb-3 mt-5">jogo pelo 3º lugar</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Em casa</th>
                        <th>placar</th>
                        <th>Fora de casa</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="table-primary">{{$league->thirdPlaceMatch()->getTeamHome->name}}</td>
                        <td class="table-secondary">{{$league->thirdPlaceMatch()->team_home_goals .' x '. $league->finalMatch()->team_outside_goals}}</td>
                        <td class="table-success">{{$league->thirdPlaceMatch()->getTeamOutside->name}}</td>
                    </tr>
                    </tbody>
                </table>

                <h3 class="text-center mb-3 mt-5">jogos das semifinais</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Em casa</th>
                        <th>placar</th>
                        <th>Fora de casa</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($league->semifinalMatch() as $match)
                        <tr>
                            <td class="table-primary">{{$match->getTeamHome->name}}</td>
                            <td class="table-secondary">{{$match->team_home_goals .' x '. $match->team_outside_goals}}</td>
                            <td class="table-success">{{$match->getTeamOutside->name}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <h3 class="text-center mb-3 mt-5">jogos das quartas de final</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Em casa</th>
                        <th>placar</th>
                        <th>Fora de casa</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($league->quarterfinalsMatches() as $match)
                        <tr>
                            <td class="table-primary">{{$match->getTeamHome->name}}</td>
                            <td class="table-secondary">{{$match->team_home_goals .' x '. $match->team_outside_goals}}</td>
                            <td class="table-success">{{$match->getTeamOutside->name}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col">
                <h3 class="text-center mb-3 mt-5">Classificação por pontos</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Time</th>
                        <th>Pontos</th>
                        <th>Gols Feitos</th>
                        <th>Gols Tomados</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($league->teams()->get()->sortByDesc('score') as $team)
                        <tr>
                            <td class="table-primary">{{$team->name}}</td>
                            <td class="table-primary">{{$team->score}}</td>
                            <td class="table-primary">{{$team->goals}}</td>
                            <td class="table-primary">{{$team->goals_taken}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

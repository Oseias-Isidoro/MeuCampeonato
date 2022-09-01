@extends('layout.layout')

@section('content')
    <div class="container py-3">
        @foreach($leagues as $league)
            <a href="{{route('leagues.show', ['league' => $league->id])}}" class="text-decoration-none {{$league->isFinished() ? '' : 'pe-none'}}">
                <div class="alert alert-primary d-flex sm:justify-between" role="alert">
                    <div class="">
                        #{{$league->id}}-{{$league->name}}
                    </div>
                    <div class="">
                        <span class="badge {{ $league->isFinished() ? 'bg-success' : 'bg-secondary' }}">{{$league->status}}</span>
                    </div>
                </div>
            </a>
        @endforeach
        {{ $leagues->links() }}
    </div>
@endsection


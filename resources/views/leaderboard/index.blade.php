@extends('layouts.master')

{{-- Web site Title --}}
@section('title', __('site.leaderboard'))

{{-- Content Header --}}
@section('header', __('site.leaderboard'))

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    @auth()
        <li class="breadcrumb-item">
            <a href="{{ route('home') }}">{{ __('site.home') }}</a>
        </li>
    @endauth
    <li class="breadcrumb-item active">
         {{ __('site.leaderboard') }}
    </li>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <table id="ranking" class="table table-hover">
                <thead>
                <tr>
                    <th class="col-md-1">#</th>
                    <th class="col-md-6">Player</th>
                    <th class="col-md-3">Level</th>
                    <th class="col-md-2">Points</th>
                </tr>
                </thead>

                @foreach($usersInRanking as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><a href="{{ route('profiles.show', $user['username']) }}">{{ $user['name'] }}</a></td>
                        <td>{{ $user['level'] }}</td>
                        <td>{{ $user['experience'] }}</td>
                    </tr>
                @endforeach

                <tfoot>
                <tr>
                    <th class="col-md-1">#</th>
                    <th class="col-md-6">Player</th>
                    <th class="col-md-3">Level</th>
                    <th class="col-md-2">Points</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>

@endsection

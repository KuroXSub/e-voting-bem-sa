@extends('layouts.app')

@section('title', 'Sistem E-Voting')

@section('content')
    <div class="welcome-container">
        @include('welcome.partials.hero')
        @include('welcome.partials.features')
        @include('welcome.partials.election')
    </div>
@endsection
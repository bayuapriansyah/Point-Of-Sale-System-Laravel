@extends('layouts.app')
@section('content_title', 'Dashboard')

@section('content')
    <div class="card">
        <div class="card-body">
            Selamat datang di halaman dashboard, <strong>{{ Auth()->user()->name }}</strong> !
        </div>
    </div>
@endsection
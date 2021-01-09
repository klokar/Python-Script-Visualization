@extends('layouts.app')

@section('title', 'Nalaganje programa')

@section('breadcrumbs')
    <ul>
        <li><a href="/processor">Programi</a></li>
        <li><a class="active" href="/">Nalaganje</a></li>
    </ul>
@endsection

@section('content')
    <div class="box">
        <div class="box-header">Nalaganje programa</div>
        <div class="box-body">
            <program-upload></program-upload>
        </div>
    </div>
@endsection

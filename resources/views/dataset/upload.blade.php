@extends('layouts.app')

@section('title', 'Nalaganje podatkov')

@section('breadcrumbs')
    <ul>
        <li><a href="/dataset">Seznam podatkov</a></li>
        <li><a class="active" href="/">Nalaganje</a></li>
    </ul>
@endsection

@section('content')
    <div class="box">
        <div class="box-header">Nalaganje podatkov</div>
        <div class="box-body">
            <dataset-upload></dataset-upload>
        </div>
    </div>
@endsection

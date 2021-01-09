@extends('layouts.app')

@section('title', 'Kreiranje izvajanja')

@section('breadcrumbs')
    <ul>
        <li><a href="/execution">Seznam izvajanj</a></li>
        <li><a class="active" href="/">Kreiranje</a></li>
    </ul>
@endsection

@section('content')
    <div class="box">
        <div class="box-header">Kreiranje izvajanja</div>
        <div class="box-body">
            <form action="/execution" method="post">
                @csrf
                <select name="data_processor_id" class="form-control">
                    @foreach ($processors as $processor)
                        <option value="{{ $processor->id }}">{{ $processor->name }}</option>
                    @endforeach
                </select>
                <select name="dataset_id" class="form-control">
                    @foreach ($datasets as $dataset)
                        <option value="{{ $dataset->id }}">{{ $dataset->name }}</option>
                    @endforeach
                </select>
                <input type="text" name="comment" id="execution-comment" placeholder="Komentar" class="form-control">
                <input type="text" name="parameters" id="execution-parameters" placeholder="Parametri" class="form-control">
                <button class="btn btn-success" type="submit" id="create-execution">Kreiraj</button>
            </form>
        </div>
    </div>
@endsection

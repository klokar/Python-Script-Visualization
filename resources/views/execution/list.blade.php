@extends('layouts.app')

@section('title', 'Seznam izvajanj')

@section('breadcrumbs')
    <ul>
        <li><a class="active" href="/execution">Seznam izvajanj</a></li>
    </ul>
@endsection

@section('breadcrumbs-button')
    <a href="/execution/create" class="btn btn-primary"><i class="fa fa-plus"></i>Novo izvajanje</a>
@endsection

@section('content')
    <div class="box">
        <div class="box-header">Izvajanja</div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <th>Ime programa</th>
                        <th>Naslov podatkov</th>
                        <th>Komentar</th>
                        <th>Datum</th>
                        <th>Akcije</th>
                    </thead>
                    <tbody>
                        @foreach ($executions as $execution)
                            <tr>
                                <td>{{ $execution->dataProcessor->name }}</td>
                                <td>{{ $execution->dataset->name }}</td>
                                <td>{{ $execution->comment }}</td>
                                <td>{{ $execution->created_at->format('d.m.Y H:i') }}</td>
                                <td><extension-actions execution-id={{$execution->id}}></extension-actions></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Seznam podatkov')

@section('breadcrumbs')
    <ul>
        <li><a class="active" href="/dataset">Seznam podatkov</a></li>
    </ul>
@endsection

@section('breadcrumbs-button')
    <a href="/dataset/create" class="btn btn-primary"><i class="fa fa-plus"></i>Naloži</a>
@endsection

@section('content')
    <div class="box">
        <div class="box-header">Seznam naloženih podatkov</div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <th>Ime</th>
                        <th>Ime datoteke</th>
                        <th>Velikost</th>
                        <th>Naloženo</th>
                        <th>Akcije</th>
                    </thead>
                    <tbody>
                        @foreach ($datasets as $dataset)
                            <tr>
                                <td>{{ $dataset->name }}</td>
                                <td>{{ $dataset->original_name }}</td>
                                <td>{{ $dataset->formatted_size }}</td>
                                <td>{{ $dataset->created_at->format('d.m.Y H:i') }}</td>
                                <td><dataset-actions dataset-id={{$dataset->id}}></dataset-actions></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

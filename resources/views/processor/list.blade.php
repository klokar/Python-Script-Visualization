@extends('layouts.app')

@section('title', 'Nalaganje programa')

@section('breadcrumbs')
    <ul>
        <li><a class="active" href="/processor">Programi</a></li>
    </ul>
@endsection

@section('breadcrumbs-button')
    <a href="/processor/create" class="btn btn-primary"><i class="fa fa-plus"></i>Naloži</a>
@endsection

@section('content')
    <div class="box">
        <div class="box-header">Seznam naloženih programov</div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <th>Ime</th>
                        <th>Algoritem</th>
                        <th>Pot programa</th>
                        <th>Pot podatkov</th>
                        <th>Pot rezultatov</th>
                        <th>Naloženo</th>
                        <th>Akcije</th>
                    </thead>
                    <tbody>
                        @foreach ($processors as $processor)
                            <tr>
                                <td>{{ $processor->name }}</td>
                                <td>{{ $processor->algorithm }}</td>
                                <td>{{ $processor->processor_path }}</td>
                                <td>{{ $processor->dataset_path }}</td>
                                <td>{{ $processor->results_path }}</td>
                                <td>{{ $processor->created_at->format('d.m.Y') }}</td>
                                <td><data-processor-actions processor-id={{$processor->id}}></data-processor-actions></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="box">
        <div class="box-header">Seznam dependencijev</div>
        <div class="box-body">
            @if(empty($dependencies))
                <div>Dependenciji niso naloženi ali pa je napaka v datoteki!</div>
            @else
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <th>Ime</th>
                        <th>Verzija</th>
                        </thead>
                        <tbody>
                        @foreach ($dependencies as $name => $version)
                            <tr>
                                <td>{{ $name }}</td>
                                <td>{{ $version }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection

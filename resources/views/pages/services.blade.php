
@extends('layouts.app')

@section('content')
    <h2>  Welcome Services</h2>

    <hr>
    @if(count($services) > 0)
        <ul class="list-group">
            @foreach($services as $service)
                <li class="list-group-item">{{$service}}</li>
            @endforeach
        </ul>
    <hr>





    @endif
@endsection

@extends('webed-theme::front._master')

@section('content')
    <h1>500</h1>
    <h3>{{ $exception->getMessage() }}</h3>
@endsection
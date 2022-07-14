@extends('layouts.experiment')
@section('content')
    <div>{{ $experiment->title }}</div>
    <div>{{ $experiment->description }}</div>
@endsection

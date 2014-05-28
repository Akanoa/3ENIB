@extends('layouts.main')

@section('content')

@if ($company)

	<h2><a href="{{URL::to('company').'/'.$company->id}}">{{$company->name}}</a></h2>

	<br/>

	<p>{{$company->description}}</p>

	<img src="{{$company->photo_filepath}}">


@endif

@endsection
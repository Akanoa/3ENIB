@extends('layouts.main')

@section('content')

<h1>Liste des Entreprises</h1>

@if ($companies)

	@foreach ($companies as $c)

		<h2><a href="{{URL::to('company').'/'.$c->id}}">{{$c->name}}</a></h2>

		<br/>

		<p>{{Str::limit($c->description, 200)}}</p>

		<img src="{{$c->photo_filepath}}">


	@endforeach

@endif

@endsection
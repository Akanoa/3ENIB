@extends('layouts.main')

@section('content')

<h1>Liste des projets</h1>

@foreach ($projects as $p)

	<h2>{{$p->name}}</h2><br/>
	<p>{{Str::limit($p->description, 200)}}</p>
	<img src="{{$p->photo_filepath}}">


@endforeach

@endsection
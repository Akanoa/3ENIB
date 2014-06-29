@extends('layouts.main')

@section('content')

<h1>Liste des Entreprises</h1>

@if ($companies)
	

	<div class="row">
		<div class="col-md-12"><hr></div>

		@foreach ($companies as $c)

			<div class="col-md-6 text-center">
				<img class="logo-company" src="{{$_ENV['root_site']}}/document/logo/{{$c->user->id}}/{{$c->photo_filepath}}">
			</div>
			<div class="col-md-6">
				<h2>
					<a href="{{URL::to('company').'/'.$c->id}}">{{$c->name}}</a>
				</h2>
				<p>{{App::make("3enib_text")->filterText(Str::limit($c->description, 500))}}</p>
			</div>

			<div class="col-md-12"><hr></div>

		@endforeach
	</div>
@else 
	<div class="row">
		<div class="col-md-12">
			<p>Il n'y a pas encore d'entreprise référencées sur le site</p>
		</div>
	</div>
@endif

@endsection
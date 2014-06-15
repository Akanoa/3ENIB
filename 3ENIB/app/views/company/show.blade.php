@extends('layouts.main')

@section('content')

@if ($company)

	<div class="text-center">
		<h1>{{$company->name}}</h1>
	</div>

	<br/>

	<div class="row">
		<div class="col-md-12"><hr></div>

		<div class="row">
			<div class="col-md-6 text-center">
				<img class="logo-company" src="{{$_ENV['root_site']}}/document/logo/{{$company->user->id}}/{{$company->photo_filepath}}">
			</div>

			<div class="col-md-6 whoiam-company">
				<h3>Qui sommes-nous?</h3>
				<div class="row">
					<div class="col-md-1">
						<span class="glyphicon glyphicon-home"></span>
					</div>
					<div class="col-md-11">
						<!-- <p>{{str_replace("‧", "<br/>", $company->contact)}}</p> -->
						<p>{{nl2br($company->contact)}}</p>
					</div>

					<div class="col-md-1">
						<span class="glyphicon glyphicon-phone-alt"></span>
					</div>
					<div class="col-md-11">
							<p>{{$company->phone_number}}</p>
					</div>

					<div class="col-md-1">
						<span class="glyphicon glyphicon-lock"></span>
					</div>
					<div class="col-md-11">
							<p><b>N°SIRET</b>: {{$company->SIRET}}</p>
					</div>

				</div>
			</div>
		</div>

		<div class="col-md-12"><hr></div>

		<div class="col-md-12 well">
			<h3>Que faisons-nous?</h3>
			<p>{{$company->description}}</p>
		</div>

		<div class="col-md-12"><hr></div>

		<div class="col-md-12">
			<h3>Nos domaine de compétence</h3>
			<p>{{$company->expertise}}</p>
		</div>

		<div class="col-md-12"><hr></div>

		<div class="col-md-12">
			<div class="row">
				<div class="col-md-2">
					<h3 class="our-projects-title">Nos projets</h3>
				</div>
				<div class="col-md-2">
					@if($authorized)
						<a href="{{URL::to('project/create')}}/{{$company->id}}"><button class="btn btn-success">Créer un nouveau projet</button></a>
					@endif
				</div>
			</div>
			@if($projects)
				@foreach($projects as $p)
					<div class="row">
					<div class="col-md-2">
						<p><a href="{{URL::to('project/show')}}/{{$p->id}}"><b>{{$p->name}}</b></a></p>
					</div>
					<div class="col-md-6">
						<p>{{Str::limit($p->description, 100)}}</p>
					</div>
					@if($authorized)
						<div class="col-md-1">
							<a href="{{URL::to('project/edit')}}/{{$p->id}}"><button class="btn btn-info">Modifier</button></a>
						</div>
						<div class="col-md-1">
							<a href="#"><button class="btn btn-danger">Supprimer le projet</button></a>
						</div>
					@endif
				</div>
				@endforeach
			@endif
		</div>

		<div class="col-md-12"><hr></div>
	</div>


@endif

@endsection
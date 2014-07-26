@extends("layouts.main")

@section("content")

@if($student)

<div class="row">
	<div class="col-md-12 text-center">
		<h1>{{{$student->firstname}}} {{{$student->lastname}}}</h1>
	</div>
	<div class="col-md-6 text-center">
		<img src="{{$_ENV['root_site']}}/document/avatar/{{$student->user_id}}/{{$student->avatar_filepath}}" alt="">
	</div>
	<div class="col-md-6 whoiam-company">
		<h3>Informations:</h3>
		<div class="row">
			<div class="col-md-1">
				<span class="glyphicon glyphicon-envelope"></span>
			</div>
			<div class="col-md-11">
				<p>{{$student->user->email}}</p>
			</div>

			<div class="col-md-1">
				<span class="glyphicon glyphicon-phone-alt"></span>
			</div>
			<div class="col-md-11">
					<p>{{{$student->phone_number}}}</p>
			</div>

			<div class="col-md-1">
				<span class="glyphicon glyphicon-lock"></span>
			</div>
			<div class="col-md-11">
				<p><b>N° de sécurité sociale</b>: {{{$student->secu}}}</p>
			</div>

			<div class="col-md-1">
				<span class="glyphicon glyphicon-user"></span>
			</div>
			<div class="col-md-11">
				<a href="{{URL::to('document/pdf')}}/{{$student->id}}/cv/{{$student->cv_filepath}}">CV</a>
			</div>
		</div>
	</div>

	<div class="col-md-12">
		<h2>Ses spécialités</h2>
		@if($student->speciality!="")
			{{{$student->speciality}}}
		@else
			pas de spécialités
		@endif
	</div>
		<div class="col-md-12">
		<h2>Ses projets</h2>
		@if(count($projects)==0)
			pas de projets
		@else
			<ul>
				@foreach($projects as $project)
					<li>
						<a href="{{URL::to('project/show')}}/{{$project->id}}">{{$project->name}}</a>
					</li>
				@endforeach
			</ul>
		@endif
	</div>
</div>



@endif


@endsection
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
				<p><b>IBAN</b>: {{{$student->RIB}}}</p>
			</div>
		</div>
	</div>
	<div class="col-md-12">
		<h2>Son CV</h2>
		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
		consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
		proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	</div>
	<div class="col-md-12">
		<h2>Ses spécialités</h2>
		{{{$student->speciality}}}
	</div>
		<div class="col-md-12">
		<h2>Ses projets</h2>
		
	</div>
</div>



@endif


@endsection
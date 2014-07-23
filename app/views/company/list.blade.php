@extends('layouts.main')

@section('content')

<h1>Liste des Entreprises</h1>

@if ($companies)
	

	<div class="row">
		<div class="col-md-12"><hr></div>

		@foreach ($companies as $company)

			<div class="col-md-6 text-center">
				<img class="logo-company" src="{{$_ENV['root_site']}}/document/logo/{{$company->user->id}}/{{$company->photo_filepath}}">
			</div>
			<div class="col-md-6">
				<h2>
					<a href="{{URL::to('company').'/'.$company->id}}">{{$company->name}}</a>
				</h2>
				<p>{{App::make("3enib_text")->filterText(Str::limit($company->description, 500))}}</p>
			</div>
			
			@if(App::make("3enib_authz")->isAdmin())
				<div class="row">
					@if(!App::make("3enib_user")->userIsActive($company))
						<div class="col-md-4">
							{{Form::open(["method"=>"POST", "url"=>"user/unban"])}}
								{{Form::hidden("user_id", $company->user->id)}}
								{{ Form::submit('Débannir l\'entreprise', array('class' => 'btn btn-warning')) }}
							{{Form::close()}}
						</div>	
					@else
						<div class="col-md-4">
							{{Form::open(["method"=>"POST", "url"=>"user/ban"])}}
								{{Form::hidden("user_id", $company->user->id)}}
								{{ Form::submit('Bannir l\'entreprise', array('class' => 'btn btn-danger')) }}
							{{Form::close()}}
						</div>			
					@endif
				</div>
			@endif

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
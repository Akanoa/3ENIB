@extends("layouts.main")

@section("content")

<h2 class="text-center">Liste des projets</h2>

@if ($projects)
	<table class="table table-striped">
		<th>Nom du projet</th>
		<th>Entreprise</th>
		<th>Etat du projet</th>
		@if (App::make("3enib_authz")->isAdmin())
			<th>Modération</th>
		@elseif (App::make("3enib_authz")->isStudent()) 
			<th>Gérer</th>
		@endif
		@foreach ($projects as $project)
			@if (App::make("3enib_project")->isVisible($project))
				<tr>
					<td><a href='{{URL::to("project/show")}}/{{$project->id}}'>{{{$project->name}}}</a></td>
					<td><a href='{{URL::to("company")}}/{{$project->company->id}}'>{{{$project->company->name}}}</a></td>
					<td>{{App::make("3enib_project")->convertStringProjectState($project->state)}}</td>
					<td class="row">
					@if (App::make("3enib_authz")->isAdmin())
						@if ($project->state == 0)
							<div class="col-md-3">
								{{Form::open(["method"=>"POST", "url"=>"project/validate"])}}
									{{Form::hidden("project_id", $project->id)}}
									{{ Form::submit('Valider le projet', array('class' => 'btn btn-success')) }}
								{{Form::close()}}
							</div>
						@elseif ($project->state == 1)
							<div class="col-md-3">
								{{Form::open(["method"=>"POST", "url"=>"project/activate"])}}
									{{Form::hidden("project_id", $project->id)}}
									{{ Form::submit('Lancer le projet', array('class' => 'btn btn-success')) }}
								{{Form::close()}}
							</div>
						@elseif ($project->state == 2)
							<div class="col-md-3">
								{{Form::open(["method"=>"POST", "url"=>"project/archive"])}}
									{{Form::hidden("project_id", $project->id)}}
									{{ Form::submit('Archiver le projet', array('class' => 'btn btn-warning')) }}
								{{Form::close()}}
							</div>
						@elseif ($project->state == 3)
							<div class="col-md-3">
								{{Form::open(["method"=>"POST", "url"=>"project/activate"])}}
									{{Form::hidden("project_id", $project->id)}}
									{{ Form::submit('Relancer le projet', array('class' => 'btn btn-success')) }}
								{{Form::close()}}
							</div>
						@elseif ($project->state == 4)
							<div class="col-md-3">
								{{Form::open(["method"=>"POST", "url"=>"project/validate"])}}
									{{Form::hidden("project_id", $project->id)}}
									{{ Form::submit('Restaurer le projet', array('class' => 'btn btn-success')) }}
								{{Form::close()}}
							</div>
						@endif
						@if ($project->state == 0 or $project->state == 1 or $project->state == 2)
							<div class="col-md-3">
								{{Form::open(["method"=>"POST", "url"=>"project/close"])}}
									{{Form::hidden("project_id", $project->id)}}
									{{ Form::submit('Clore le projet', array('class' => 'btn btn-danger')) }}
								{{Form::close()}}
							</div>
						@endif
						<div class="col-md-3">
							<a href="{{URL::to('project/delete')}}/{{$project->id}}/list" onclick="return confirm('Êtes vous sûr de vouloir supprimer ce projet?');"><button class="btn btn-danger">Supprimer le projet</button></a>
						</div>
					@endif
					@if (App::make("3enib_authz")->studentAllowedToSubscribeToProject($project)) 
						<div class="col-md-3">
							{{Form::open(["url"=>"/project/signup/","method"=>"post"])}}
								{{Form::hidden("project_id", $project->id)}}
								{{Form::hidden("student_id", Auth::user()->own->id)}}
								{{ Form::submit('Postuler', array('class' => 'btn btn-info')) }}
							{{Form::close()}}
						</div>
					@endif
					</td>
				</tr>
			@endif
		@endforeach
	</table>
@endif


@endsection
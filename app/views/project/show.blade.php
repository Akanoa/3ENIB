@extends("layouts.main")

@section("content")

@if($project)

<div class="row">
	
	<div class="col-md-12 text-center">
		<h1>{{{$project->name}}}</h1>
	</div>

	<div class="col-md-12">
		<h3>Que voulons nous faire?</h2>
		<p>{{{$project->description}}}</p>
	</div>

	<div class="col-md-12">
		<h3>De quels compétences avons nous besoin?</h3>
		<p><span class="glyphicon glyphicon-eye-open">&nbsp;</span>{{{$project->required_skills}}}</p>
	</div>

	<div class="col-md-12">
		<h3>Durée du projet?</h2>
		<p><span class="glyphicon glyphicon-time">&nbsp;</span>{{{$project->estimated_time}}}</p>
	</div>

	<div class="col-md-12">
		<h3>Rémunération?</h2>
		<p><span class="glyphicon glyphicon-usd">&nbsp;</span>{{{$project->remuneration}}}€</p>
	</div>

	<div class="col-md-12">
		<h3>Différents documents pouvant vous servir</h2>
		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
		consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
		proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
		@if ($files)
			@foreach ($files as $file)
				{{$file->name}}
			@endforeach
		@endif
	</div>
	
	@if($project->state == 1)
		<div class="col-md-12">
			<h3>Se proposer sur le projet</h2>
			@if (App::make("3enib_authz")->studentAllowedToSubscribeToProject($project))
				{{Form::open(["url"=>"/project/signup/","method"=>"post"])}}
					{{Form::hidden("project_id", $project->id)}}
					{{Form::hidden("student_id", Auth::user()->own->id)}}
					{{ Form::submit('Postuler', array('class' => 'btn btn-info')) }}
				{{Form::close()}}
			@elseif(App::make("3enib_project")->studentHasBeenAcceptedOnProject($project))
				<p>Vous êtes déjà intégré sur ce projet</p>
				{{Form::open(["url"=>"/project/signout/","method"=>"post"])}}
					{{Form::hidden("project_id", $project->id)}}
					{{Form::hidden("student_id", Auth::user()->own->id)}}
					{{ Form::submit('Quitter le projet', array('class' => 'btn btn-warning')) }}
				{{Form::close()}}
			@elseif(App::make("3enib_project")->studentHadSubscribedToProject($project))
				<p>Vous avez déjà postulé sur ce projet</p>
				{{Form::open(["url"=>"/project/signout/","method"=>"post"])}}
					{{Form::hidden("project_id", $project->id)}}
					{{Form::hidden("student_id", Auth::user()->own->id)}}
					{{ Form::submit('Quitter le projet', array('class' => 'btn btn-warning')) }}
				{{Form::close()}}
			@elseif(App::make("3enib_project")->studentHasBeenExcludeFromProject($project))
				<p>Vous avez été refusé sur ce projet</p>
			@else
				<p>Vous n'êtes pas autorisé à postuler sur ce projet</p>
			@endif
		</div>
	@endif

	@if (App::make("3enib_authz")->isAdmin())
		<div class="col-md-12">
			<h3>Liste des étudiants rattaché au projet</h3>
			<table class="table table-striped">
				<th>Etudiant</th>
				<th>Etat</th>
				<th>opération</th>
			@foreach ($students as $student)
				<tr>
					<td>
						<a href="{{URL::to('student/show')}}/{{$student[0]->id}}">{{$student[0]->firstname}} {{$student[0]->lastname}}</a>
					</td>				
					@if ($student[1] == 1)
						<td>Est actuellement dans le projet</td>
						<td>
							<div class="row">
								<div class="col-md-4">
									{{Form::open(["method"=>"POST", "url"=>"project/exclude"])}}
										{{Form::hidden("project_id", $project->id)}}
										{{Form::hidden("student_id", $student[0]->id)}}
										{{ Form::submit('Exclure l\'étudiant du projet', array('class' => 'btn btn-danger')) }}
									{{Form::close()}}
								</div>
							</div>
						</td>
					@elseif($student[1] == 0)
						<td>En attente de validation</td>
						<td>
							<div class="row">
								<div class="col-md-4">
									{{Form::open(["method"=>"POST", "url"=>"project/include"])}}
										{{Form::hidden("project_id", $project->id)}}
										{{Form::hidden("student_id", $student[0]->id)}}
										{{ Form::submit('Inclure l\'étudiant dans le projet', array('class' => 'btn btn-success')) }}
									{{Form::close()}}
								</div>
							</div>
						</td>
					@endif
				</tr>
			@endforeach
			</table>
		</div>
	@endif

	<div class="col-md-12">
		<h3>Communiquer avec nous</h2>
		
		{{Form::open(["url"=>"/post/create/","method"=>"post"])}}
		  {{Form::hidden("redirection", "project/show/".$project->id)}}
		  {{Form::hidden("project_id", $project->id)}}
	      <div class="row">
	        <div class="col-md-11">                     
	          {{ Form::textarea('message', "", ['placeholder'=>"Votre message",'class' => 'form-control', "rows"=>3]) }}
	        </div>
	        <div class="col-md-1">
	          {{ Form::submit('Envoyer', array('class' => 'btn btn-info')) }}
	        </div>
	      </div>
		{{Form::close()}}

		<br/>

		@if ($posts)
			@foreach ($posts as $post)
				@if ($post->user->own_type == "company")
					<div class="row post">
						<div class="col-md-11 post-message">
							{{App::make("3enib_text")->filterText($post->message)}}
							@if($auth and ($post->user->id == Auth::user()->id or Auth::user()->admin==1))
							{{Form::open(["url"=>"/post/edit/".$post->id,"method"=>"post", "class"=>"post-edit"])}}
							  {{Form::hidden("redirection", "project/show/".$project->id)}}
						      <div class="row">
						        <div class="col-md-10">                     
						          {{ Form::textarea('message', $post->message, ['placeholder'=>"Votre message",'class' => 'form-control post-edit-form', "rows"=>3]) }}
						        </div>
						        <div class="col-md-1">
						          {{ Form::submit('Editer', array('class' => 'btn btn-info post-edit-btn')) }}
						        </div>
						      </div>
							{{Form::close()}}
							<div class="post-panel">
								<span class="glyphicon glyphicon-pencil post-panel-edit"></span>
								&nbsp;
								<a href="{{URL::to('post/delete')}}/{{$post->id}}"><span class="glyphicon glyphicon-remove post-panel-remove"></span></a>
							</div>
							@endif
						</div>
						<div class="col-md-1">
							<img class="img-circle post-avatar" src="{{$_ENV['root_site']}}/document/avatar/{{$post->user_id}}/{{User::find($post->user_id)->own->avatar_filepath}}" alt="">
						</div>
					</div> 
				@else
					<div class="row post">
						<div class="col-md-1">
							<img class="img-circle post-avatar" src="{{$_ENV['root_site']}}/document/avatar/{{$post->user_id}}/{{User::find($post->user_id)->own->avatar_filepath}}" alt="">
						</div>
						<div class="col-md-11 post-message">
							{{App::make("3enib_text")->filterText($post->message)}}
							@if($auth and ($post->user->id == Auth::user()->id or Auth::user()->admin==1))
							{{Form::open(["url"=>"/post/edit/".$post->id,"method"=>"post", "class"=>"post-edit"])}}
							{{Form::hidden("redirection", "project/show/".$project->id)}}
							<div class="row">
								<div class="col-md-10">                     
									{{ Form::textarea('message', $post->message, ['placeholder'=>"Votre message",'class' => 'form-control post-edit-form', "rows"=>3]) }}
								</div>
								<div class="col-md-1">
									{{ Form::submit('Editer', array('class' => 'btn btn-info post-edit-btn')) }}
								</div>
							</div>
							{{Form::close()}}
							<div class="post-panel">
								<span class="glyphicon glyphicon-pencil post-panel-edit"></span>
								&nbsp;
								<a href="{{URL::to('post/delete')}}/{{$post->id}}"><span class="glyphicon glyphicon-remove post-panel-remove"></span></a>
							</div>
							@endif
						</div>
					</div>
				@endif
			@endforeach
		@endif
	</div>

</div>

@endif

@endsection
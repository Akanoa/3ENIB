@extends("layouts.main")

@section("content")

@if($project)

<a href="{{URL::to('company')}}/{{$project->company->id}}" id="back-to-company">Retour à l'entreprise</a>

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
		@if(App::make("3enib_authz")->isAdmin() or (App::make("3enib_authz")->isCompany() and Auth::user()->own->id==$project->company->id))
			{{Form::open(["method"=>"GET", "url"=>"project/add-document/".$project->company->user->id."/".$project->id."/"])}}
				{{ Form::submit('Ajouter un document', array('class' => 'btn btn-success')) }}
			{{Form::close()}}
		@endif
		@if ($files)
			<ul id="document-list">
			@foreach ($files as $file)
				@if(App::make("3enib_project")->documentIsVisible($file, $project))
					<li>
						<a href="{{URL::to('document/pdf')}}/{{$project->company->user->id}}/pdf/{{$file->path}}">{{$file->name}}</a>
						@if($allow_to_remove_docs)
							&nbsp;
							<a href="{{URL::to('document/delete')}}/{{$file->id}}/{{$project->id}}"><span class="glyphicon glyphicon-remove remove-document"></span></a>
						@endif
					</li>
				@endif
			@endforeach
			</ul>
		@else
			<br>
			Il n'y a pas de document disponible.
		@endif
	</div>
	
	@if($project->state == 1 and App::make("3enib_authz")->isStudent())
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
							<img class="post-avatar" src="{{$_ENV['root_site']}}/document/avatar/{{$post->user_id}}/{{User::find($post->user_id)->own->avatar_filepath}}" title="{{$post->user->own->name}}">
						</div>
					</div> 
				@else
					<div class="row post">
						<div class="col-md-1">
							<img class="post-avatar" src="{{$_ENV['root_site']}}/document/avatar/{{$post->user_id}}/{{User::find($post->user_id)->own->avatar_filepath}}" title="{{$post->user->own->firstname}} {{$post->user->own->lastname}}">
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
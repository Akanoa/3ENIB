@extends("layouts.main")

@section("content")

 {{Form::open(['url' => 'project/add-document', 'method' => 'post', 'class'=>'form-horizontal well', 'files'=>true])}}

	{{Form::hidden("user_id", $user_id)}}
	{{Form::hidden("project_id", $project_id)}}
	<fieldset>

	<!-- Form Name -->
	<a href="{{URL::to('project/show')}}/{{$project_id}}" id="back-to-project">Retour au projet</a>
	<legend>Ajouter des documents</legend>
	<div id="documents">
		<div class="document">
			<!-- Text input-->
			<div class="form-group">
				<label class="col-md-4 control-label" for="name">Nom</label>  
				<div class="col-md-4">
					{{Form::text("name[]", "", array("placeholder"=>"Nom du document", "class"=>"form-control input-md"))}}
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-4 control-label" for="document">Choississez votre fichier</label>  
				<div class="col-md-4">
					{{Form::file("document[]")}}
				</div>
				{{$errors->first("document", '<span class="help-block">:message</span>')}}

			</div>

			<div class="form-group visibility">
				<label class="col-md-4 control-label" for="private">Uniquement visible pour les membres du projet</label>  
				<div class="col-md-8">
					{{Form::checkbox("private[0]")}}
				</div>
				{{$errors->first("document", '<span class="help-block">:message</span>')}}

			</div>		

			<abbr title="Supprimer ce document"><span onclick="removeDocument(this);" class="minus glyphicon glyphicon-minus"></span></abbr>
		</div>
	</div>
	<abbr title="Ajouter un document"><span id="add-document" class="add glyphicon glyphicon-plus"></span></abbr>

  <!-- Button -->
  <div class="form-group">
    <label class="col-md-4 control-label" for="submit"></label>
    <div class="col-md-4">
      {{ Form::submit('Envoyer', array('class' => 'btn btn-info btn-block')) }}
    </div>
  </div>

  </fieldset>
{{Form::close()}}

@endsection
@extends('layouts.main')

@section('content')

<div id="edit-student">
      {{Form::open(['url' => 'project/create', 'method' => 'post', 'class'=>'form-horizontal well', 'files'=>true])}}

      {{Form::hidden("subscription_type", "student")}}
      {{Form::hidden("company_id", $company_id)}}
      <fieldset>

      <!-- Form Name -->
      <legend>Créer un projet</legend>

      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-4 control-label" for="name">Nom</label>  
        <div class="col-md-4">
        {{Form::text("name", "", array("placeholder"=>"nom", "class"=>"form-control input-md"))}}
        </div>
          {{$errors->first("name", '<span class="help-block">:message</span>')}}
      </div>


      <!-- Textarea -->
      <div class="form-group">
        <label class="col-md-4 control-label" for="description">Descripition du projet</label>
        <div class="col-md-4">
          {{ Form::textarea('description', "", ['placeholder'=>"Présentez votre projet",'class' => 'form-control']) }}
        </div>
      </div>

      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-4 control-label" for="skills">Domaine de compétence requis</label>  
        <div class="col-md-4">
        {{Form::text("skills", "", array("placeholder"=>"Compétences requises", "class"=>"form-control input-md"))}}
        </div>
          {{$errors->first("skills", '<span class="help-block">:message</span>')}}
      </div>

      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-4 control-label" for="estimated_time">Temps estimé de la réalisation</label>  
        <div class="col-md-4">
        {{Form::text("estimated_time", "", array("placeholder"=>"Estimation du temps de réalisation", "class"=>"form-control input-md"))}}
        </div>
          {{$errors->first("estimated_time", '<span class="help-block">:message</span>')}}
      </div>

      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-4 control-label" for="remuneration">Rémunération</label>  
        <div class="col-md-4">
        {{Form::text("remuneration", "", array("placeholder"=>"0", "class"=>"form-control input-md"))}}
        </div>
        <div class="col-md-1 symbol-euro-project">€</div>
          {{$errors->first("remuneration", '<span class="help-block">:message</span>')}}
      </div>

      <!-- Button -->
      <div class="form-group">
        <label class="col-md-4 control-label" for="submit"></label>
        <div class="col-md-4">
          {{ Form::submit('Soumettre le projet', array('class' => 'btn btn-info btn-block')) }}
        </div>
      </div>


@endsection
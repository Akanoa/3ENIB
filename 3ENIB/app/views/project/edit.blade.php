@extends('layouts.main')

@section('content')

<div id="edit-student">
      {{Form::open(['url' => 'project/edit/'.$datas["id"], 'method' => 'post', 'class'=>'form-horizontal well', 'files'=>true])}}

      {{Form::hidden("subscription_type", "student")}}
      <fieldset>

      <!-- Form Name -->
      <legend>Modifier le projet {{$datas["name"]}}</legend>

      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-4 control-label" for="name">Nom</label>  
        <div class="col-md-4">
        {{Form::text("name", $datas["name"], array("placeholder"=>"nom", "class"=>"form-control input-md"))}}
        </div>
          {{$errors->first("name", '<span class="help-block">:message</span>')}}
      </div>


      <!-- Textarea -->
      <div class="form-group">
        <label class="col-md-4 control-label" for="description">Descripition du projet</label>
        <div class="col-md-4">                     
          {{ Form::textarea('description', $datas["description"], ['placeholder'=>"Présentez votre projet",'class' => 'form-control']) }}
        </div>
      </div>

      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-4 control-label" for="skills">Domaine de compétence requis</label>  
        <div class="col-md-4">
        {{Form::text("skills", $datas["skills"], array("placeholder"=>"Compétences requises", "class"=>"form-control input-md"))}}
        </div>
          {{$errors->first("skills", '<span class="help-block">:message</span>')}}
      </div>

      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-4 control-label" for="estimated_time">Temps estimé de la réalisation</label>  
        <div class="col-md-4">
        {{Form::text("estimated_time", $datas["estimated_time"], array("placeholder"=>"Estimation du temps de réalisation", "class"=>"form-control input-md"))}}
        </div>
          {{$errors->first("estimated_time", '<span class="help-block">:message</span>')}}
      </div>

      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-4 control-label" for="remuneration">Rémunération</label>  
        <div class="col-md-4">
        {{Form::text("remuneration", $datas["remuneration"], array("placeholder"=>"0", "class"=>"form-control input-md"))}}
        </div>
        <div class="col-md-1 symbol-euro-project">€</div>
          {{$errors->first("remuneration", '<span class="help-block">:message</span>')}}
      </div>

      <!-- Button -->
      <div class="form-group">
        <label class="col-md-4 control-label" for="submit"></label>
        <div class="col-md-4">
          {{ Form::submit('Editer le projet', array('class' => 'btn btn-info btn-block')) }}
        </div>
      </div>
      {{Form::close()}}


@endsection
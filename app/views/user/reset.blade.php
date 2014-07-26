@extends("layouts.main")

@section("content")



{{Form::open(["method"=>"post", "url"=>"user/reset", 'class'=>'form-horizontal form-signin', 'id'=>'form-signin'])}}


  {{Form::hidden("hash", $user->remember_token)}}
  {{Form::hidden("email", $user->email)}}

  <legend>Changer le mot de passe</legend>

  <div class="form-group">
    <label class="col-md-4 control-label" for="password">Mot de passe</label>  
    <div class="col-md-4">
    {{Form::password("password", array("placeholder"=>"mot de passe", "class"=>"form-control input-md"))}}
    </div>
      {{$errors->first("password", '<span class="help-block">:message</span>')}}
  </div>

  <div class="form-group">
    <label class="col-md-4 control-label" for="password_confirmation">Confirmer le mot de passe</label>  
    <div class="col-md-4">
    {{Form::password("password_confirmation", array("placeholder"=>"confirmer le mot de passe", "class"=>"form-control input-md"))}}
    </div>
      {{$errors->first("password_confirmation", '<span class="help-block">:message</span>')}}
  </div>


  <!-- Button -->
  <div class="form-group">
    <label class="col-md-4 control-label" for="submit"></label>
    <div class="col-md-4">
      {{ Form::submit('Se connecter', array('class' => 'btn btn-info btn-block')) }}
    </div>
  </div>

{{Form::close()}}
@endsection
@extends("layouts.main")

@section("content")



{{Form::open(["method"=>"post", "url"=>"user/signin", 'class'=>'form-horizontal form-signin', 'id'=>'form-signin'])}}

  <!-- Text input-->
  <div class="form-group">
    <label class="col-md-4 control-label" for="email">Email</label>  
    <div class="col-md-4">
    {{Form::email("email", "", array("placeholder"=>"email", "class"=>"form-control input-md" ,"id"=>"signin-email"))}}
    </div>
      {{$errors->first("email", '<span class="help-block">:message</span>')}}
  </div>

  <div class="form-group">
    <label class="col-md-4 control-label" for="password">Mot de passe</label>  
    <div class="col-md-4">
    {{Form::password("password", array("placeholder"=>"mot de passe", "class"=>"form-control input-md"))}}
    </div>
      {{$errors->first("password", '<span class="help-block">:message</span>')}}
  </div>


  <div class="form-group">
    <div class="col-md-8 col-md-offset-4">  
      {{Form::hidden("location-to", URL::to('user/reset'), ["id"=>"root-to-forgot-passwd"])}}
      <a href="" id="forgot-passwd">Mot de passe oublié</a>
    </div>
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
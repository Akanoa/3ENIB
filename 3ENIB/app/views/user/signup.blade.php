@extends("layouts.main")

@section('content')
  <form class="form-horizontal">
  <fieldset>

  <!-- Form Name -->
  <legend>Inscription</legend>

  <!-- Multiple Radios -->
  <div class="form-group">
    <label class="col-md-4 control-label" for="radios">Je suis</label>
    <div class="col-md-5">
      <div class="radio">
        <label for="radios-0">
          <input type="radio" name="radios" id="radios-0" value="1" checked="checked">
          Un étudiant
        </label>
      </div>
      <div class="radio">
        <label for="radios-1">
          <input type="radio" name="radios" id="radios-1" value="2">
          Une entreprise
        </label>
      </div>
    </div>
  </div>

  </fieldset>
  </form>


<div class="signup-student">


{{Form::open(array('url' => 'user/signup', 'method' => 'post', 'class'=>'form-horizontal well'))}}

{{Form::hidden("subscription_type", "student")}}
<fieldset>

<!-- Form Name -->
<legend>Étudiant</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="firstname">Prénom</label>  
  <div class="col-md-4">
  {{Form::text("firstname", "", array("placeholder"=>"prénom", "class"=>"form-control input-md"))}}
  </div>
  <div class="col-md-8">
    {{$errors->first("firstname", '<span class="error">:message</span>')}}
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="lastname">Nom</label>  
  <div class="col-md-4">
  {{Form::text("lastname", "", array("placeholder"=>"nom", "class"=>"form-control input-md"))}}
  </div>
  <div class="col-md-8">
    {{$errors->first("lastname", '<span class="error">:message</span>')}}
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="phone_number">Téléphone</label>  
  <div class="col-md-4">
  {{Form::text("phone_number", "", array("placeholder"=>"téléphone", "class"=>"form-control input-md"))}}
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="email">Email</label>  
  <div class="col-md-4">
  {{Form::email("email", "", array("placeholder"=>"email", "class"=>"form-control input-md"))}}
  </div>
  <div class="col-md-8">
    {{$errors->first("email", '<span class="error">:message</span>')}}
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="password">Mot de passe</label>  
  <div class="col-md-4">
  {{Form::password("password", array("placeholder"=>"mot de passe", "class"=>"form-control input-md"))}}
  </div>
  <div class="col-md-8">
    {{$errors->first("password", '<span class="error">:message</span>')}}
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="password_confirmation">Confirmation</label>  
  <div class="col-md-4">
  {{Form::password("password_confirmation", array("placeholder"=>"confirmé votre mot de passe", "class"=>"form-control input-md"))}}
  </div>
  <div class="col-md-8">
    {{$errors->first("password_confirmation", '<span class="error">:message</span>')}}
  </div>
</div>

<!-- Multiple Checkboxes -->

<div class="form-group">
  <label class="col-md-4 control-label" for="specialities">Spécialités</label>
  <div class="col-md-4">
    {{-- */$i=0;/* --}}
    @foreach ($specialities as $speciality)
    <div class="checkbox">
      <label for="specialities-{{$i}}">
        {{ Form::checkbox('specialities[]', $speciality->id, false, ['id' => 'specialities-'.$i]) }}
        {{$speciality->name}}
      </label>
      {{-- */$i++;/* --}}
    </div>
    @endforeach
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="description">Parlez nous de vous</label>
  <div class="col-md-4">                     
    {{ Form::textarea('description', null, ['class' => 'form-control']) }}
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="submit"></label>
  <div class="col-md-4">
    {{ Form::submit('S\'inscrire', array('class' => 'btn btn-info pull-right')) }}
  </div>
</div>

</fieldset>
{{Form::close()}}

  </div>
@endsection

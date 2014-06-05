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
        <label for="student-subscription">
          <input type="radio" name="radios" id="student-subscription" value="1" checked="checked">
          Un étudiant
        </label>
      </div>
      <div class="radio">
        <label for="company-subscription">
          <input type="radio" name="radios" id="company-subscription" value="2">
          Une entreprise
        </label>
      </div>
    </div>
  </div>

  </fieldset>
  </form>


<div id="signup-student">
  {{Form::open(['url' => 'user/signup', 'method' => 'post', 'class'=>'form-horizontal well', 'files'=>true])}}

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
      {{$errors->first("firstname", '<span class="help-block">:message</span>')}}
  </div>

  <!-- Text input-->
  <div class="form-group">
    <label class="col-md-4 control-label" for="lastname">Nom</label>  
    <div class="col-md-4">
    {{Form::text("lastname", "", array("placeholder"=>"nom", "class"=>"form-control input-md"))}}
    </div>
      {{$errors->first("lastname", '<span class="help-block">:message</span>')}}
  </div>

  <!-- Text input-->
  <div class="form-group">
    <label class="col-md-4 control-label" for="email">Email</label>  
    <div class="col-md-4">
    {{Form::email("email", "", array("placeholder"=>"email", "class"=>"form-control input-md"))}}
    </div>
      {{$errors->first("email", '<span class="help-block">:message</span>')}}
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
    <label class="col-md-4 control-label" for="password">Mot de passe</label>  
    <div class="col-md-4">
    {{Form::password("password", array("placeholder"=>"mot de passe", "class"=>"form-control input-md"))}}
    </div>
      {{$errors->first("password", '<span class="help-block">:message</span>')}}
  </div>

  <!-- Text input-->
  <div class="form-group">
    <label class="col-md-4 control-label" for="password_confirmation">Confirmation</label>  
    <div class="col-md-4">
    {{Form::password("password_confirmation", array("placeholder"=>"confirmez votre mot de passe", "class"=>"form-control input-md"))}}
    </div>
      {{$errors->first("password_confirmation", '<span class="help-block">:message</span>')}}
  </div>

  <!-- Avatar -->
  <div class="form-group">
    <label class="col-md-4 control-label" for="avatar">Avatar</label>  
    <div class="col-md-4">
    {{Form::file("avatar", ["class"=>"filestyle", "data-buttonText"=>"Choississez votre avatar", "data-iconName"=>"glyphicon-inbox"])}}
    </div>
      {{$errors->first("avatar", '<span class="help-block">:message</span>')}}
  </div>

  <!-- Avatar -->
  <div class="form-group">
    <label class="col-md-4 control-label" for="cv">Déposer votre CV</label>  
    <div class="col-md-4">
    {{Form::file("cv", ["class"=>"filestyle", "data-buttonText"=>"Votre CV", "data-iconName"=>"glyphicon-inbox"])}}
    </div>
      {{$errors->first("cv", '<span class="help-block">:message</span>')}}
  </div>

  <!-- Multiple Checkboxes -->

  <div class="form-group">
    <label class="col-md-4 control-label" for="specialities">Spécialités</label>
    <div class="col-md-4">
      {{-- */$i=0;/* --}}
      @foreach ($studentSpecialities as $speciality)
      <div class="checkbox">
        <label for="specialities-{{$i}}">
          {{ Form::checkbox('specialities[]', $speciality, false, ['id' => 'specialities-'.$i]) }}
          {{$speciality}}
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
      {{ Form::textarea('description', null, ['placeholder'=>"Votre petit +...",'class' => 'form-control']) }}
    </div>
  </div>

  <!-- Button -->
  <div class="form-group">
    <label class="col-md-4 control-label" for="submit"></label>
    <div class="col-md-4">
      {{ Form::submit('S\'inscrire', array('class' => 'btn btn-info btn-block')) }}
    </div>
  </div>

  </fieldset>
  {{Form::close()}}
</div>

<div id="signup-company">
  {{Form::open(['url' => 'user/signup', 'method' => 'post', 'class'=>'form-horizontal well', 'files'=>true])}}

  {{Form::hidden("subscription_type", "company")}}
  <fieldset>

  <!-- Form Name -->
  <legend>Entreprise</legend>

  <!-- Text input-->
  <div class="form-group">
    <label class="col-md-4 control-label" for="name">Nom de l'entreprise</label>  
    <div class="col-md-4">
    {{Form::text("name", "", array("placeholder"=>"Nom de l'entreprise", "class"=>"form-control input-md"))}}
    </div>
      {{$errors->first("name", '<span class="help-block">:message</span>')}}
  </div>

  <!-- Text input-->
  <div class="form-group">
    <label class="col-md-4 control-label" for="email">Email</label>  
    <div class="col-md-4">
    {{Form::email("email", "", array("placeholder"=>"email", "class"=>"form-control input-md"))}}
    </div>
      {{$errors->first("email", '<span class="help-block">:message</span>')}}
  </div>

  <!-- Text input-->
  <div class="form-group">
    <label class="col-md-4 control-label" for="password">Mot de passe</label>  
    <div class="col-md-4">
    {{Form::password("password", array("placeholder"=>"mot de passe", "class"=>"form-control input-md"))}}
    </div>
      {{$errors->first("password", '<span class="help-block">:message</span>')}}
  </div>

  <!-- Text input-->
  <div class="form-group">
    <label class="col-md-4 control-label" for="password_confirmation">Confirmation</label>  
    <div class="col-md-4">
    {{Form::password("password_confirmation", array("placeholder"=>"confirmez votre mot de passe", "class"=>"form-control input-md"))}}
    </div>
      {{$errors->first("password_confirmation", '<span class="help-block">:message</span>')}}
  </div>

  <!-- Text input-->
  <div class="form-group">
    <label class="col-md-4 control-label" for="expertise">Mots clefs</label>  
    <div class="col-md-4">
    {{Form::password("expertise", array("placeholder"=>"Mots clefs décrivant votre secteur d'activité", "class"=>"form-control input-md"))}}
    </div>
      {{$errors->first("password_confirmation", '<span class="help-block">:message</span>')}}
  </div>

  <!-- Avatar -->
  <div class="form-group">
    <label class="col-md-4 control-label" for="avatar">Avatar</label>  
    <div class="col-md-4">
    {{Form::file("avatar", ["class"=>"filestyle", "data-buttonText"=>"Choississez votre avatar", "data-iconName"=>"glyphicon-inbox"])}}
    </div>
      {{$errors->first("avatar", '<span class="help-block">:message</span>')}}
  </div>

  <!-- Avatar -->
  <div class="form-group">
    <label class="col-md-4 control-label" for="logo" >Image/Logo de votre entreprise</label>  
    <div class="col-md-4">
    {{Form::file("logo", ["class"=>"filestyle", "data-buttonText"=>"Image de présentation", "data-iconName"=>"glyphicon-inbox"])}}
    </div>
      {{$errors->first("logo", '<span class="help-block">:message</span>')}}
  </div>

  <!-- Textarea -->
  <div class="form-group">
    <label class="col-md-4 control-label" for="contact">Adresse de contact</label>
    <div class="col-md-4">
      {{ Form::textarea('contact',null, ['placeholder'=>"Où vous contacter", "rows"=>3,'class' => 'form-control']) }}
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
    <label class="col-md-4 control-label" for="siret">N° SIRET</label>  
    <div class="col-md-4">
    {{Form::password("siret", array("placeholder"=>"Votre SIRET", "class"=>"form-control input-md"))}}
    </div>
      {{$errors->first("password_confirmation", '<span class="help-block">:message</span>')}}
  </div>


  <!-- Textarea -->
  <div class="form-group">
    <label class="col-md-4 control-label" for="description">Présentation de votre entreprise</label>
    <div class="col-md-4">
      {{ Form::textarea('description',null, ['placeholder'=>"Parlez nous de votre entreprise...",'class' => 'form-control']) }}
    </div>
  </div>

  <!-- Button -->
  <div class="form-group">
    <label class="col-md-4 control-label" for="submit"></label>
    <div class="col-md-4">
      {{ Form::submit('S\'inscrire', array('class' => 'btn btn-info btn-block')) }}
    </div>
  </div>

  </fieldset>
  {{Form::close()}}
</div>
@endsection

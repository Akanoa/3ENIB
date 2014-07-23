@extends("layouts.main")

@section('content')


  @if($type=="student")
    <div id="edit-student">
      {{Form::open(['url' => 'user/edit', 'method' => 'post', 'class'=>'form-horizontal well', 'files'=>true])}}

      {{Form::hidden("subscription_type", "student")}}
      <fieldset>

      <!-- Form Name -->
      <legend>Étudiant</legend>

      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-4 control-label" for="firstname">Prénom</label>  
        <div class="col-md-4">
        {{Form::text("firstname", App::make("3enib_text")->filterText($datas["firstname"]), array("placeholder"=>"prénom", "class"=>"form-control input-md"))}}
        </div>
          {{$errors->first("firstname", '<span class="help-block">:message</span>')}}
      </div>

      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-4 control-label" for="lastname">Nom</label>  
        <div class="col-md-4">
        {{Form::text("lastname", App::make("3enib_text")->filterText($datas["lastname"]), array("placeholder"=>"nom", "class"=>"form-control input-md"))}}
        </div>
          {{$errors->first("lastname", '<span class="help-block">:message</span>')}}
      </div>

      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-4 control-label" for="email">Email</label>  
        <div class="col-md-4">
        {{Form::email("email", App::make("3enib_text")->filterText($datas["email"]), array("placeholder"=>"email", "class"=>"form-control input-md"))}}
        </div>
          {{$errors->first("email", '<span class="help-block">:message</span>')}}
      </div>

      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-4 control-label" for="phone_number">Téléphone</label>  
        <div class="col-md-4">
        {{Form::text("phone_number", App::make("3enib_text")->filterText($datas["phone_number"]), array("placeholder"=>"téléphone", "class"=>"form-control input-md"))}}
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
    <label class="col-md-4 control-label" for="avatar">Choisssissez votre avatar</label>  
    <div class="col-md-4">
    {{Form::file("avatar", ["class"=>"filestyle", "data-buttonText"=>"Avatar", "data-iconName"=>"glyphicon-inbox"])}}
    </div>
      {{$errors->first("avatar", '<span class="help-block">:message</span>')}}
  </div>

      <!-- Avatar -->
      <div class="form-group">
        <label class="col-md-4 control-label" for="photo">Choississez votre photo de profil</label>  
        <div class="col-md-4">
        {{Form::file("photo", ["class"=>"filestyle", "data-buttonText"=>"Photo de profil", "data-iconName"=>"glyphicon-inbox"])}}
        </div>
          {{$errors->first("photo", '<span class="help-block">:message</span>')}}
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
          {{ Form::textarea('description', App::make("3enib_text")->filterText($datas["description"]), ['placeholder'=>"Votre petit +...",'class' => 'form-control light-textarea']) }}
        </div>
      </div>

      <!-- Button -->
      <div class="form-group">
        <label class="col-md-4 control-label" for="submit"></label>
        <div class="col-md-4">
          {{ Form::submit('Modifier mon profil', array('class' => 'btn btn-info btn-block')) }}
        </div>
      </div>

      </fieldset>
      {{Form::close()}}
    </div>
  @elseif($type=="company")
    <div id="edit-company">
      {{Form::open(['url' => 'user/edit', 'method' => 'post', 'class'=>'form-horizontal well', 'files'=>true])}}

      {{Form::hidden("subscription_type", "company")}}
      <fieldset>

      <!-- Form Name -->
      <legend>Entreprise</legend>

      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-4 control-label" for="name">Nom de l'entreprise</label>  
        <div class="col-md-4">
        {{Form::text("name", App::make("3enib_text")->filterText($datas["name"]), array("placeholder"=>"Nom de l'entreprise", "class"=>"form-control input-md"))}}
        </div>
          {{$errors->first("name", '<span class="help-block">:message</span>')}}
      </div>

      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-4 control-label" for="email">Email</label>  
        <div class="col-md-4">
        {{Form::email("email", App::make("3enib_text")->filterText($datas["email"]), array("placeholder"=>"email", "class"=>"form-control input-md"))}}
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
        {{Form::text("expertise", App::make("3enib_text")->filterText($datas["expertise"]),array("placeholder"=>"Mots clefs décrivant votre secteur d'activité", "class"=>"form-control input-md"))}}
        </div>
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
          {{ Form::textarea('contact',App::make("3enib_text")->filterText($datas["contact"]), ['placeholder'=>"Où vous contacter", "rows"=>3,'class' => 'form-control light-textarea']) }}
        </div>
      </div>

      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-4 control-label" for="phone_number">Téléphone</label>  
        <div class="col-md-4">
        {{Form::text("phone_number", App::make("3enib_text")->filterText($datas["phone_number"]), array("placeholder"=>"téléphone", "class"=>"form-control input-md"))}}
        </div>
      </div>


      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-4 control-label" for="siret">N° SIRET</label>  
        <div class="col-md-4">
        {{Form::text("siret", App::make("3enib_text")->filterText($datas["siret"]), array("placeholder"=>"Votre SIRET", "class"=>"form-control input-md"))}}
        </div>
          {{$errors->first("password_confirmation", '<span class="help-block">:message</span>')}}
      </div>


      <!-- Textarea -->
      <div class="form-group">
        <label class="col-md-4 control-label" for="description">Présentation de votre entreprise</label>
        <div class="col-md-4">
          {{ Form::textarea('description', App::make("3enib_text")->filterText($datas["description"]), ['placeholder'=>"Parlez nous de votre entreprise...",'class' => 'form-control light-textarea']) }}
        </div>
      </div>

      <!-- Button -->
      <div class="form-group">
        <label class="col-md-4 control-label" for="submit"></label>
        <div class="col-md-4">
          {{ Form::submit('Modifier mon profil', array('class' => 'btn btn-info btn-block')) }}
        </div>
      </div>

      </fieldset>
      {{Form::close()}}
    </div>
  @endif

@endsection

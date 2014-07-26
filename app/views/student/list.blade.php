@extends("layouts.main")

@section("content")

@if($students)
	
	<table class="table table-striped">
		<th>Étudiant</th>
		<th>Statut</th>
		<th>Actions</th>
		@foreach ($students as $student)
			<tr>

				<td>
					<a href="{{URL::to('student/show')}}/{{$student->id}}">{{{$student->firstname}}} {{{$student->lastname}}}</a>
				</td>
				<td>{{App::make("3enib_user")->userStatus($student)}}</td>
				<td>
					<div class="row">

						<div class="col-md-3">
							{{Form::open(["method"=>"GET", "url"=>"student/delete/".$student->id])}}
								{{ Form::submit('Supprimer l\'étudiant', array('class' => 'btn btn-danger')) }}
							{{Form::close()}}
						</div>	

						@if(!App::make("3enib_user")->userIsActive($student))
							<div class="col-md-3">
								{{Form::open(["method"=>"POST", "url"=>"user/unban"])}}
									{{Form::hidden("user_id", $student->user->id)}}
									{{ Form::submit('Débannir l\'étudiant', array('class' => 'btn btn-warning')) }}
								{{Form::close()}}
							</div>	
						@else
							<div class="col-md-3">
								{{Form::open(["method"=>"POST", "url"=>"user/ban"])}}
									{{Form::hidden("user_id", $student->user->id)}}
									{{ Form::submit('Bannir l\'étudiant', array('class' => 'btn btn-danger')) }}
								{{Form::close()}}
							</div>			
						@endif

							<div class="col-md-3">
								{{Form::open(["method"=>"GET", "url"=>"user/edit/".$student->user->id])}}
									{{ Form::submit('Modifier l\'étudiant', array('class' => 'btn btn-info')) }}
								{{Form::close()}}
							</div>

							@if($student->user->admin==0)
							<div class="col-md-3">
								{{Form::open(["method"=>"POST", "url"=>"user/elevate/"])}}
									{{Form::hidden("user_id", $student->user->id)}}
									{{ Form::submit('Rendre cette étudiant administrateur', array('class' => 'btn btn-success')) }}
								{{Form::close()}}
							</div>
							@else
							<div class="col-md-3">
								{{Form::open(["method"=>"POST", "url"=>"user/retrograde/"])}}
									{{Form::hidden("user_id", $student->user->id)}}
									{{ Form::submit('Supprimer les droits administrateurs de l\'étudiant', array('class' => 'btn btn-danger')) }}
								{{Form::close()}}
							</div>
							@endif

					</div>
				</td>

			</tr>
		@endforeach
	</table>

@endif

@endsection
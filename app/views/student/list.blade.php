@extends("layouts.main")

@section("content")

@if($students)
	
	<table class="table table-striped">
		<th>Étudiant</th>
		<th>Statut</th>
		<th>Actions</th>
		@foreach ($students as $student)
			<tr>
				@if($student->user->admin == 0)
					<td>
						<a href="{{URL::to('student/show')}}/{{$student->id}}">{{{$student->firstname}}} {{{$student->lastname}}}</a>
					</td>
					<td>{{App::make("3enib_user")->userStatus($student)}}</td>
					<td>
						<div class="row">
							@if(!App::make("3enib_user")->userIsActive($student))
								<div class="col-md-4">
									{{Form::open(["method"=>"POST", "url"=>"user/unban"])}}
										{{Form::hidden("user_id", $student->user->id)}}
										{{ Form::submit('Débannir l\'étudiant', array('class' => 'btn btn-warning')) }}
									{{Form::close()}}
								</div>	
							@else
								<div class="col-md-4">
									{{Form::open(["method"=>"POST", "url"=>"user/ban"])}}
										{{Form::hidden("user_id", $student->user->id)}}
										{{ Form::submit('Bannir l\'étudiant', array('class' => 'btn btn-danger')) }}
									{{Form::close()}}
								</div>			
							@endif
						</div>
					</td>
				@endif
			</tr>
		@endforeach
	</table>

@endif

@endsection
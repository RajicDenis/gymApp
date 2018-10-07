@extends('layouts.app')

@section('content')

	<div class="container">

		@if($type == 'level')
			<h1 class="text-center">Change program level</h1>
		@else
			<h1 class="text-center">Change program trainer</h1>
		@endif

		<hr class="hr mb-5">

		<!-- Show level form -->
		@if($type == 'level')

			<form class="mt-5" action="{{ route('program_level', $program->id) }}" method="POST">

				{{ csrf_field() }}
				
				<div class="form-group row">
				  <label for="level" class="col-2 col-form-label"><strong>Level</strong></label>
				  <div class="col-10">
				  	<select name="level" id="level">
				  		<option value="light" @if($program->level == 'light') selected @endif>Light</option>
				  		<option value="medium" @if($program->level == 'medium') selected @endif>Medium</option>
				  		<option value="hard" @if($program->level == 'hard') selected @endif>Hard</option>
				  	</select>
				  </div>
				</div>
		
				<button type="submit" class="btn btn-primary">Save</button>

			</form>

		<!-- Show trainer form -->
		@else

			<form class="mt-5" action="{{ route('program_trainer', $program->id) }}" method="POST">

				{{ csrf_field() }}
				
				<div class="form-group row">
				  <label for="trainer" class="col-2 col-form-label">Trainer</label>
				  <div class="col-10">
				  	<select name="trainer" id="trainer">
				  		@foreach($trainers as $trainer)
				  			<option value="{{ $trainer->id }}" @if($type == $trainer->id) selected @endif>{{ $trainer->name }}</option>
				  		@endforeach
				  	</select>
				  </div>
				</div>
		
				<button type="submit" class="btn btn-primary">Save</button>

			</form>

		@endif
	</div>

@stop
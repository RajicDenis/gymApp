@extends('layouts.app')

@section('content')

	<div class="container">

		@if(Session::has('status'))
			<div class="center">
				<div class="alert {{ Session::get('alert_type') }}">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					{{ Session::get('status') }}
				</div>
			</div>
		@endif

		<h1 class="text-center">Choose program details</h1>

		<form action="{{ route('program_store') }}" method="POST">

			{{ csrf_field() }}
			
			<div class="form-group row">
			  <label for="example-text-input" class="col-2 col-form-label">Name</label>
			  <div class="col-10">
			    <input class="form-control" type="text" name="name" id="example-text-input" required>
			  </div>
			</div>

			<div class="form-group row">
			  <label for="level" class="col-2 col-form-label">Level</label>
			  <div class="col-10">
			  	<select name="level" id="level">
			  		<option value="light">Light</option>
			  		<option value="medium">Medium</option>
			  		<option value="hard">Hard</option>
			  	</select>
			  </div>
			</div>

			<div class="form-group row">
			  <label for="trainer" class="col-2 col-form-label">Trainer</label>
			  <div class="col-10">
			  	<select name="trainer" id="trainer">
			  		@foreach($trainers as $trainer)
			  			<option value="{{ $trainer->id }}">{{ $trainer->name }}</option>
			  		@endforeach
			  	</select>
			  </div>
			</div>

			<div class="form-group row">
			    <label for="example-datetime-local-input" class="col-2 col-form-label">Start date (Sunday)</label>
			    <div class="col-10">
			  		<input class="form-control" type="date" name="start_date" id="example-datetime-local-input" value="{{ \App\Time::find(1)->time }}" required>
			  		<small id="dateHelp" class="form-text text-muted">Date is entered in mm-dd-Y format (e.g. 05/20/2018)</small>
			    </div>
			</div>

			<button type="submit" class="btn btn-primary">Save Program</button>

		</form>

	</div>

@stop
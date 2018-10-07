<div class="d-flex justify-content-center">

	<form action="{{ route('travel') }}" method="POST">
		
		{{ csrf_field() }}
		
		<h3>Timetravel -- choose current time</h3>

		<hr class="hr">

		<div class="form-group row">
			<label for="example-text-input" class="col-3 col-form-label"><strong>Time:</strong></label>
			<div class="col-9">
		    	<input class="form-control" type="date" name="date" id="example-text-input" value="{{ \App\Time::find(1)->time }}" required>
			</div>
		</div>

		<button type="submit" class="btn btn-primary w-100 mb-3">Save</button>

	</form>

</div>

<div class="text-center mb-5"><strong>Current date: </strong>{{ date('d.m.Y', strtotime(\App\Time::find(1)->time)) }}</div>
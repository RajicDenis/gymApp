@extends('layouts.app')

@section('content')

<div class="container">

    <!-- Include time travel form -->
    @include('include.timetravel')
    
    <!-- Start new program button -->
    <div class="text-center position-relative">
        <h1>My Programs</h1>
        @if(count($programs) == 0)
            <a href="{{ route('program_create') }}" class="btn btn-primary add_program">Start New Program</a>
        @endif
    </div>
    <hr>

    <!-- Success or failure message -->
    @if(Session::has('status'))
        <div class="center">
            <div class="alert {{ Session::get('alert_type') }}">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ Session::get('status') }}
            </div>
        </div>
    @endif

    <!-- If the user has programs -->
    @if(count($programs) != 0)

        <i class="fas fa-info-circle text-muted mr-3 mb-2"></i><span class="text-muted">To cancel, pause or continue the program as well as change level or trainer you need to wait for the first day of the week (Sunday)</span><br>

        <i class="fas fa-info-circle text-muted mr-3 mb-4"></i><span class="text-muted">If the program start date is in the future, you have to wait for the program to start before you can pause it. You can, however, cancel the program before it starts.</span>

        @foreach($programs as $program)
        <div class="p-wrapper">
            <!-- Check if the program is finished -->
            {{ Listener::isFinished($program->id) }}

            @if($program->paused == true)
                <div class="d-flex justify-content-center mt-5"><span class="pb-status">PAUSED</span></div>

                <!-- Change the date if neccessary -->
                {{ Listener::changeDate($program->id) }}
            @endif

            @if($program->canceled == true)
                <div class="d-flex justify-content-center mt-5"><span class="pb-status red">CANCELED</span></div>
            @endif

            @if($program->finished == true)
                <div class="d-flex justify-content-center mt-5 fin"><span class="pb-status green">FINISHED</span></div>
            @endif

            <!-- Use jQuery to display program status before page refresh -->
            <div class="hidden-status d-none"></div>

            <div class="program-box mb-5 @if($program->paused) paused-border @elseif($program->canceled) canceled-border @elseif($program->finished) finished-border @endif d-flex flex-column">

                <!-- Header with program name -->
                <div class="position-relative">

                    <h3 class="text-center">{{ $program->name }}</h3>

                    @if($program->canceled != true && $program->finished != true)
                        <a href="{{ route('program') }}" id="refresh" class="btn btn-primary add_program refresh" data-toggle="tooltip" data-placement="top" title="Refresh program"><i class="fas fa-sync-alt"></i></a>
                    @endif

                </div>

                <hr class="hr"/>

                <!-- Show program details (level, trainer, start date, end date) -->
                <div class="info-box d-flex justify-content-between">

                    <div class="ib-item d-flex flex-column align-items-center">
                        <h4>
                            <strong>LEVEL 
                                @if(Helper::isSunday() == true && $program->canceled != true && $program->finished != true)
                                <a class="hide-lnk" href="{{ route('program_change', ['id' => $program->id, 'type' => 'level']) }}"><i class="fas fa-arrows-alt-v ml-2"></i></a>
                                @endif
                            </strong>
                        </h4>

                        <h5>{{ ucfirst($program->level) }}</h5>
                    </div>

                    <div class="ib-item">
                        <h4>
                            <strong>TRAINER
                                @if(Helper::isSunday() == true && $program->canceled != true && $program->finished != true) 
                                <a class="hide-lnk" href="{{ route('program_change', ['id' => $program->id, 'type' => $program->trainers[count($program->trainers) - 1]->id]) }}"><i class="fas fa-exchange-alt ml-2"></i></a>
                                @endif
                            </strong>
                        </h4>

                        <h5>{{ $program->trainers[count($program->trainers) - 1]->name }}</h5>
                    </div>

                    <div class="ib-item">
                        <h4><strong>START DATE</strong></h4>
                        <h5>{{ date('d.m.Y', strtotime( $program->start_date )) }}</h5>
                    </div>

                    <div class="ib-item">
                        <h4><strong>END DATE</strong></h4>
                        <h5>{{ date('d.m.Y', strtotime( $program->new_end_date )) }}</h5>
                    </div> 

                <!-- END info box -->
                </div> 
                
                <!-- Add progress bar to program (if it is not canceled) -->
                @if($program->canceled != true)
                    <div class="mb-4 mt-4">

                        <div class="progress">
                            @if($program->finished == true)
                                <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">100%</div>
                            @else
                                <div class="progress-bar" role="progressbar" aria-valuenow="{{ Listener::getPercentage($program->id) }}" aria-valuemin="0" aria-valuemax="100" style="width:{{ Listener::getPercentage($program->id) }}%">{{ Listener::getPercentage($program->id) }}%</div>
                            @endif
                        </div>

                    </div>
                @endif

                <!-- Add pause, continue and cancel buttons -->
                <!-- Hide them if it's not sunday or if the program is finished or canceled -->
                @if($program->canceled != true && $program->finished != true)
                    <div class="p-buttons d-flex justify-content-center">

                        @if($program->paused) 
                            @if(Helper::isSunday() == true)
                                <a href="{{ route('program_continue', $program->id) }}" class="pause btn btn-success ml-4 mr-4">Continue</a>
                            @endif
                        @else
                            @if(Carbon\Carbon::parse($program->start_date) < Carbon\Carbon::parse(\App\Time::find(1)->time))
                                @if(Helper::isSunday() == true)
                                    <a href="{{ route('program_pause', $program->id) }}" class="pause btn btn-warning ml-4 mr-4">Pause</a>
                                @endif
                            @endif
                        @endif

                        @if(Helper::isSunday() == true)
                            <a href="{{ route('program_cancel', $program->id) }}" class="cancel btn btn-danger ml-4 mr-4">Cancel</a>
                        @endif

                    </div>
                @endif

            <!-- END program-box -->    
            </div>

        <!-- END p-wrapper -->
        </div>
        @endforeach

        <!-- Start new program button -->
        @if($program->canceled == true || $program->finished == true)
            <div class="text-center mt-5 start-new"><a href="{{ route('program_create') }}" class="btn btn-primary">Start New Program</a></div>
        @endif

        <div id="start_{{ $program->id }}" class="text-center mt-5 d-none start"></div>

    @else
        
        <!-- If user has no programs, show message -->
        <div class="program-box d-flex flex-column mt-5">
            <h3 class="text-center">You have no training programs yet!</h3>
        </div>

    @endif

<!-- END container -->
</div>

@endsection


@section('js')
    
    <script>
        $(document).ready(function() {

            // Initiate tooltip
            $('#refresh').tooltip();

            // Check if progress bar reached end and change color to green
            $('.progress-bar').each(function() {
                $width = $(this).css('width');

                $percent = ( 100 * parseFloat($width) / parseFloat($(this).parent().css('width')) );

                // Checkif progress bar reached 100%
                if($percent == 100) {
                    $(this).css('background-color', 'lawngreen');
     
                    $box = $(this).parents('.program-box');
                    $fin = $(this).parents('.p-wrapper').find('.fin');

                    // Add green border
                    if(!$box.hasClass('finished-border')) {
                        $box.addClass('finished-border');
                    }

                    // Add finished styling before page refresh
                    if($fin.length == false) {
                        $hidden = $(this).parents('.p-wrapper').find('.hidden-status');
                        $hidden.removeClass('d-none');
                        $hidden.addClass('d-flex justify-content-center mt-5');
                        $hidden.html('<span class="pb-status green">FINISHED</span>');
                    }
                    
                    // Hide the refresh button if the program has finished
                    $(this).parents('.program-box').find('.refresh').hide();

                    // Hide the cancel, pause and continue buttons if the program has finished
                    $(this).parents('.program-box').find('.p-buttons').attr('style','display:none !important');   

                    $(this).parents('.program-box').find('.hide-lnk').hide();

                    // Show "Start new program" button before page refresh
                    if($(this)[0] == $('.progress-bar').last()[0]) {
                        if($('.start-new').length === 0) {
                            $('.start').last().removeClass('d-none');
                            $('.start').last().html('<a href="{{ route('program_create') }}" class="btn btn-primary">Start New Program</a>');
                        } 
                    }          
                }
            });
        });
    </script>

@stop

@extends('layouts.debate_tracking')

@section('content')
	<input type="hidden" id="event_type" name="event_type" value="debate_view">
	<input type="hidden" id="event_id" name="event_id" value="{{ $debate->id }}">

    <!-- debate component loading -->
    <debate :debate="{{ $debate }}"></debate>
  	<!-- /.game-wrapper -->

@endsection
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <video src="{{ $video->video_url }}"></video>
        </div>
    </div>
@endsection

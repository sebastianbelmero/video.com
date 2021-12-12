@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @foreach ($videos as $video)
        
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-header {{ $video->watched->Where('user_id', Auth::user()->id)->count() > 0 ? 'bg-success text-white' : '' }}">{{ $video->watched->Where('user_id', Auth::user()->id)->count() > 0 ? 'Ditonton' : 'Belum Ditonton' }}</div>
            <img src="{{ $video->cover_image }}" class="card-img-top" alt="...">
            <div class="card-body">
                <a href="{{ route('video.show', $video->id) }}" class="nav-link">{{ $video->title }}</a>
            </div>
        </div>
    </div>
    @endforeach
    </div>
</div>
@endsection

<?php

namespace App\Http\Controllers;

use App\Models\admin\Category;
use App\Models\admin\Video;
use App\Models\admin\Watched;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\admin\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tonton = false;
        $video = Video::find($id);
        $watched = Watched::Where('user_id', Auth::user()->id)->where('video_id', $id)->first();
        $watched ? $tonton = true : Watched::create([
            'user_id' => Auth::user()->id,
            'video_id' => $id
        ]);
        return view('videos.show', compact('video', 'tonton'));
    }
}

<?php

namespace App\Http\Controllers\Youtub;

use App\Events\VideoViewer;
use App\Http\Controllers\Controller;
use App\Models\Video;

class YoutubController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('verified');
    }

    public function getVideo()
    {
        $video = Video::first();
        event(new VideoViewer($video)); //file event
        return view('youtub.video')->with('video', $video);

    }

}

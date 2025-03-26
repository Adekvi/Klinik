<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class DataVideController extends Controller
{
    public function index()
    {
        $video = Video::all();
        return view('admin.master.datavideo.index', compact('video'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'video' => 'required|file|mimes:mp4,mov,avi,wmv,jpeg,jpg,png|max:102400', // maksimum 100 MB
        ]);

        // Simpan video di dalam folder 'public/videos'
        $videoPath = $request->file('video')->store('videos', 'public');

        // Simpan path video ke dalam basis data
        $video = new Video([
            'title' => $request->title,
            'video_path' => $videoPath,
        ]);
        $video->save();

        return redirect()->route('master.video')->with('toast_success', 'Video Berhasil ditambahkan');
    }
    // public function saveVideo(Request $request)
    // {
    //     // Ambil array videos dari request
    //     $selectedVideos = $request->selectedVideos;
        
    //     // dd($selectedVideos);
    //     // Simpan data dalam session
    //     session(['selectedVideos' => $selectedVideos]);
    //     return response()->json(['selectedVideos' => $selectedVideos]);
    // }

    public function delete($id)
    {
        Video::destroy($id);
        return redirect()->route('master.video', 'id')->with('toast_success', 'Video Berhasil dihapus');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DataVideController extends Controller
{
    public function index()
    {
        $video = Video::all();

        // dd($video);

        return view('admin.master.datavideo.index', compact('video'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'video' => 'required|file|mimes:mp4,mov,avi,wmv,jpeg,jpg,png|max:10400',
        ]);

        // Simpan video di dalam folder 'public/videos'
        $videoPath = $request->file('video')->store('videos', 'public');

        // Simpan path video ke dalam basis data
        $video = new Video([
            'title' => $request->title,
            'video_path' => $videoPath,
            'status' => 'Nonaktif',
        ]);

        $video->save();

        return redirect()->route('master.video')->with('toast_success', 'Video Berhasil ditambahkan');
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'video' => 'nullable|mimes:mp4,mov,avi,flv|max:20480', // Maks 20MB
        ]);

        $video = Video::findOrFail($id);

        // Jika ada file video baru diupload
        if ($request->hasFile('video')) {
            // Hapus video lama dari storage jika ada
            if ($video->video_path && Storage::exists($video->video_path)) {
                Storage::delete($video->video_path);
            }

            // Simpan video baru ke storage/video
            $videoPath = $request->file('video')->store('video', 'public');

            // Update path video di database
            $video->video_path = $videoPath;
        }

        // Update data lainnya
        $video->title = $request->title;
        $video->status = $request->status ?? 'Nonaktif';
        $video->save();

        return redirect()->back()->with('success', 'Video berhasil diperbarui.');
    }

    public function updateStatus(Request $request)
    {
        $videoId = $request->input('id');
        $isChecked = $request->has('status');

        $video = Video::findOrFail($videoId);

        // Ubah status menjadi string sesuai kondisi checkbox
        $video->status = $isChecked ? 'Aktif' : 'Nonaktif';
        $video->save();

        return redirect()->back()->with('status', 'Status video berhasil diperbarui.');
    }

    public function delete($id)
    {
        Video::destroy($id);
        return redirect()->route('master.video', 'id')->with('toast_success', 'Video Berhasil dihapus');
    }
}

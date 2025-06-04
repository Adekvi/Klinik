<?php

namespace App\Http\Controllers\Admin\Pesan;

use App\Http\Controllers\Controller;
use App\Models\Chats;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua user yang bukan diri sendiri
        $users = User::where('id', '!=', auth()->id())->get();

        $search = $request->input('search');
        $entries = $request->input('entries', 10);
        $page = $request->input('page', 1);

        // Query semua pasien
        $query = Chats::with(['user'])
            ->orderBy('urutan', 'asc') // Menambahkan pengurutan berdasarkan urutan
            ->orderBy('created_at', 'asc');

        if ($search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('username', 'LIKE', "%{$search}%");
            });
        }

        // Paginasi dengan jumlah entri yang dipilih
        $pesan = $query->orderBy('id', 'desc')->paginate($entries, ['*'], 'page', $page);

        // Menjaga parameter pencarian tetap ada saat navigasi halaman
        $pesan->appends(['search' => $search, 'entries' => $entries]);

        // Tentukan user yang akan dijadikan penerima chat
        // Misalnya, kita ambil user pertama sebagai contoh (ini bisa disesuaikan)
        $userId = $users->first()->id; // Ambil ID user pertama (atau sesuaikan sesuai kebutuhan)

        // Kirim data pengguna dan user yang bisa dikirim pesan ke view
        return view('admin.rekapan.chat.index', compact('users', 'userId', 'pesan', 'entries', 'search'));
    }

    // Controller Method: fetchMessages
    public function fetchMessages($userId)
    {
        $messages = Chats::where(function ($q) use ($userId) {
            $q->where('sender_id', auth()->id())
                ->where('receiver_id', $userId);
        })->orWhere(function ($q) use ($userId) {
            $q->where('sender_id', $userId)
                ->where('receiver_id', auth()->id());
        })
            ->orderBy('created_at', 'asc')
            ->get();

        foreach ($messages as $message) {
            $message->sender_name = User::find($message->sender_id)->name;
            $message->sender_role = User::find($message->sender_id)->role;
            $message->receiver_name = User::find($message->receiver_id)->name;
            $message->receiver_role = User::find($message->receiver_id)->role;
        }

        return response()->json($messages);
    }

    // Controller Method: sendMessage
    public function sendMessage(Request $request)
    {
        $message = Chats::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        // Menambahkan informasi pengirim dan penerima
        $message->sender_name = User::find($message->sender_id)->name;
        $message->sender_role = User::find($message->sender_id)->role;
        $message->receiver_name = User::find($message->receiver_id)->name;
        $message->receiver_role = User::find($message->receiver_id)->role;

        return response()->json($message);
    }
}

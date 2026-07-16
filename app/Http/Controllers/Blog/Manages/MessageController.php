<?php

namespace App\Http\Controllers\Blog\Manages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;

class MessageController extends Controller
{
    public function index()
    {
        // Route dan nama halaman yang di akses
        $currentLink = route('read');
        $currentTitle = 'Notifikasi';

        $messages = Message::orderBy('created_at', 'desc')->get();
        $unreadCount = Message::where('is_read', false)->count();

        return view('operator.notifikasi', compact('messages', 'unreadCount', 'currentLink', 'currentTitle'));
    }

    public function storeHome(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ],[
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'subject.required' => 'Subject harus diisi',
            'message.required' => 'Pesan harus diisi'
        ]);

        Message::create($request->all());

        return redirect()->route('message.home')->with('success','Pesan anda berhasil dikirim, silahkan menunggu konfirmasi balasan melalui email dari pihak sekolah');
    }

    public function storeInfo(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ],[
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'subject.required' => 'Subject harus diisi',
            'message.required' => 'Pesan harus diisi'
        ]);

        Message::create($request->all());

        return redirect()->route('message.info')->with('success', 'Pesan anda berhasil dikirim.');
    }

    public function markAsRead($id)
    {
        $message = Message::findOrFail($id);
        $message->is_read = true;
        $message->save();

        return redirect()->route('read')->with('success', 'Pesan ' . $message->subject . ' dari ' . $message->name . ' berhasil anda baca');
    }

    public function destroy($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();

        return redirect()->route('read')->with('danger', 'Data pesan masuk dari ' . $message->name . ' berhasil dihapus.');
    }
}

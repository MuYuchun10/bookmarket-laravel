<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('contacts.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:150',
            'message' => 'required|string|max:5000',
        ]);

        $data['user_id'] = $request->user()?->id;

        ContactMessage::create($data);

        return redirect()
            ->route('contacts.index')
            ->with('success', 'Ваше сообщение успешно сохранено!');
    }
}

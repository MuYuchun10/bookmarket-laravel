<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $orders = $user->orders()
            ->with('items')
            ->latest()
            ->get();

        return view('profile.index', compact('user', 'orders'));
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone' => ['nullable', 'string', 'max:30'],
            'city' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string', 'max:255'],
            'postcode' => ['nullable', 'string', 'max:20'],
        ]);

        foreach (['phone', 'city', 'address', 'postcode'] as $field) {
            $data[$field] = $data[$field] ?? '';
        }

        $user->update($data);

        return redirect()
            ->route('profile.index')
            ->with('success', 'Данные успешно сохранены');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 
                'string', 
                'email', 
                'max:255', 
                Rule::unique('clients')->where(function ($query) use ($request) {
                    return $query->where('user_id', auth()->id());
                }),
            ],
            'sex' => ['required', 'string', 'max:255'],
            'birthday' => ['required', 'date'],
        ]);

        $client = new Client([
            'user_id' => $request->user()->id,
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'sex' => $request->input('sex'),
            'birthday' => $request->input('birthday'),
        ]);

        $client->user_id = auth()->id();

        $client->save();

        return redirect()->route('dashboard')->with('status', 'profile-updated');
    }
}

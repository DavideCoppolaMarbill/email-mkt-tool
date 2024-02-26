<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientGroups;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    
    public function getAllClients() {
        $clients = Client::where('user_id', auth()->id())->get();
        return view('dashboard.show', [
            'clients' => $clients,
            'groups' => ClientGroups::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate($this->getClientValidationRules($request));

        $client = new Client([
            'user_id' => auth()->id(),
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'sex' => $request->input('sex'),
            'birthday' => $request->input('birthday'),
        ]);

        $client->save();

        $groupIds = $request->input('group_id');

        if ($groupIds) {
            foreach ($groupIds as $groupId) {
                $client->clientGroups()->attach($groupId);
            }
        }

        return redirect()->route('dashboard')->with('status', 'profile-updated');
    }

    public function destroy(Client $client){
        $client->delete();
        return redirect()->route('dashboard')->with('status', 'profile-updated');
    }

    public function edit(Client $client) {
        return view('dashboard.clients.edit', 
        [
            'client' => $client,
            'groups' => ClientGroups::all(),
        ]);
    }

    public function update(Request $request, Client $client) {
        $request->validate($this->getClientValidationRules($request, $client));
    
        $clientData = $request->only(['first_name', 'last_name', 'email', 'sex', 'birthday']);
        $clientData['user_id'] = auth()->id();
    
        $client->update($clientData);
    
        $groupIds = $request->input('group_id', []);
    
        $client->clientGroups()->sync($groupIds);
    
        return redirect()->route('dashboard')->with('status', 'Client updated successfully');
    }
    

    protected function getClientValidationRules(Request $request, $client = null)
    {
        $rules = [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('clients')->where(function ($query) use ($request) {
                    return $query->where('user_id', auth()->id());
                })->ignore($client ? $client->id : null),
            ],

            'sex' => ['required', 'string', 'max:255'],
            'birthday' => ['nullable', 'date'],
        ];

        return $rules;
    }
}

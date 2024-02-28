<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Client;
use App\Models\ClientGroups;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    
    public function getAllClients() {
        $clients = Client::where('user_id', auth()->id())
        ->orderBy('updated_at', 'desc')
        ->paginate(10);

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
            'sex' => ['string', 'in:male,female,other'],
            'group_id' => ['array', 'valid_group_ids'],
            'birthday' => [
                'nullable',
                'date',
                'before_or_equal:' . Carbon::now()->format('Y-m-d'),
                'after_or_equal:' . Carbon::now()->subYears(100)->format('Y-m-d')
            ],
        ];

        return $rules;
    }
}

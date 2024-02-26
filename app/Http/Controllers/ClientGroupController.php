<?php

namespace App\Http\Controllers;

use App\Models\ClientGroups;
use Illuminate\Http\Request;

class ClientGroupController extends Controller
{
    public function index(){
        $groups = ClientGroups::all();
        return view('dashboard.clients.groups.index', ['groups' => $groups]);
    }

    public function store(Request $request){
        $request->validate([
            'group_name' => ['required','string','max:255', 'unique:groups'],
        ]);

        $group = new ClientGroups([
            'group_name' => $request->input('group_name'),
            'user_id' => auth()->id(),
        ]);

        $group->save();

        return redirect()->route('groups.index')->with('status', 'Group created successfully');
    }

    public function destroy(ClientGroups $group){
        $group->delete();
        return redirect()->route('groups.index')->with('status', 'Group deleted successfully');
    }
}

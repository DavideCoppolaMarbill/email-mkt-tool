<?php

namespace App\Http\Controllers;

use App\Models\ClientGroups;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClientGroupController extends Controller
{
    public function index(){
        $groups = ClientGroups::all();
        return view('dashboard.clients.group.index', ['groups' => $groups]);
    }

    public function store(Request $request){
        $request->validate([
            'group_name' => ['required','string','max:255', Rule::unique('groups', 'group_name')->where('user_id', auth()->id())],
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

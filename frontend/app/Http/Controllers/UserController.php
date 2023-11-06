<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\University;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function insertView(){
        $universities = University::all();
        $roles = Role::all();

        return view('admin.insert-user', compact('universities', 'roles'));
    }

    public function updateView($id){
        $user = User::where('id', $id)->first();
        $universities = University::all();
        $roles = Role::all();

        return view('admin.update-user', compact('user', 'universities', 'roles'));
    }

    public function insertUser(Request $request){
        $validated = $request->validate([
            'username' => 'required',
            'role' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'university' => 'required'
        ]);

        User::create([
            'university_id' => $validated['university'],
            'role_id' => $validated['role'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        return redirect('/');
    }

    public function updateUser(Request $request, $id){
        $validated = $request->validate([
            'username' => 'required',
            'email' => 'required|email',
            'university' => 'required',
            'role' => 'required',
        ]);

        if($request->password == NULL) {
            User::where('id', $id)->update([
                'university_id' => $validated['university'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'role_id' => $validated['role'],
            ]);
        }
        else {
            User::where('id', $id)->update([
                'university_id' => $validated['university'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'role_id' => $validated['role'],
                'password' => $validated['password'],
            ]);
        }

        return redirect('/');
    }

    public function deleteUser($id){
        User::where('id', $id)->delete();
        
        return response()->json(['message' => 'User deleted successfully']);
    }   
}

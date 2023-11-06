<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UniversityController extends Controller
{
    public function universityInsertView(){
        return view('admin.insert-university');
    }

    public function universityUpdateView($id){
        $university = University::where('id', $id)->first();

        return view('admin.update-university', compact('university'));
    }

    public function insertUniversity(Request $request){

        $validated = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'logo' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        $image_name = $validated['name'].'.'.$request->file('logo')->getClientOriginalExtension();
        $path = $request->file('logo')->storeAs('public/asset/logo', $image_name);

        University::create([
            'university_name' => $validated['name'],
            'university_address' => $validated['address'],
            'logo_path' => '/storage/asset/logo/'.$image_name,
        ]);

        return redirect()->intended('/');
    }

    // not done
    public function updateUniversity(Request $request, $id){
        
        $old_img = $request->oldLogo;

        // Get all files in the storage directory
        $files = Storage::files('public/asset/logo');
        $del_file = null;

        foreach ($files as $file) {
            // Check if the substring exists in the file name
            if (strpos($file, $old_img) !== false) {
                $del_file = $file;
            }
        }

        $validated = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'logo' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        if ($del_file != null) {
            Storage::delete($del_file);
        }

        $request->file('logo')->storeAs('public/asset/logo', $validated['name'].'.'.$request->file('logo')->getClientOriginalExtension());

        University::where('id', $id)->update([
            'university_name' => $validated['name'],
            'university_address' => $validated['address'],
            'logo_path' => '/storage/asset/logo/'.$validated['name'].'.'.$request->file('logo')->getClientOriginalExtension(),
        ]);

        return redirect()->intended('/');
    }

    public function deleteUniversity($id) {
        try {
            $university = University::findOrFail($id);

            $logo = $university->logo_path;
            if(Storage::exists($logo)){
                Storage::delete($logo);
            }

            $users = $university->users->pluck('id')->toArray();

            $university->delete();

            return response()->json(['success' => 'University deleted successfully', 'user_ids' => $users]);
        } catch (\Exception $e) {
            Log::error('Error deleting university: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to delete university'], 500);
        }
    }
}

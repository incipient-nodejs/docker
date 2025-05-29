<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Comment;

class MainController extends Controller
{

    public function terms()
    {
        return view('terms');
    }

    public function privacy()
    {
        return view('privacy');
    }

    public function deleteData(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('delete-data');
        }

        $request->validate([ 'name' => 'required|string|max:255', 'phone' => 'required|string|max:20', 'feedback' => 'nullable|string|max:500', ]);
        $user = User::where('name', $request->name)->where('phone', $request->phone)->first();

        if(!isset($user->id)){
            return redirect()->route('delete-data')->with('info', 'Utilizador não encontrado');
        }

        Comment::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'feedback' => $request->feedback,
            'send_data' => now(),
        ]);

        return redirect()->route('delete-data')->with('success', 'Sua conta foi removida com sucesso.');
    }

}


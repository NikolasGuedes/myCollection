<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Console;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;



class CollectionController extends Controller
{

    public function index()
    {

        return Inertia::render('Collection', [
            'consoles' => Console::where('user_id', Auth::id())->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            DB::transaction(function () use ($request) {
                Console::create([
                    'name' => $request['name'],
                    'status' => $request['status'],
                    'picture' => $request->hasFile('picture') ? $request->file('picture')->store('consoles', 'public') : null,
                    'user_id' => Auth::user()->id,
                ]);
            });
        } catch (\Throwable $th) {

            Log::error('Failed to create console: ' . $th->getMessage(), [
                'trace' => $th->getTraceAsString(),
                'user_id' => Auth::id(),
                'request_data' => $request->all()
            ]);

            return redirect()->back()->withErrors([
                'error' => 'Failed to create console: ' . $th->getMessage()
            ]);
        }

        return Inertia::render('Collection', [
            'consoles' => Console::where('user_id', Auth::id())->get()
        ]);
    }
}

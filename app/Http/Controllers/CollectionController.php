<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Console;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;



class CollectionController extends Controller
{

    public function index()
    {
        $consoles = Console::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Collection', [
            'consoles' => $consoles
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
                $pictureUrl = null;
                
                if ($request->hasFile('picture')) {
                    $pictureUrl = $request->file('picture')->store('consoles', 'public');
                }

                Console::create([
                    'name' => $request['name'],
                    'status' => $request['status'],
                    'picture' => $pictureUrl,
                    'user_id' => Auth::user()->id,
                ]);
            });
        } catch (\Throwable $th) {

            Log::error('Failed to create console: ' . $th->getMessage(), [
                'trace' => $th->getTraceAsString(),
                'user_id' => Auth::id(),
                'request_data' => $request->except('picture') // Excluir o arquivo da imagem dos logs
            ]);

            return redirect()->back()->withErrors([
                'error' => 'Failed to create console: ' . $th->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $console = Console::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            // Delete the image file if it exists
            if ($console->picture) {
                Storage::disk('public')->delete($console->picture);
            }

            $console->delete();

            return redirect()->route('collection')->with('success', 'Console deletado com sucesso!');

        } catch (\Throwable $th) {
            Log::error('Failed to delete console: ' . $th->getMessage(), [
                'trace' => $th->getTraceAsString(),
                'user_id' => Auth::id(),
                'console_id' => $id
            ]);

             return Inertia::render('Collection', [
            'consoles' => Console::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get()
        ]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Console;
use App\Models\AllConsole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;



class CollectionController extends Controller
{

    public function index()
    {

        $filters = request()->validate([
            'search' => 'nullable|string|max:255',
        ]);

        $consoles = Console::where('user_id', Auth::id())
            ->when($filters['search'] ?? false, function ($query) use ($filters) {
                $query->where('name', 'like', '%' . $filters['search'] . '%');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $allConsoles = AllConsole::all();

        return Inertia::render('Collection', [
            'consoles' => $consoles->map(function ($console) {
                return [
                    'id' => $console->id,
                    'name' => $console->name,
                    'status' => $console->status,
                ];
            }),
            'allConsoles' => $allConsoles->map(function ($console) {
                return [
                    'id' => $console->id,
                    'name' => $console->name,
                    'picture' => $console->picture,
                    'picture_url' => $console->picture_url,
                ];
            }),
            'search' => $filters['search'] ?? ''
        ]);
    }

    public function update($id, Request $request)
    {

        $request->validate([
            'name' => 'nullable',
            'status' => 'required|string|max:255'
        ]);

        try {
            DB::transaction(function () use ($id, $request) {
                Console::where('id', $id)
                    ->where('user_id', Auth::id())
                    ->update(['status' => $request['status']]);
            });
        } catch (\Throwable $th) {

            Log::error('Failed to create console: ' . $th->getMessage(), [
                'trace' => $th->getTraceAsString(),
                'user_id' => Auth::id(),
                'request_data' => $id->all()
            ]);

            return redirect()->back()->withErrors([
                'error' => 'Failed to create console: ' . $th->getMessage()
            ]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|string|max:255',
        ]);

        try {
            DB::transaction(function () use ($request) {
                // Validar se o console existe na tabela all_consoles
                $allConsole = AllConsole::where('name', $request['name'])->first();

                if (!$allConsole) {
                    throw new \Exception('Console não encontrado na base de dados de consoles disponíveis.');
                }

                Console::create([
                    'name' => $request['name'],
                    'status' => $request['status'],
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
    }

    public function destroy($id)
    {
        try {
            $console = Console::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $console->delete();

            return redirect()->route('collection')->with('success', 'Console deletado com sucesso!');
        } catch (\Throwable $th) {
            Log::error('Failed to delete console: ' . $th->getMessage(), [
                'trace' => $th->getTraceAsString(),
                'user_id' => Auth::id(),
                'console_id' => $id
            ]);

            return redirect()->back()->withErrors([
                'error' => 'Failed to delete console: ' . $th->getMessage()
            ]);
        }
    }
}

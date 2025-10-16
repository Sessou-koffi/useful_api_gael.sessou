<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\User;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function index()
    {
        return response()->json(Module::all());
    }

    public function activate($id)
    {
        $user = auth()->User;
        $module = Module::find($id);

        if (!$module) {
            return response()->json(['error' => 'Module not found'], 404);
        }

        $user->modules()->syncWithoutDetaching([$id => ['active' => true]]);

        return response()->json(['message' => 'Module activated']);
    }

    public function deactivate($id)
    {
        $user = auth()->User;
        $module = Module::find($id);

        if (!$module) {
            return response()->json(['error' => 'Module not found'], 404);
        }

        $user->modules()->updateExistingPivot($id, ['active' => false]);

        return response()->json(['message' => 'Module deactivated']);
    }
}

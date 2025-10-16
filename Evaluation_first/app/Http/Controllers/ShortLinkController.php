<?php

namespace App\Http\Controllers;

use App\Models\ShortLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ShortLinkController extends Controller
{
    // Fonction pour créer un lien court
    public function shorten(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'original_url' => 'required|url',
            'custom_code' => 'nullable|string|max:10|regex:/^[A-Za-z0-9_-]+$/|unique:short_links,code',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = $request->user();

        $code = $request->custom_code ?? Str::random(6);

        $shortLink = ShortLink::create([
            'user_id' => $user->id,
            'original_url' => $request->original_url,
            'code' => $code,
        ]);

        return response()->json($shortLink, 201);
    }

    // Fonction pour lister les liens de l'utilisateur connecté
    public function index(Request $request)
    {
        $links = $request->user()->shortLinks()->get();
        return response()->json($links);
    }

    // Fonction pour supprimer son lien
    public function destroy(Request $request, $id)
    {
        $link = ShortLink::find($id);

        if (!$link) {
            return response()->json(['error' => 'Link not found'], 404);
        }

        if ($link->user_id !== $request->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $link->delete();

        return response()->json(['message' => 'Link deleted successfully']);
    }

    //Redirection sans authentification
    public function redirect($code)
    {
        $link = ShortLink::where('code', $code)->first();

        if (!$link) {
            return response()->json(['error' => 'Link not found'], 404);
        }

        $link->increment('clicks');
        return redirect()->away($link->original_url, 302);
    }
}

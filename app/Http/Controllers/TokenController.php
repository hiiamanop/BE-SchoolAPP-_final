<?php

namespace App\Http\Controllers;

use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class TokenController extends Controller
{
    // Display a listing of tokens
    public function index()
    {
        $tokens = Token::all()->map(function ($token) {
            $token->lifetime = Date::parse($token->lifetime); // Convert to Carbon instance
            return $token;
        });

        return view('tokens.index', compact('tokens'));
    }

    // Show the form for creating a new token
    public function create()
    {
        return view('tokens.create');
    }

    // Store a newly created token in storage
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'value' => 'required|string|max:255',
            'lifetime' => 'required|date',
        ]);

        // Create a new token
        Token::create([
            'value' => $validated['value'],
            'lifetime' => $validated['lifetime'],
        ]);

        return redirect()->route('tokens.index')->with('success', 'Token created successfully.');
    }

    // Show the form for editing the specified token
    public function edit(Token $token)
    {
        return view('tokens.edit', compact('token'));
    }

    // Update the specified token in storage
    public function update(Request $request, Token $token)
    {
        // Validate the request
        $validated = $request->validate([
            'value' => 'required|string|max:255',
            'lifetime' => 'required|date',
        ]);

        // Update the token
        $token->value = $validated['value'];
        $token->lifetime = $validated['lifetime'];
        $token->save();

        return redirect()->route('tokens.index')->with('success', 'Token updated successfully.');
    }

    // Remove the specified token from storage
    public function destroy(Token $token)
    {
        $token->delete();

        return redirect()->route('tokens.index')->with('success', 'Token deleted successfully.');
    }
}

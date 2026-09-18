<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class SearchClientController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q');
        
        $clients = Client::with('user')
            ->where('is_active', true)
            ->when($query, function ($q) use ($query) {
                $q->whereHas('user', function ($q2) use ($query) {
                    $q2->where('name', 'like', "%{$query}%")
                       ->orWhere('email', 'like', "%{$query}%")
                       ->orWhere('phone', 'like', "%{$query}%");
                });
            })
            ->latest()
            ->limit(20)
            ->get()
            ->map(function ($client) {
                return [
                    'id' => $client->id,
                    'name' => $client->user->name,
                    'email' => $client->user->email,
                    'phone' => $client->user->phone,
                    'address' => $client->address,
                ];
            });

        return response()->json($clients);
    }
}

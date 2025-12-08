<?php

namespace App\Http\Controllers;

use App\Models\Client;

class ClientController extends Controller
{
    /**
     * Display the specified client.
     */
    public function show(Client $client)
    {
        return view('clients.show', compact('client'));
    }
}

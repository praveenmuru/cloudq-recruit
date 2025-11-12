<?php
namespace App\Http\Controllers;

use App\Models\ClientRequest;
use Illuminate\Http\Request;

class ClientRequestController extends Controller
{
    public function index()
    {
        $requests = ClientRequest::latest()->paginate(10);
        return view('client_requests.index', compact('requests'));
    }

    public function create()
    {
        return view('client_requests.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
        ]);

        ClientRequest::create($request->all());

        return redirect()->route('client-requests.index')->with('success', 'Client request created successfully.');
    }

    public function edit(ClientRequest $clientRequest)
    {
        return view('client_requests.edit', compact('clientRequest'));
    }

    public function update(Request $request, ClientRequest $clientRequest)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
        ]);

        $clientRequest->update($request->all());

        return redirect()->route('client-requests.index')->with('success', 'Client request updated successfully.');
    }

    public function destroy(ClientRequest $clientRequest)
    {
        $clientRequest->delete();
        return redirect()->route('client-requests.index')->with('success', 'Client request deleted successfully.');
    }
}

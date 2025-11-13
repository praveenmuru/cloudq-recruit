<?php
namespace App\Http\Controllers;

use App\Models\ClientRequest;
use App\Models\Client;
use App\Models\Role;
use App\Models\Skill;
use App\Models\Location;
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


    public function edit(ClientRequest $clientRequest)
    {
        return view('client_requests.edit', compact('clientRequest'));
    }

    public function destroy(ClientRequest $clientRequest)
    {
        $clientRequest->delete();
        return redirect()->route('client-requests.index')->with('success', 'Client request deleted successfully.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_name'        => 'required|string|max:255',
            'role'               => 'required|string|max:255',
            'skills'             => 'nullable|array',
            'skills.*'           => 'string|max:255',
            'locations' => 'nullable|array',
            'locations.*' => 'string|max:255',
        ]);

        // Check if client already exists
        $client = Client::firstOrCreate(
            ['name' => $request->client_name],
            [
                'point_of_contact' => $request->point_of_contact,
                'point_of_contact_number' => $request->point_of_contact_number,
            ]
        );

        $locationIds = [];
        if ($request->locations) {
            foreach ($request->locations as $locName) {
                $location = Location::firstOrCreate(['name' => $locName]);
                $locationIds[] = $location->id;
            }
        }

        $data = $request->all();
        $data['client_id'] = $client->id;
        $role = Role::firstOrCreate(['name' => $request->role]);
        $data['role_id'] = $role->id;
        $data['role'] = $request->role;
        $clientRequest =  ClientRequest::create($data);
        if ($request->skills) {
            $skillIds = [];
            foreach ($request->skills as $skillName) {
                $skill = Skill::firstOrCreate(['name' => $skillName]);
                $skillIds[] = $skill->id;
            }

            $clientRequest->skills()->sync($skillIds);
        }
        $clientRequest->locations()->sync($locationIds);
  

        return redirect()->route('client-requests.index')->with('success', 'Client request created successfully.');
    }

    public function update(Request $request, ClientRequest $clientRequest)
    {


        $request->validate([
            'client_name'        => 'required|string|max:255',
            'role'               => 'required|string|max:255',
            'skills'             => 'nullable|array',
            'skills.*'           => 'string|max:255',
            'locations' => 'nullable|array',
            'locations.*' => 'string|max:255',
        ]);


        $client = Client::firstOrCreate(
            ['name' => $request->client_name],
            [
                'point_of_contact' => $request->point_of_contact,
                'point_of_contact_number' => $request->point_of_contact_number,
            ]
        );

        $data = $request->all();
        $data['client_id'] = $client->id;
        $role = Role::firstOrCreate(['name' => $request->role]);
        $data['role_id'] = $role->id;
        $data['role'] = $request->role;

        $locationIds = [];
        if ($request->locations) {
            foreach ($request->locations as $locName) {
                $location = Location::firstOrCreate(['name' => $locName]);
                $locationIds[] = $location->id;
            }
        }


                // Save skills
        if ($request->skills) {
            $skillIds = [];
            foreach ($request->skills as $skillName) {
                $skill = Skill::firstOrCreate(['name' => $skillName]);
                $skillIds[] = $skill->id;
            }

            $clientRequest->skills()->sync($skillIds);
        }
        $clientRequest->locations()->sync($locationIds);

        $clientRequest->update($data);

        return redirect()->route('client-requests.index')->with('success', 'Client request updated successfully.');
    }
}

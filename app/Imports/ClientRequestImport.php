<?php

namespace App\Imports;

use App\Models\Client;
use App\Models\Role;
use App\Models\Skill;
use App\Models\Location;
use App\Models\ClientRequest;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Throwable;

class ClientRequestImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, SkipsOnError
{
    use Importable, SkipsErrors;

    // number of rows per batch insert (optimisation)
    public function batchSize(): int
    {
        return 100;
    }

    // chunk size for reading
    public function chunkSize(): int
    {
        return 1000;
    }

    /**
     * Map a row into a ClientRequest (and create related models).
     *
     * HeadingRow reads first row and normalizes keys (lowercase, spaces -> _)
     */
    public function model(array $row)
    {
        // Normalize header keys we expect — heading row will convert "Client Name" => client_name
        $clientName = isset($row['client_name']) ? trim($row['client_name']) : null;
        if (!$clientName) {
            return null; // skip rows without client name
        }

        $poc = trim($row['poc'] ?? '');
        $roleName = trim($row['role'] ?? '');
        $positionStatus = trim($row['position_status'] ?? '');
        // keys depending on header normalization — adjust if your headers are different
        $skillsRaw = trim($row['skills_setsrequirements'] ?? $row['skills_sets_requirements'] ?? '');
        $experience = trim($row['experience_yrs'] ?? $row['experience_(yrs)'] ?? $row['experience'] ?? '');
        $locationsRaw = trim($row['location'] ?? '');
        $remarks = trim($row['remarks'] ?? '');
        $panel = trim($row['panel_availability'] ?? '');

        // --- Client: firstOrCreate (case-insensitive)
        $client = Client::firstOrCreate(
            ['name' => $clientName],
            ['point_of_contact' => $poc]
        );

        // --- Role
        $role = null;
        if ($roleName !== '') {
            $role = Role::firstOrCreate(['name' => $roleName]);
        }

        // --- Create client request
        $request = ClientRequest::create([
            'client_id' => $client->id,
            'client_name' => $clientName,
            'point_of_contact' => $poc ?: ($client->point_of_contact ?? null),
            'role_id' => $role ? $role->id : null,
            'role' => $roleName,
            'position_status' => $positionStatus ?: null,
            'skills_sets' => $skillsRaw ?: null,
            'experience' => $experience ?: null,
            'location' => $locationsRaw ?: null,
            'remarks' => $remarks ?: null,
            'panel_availability' => $panel ?: null,
        ]);

        // --- Skills pivot
        if (!empty($skillsRaw)) {
            // handle comma separated list
            $skills = array_filter(array_map('trim', preg_split('/[,;|]+/', $skillsRaw)));
            $skillIds = [];
            foreach ($skills as $s) {
                if ($s === '') continue;
                $skill = Skill::firstOrCreate(['name' => $s]);
                $skillIds[] = $skill->id;
            }
            if (!empty($skillIds)) {
                $request->skills()->sync($skillIds);
            }
        }

        // --- Locations pivot (multi)
        if (!empty($locationsRaw)) {
            $locs = array_filter(array_map('trim', preg_split('/[,;|]+/', $locationsRaw)));
            $locIds = [];
            foreach ($locs as $l) {
                if ($l === '') continue;
                $location = Location::firstOrCreate(['name' => $l]);
                $locIds[] = $location->id;
            }
            if (!empty($locIds)) {
                $request->locations()->sync($locIds);
            }
        }

        return $request;
    }

    /**
     * Handle throwable errors gracefully — SkipsOnError trait takes care of storing them.
     */
    public function onError(Throwable $e)
    {
        // Let SkipsErrors handle it; optionally log
        \Log::error('ClientRequestImport error: '.$e->getMessage());
    }
}

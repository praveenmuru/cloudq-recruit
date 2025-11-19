<?php

namespace App\Imports;

use App\Models\Candidate;
use App\Models\Skill;
use App\Models\Location;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CandidateImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Skip empty rows
            if (empty($row['name'])) continue;

            // Parse combined phone/email field
            $phone = null;
            $email = null;
            if (!empty($row['phone___email'])) {
                [$phone, $email] = $this->extractPhoneEmail($row['phone___email']);
            }

            // --- Handle skills ---
            $skills = $this->processSkills($row['keywords'] ?? '');

            // --- Handle location ---
            $locationId = $this->processSingleLocation($row['location'] ?? null);

            // --- Handle preferred/remote mode ---
            $workType = $this->normalizeWorkType($row['remote_inoffice_hybrid'] ?? 'Hybrid');

            // --- Create candidate ---
            $candidate = Candidate::create([
                'client' => $row['client'] ?? null,
                'date_of_joining' => $row['date'] ?? null,
                'title' => $row['title'] ?? null,
                'name' => $row['name'] ?? null,
                'phone' => $phone,
                'email' => $email,
                'current_company' => $row['current_company'] ?? null,
                'current_role' => $row['current_role'] ?? null,
                'total_exp' => $row['total_exp_yrs'] ?? null,
                'relevant_exp' => $row['relevant_exp_yrs'] ?? null,
                'ctc' => $row['ctc_lpa'] ?? null,
                'ectc' => $row['ectc_lpa'] ?? null,
                'notice_period' => $row['np_days'] ?? null,
                'earliest_availability' => $row['earliest_availability'] ?? null,
                'location_id' => $locationId,
                'work_type' => $workType,
                'reason_for_job_change' => $row['reason_for_job_change'] ?? null,
                'remarks' => $row['remarks'] ?? null,
            ]);

            // --- Attach Skills ---
            $candidate->skills()->sync($skills);
        }
    }

    private function extractPhoneEmail($field)
    {
        $parts = preg_split('/[\/,]/', $field);
        $phone = trim($parts[0] ?? null);
        $email = isset($parts[1]) ? trim($parts[1]) : null;
        return [$phone, $email];
    }

    private function processSkills($skillsString)
    {
        if (!$skillsString) return [];
        $skills = array_map('trim', explode(',', $skillsString));
        $skillIds = [];
        foreach ($skills as $name) {
            if ($name === '') continue;
            $skill = Skill::firstOrCreate(['name' => Str::title($name)]);
            $skillIds[] = $skill->id;
        }
        return $skillIds;
    }

    private function processSingleLocation($name)
    {
        if (!$name) return null;
        $location = Location::firstOrCreate(['name' => Str::title(trim($name))]);
        return $location->id;
    }

    private function normalizeWorkType($value)
    {
        $val = strtolower(trim($value));
        return match (true) {
            str_contains($val, 'remote') => 'Remote',
            str_contains($val, 'office') => 'Inoffice',
            str_contains($val, 'hybrid') => 'Hybrid',
            default => 'Hybrid',
        };
    }
}

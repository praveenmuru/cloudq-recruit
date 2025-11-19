<?php
namespace App\Imports;

use App\Models\Client;
use App\Models\Candidate;
use App\Models\Interview;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class InterviewImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        // Skip header row
        $rows->shift();

        foreach ($rows as $row) {

            if (!$row || !$row[0]) {
                continue;
            }

            // 1. CLIENT
            $client = Client::firstOrCreate(['name' => trim($row[0])]);

            // 2. CANDIDATE
            $candidate = Candidate::firstOrCreate(['name' => trim($row[2])]);

            // 3. Create Interview
            Interview::create([
                'client_id'        => $client->id,
                'candidate_id'     => $candidate->id,
                'role'             => $row[1] ?? null,
                // 'cv_status'        => $row[3] ?? null,
                'interview_date'   => $this->excelDate($row[4]),
                // 'interview_time'   => $row[5],
                'client_round'     => $row[6] ?? null,
                // 'interview_status' => $row[7] ?? null,
                // 'offer_status'     => $row[8] ?? null,
                'offered_salary'   => is_numeric($row[9]) ? $row[9] : null,
                'joining_date'     => $this->excelDate($row[10]),
            ]);
        }
    }

    // handle Excel date formats like 2025-11-20 and N/A
    private function excelDate($value)
    {
        // if (!$value || $value == 'N/A') {
        //     return null;
        // }
        return date('Y-m-d', strtotime($value));
    }
}

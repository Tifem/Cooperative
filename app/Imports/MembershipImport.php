<?php

namespace App\Imports;

use App\Models\Membership;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class MembershipImport implements ToModel, WithBatchInserts, WithHeadingRow, WithChunkReading, WithValidation
{
    // protected $type;
    // protected $classification;

    // protected $subject;

    // function __construct($type,$classification)
    // {
    //     // dd($class,$ca,$subject);
    //     $this->type = $type;
    //     $this->classification = $classification;
    // }

    public function rules(): array
    {
        return [
            //names in the excel
        'name' => 'required|max:500',
        'mem_no' => 'required|numeric',
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            //All Email Validation for Staff
            'firstname.required' => ' Member Name must not be empty!',
            'member_id.numeric'    => 'Member ID must be in numeric format',
        ];
    }

    public function model(array $row)
    {
        // dd($row);
        return new Membership([
            'firstname' => $row['name'], // names in the database table the first (firstname)  // names in the excel inside array[]
            'member_id' => $row['mem_no'],
        ]);
    }

    public function chunkSize(): int
    {
        return 100;
    }

    public function batchSize(): int
    {
        return 1000;
    }
}

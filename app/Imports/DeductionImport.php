<?php

namespace App\Imports;

use App\Models\MonthlyDeduction;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class DeductionImport implements ToModel,WithHeadingRow

{

    protected $deduction;

    public function __construct($deduction)
    {
        // dd($class,$ca,$subject);
        $this->deduction_id = $deduction;
    }

    public function rules(): array
    {
        return [
        'staff_id' => 'required|max:500',
        'amount' => 'required|numeric',
        'date' => 'required|numeric'
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'staff_id.required' => ' Staff Name must not be empty!',
            'amount.required' => 'Amount must not be empty!',
            'date.numeric' => 'Date must be in date format'
        ];
    }
    public function model(array $row)
    {
        // dd($row);
    //    dd($row['staff_id']);
    //    dd('here');
        return new MonthlyDeduction([
            'staff_id' => $row['staff_id'],
            'deduction_id' => $this->deduction_id,
            'amount' => $row['amount'],
            'date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date'])->format('Y-m-d')
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

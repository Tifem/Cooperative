<?php

namespace App\Exports;

use App\Models\Deduction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class DeductionExport implements FromCollection, WithHeadings,WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return Deduction::all();
        return $collection = collect([]);
    }

    public function headings() : array{
        return [
            'S/N',
            'Employee',
            'Deduction',
            'Amount',
            'Date'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 45,
            'C' => 55,
            'D' => 45,
            'C' => 55
        ];
    }

}

<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;


class MembershipExport implements FromCollection, WithHeadings,WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $collection = collect([]);
    }

    public function headings() : array{
        return [
            'S/N',
            'Member ID',
            'Firstname',
            // 'Lastname',
            // 'Othername',
            // 'Phone No',
            // 'Home Address',
            // 'Email',
            // 'Sex',
            // 'Religion',
            // 'Account Number',
            // 'Account Name',
            // 'Bank Name',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 45,
            'C' => 55,
        ];
    }
}

<?php

namespace App\Exports;

use App\TaxDeductionCard;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;

use Illuminate\Support\Facades\Auth;

class EmployeeExport implements FromCollection, WithHeadings, ShouldAutoSize
{

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
      //  return TaxDeductionCard::all();

      $requesst= DB::table('employees')->select('staff_id', 'firstname','lastname', 'othername' )->get();

     return $requesst;

    }

    public function headings() : array{

        return [
            'staff_id',
            'Firstname',
            'Lastname',
            'Othername',
            'Amount',
            'Date'
        ];



    }

    // public function registerEvents(): array
    // {
    //     return [
    //         AfterSheet::class    => function(AfterSheet $event) {
    //             $cellRange = 'A1:W1'; // All headers
    //             $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12);
    //         },
    //     ];


    // }


   }

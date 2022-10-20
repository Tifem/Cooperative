<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Validation\Rule;
use App\Models\MonthlyDeduction;

class TemplateDeduction implements  ToModel,   WithChunkReading
{
    protected $position;
    protected $month;
    protected $account;

    function __construct($position,$month,$account)
    {
        $this->position = $position;
        $this->month = $month;
        $this->account = $account;
        // dd($position,$month,$account);
    }

    // public function rules(): array
    // {
    //   return [
    //     'budget_head'           => ['required', 'max:500', Rule::exists(Account::class, 'gl_name')],
    //     'amount'     => 'required|numeric',
    //     'gl_code'             => [Rule::exists(Account::class, 'gl_code') , 'required'],
    //     ];

    // }

    // public function customValidationMessages(): array
    // {
    //     return [
    //         'budget_head.required'    => ' Budget Head must not be empty!',
    //         'budget_head.exists'    => ' Budget Head is invalid!',
    //         'gl_code.required'    => 'Gl Code must not be empty!',
    //         'gl_code.exists'    => 'Gl Code is invalid',
    //         'amount.required'    => 'Amount column must not be empty',
    //         'amount.numeric'    => 'Amount must be a number',
    //     ];
    // }
    public function model(array $row)
    {
    //    dd(is_int($row[0])) ;

        if (is_int($row[0]) == false || empty($row[$this->position])) {
            return null;
        }
        // dd($this->position);
        return new MonthlyDeduction([
            'member_id'=> $row[2],
            'month'=>  $this->month,
            'glcode'=> $this->account,
            'amount'=> (preg_replace('/[^\d.]/', '',$row[$this->position])),
            // 'amount'=> $row["savings"],
            // 'balance'=> $row["amount"],
        ]);

    }

    public function chunkSize(): int
    {
        return 100;
    }
    // public function batchSize(): int
    // {
    //     return 500;
    // }
}

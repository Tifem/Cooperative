<?php

namespace App\Imports;

// use App\Imports\MemberImport;
use App\Models\Membership;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class MemberImport implements ToModel, WithBatchInserts, WithHeadingRow, WithChunkReading, WithValidation
{
    protected $type;
    protected $classification;

    // protected $subject;

    public function __construct($type, $classification)
    {
        // // dd($class,$ca,$subject);
        // $this->type = $type;
        // $this->classification = $classification;
    }

    public function rules(): array
    {
        return [
        'name' => 'required|max:500',
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            //All Email Validation for Teacher Email
            'asset_name.required' => ' Asset Name must not be empty!',
            // 'asset_type.required'    => 'Asset Type must not be empty!',
            // 'description.required'    => 'Asset Description must be valid!',
            'serial_no.required' => 'Serial no must not be empty!',
            // 'classification.required'    => 'Asset Classification must be valid',
            'purchase_date.numeric' => 'Purchase date must be in date format',
            'amount_purchased.required' => 'Amount purchased is required',
            'amount_purchased.numeric' => 'Amount purchased must be a number',
            'supplier.required' => 'Supplier name must be not br empty',

            // 'percentage.gt'    => 'The percentage must greater than 0',
            // 'percentage.lt'    => 'The percentage must less than 100',
            // 'basic.numeric'    => 'Basic must be a number',
            // 'total.regex'    => 'TOtal must be a number'
        ];
    }

    public function model(array $row)
    {
        // dd($row);
        return new Membership([
            'asset_name' => $row['asset_name'],
            'type_id' => $this->type,
            'description' => $this->classification,
            'serial_no' => $row['serial_no'],
            'classification' => $this->classification,
            'dateofpurchase' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['purchase_date'])->format('Y-m-d'),
            'amount_purchase' => $row['amount_purchased'],
            'supplier_id' => $row['supplier'],
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

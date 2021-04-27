<?php

namespace App\Exports;

use App\Models\CashReceipt;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CashReceiptsExport implements FromCollection, WithMapping,WithHeadings, ShouldAutoSize
{

    protected array $receipts;

    public function __construct(array $receipts)
    {
        $this->receipts = $receipts;
    }

    public function collection()
    {
        return CashReceipt::with('customer', 'user')->find($this->receipts);
    }

    public function map($row): array
    {
        return  [
            $row->date->format('d-m-Y'),
            $row->customer->name,
            $row->amount,
            $row->status,
            $row->user->name,
            $row->created_at->format('d-m-Y H:i:s')
        ];
    }

    public function headings(): array
    {
        return  [
            'Date',
            'Customer',
            'Amount',
            'Status',
            'Posted By',
            'Posted On',
        ];
    }
}

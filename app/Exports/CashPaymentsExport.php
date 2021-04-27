<?php

namespace App\Exports;

use App\Models\CashPayment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CashPaymentsExport implements FromCollection, WithMapping,WithHeadings, ShouldAutoSize
{
    protected array $payments;

    public function __construct(array $payments)
    {
        $this->payments = $payments;
    }

    public function collection()
    {
        return CashPayment::with('supplier', 'user')->find($this->payments);
    }

    public function map($row): array
    {
        return  [
            $row->date->format('d-m-Y'),
            $row->supplier->name,
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
            'Supplier',
            'Amount',
            'Status',
            'Posted By',
            'Posted On',
        ];
    }
}

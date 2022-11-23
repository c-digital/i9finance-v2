<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesOnlineExport implements FromCollection, WithHeadings
{
    public function __construct($sales)
    {
        $this->sales = $sales;
    }

    public function collection()
    {
        $data = [];
        $i = 0;

        foreach ($this->sales as $sale) {
            $data[$i]['date'] = $sale->pos_date;
            $data[$i]['order'] = $sale->pos_id;
            $data[$i]['customer'] = $sale->customer->name;
            $data[$i]['total'] = $sale->posPayment->amount;
            $data[$i]['status'] = $sale->order_status;

            $i++;
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            __('Date'),
            __('Order'),
            __('Customer'),
            __('Total'),
            __('Status')
        ];
    }
}

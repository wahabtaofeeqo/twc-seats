<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class BookersExport implements FromQuery, WithMapping
{
    use Exportable;

    public function query()
    {
        return Booking::query();
    }

    public function map($model): array
    {
        return [
            $model->booker->name,
            $model->booker->email,
            $model->booker->phone,
            $model->code,
            $model->category->name,
            $model->booker->tickets->count() ?? 1,
            Date::dateTimeToExcel($model->created_at),
        ];
    }
}

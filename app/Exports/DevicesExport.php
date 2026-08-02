<?php

namespace App\Exports;

use App\Models\Device;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;

class DevicesExport implements FromCollection, WithHeadings, WithMapping, WithStrictNullComparison, WithTitle
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Device::with(['counter.department', 'deviceType'])->get();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Devices';
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Device Number',
            'IP Address',
            'Device Type',
            'Counter Number',
            'Department',
        ];
    }

    /**
     * @param Device $device
     * @return array
     */
    public function map($device): array
    {
        return [
            $device->id,
            $device->device_number,
            $device->ip,
            $device->deviceType?->name ?? 'N/A',
            $device->counter?->counter_number ?? 'N/A',
            $device->counter?->department?->name ?? 'N/A',
        ];
    }
}

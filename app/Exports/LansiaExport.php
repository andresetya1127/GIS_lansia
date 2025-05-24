<?php

namespace App\Exports;

use App\Models\Lansia;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LansiaExport implements FromCollection, WithHeadings, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Lansia::select(
            'nik',
            'nama',
            'tgl_lahir',
            'umur',
            'provinsi',
            'kabupaten',
            'kecamatan',
            'desa',
            'alamat',
            'rt',
            'rw',
            'lat',
            'lng',
            'status',
        )->get();
    }

    public function headings(): array
    {
        return [
            'NIK',
            'Nama',
            'Tgl Lahir',
            'Umur',
            'Provinsi',
            'Kota/Kabupaten',
            'Kecamatan',
            'Desa/Kelurahan',
            'Alamat',
            'RT',
            'RW',
            'Lat',
            'Lng',
            'Status',
        ];
    }
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
}

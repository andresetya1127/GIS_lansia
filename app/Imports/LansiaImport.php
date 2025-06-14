<?php

namespace App\Imports;

use App\Models\Lansia;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMappedCells;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class LansiaImport implements ToModel, WithStartRow, WithHeadingRow
{
    public function startRow(): int
    {
        return 2;
    }

    /**
     * @param array $rowWW
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        try {
            $data = [
                'nama' => $row['nama_pm'],
                'nik' => $row['nik_pm'],
                'alamat' => $row['alamat'],
                // 'lat'=> $row['lat'],
                // 'lng'=> $row['lng'],
                'tgl_lahir' => $row['tgl_lhr'],
                'provinsi' => $row['provinsi'],
                'kabupaten' => $row['kabupaten'],
                'kecamatan' => $row['kecamatan'],
                'desa' => $row['kelurahan'],
                'rt' => $row['rt'],
                'rw' => $row['rw'],
                'user_id' => Auth::user()->id,
                'status' => 'pending',
            ];
            $validator = Validator::make($data, [
                'nik' => ['unique:lansias,nik'],
                'nama' => ['required'],
            ]);

            if (!$validator->fails()) {
                $location = $this->cordinates($row['kelurahan'] . ',' . $row['kecamatan']);

                if (!empty($location)) {
                    $data['lat'] = $location['lat'];
                    $data['lng'] = $location['lon'];
                }

                return new Lansia($data);
            }
        } catch (\Throwable $th) {
            dd($th);
            return null;
        }
    }

    public function cordinates($query)
    {
        try {
            $json = Http::withHeaders(['User-Agent' => 'WebGis/1.0'])
                ->get('https://nominatim.openstreetmap.org/search?addressdetails=1&q=' . $query . '&format=jsonv2&limit=1');
            return $json->json()[0];
        } catch (\Throwable $th) {
            return [];
        }
    }
}

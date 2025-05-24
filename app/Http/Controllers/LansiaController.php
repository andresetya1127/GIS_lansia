<?php

namespace App\Http\Controllers;

use App\Exports\LansiaExport;
use App\Imports\LansiaImport;
use App\Models\Lansia;
use App\Models\User;
use App\Notifications\LansiaNotif;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class LansiaController extends Controller
{
    public function index(): View
    {
        return view('pages.admin.lansia.index');
    }

    public function edit($id): View
    {
        $data = Lansia::findOrFail($id);
        return view('pages.admin.lansia.edit', compact('data'));
    }

    public function store(Request $request, $id)
    {
        $save = $this->saveLansia($request, $id);
        return response()->json($save, $save['code']);
    }

    public function saveLansia($request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => ['required'],
            'nik' => ['required', 'numeric', 'min:16', Rule::unique('lansias', 'nik')->ignore($id, 'uuid')],
            'alamat' => ['required'],
            'lat' => ['required'],
            'lng' => ['required'],
            'tgl_lahir' => ['required'],
            'umur' => ['required', 'numeric'],
            'provinsi' => ['required'],
            'kabupaten' => ['required'],
            'kecamatan' => ['required'],
            'desa' => ['required'],
            'rt' => ['required', 'numeric'],
            'rw' => ['required', 'numeric'],
            'foto' => ['file', 'mimes:jpeg,jpg,png', 'max:2048'],
        ]);

        if ($validator->fails()) {
            return [
                'status' => 'error',
                'validations' => $validator->errors(),
                'message' => 'Silahkan isi data dengan benar!',
                'code' => 500,
            ];
        }

        try {
            DB::beginTransaction();

            $data = Lansia::findOrFail($id);
            if ($request->hasFile('profile')) {
                $file = $request->file('profile');
                $name = 'lansia-' . time() . '.' . $file->getClientOriginalExtension();
                $path = 'storage/profile';

                $file->move(public_path($path), $name);
                $request->merge(['foto' => $path.'/'.$name]);
            }
            $data->update($request->only('nama', 'nik', 'alamat', 'lat', 'lng', 'tgl_lahir', 'provinsi', 'kabupaten', 'kecamatan', 'umur','desa', 'rt', 'rw', 'user_id', 'status', 'foto'));
            $user = User::role('admin')->get();
            $notif = [
                'title' => 'Lansia baru ditambahkan!',
                'name' => auth()->user()->name,
                'icon' => 'fa-solid fa-users-rays',
                'message' => 'Data lansia berhasil disimpan ke sistem.',
                'url' => route('lansia.detail', $data->uuid),
            ];
            Notification::sendNow($user, new LansiaNotif($notif));
            DB::commit();

            return [
                'url' =>  route('lansia'),
                'status' => 'success',
                'message' => 'Data berhasil disimpan!',
                'code' => 200,
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            return [
                'status' => 'error',
                'message' => $th->getMessage(),
                'code' => 500,
            ];
        }
    }

    public function findLocation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lat' => ['required', 'numeric'],
            'lng' => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            return [
                'status' => 'error',
                'message' => 'Lokasi gagal ditemukan!',
                'code' => 400,

            ];
        }

        $response = Http::withHeaders([
            'User-Agent' => 'WebGis'
        ])->get("https://nominatim.openstreetmap.org/reverse", [
            'lat' => $request->input('lat'),
            'lon' => $request->input('lng'),
            'format' => 'json'
        ]);

        if ($response->failed()) {
            return [
                'status' => 'error',
                'message' => 'Lokasi gagal ditemukan!',
                'code' => 400,
            ];
        }

        $data = $response->json()['address'];
        $data['display_name'] = $response->json()['display_name'];

        return [
            'data' => $data,
            'status' => 'success',
            'message' => 'Lokasi berhasil ditemukan.',
            'target' => 'save',
            'code' => $response->status(),
        ];;
    }

    public function detailResponse($id)
    {
        $data = Lansia::find($id);
        $this->canAccess($data);
        return response()->json($data);
    }

    public function detail($id): View
    {
        $data = Lansia::findOrFail($id);
        $this->canAccess($data);
        return view('pages.admin.lansia.detail', ['data' => $data]);
    }

    public function canAccess($data)
    {
        if ($data->user_id != Auth::user()->id || !auth()->user()->hasRole('admin')) {
            abort(404);
        }
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => ['required', 'mimes:xlsx,xls,csv'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('lansia')->withErrors($validator);
        }

        try {
            $file = $request->file('file');
            Excel::import(new LansiaImport, $file);

            return redirect()->route('lansia')->with('message', 'Data berhasil diimport!');
        } catch (\Throwable $th) {
            return redirect()->route('lansia')->with('message', 'Data gagal diimport!');
        }
    }

    public function export()
    {
        return Excel::download(new LansiaExport, 'lansia.xlsx');
    }
}

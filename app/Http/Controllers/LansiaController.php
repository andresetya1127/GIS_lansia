<?php

namespace App\Http\Controllers;

use App\Models\Lansia;
use App\Models\User;
use App\Notifications\LansiaNotif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class LansiaController extends Controller
{
    public function index(): View
    {
        return view('pages.admin.lansia.index');
    }

    public function create(): View
    {
        return view('pages.admin.lansia.create');
    }

    public function store(Request $request)
    {
        if ($request->input('target') !== 'save') {
            $location = $this->findLocation($request);

            return response()->json($location, $location['code']);
        }


        if ($request->input('target') == 'save') {
            $save = $this->saveLansia($request);
            return response()->json($save, $save['code']);
        }
    }

    public function saveLansia($request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => ['required'],
            'nik' => ['required', 'numeric', 'min:16', 'unique:lansias,nik'],
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
        ]);

        if ($validator->fails()) {
            return [
                'status' => 'error',
                'validations' => $validator->errors(),
                'message' => 'Silahkan isi data dengan benar!',
                'code' => 500,
            ];
        }

        $request->merge([
            'user_id' => Auth::user()->id
        ]);

        try {
            DB::beginTransaction();
            $data = Lansia::create($request->only('nama', 'nik', 'alamat', 'lat', 'lng', 'tgl_lahir', 'umur', 'provinsi', 'kabupaten', 'kecamatan', 'desa', 'rt', 'rw', 'user_id'));
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

    public function findLocation($request)
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

        return [
            'data' =>  view('response.form-location', ['location' => $response->json()])->render(),
            'status' => 'success',
            'message' => 'Lokasi berhasil ditemukan.',
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
}
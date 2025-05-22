<?php

namespace App\Http\Controllers;

use App\Models\Lansia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Spatie\Permission\Middleware\PermissionMiddleware;

class DashboardController extends Controller
{

    protected $modelLansia;
    public function __construct()
    {
        $this->modelLansia = new Lansia();
    }

    public function index()
    {
        if (Auth::user()->hasRole('admin')) {
            $stats = collect([
                'success' => [
                    'title' => 'Dikonfirmasi',
                    'count' => $this->modelLansia::where('status', 'success')->count(),
                    'color' => 'bg-success'
                ],
                'pending' => [
                    'title' => 'Menunggu Konfirmasi',
                    'count' => $this->modelLansia::where('status', 'success')->count(),
                    'color' => 'bg-info'
                ],
                'reject' => [
                    'title' => 'Ditolak',
                    'count' => $this->modelLansia::where('status', 'success')->count(),
                    'color' => 'bg-danger'
                ]
            ]);
        } else {
            $stats = collect([
                'success' => [
                    'title' => 'Dikonfirmasi',
                    'count' => $this->modelLansia::where('status', 'success')->where('user_id', Auth::user()->id)->count(),
                    'color' => 'bg-success'
                ],
                'pending' => [
                    'title' => 'Menunggu Konfirmasi',
                    'count' => $this->modelLansia::where('status', 'success')->where('user_id', Auth::user()->id)->count(),
                    'color' => 'bg-info'
                ],
                'reject' => [
                    'title' => 'Ditolak',
                    'count' => $this->modelLansia::where('status', 'success')->where('user_id', Auth::user()->id)->count(),
                    'color' => 'bg-danger'
                ]
            ]);
        }
        return view('pages.admin.dashboard.index', compact('stats'));
    }

    public function locations()
    {

        if (Auth::user()->hasRole('admin')) {
            $cordinat = Lansia::select('nama', 'status', 'lat', 'lng', 'alamat', 'created_at')->orderBy('created_at', 'desc')->get()->toArray();
        } else {
            $cordinat = Lansia::query()->where('user_id', Auth::user()->id)->select('nama', 'status', 'lat', 'lng', 'alamat', 'created_at')->orderBy('created_at', 'desc')->get()->toArray();
        }
        return response()->json($cordinat);
    }
}

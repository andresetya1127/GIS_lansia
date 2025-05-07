@extends('layout.panel.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <x-base.card>
                <div class="row">
                    <div class="col-12">
                        <h3 class="text-center">Email belum diverifikasi</h3>
                        <p class="text-center">Silahkan verifikasi email anda terlebih dahulu untuk melanjutkan
                            penggunaan aplikasi</p>
                        <div class="d-flex justify-content-center">
                            @session('message')
                                <div class="alert alert-success">
                                    {{ session('message') }}
                                </div>
                            @endsession

                            @empty(session('message'))
                                <form action="{{ route('verification.send') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary text-capitalize">
                                        <i class="fa-solid fa-envelope"></i>
                                        Kirim Ulang Verifikasi
                                    </button>
                                </form>
                            @endempty
                        </div>
                    </div>
                </div>
            </x-base.card>
        </div>
    </div>
@endsection

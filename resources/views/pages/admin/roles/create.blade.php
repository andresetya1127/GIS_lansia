@extends('layout.panel.app')
@section('content')
    <form action="{{ route('role.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12">
                <x-base.card>
                    <div class="row row-cols-1 row-cols-md-2">
                        <x-forms.input :label="'Nama Peran'" name="name" />
                        <x-forms.input :label="'Nama Penjaga'" name="guard" value="web" />
                    </div>

                    <div class="d-flex justify-content-end">
                        <x-actions.button type="submit" :title="'Simpan'" :icon="'fa-save'" />
                    </div>
                </x-base.card>
            </div>
        </div>

        <!-- Permission Message-->
        @error('permissions')
            <div class="row row-col-1">
                <div class="alert alert-danger">
                    {{ $message }}
                </div>
            </div>
        @enderror

        <div class="row mt-3">
            @foreach ($permission as $key => $val)
                <div class="col-12 col-md-4 mb-3">
                    <x-base.card :title="__($key)">
                        <div class="row row-cols-2 row-cols-md-2">
                            @foreach ($val as $v)
                                <x-forms.checkbox :label="__($v->name)" name="permissions[]" value="{{ $v->name }}"
                                    :id="$v->name" />
                            @endforeach
                        </div>
                    </x-base.card>
                </div>
            @endforeach
        </div>

    </form>
@endsection

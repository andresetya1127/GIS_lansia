@extends('layout.panel.app')
@section('content')
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12">
                <x-base.card>
                    <div class="row row-cols-1 row-cols-md-2">
                        <x-forms.input :label="'Nama Pengguna'" name="name" />
                        <x-forms.input :label="'Email'" name="email" type="email" />
                        <x-forms.input :label="'Kata Sandi'" name="password" type="password" />
                        <x-forms.input :label="'konfirmasi Kata Sandi'" name="password_confirmation" type="password" />
                        <x-forms.select placeholder="Pilih Peran" :label="'Peran'" name="roles[]">
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" @selected($role->name == old('roles'))>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </x-forms.select>
                    </div>

                    <div class="d-flex justify-content-end">
                        <x-actions.button type="submit" :title="'Simpan'" :icon="'fa-save'" />
                    </div>
                </x-base.card>
            </div>
        </div>
    </form>
@endsection

@extends('layout.auth.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card-group d-block d-md-flex row">
                <div class="card col-md-5 text-white bg-primary py-5">
                    <div class="card-body text-center">
                        <div>
                            <h2>{{ __('Login') }}</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua.</p>
                            <a href="{{ route('login') }}"
                                class="btn btn-lg btn-outline-light mt-3 text-capitalize">{{ __('login') }}</a>
                        </div>
                    </div>
                </div>
                <div class="card col-md-7 p-4 mb-0">
                    <div class="card-body">
                        <form action="{{ route('auth.store') }}" method="POST">
                            @csrf
                            <h1 class="text-capitalize">{{ __('register') }}</h1>
                            <div class="my-3">
                                <input @class(['form-control', 'is-invalid' => $errors->has('name')]) name="name" type="text"
                                    placeholder="{{ __('name') }}"">
                            </div>

                            <div class="my-3">
                                <input @class(['form-control', 'is-invalid' => $errors->has('email')]) name="email" type="email" placeholder="{{ __('email') }}">
                            </div>

                            <div class="my-3">
                                <input @class(['form-control', 'is-invalid' => $errors->has('password')]) name="password" type="password" placeholder="{{ __('password') }}">
                            </div>

                            <div class="my-3">
                                <input @class(['form-control', 'is-invalid' => $errors->has('password_confirmation')]) name="password_confirmation" type="password" placeholder="{{ __('password confirmation') }}">
                            </div>
                            <div class="text-end">
                                <button class="btn btn-primary px-4 text-capitalize"
                                    type="submit">{{ __('signup') }}</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

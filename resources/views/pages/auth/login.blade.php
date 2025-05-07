@extends('layout.auth.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card-group d-block d-md-flex row">
                <div class="card col-md-7 p-4 mb-0">
                    <div class="card-body">
                        <form action="{{ route('authenticate') }}" method="POST">
                            @csrf
                            <h1>Login</h1>
                            <p class="text-body-secondary">Sign In to your account</p>
                            <div class="input-group mb-3"><span class="input-group-text">
                                    <svg class="icon">
                                        <use xlink:href="{{ asset('dist') }}/vendors/@coreui/icons/svg/free.svg#cil-user">
                                        </use>
                                    </svg></span>
                                <input @class(['form-control', 'is-invalid' => $errors->has('wrong')]) name="email" type="email" placeholder="Email"">
                            </div>

                            <div class="input-group mb-4"><span class="input-group-text">
                                    <svg class="icon">
                                        <use
                                            xlink:href="{{ asset('dist') }}/vendors/@coreui/icons/svg/free.svg#cil-lock-locked">
                                        </use>
                                    </svg></span>
                                <input @class(['form-control', 'is-invalid' => $errors->has('wrong')]) name="password" type="password" placeholder="Password">
                                @error('wrong')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <button class="btn btn-primary px-4" type="submit">Login</button>
                                </div>
                                <div class="col-6 text-end">
                                    <button class="btn btn-link px-0" type="button">Forgot password?</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card col-md-5 text-white bg-primary py-5">
                    <div class="card-body text-center">
                        <div>
                            <h2>Sign up</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua.</p>
                            <a href="{{ route('register') }}" class="btn btn-lg btn-outline-light mt-3">Register
                                Now!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

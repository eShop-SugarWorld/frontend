@extends('layouts.app')


@section('title', 'Login')
@section('additional-css')
    <link rel="stylesheet" href="{{ asset('css/login-page.css') }}">
@endsection

@section('main')

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-12">
                <div class="login-form p-4 rounded">
                    <h2 class="text-center mb-4">Log In</h2>
                    <div class="row">
                        <div class="col-md-6 col-12 mb-4">
                            <form method="POST" class="form-container" action="{{ route('login.submit') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password" required>
                                </div>
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="rememberMe">
                                    <label class="form-check-label" for="rememberMe">Remember me</label>
                                </div>
                                <button type="submit"  class="btn btn-custom w-100">Log in</button>
                                <div class="text-center mt-3">
                                    <small>Don't have an account? <a href="{{ route('registration') }}" class="text-decoration-none">Sign up here</a></small>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 col-12 d-flex align-items-center justify-content-center d-none d-md-flex">
                            <img src="../images/homePage/popularProducts/cake-balls-4139982_640.jpg" alt="Placeholder Image" class="rounded signup-img">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


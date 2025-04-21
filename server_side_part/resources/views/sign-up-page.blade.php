@extends('layouts.app')


@section('title', 'Registration')
@section('additional-css')
    <link rel="stylesheet" href="{{ asset('css/sing-up-page.css') }}">
@endsection
@section('main')

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-12">
                <div class="signup-form p-4 rounded">
                    <h2 class="text-center mb-4">Personal Information</h2>
                    <div class="row">
                        <div class="col-md-6 col-12 mb-4">
                            <div class="form-container">
                                <div class="mb-3">
                                    <label for="firstName" class="form-label">First name</label>
                                    <input type="text" class="form-control" id="firstName" placeholder="Enter your first name">
                                </div>
                                <div class="mb-3">
                                    <label for="lastName" class="form-label">Last name</label>
                                    <input type="text" class="form-control" id="lastName" placeholder="Enter your last name">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" placeholder="Enter your email">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" placeholder="Enter your password">
                                </div>
                                <div class="mb-3">
                                    <label for="confirmPassword" class="form-label">Confirm password</label>
                                    <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm your password">
                                </div>
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="terms">
                                    <label class="form-check-label" for="terms">I agree to the terms of use</label>
                                </div>
{{--                                <a href="{{ route('login') }}" class="btn btn-custom w-100">Create an account</a>--}}
                                <button id="submitBtn" class="btn btn-custom w-100">Create an account</button>
                                <div class="text-center mt-3">
                                    <small>Already have an account? <a href="{{route('login')}}" class="text-decoration-none">Log in here</a></small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 d-flex align-items-center justify-content-center d-none d-md-flex">
                            <img src="../images/homePage/popularProducts/christmas-3865695_640.jpg" alt="Placeholder Image" class="rounded" style="max-width: 100%; height: auto;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        document.getElementById('submitBtn').addEventListener('click', function () {
            if (!document.getElementById('terms').checked) {
                alert('You must agree to the terms of use before proceeding.');
                return;
            }


            const csrfToken = '{{ csrf_token() }}';
            const url = "{{ route('registration') }}";

            const payload = {
                first_name: document.getElementById('firstName').value,
                last_name: document.getElementById('lastName').value,
                email: document.getElementById('email').value,
                password: document.getElementById('password').value,
                password_confirmation: document.getElementById('confirmPassword').value,
            };
            fetch(url, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: JSON.stringify(payload)
            })
                .then(res => res.json().then(data => {
                    if (!res.ok) throw data;
                    return data;
                }))
                .then(data => {
                    if (data.success) {
                        window.location.href = "{{ route('login') }}";
                    } else {
                        alert(data.message || "Registration failed");
                    }
                })
                .catch(err => {
                    if (err.errors) {
                        const messages = Object.values(err.errors).flat().join('\n');
                        alert(messages);
                    } else {
                        alert(err.message || "Something went wrong");
                    }
                    console.error("ERROR:", err);
                });
        });
    </script>
@endsection

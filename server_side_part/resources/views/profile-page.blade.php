@extends('layouts.app')

@section('additional-css')
    <link rel="stylesheet" href="{{ asset('css/profile-page.css') }}">
@endsection

@section('title', 'Profile')


@section('main')
    <div class="container my-5 information ">
        <div class="profile-wrapper">
            <div class="row">

                <input type="radio" name="tab" id="tab1" class="tab-toggle" checked>
                <input type="radio" name="tab" id="tab2" class="tab-toggle">
                <input type="radio" name="tab" id="tab3" class="tab-toggle">

                <div class="col-md-3">
                    <div class="sidebar">
                        <h3 class="mb-4">Account overview</h3>
                        <div class="nav flex-column">
                            <label for="tab1" class="nav-link profile-tab">Profile information</label>
                            <label for="tab2" class="nav-link profile-tab">Change password</label>
                            <label for="tab3" class="nav-link profile-tab">Order history</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="tab-content" id="profile-info">
                        <h2 class="mb-4">Profile information</h2>
                        <form>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="firstName" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="firstName" placeholder="Enter your name" value="{{auth()->user()->info->first_name ?? ''}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="lastName" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="lastName" placeholder="Enter your last name" value="{{ auth()->user()->info->last_name ?? '' }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" placeholder="Enter your email address" value="{{ auth()->user()->email ?? '' }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="country" class="form-label">Country</label>
                                    <input type="text" class="form-control" id="country" placeholder="Enter your country" value="{{ auth()->user()->info->country ?? '' }}">
                                </div>
                            </div>

                            <a href="home-page.html" class="btn btn-custom">Save Changes</a>
                        </form>
                    </div>

                    <div class="tab-content" id="change-password">
                        <h2 class="mb-4">Change password</h2>
                        <form>
                            <div class="mb-3">
                                <label for="oldPassword" class="form-label">Old password</label>
                                <input type="password" class="form-control" id="oldPassword" placeholder="Enter the old password">
                            </div>
                            <div class="mb-3">
                                <label for="newPassword" class="form-label">New password</label>
                                <input type="password" class="form-control" id="newPassword" placeholder="Enter a new password">
                            </div>
                            <div class="mb-3">
                                <label for="repeatPassword" class="form-label">Repeat the new password</label>
                                <input type="password" class="form-control" id="repeatPassword" placeholder="Repeat the new password">
                            </div>
                            <button type="submit" class="btn btn-custom">Change password</button>
                        </form>
                    </div>

                    <div class="tab-content" id="order-history">
                        <h2 class="mb-4">Order history</h2>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Order number</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>№ 12345</td>
                                    <td>17.02.2025</td>
                                    <td>258$</td>
                                    <td>Shipped</td>
                                </tr>
                                <tr>
                                    <td>№ 12346</td>
                                    <td>18.02.2025</td>
                                    <td>150$</td>
                                    <td>In processing</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

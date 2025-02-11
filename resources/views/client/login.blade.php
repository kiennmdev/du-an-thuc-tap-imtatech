@extends('client.layouts.master')

@section('title')
    Login
@endsection

@section('content')
    <!-- Begin Kenne's Breadcrumb Area -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="breadcrumb-content">
                <h2>Đăng nhập</h2>
                <ul>
                    <li><a href="index.html">Trang chủ</a></li>
                    <li class="active">Đăng nhập</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Kenne's Breadcrumb Area End Here -->
    <!-- Begin Kenne's Login Register Area -->
    <div class="kenne-login-register_area">
        <div class="container">
            <div class="d-flex justify-content-center">
                <div class="col-sm-12 col-md-12 col-xs-12 col-lg-6">
                    <!-- Login Form s-->
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="login-form">
                            <h4 class="login-title">Đăng nhập</h4>
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <label>Địa chỉ email*</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}" placeholder="Địa chỉ email" name="email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-12 mb--20">
                                    <label>Mật khẩu</label>
                                    <input type="password" placeholder="Mật khẩu"
                                        class="form-control @error('password') is-invalid @enderror" name="password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-8">
                                    <div class="check-box">
                                        <input type="checkbox" id="remember_me">
                                        <label for="remember_me">Ghi nhớ đăng nhập</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="forgotton-password_info">
                                        <a href="{{route('show.form.forgot')}}"> Quên mật khẩu?</a>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button class="kenne-login_btn" type="submit">Đăng nhập</button>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <div class="text-end">
                                        <p>Bạn chưa có tài khoản ? <a href="{{route('form.register')}}" class="fw-bold text-decoration-underline">Đăng kí</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Kenne's Login Register Area  End Here -->
@endsection

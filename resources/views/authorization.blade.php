@extends('layouts.app')

@section('content')

    @include('includes.header')

    <section id="auth">
        <div class="container">
            <form class="default ajax-form" method="POST" action="{{ route('authorizationAction') }}">
                @csrf
                <h1>Authorization</h1>
                <label>
                    Email<span class="required"></span>
                    <input type="email" name="email" required>
                    <p class="error email-error"></p>
                </label>
                <label>
                    Password<span class="required"></span>
                    <input type="password" name="password" required>
                    <p class="error password-error"></p>
                </label>
                <button type="submit" class="button">
                    Sign in
                </button>
                <p class="info">Not registered yet? <a href="{{ route('registration') }}">Sign up</a></p>
            </form>
        </div>
    </section>

@endsection

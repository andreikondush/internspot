@extends('layouts.app')

@section('content')

    @include('includes.header')

    <section id="auth">
        <div class="container">
            <form class="default ajax-form" method="POST" action="{{ route('registrationAction') }}">
                @csrf
                <h1>Registration</h1>
                <label>
                    First name<span class="required"></span>
                    <input type="text" name="first_name" required autocomplete="off">
                    <p class="error first_name-error"></p>
                </label>
                <label>
                    Last name<span class="required"></span>
                    <input type="text" name="last_name" required autocomplete="off">
                    <p class="error last_name-error"></p>
                </label>
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
                    Sign up
                </button>
                <p class="info">Already have an account? <a href="{{ route('authorization') }}">Sign in</a></p>
            </form>
        </div>
    </section>

@endsection

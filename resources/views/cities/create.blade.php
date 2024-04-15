@extends('layouts.app')

@section('content')

    @include('includes.header')

    <section id="form">
        <div class="container">
            <form class="default ajax-form" method="POST" action="{{ route('cities.createAction') }}">
                @csrf
                <h1>Add city</h1>
                <label>
                    Name<span class="required"></span>
                    <input type="text" name="name" required>
                    <p class="error name-error"></p>
                </label>
                <button type="submit" class="button">Add</button>
            </form>
        </div>
    </section>

@endsection

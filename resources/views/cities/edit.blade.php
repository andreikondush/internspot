@extends('layouts.app')

@section('content')

    @include('includes.header')

    <section id="form">
        <div class="container">
            <form class="default ajax-form" method="POST" action="{{ route('cities.editAction', ['id' => $city->id]) }}">
                @csrf
                <h1>Edit city #{{ $city->id }}</h1>
                <label>
                    Name<span class="required"></span>
                    <input type="text" name="name" required value="{{ ucfirst($city->name) }}">
                    <p class="error name-error"></p>
                </label>
                <button type="submit" class="button">Save</button>
            </form>
        </div>
    </section>

@endsection

@extends('layouts.app')

@section('content')

@include('includes.header')

<section id="preview">

    <video class="background" autoplay muted loop>
        <source src="{{ asset('/assets/video/preview.mp4')  }}" type="video/mp4">
    </video>

    <div class="container">
        <div class="box">
            <h1>Explore and share <br> internships for students</h1>
            <a href="{{ route('internships.list') }}" class="button">
                Begin
            </a>
        </div>
    </div>

</section>

@endsection

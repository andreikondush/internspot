@extends('layouts.app')

@section('content')

    @include('includes.header')

    <section id="form">
        <div class="container">
            <form class="default ajax-form" method="POST" action="{{ route('internships.editAction', ['id' => $internship->id]) }}">
                <h1>Edit internship #{{ $internship->id }}</h1>

                @csrf

                <label>
                    Title<span class="required"></span>
                    <input type="text" name="title" required value="{{ $internship->title }}" autocomplete="off">
                    <p class="error title-error"></p>
                </label>

                <label>
                    Description<span class="required"></span>
                    <textarea name="description" hidden="hidden" autocomplete="off">{!! $internship->description !!}</textarea>
                    <div class="editor">{!! $internship->description !!}</div>
                    <p class="error description-error"></p>
                </label>

                <label>
                    Address<span class="required"></span>
                    <input type="text" name="address" required value="{{ $internship->address }}" autocomplete="off">
                    <p class="error address-error"></p>
                </label>

                <label>
                    City<span class="required"></span>
                    <select name="city" autocomplete="off">
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}"
                                    @if($city->id === $internship->city_id) selected @endif
                            >
                                {{ ucfirst($city->name) }}
                            </option>
                        @endforeach
                    </select>
                    <p class="error city-error"></p>
                </label>

                <div class="d-flex form-box">
                    <label class="left">
                        Company name<span class="required"></span>
                        <select name="company_name" autocomplete="off">
                            @foreach($companies as $company)
                                <option value="{{ $company->name }}"
                                        data-email="{{ $company->email }}"
                                        @if($company->id === $internship->company()->first()->id) selected @endif
                                >
                                    {{ $company->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="error company_name-error"></p>
                    </label>
                    <label class="right">
                        Company email<span class="required"></span>
                        <input type="text" name="company_email" required value="{{ $internship->company()->first()->email }}" autocomplete="off">
                        <p class="error company_email-error"></p>
                    </label>
                </div>

                @php
                    $tags = [];
                    foreach ($internship->tags()->get() as $internshipTag) {
                        $tags[] = $internshipTag->name;
                    }
                @endphp

                <label for="tags">Tags:</label>
                <input class="tags" id="tags" type="text" name="tags" autocomplete="off" value="{{ implode(', ', $tags) }}">

                <button type="submit" class="button">Save</button>
            </form>
        </div>
    </section>

@endsection

@push('styles')
    {{ HTML::style('https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css') }}
@endpush

@push('scripts_header')
    {{ HTML::script('https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js') }}
@endpush

@push('scripts_footer')
    {{ HTML::script('/assets/js/internships/create.js') }}
@endpush

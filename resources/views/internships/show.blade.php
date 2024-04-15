@extends('layouts.app')

@section('content')

    @include('includes.header')

    <section id="show">
        <div class="container">
            <div class="left">

                <div class="item">
                    <h1 class="title">{{ $internship->title }}</h1>
                    <div class="content">
                        {!! $internship->description !!}
                    </div>
                    <div class="panel">
                        <a class="button" href="{{ route('internships.list') }}"><i class="fas fa-chevron-left"></i> Back</a>
                        <ul class="parameters">
                            <li>
                                <i class="fas fa-star-half-alt"></i> <span class="internshipScore">{{ (int)$internship->feedbacks()->avg('score') }}</span>
                            </li>
                            <li>
                                <i class="fas fa-calendar-alt"></i> {{ $internship->created_at->format('d.m.Y') }}
                            </li>
                        </ul>
                    </div>
                </div>

                @if(!$isAdmin)
                    <div class="add_feedback">
                        <h2>Add feedback</h2>
                        <form class="ajax-form" method="POST" action="{{ route('feedbacks.createAction') }}" data-update=".comments">
                            @csrf
                            <input type="text" name="internship_id" value="{{ $internship->id }}" autocomplete="off" hidden="hidden">
                            <label>
                                Text<span class="required"></span>
                                <textarea name="text" autocomplete="off" rows="5"></textarea>
                                <p class="error text-error"></p>
                            </label>
                            <label>
                                Score<span class="required"></span>
                                <input type="range" name="score" autocomplete="off" min="1" max="5" step="1">
                                <p class="current_score"><span></span>/5</p>
                                <p class="error score-error"></p>
                            </label>
                            <button type="submit" class="button">Send</button>
                        </form>
                    </div>
                @endif

                <div class="comments @if($internship->feedbacks()->count() === 0) d-none @endif">
                    <h2>Feedbacks</h2>
                    <ul>
                        @foreach($internship->feedbacks()->orderBy('id', 'desc')->get() as $feedback)
                            <li class="comment" data-id="{{ $feedback->id }}">
                                <div class="name">{{ $feedback->user()->first()->first_name }} {{ $feedback->user()->first()->last_name }}</div>
                                <p class="text">
                                    {!! $feedback->text !!}
                                </p>
                                <div class="rate">{{ $feedback->score }}/5</div>
                                @if($isAdmin or auth('user')->user()->id === $feedback->user()->first()?->id)
                                    <div class="dropdown">
                                        <button class="dropbtn" type="button">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <div class="dropdown-content">
                                            @if(auth('user')->user()->id === $feedback->user()->first()?->id)
                                                <a href="#" onclick="editFeedback(this, event)">Edit</a>
                                            @endif
                                            @if($isAdmin or auth('user')->user()->id === $feedback->user()->first()?->id)
                                                <a class="remove" href="{{ route('feedbacks.deleteAction', ['id' => $feedback->id]) }}">Delete</a>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>

            </div>
            <div class="right">
                <div class="info">
                    <h3>About internship:</h3>
                    <p class="item-info"><span>City:</span>{{ $internship->city()->first()->name }}</p>
                    <p class="item-info"><span>Address:</span>{{ $internship->address }}</p>
                    <p class="item-info"><span>Company:</span>{{ $internship->company()->first()->name }}</p>
                    <p class="item-info"><span>Company email:</span>{{ $internship->company()->first()->email }}</p>
                </div>
                @if($internship->tags()->count() > 0)
                    <ul class="tags">
                        @foreach($internship->tags()->get() as $tag)
                            <li># {{ $tag->name }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </section>

@endsection

@push('scripts_footer')
    {{ HTML::script('/assets/js/internships/show.js') }}
@endpush

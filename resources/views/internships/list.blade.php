@extends('layouts.app')

@section('content')

    @include('includes.header')

    <section id="list">
        <div class="container">
            <div class="row">
                <h1>Internships</h1>
                @if(!$isAdmin)
                    <a class="button" href="{{ route('internships.create') }}">Create</a>
                @endif
            </div>
            <div class="row">
                <div id="result-search" class="left">
                    @if($internships->count() > 0)
                        <table>
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th class="cursor-pointer"
                                        @if(request()->get('sort_by_score') === 'asc' or request()->get('sort_by_score') === 'desc')
                                            data-sort="{{ request()->get('sort_by_score') }}"
                                        @else
                                            data-sort="default"
                                        @endif
                                        data-type="score"
                                        onclick="sort(this);"
                                    >
                                        Score
                                        <div class="sort_button">
                                            <i class="fas fa-caret-left top @if(request()->get('sort_by_score') === 'desc') active @endif"></i>
                                            <i class="fas fa-caret-right bottom @if(request()->get('sort_by_score') === 'asc') active @endif"></i>
                                        </div>
                                    </th>
                                    <th class="cursor-pointer"
                                        @if(request()->get('sort_by_feedbacks') === 'asc' or request()->get('sort_by_feedbacks') === 'desc')
                                            data-sort="{{ request()->get('sort_by_feedbacks') }}"
                                        @else
                                            data-sort="default"
                                        @endif
                                        data-type="feedbacks"
                                        onclick="sort(this);"
                                    >
                                        Feedbacks
                                        <div class="sort_button">
                                            <i class="fas fa-caret-left top @if(request()->get('sort_by_feedbacks') === 'desc') active @endif"></i>
                                            <i class="fas fa-caret-right bottom @if(request()->get('sort_by_feedbacks') === 'asc') active @endif"></i>
                                        </div>
                                    </th>
                                    <th class="cursor-pointer"
                                        @if(request()->get('sort_by_date') === 'asc' or request()->get('sort_by_date') === 'desc')
                                            data-sort="{{ request()->get('sort_by_date') }}"
                                        @else
                                            data-sort="default"
                                        @endif
                                        data-type="date"
                                        onclick="sort(this);"
                                    >
                                        Date
                                        <div class="sort_button">
                                            <i class="fas fa-caret-left top @if(request()->get('sort_by_date') === 'desc') active @endif"></i>
                                            <i class="fas fa-caret-right bottom @if(request()->get('sort_by_date') === 'asc') active @endif"></i>
                                        </div>
                                    </th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($internships as $internship)
                                    <tr>
                                        <td>{{ $internship->title }}</td>
                                        <td>{{ (int)$internship->feedbacks()->avg('score') }}</td>
                                        <td>{{ $internship->feedbacks()->count() }}</td>
                                        <td>{{ $internship->created_at->format('d.m.Y') }}</td>
                                        <td width="5%">
                                            <div class="dropdown">
                                                <button class="dropbtn" type="button">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <div class="dropdown-content">
                                                    <a href="{{ route('internships.show', ['id' => $internship->id]) }}">Show</a>
                                                    @if(auth('user')->user()->id === $internship->user()->first()?->id)
                                                        <a href="{{ route('internships.edit', ['id' => $internship->id]) }}">Edit</a>
                                                    @endif
                                                    @if($isAdmin or auth('user')->user()->id === $internship->user()->first()?->id)
                                                        <a class="remove" href="{{ route('internships.deleteAction', ['id' => $internship->id]) }}">Delete</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="empty">No internships records found. @if(!$isAdmin)Would you like to <a href="{{ route('internships.create') }}">create</a> a internship?@endif</p>
                    @endif
                    @if ($internships->lastPage() > 1)
                        {{ $internships->links('includes.pagination') }}
                    @endif
                </div>
                <div class="right">
                    <form class="search" method="GET" action="{{ route('internships.list') }}" autocomplete="off" enctype="multipart/form-data">

                        <input name="sort_by_score" autocomplete="off" hidden="hidden">
                        <input name="sort_by_feedbacks" autocomplete="off" hidden="hidden">
                        <input name="sort_by_date" autocomplete="off" hidden="hidden">

                        <label>
                            <input type="text" name="search" autocomplete="off" placeholder="Search...">
                        </label>

                        <label>
                            <select name="city" autocomplete="off">
                                <option></option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}">{{ ucfirst($city->name) }}</option>
                                @endforeach
                            </select>
                        </label>

                        <label>
                            <select name="company" autocomplete="off">
                                <option></option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ ucfirst($company->name) }}</option>
                                @endforeach
                            </select>
                        </label>

                        <label>
                            <select name="tags[]" multiple="multiple">
                                @foreach($tags as $tag)
                                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                @endforeach
                            </select>
                        </label>

                    </form>
                </div>
            </div>
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
    {{ HTML::script('/assets/js/internships/list.js') }}
@endpush

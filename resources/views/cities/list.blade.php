@extends('layouts.app')

@section('content')

    @include('includes.header')

    <section id="list">
        <div class="container">
            <div class="row">
                <h1>Cities</h1>
                <a class="button" href="{{ route('cities.create') }}">Add</a>
            </div>
            <div class="row">
                <div id="result-search" class="left">
                    @if($cities->count() > 0)
                        <table>
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($cities as $city)
                                    <tr>
                                        <td>{{ ucfirst($city->name) }}</td>
                                        <td width="5%">
                                            <div class="dropdown">
                                                <button class="dropbtn" type="button">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <div class="dropdown-content">
                                                    <a href="{{ route('cities.edit', ['id' => $city->id]) }}">Edit</a>
                                                    <a class="remove" href="{{ route('cities.deleteAction', ['id' => $city->id]) }}">Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="empty">No city records found. Would you like to <a href="{{ route('cities.create') }}">add</a> a city?</p>
                    @endif
                    @if ($cities->lastPage() > 1)
                        {{ $cities->links('includes.pagination') }}
                    @endif
                </div>
                <div class="right">
                    <form class="search" method="GET" action="{{ route('cities.list') }}">
                        <label>
                            <input type="text" name="search" autocomplete="off" placeholder="Search...">
                        </label>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

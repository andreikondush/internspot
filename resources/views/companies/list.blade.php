@extends('layouts.app')

@section('content')

    @include('includes.header')

    <section id="list">
        <div class="container">
            <div class="row">
                <h1>Companies</h1>
            </div>
            <div class="row">
                <div id="result-search" class="left">
                    @if($companies->count() > 0)
                        <table>
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($companies as $company)
                                <tr>
                                    <td>{{ $company->name }}</td>
                                    <td>{{ $company->email }}</td>
                                    <td width="5%">
                                        <div class="dropdown">
                                            <button class="dropbtn" type="button">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <div class="dropdown-content">
                                                <a class="remove" href="{{ route('companies.deleteAction', ['id' => $company->id]) }}">Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="empty">No companies records found.</p>
                    @endif
                    @if ($companies->lastPage() > 1)
                        {{ $companies->links('includes.pagination') }}
                    @endif
                </div>
                <div class="right">
                    <form class="search" method="GET" action="{{ route('companies.list') }}">
                        <label>
                            <input type="text" name="search" autocomplete="off" placeholder="Search...">
                        </label>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

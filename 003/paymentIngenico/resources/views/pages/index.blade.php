@extends('layouts.main')
@section('content')
    <div class="container-fluid">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
        @include('components.nav')
        </nav>
        <div class="col-md-9 ml-sm-auto col-lg-10 px-4">
        @include('components.transactions')
        </div>
    </div>
@endsection


<!-- resources/views/errors/500.blade.php -->
@extends('errors.error')
@section('content')
    <div class="container">
        <div class="alert alert-danger">
            <h3>Internal Server Error</h3>
            <p>Sorry, there was an internal server error. Please try again later.</p>
            @if(app()->bound('exception') && $exception->getMessage())
                <p>Error Message: {{ $exception->getMessage() }}</p>
            @endif

            @if(config('app.debug') && app()->bound('exception'))
                <h4>Debug Information:</h4>
                <pre>{{ $exception }}</pre>
            @endif
        </div>
    </div>
@endsection

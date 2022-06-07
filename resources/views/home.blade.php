@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @role('admin')
                    Anda login sebagai Admin
                    @endrole
                    @role('author')
                    Anda login sebagai Author
                    @endrole
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Post</div>

                <div class="card-body">
                    <form method="post" action="{{ route('post.store') }}">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="users_id" id="users_id" value="{{ Auth::user()->id }}">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Title</label>
                            <input class="form-control" name="title" id="title" type="text" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Content</label>
                            <textarea class="form-control" name="content" id="content" cols="30" rows="10"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="exampleFormControlInput1">Date</label>
                            <input class="form-control" name="date" id="date" type="date" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

@endsection

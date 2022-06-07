@extends('layouts.app')

@section('css')

@endsection

@section('content')
    <div class="card shadow mb-4 mt-3">
        <div class="card-header py-3">
            <div class="row">
                <div class="col d-flex align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Data Post</h6>
                </div>
                <div class="col">
                    <div class="text-right">
                        @can('post-create')                            
                        <a class="btn btn-primary btn-sm" href="#" onclick="add()" type="button" data-toggle="modal" data-target="#tambah-post">
                            Tambah Post <i class="fas fa-plus fa-sm fa-fw text-gray-400"></i>
                        </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-success text-white">
                        <tr>
                            <th>No</th>
                            <th>Title</th>
                            <th>Content</th>
                            <th>Date</th>
                            <th>Author</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($post as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><b>{{ $item->title }}</b></td>
                                <td>{{ $item->content }}</td>
                                <td>{{ $item->date }}</td>
                                <td>{{ $item->users->name }}</td>
                                <td>
                                    <div class="row d-flex justify-content-center">
                                        @can('post-edit')    
                                        <div class="col-lg">
                                            <a type="button" onclick="edit({{ json_encode($item) }})" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#tambah-post"><i class="fas fa-edit"></i></a>
                                        </div>
                                        @endcan
                                        @can('post-delete')                                            
                                        <div class="col-lg">
                                            <a type="button" data-toggle="modal" data-target="#modal-hapus{{ $item->id }}" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>                                            
                                        </div>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="tambah-post" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
            <div class="modal-body">
                <form id="modal_form">
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="users_id" id="users_id" value="{{ Auth::user()->id }}">
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Title</label>
                        <input class="form-control" name="title" id="title" type="text" placeholder="Title" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Content</label>
                        <textarea name="content" id="content" class="form-control" cols="30" rows="10" placeholder="Content"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Date</label>
                        <input type="date" name="date" id="date" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Author</label>
                        <input class="form-control" name="author" id="author" type="text" placeholder="Author" value="{{ Auth::user()->name }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a type="button" onclick="store()" id="store" class="btn btn-primary">Submit</a>
                    <a type="button" onclick="update()" id="update" class="btn btn-primary">Save</a>
                </div>
            </form>
        </div>
        </div>
    </div>
    @foreach ($post as $item)       
    <!-- Modal -->
    <div class="modal fade" id="modal-hapus{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Hapus Data Post</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                Apakah anda yakin?
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" onclick="destroy({{$item->id}})" class="btn btn-danger">Delete</button>
            </div>
        </div>
        </div>
    </div>
    @endforeach
@endsection

@section('script')
    <script>
        function add() {
            $('#exampleModalLabel').text('Tambah Post');
            $('#modal_form').trigger("reset");
            $("#store").show();
            $("#update").hide();
        }

        function edit(data) {
            $('#exampleModalLabel').text('Edit Post');
            $('#modal_form').trigger("reset");
            $('#id').val(data.id);
            $('#users_id').val(data.users_id);
            $('#title').val(data.title);
            $('textarea#content').val(data.content);
            $('#date').val(data.date);
            $('#author').val(data.users.name);
            $("#store").hide();
            $("#update").show();
        } 

        function store() {
            var users_id = $('#users_id').val();
            var title = $('#title').val();
            var content = $('textarea#content').val();
            var date = $('#date').val();
            var form_data = new FormData();
            form_data.append('_token', '{{ csrf_token() }}');
            form_data.append('title', title);
            form_data.append('content', content);
            form_data.append('date', date);
            form_data.append('users_id', users_id);
            $.ajax({
                type: "POST",
                url: "{!! route('post.store') !!}",
                data: form_data,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if(data["status"] == "success") {            
                        toastr.success(data["message"]);
                        setTimeout(function(){ 
                            window.location = "{{ route('post.index') }}";
                        }, 500);            
                    }else {
                        toastr.error(data["message"]);
                    }
                },
                error: function(error) {
                    toastr.error(error);
                }
            });            
        }

        function destroy(id) {
            $.ajax({
                type: "POST",
                url: "post/"+id,
                data: {
                        '_token' : '{{ csrf_token() }}',
                        _method: 'DELETE',
                        id: id,
                    },
                dataType: "json",
                success: function (data) {
                    toastr.success(data["message"]);
                    setTimeout(function(){ 
                        window.location = "{{ route('post.index') }}";
                    }, 500);
                },
                error: function(error) {
                    toastr.error(data["message"]);
                }
            });
        }

        function update() {
            var id = $('#id').val();
            var users_id = $('#users_id').val();
            var title = $('#title').val();
            var content = $('textarea#content').val();
            var date = $('#date').val();
            $.ajax({
                type: "put",
                url: "{!! route('post.update',["id"]) !!}",
                data: {
                    '_token' : '{{ csrf_token() }}',
                    'id' : id,
                    'users_id' : users_id,
                    'title' : title,
                    'content' : content,
                    'date' : date,
                },
                dataType: "json",
                success: function (data) {
                    if(data["status"] == "success") {            
                        toastr.success(data["message"]);
                        setTimeout(function(){ 
                            window.location = "{{ route('post.index') }}";
                        }, 500);            
                    }else {
                        toastr.error(data["message"]);
                    }
                },
                error: function(error) {
                    toastr.error(error);
                }
            });
        }
    </script>
@endsection
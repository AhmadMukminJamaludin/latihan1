@extends('layouts.app')

@section('content')
    <div class="card shadow mb-4 mt-3">
        <div class="card-header py-3">
            <div class="row">
                <div class="col d-flex align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Manajemen Pengguna</h6>
                </div>
                <div class="col">
                    <div class="text-right">
                        @can('manajemen-pengguna-create')                            
                        <a class="btn btn-primary btn-sm" href="#" type="button" onclick="add()" data-toggle="modal" data-target="#tambah-pengguna">
                            Tambah Pengguna <i class="fas fa-plus fa-sm fa-fw text-gray-400"></i>
                        </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-stripped" width="100%" cellspacing="0">
                    <thead class="bg-success text-white">
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>Nama Pengguna</th>
                            <th>Email</th>
                            <th>Role</th>
                            @can('manajemen-pengguna-list')                                
                            <th>Aksi</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengguna as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->username }}</td>
                                <td>{{ $item->email }}</td>
                                <td>
                                    @if ($item->hasRole('admin'))
                                        <span class="badge badge-primary">Admin</span>
                                    @else
                                        <span class="badge badge-info">Author</span>
                                    @endif
                                </td>
                                @can('manajemen-pengguna-list')                                    
                                <td>
                                    <div class="row d-flex justify-content-center">                                          
                                        @can('manajemen-pengguna-edit')                                            
                                        <div class="col-lg">
                                            <a type="button" onclick="edit({{ json_encode($item) }})" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#tambah-pengguna"><i class="fas fa-edit"></i></a>
                                        </div>                                            
                                        @endcan
                                        @can('manajemen-pengguna-delete')                                            
                                        <div class="col-lg">
                                            <a type="button" data-toggle="modal" data-target="#modal-hapus{{ $item->id }}" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>                                             
                                        </div>
                                        @endcan
                                    </div>
                                </td>
                                @endcan
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<!-- Modal -->
<div class="modal fade" id="tambah-pengguna" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambah Pengguna</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
        <div class="modal-body">
            <form id="modal_form">
                <input type="hidden" name="id" id="id">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Nama Lengkap</label>
                    <input class="form-control" type="text" name="name" id="name" placeholder="Nama Lengkap" required>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Nama Pengguna</label>
                    <input class="form-control" type="text" name="username" id="username" placeholder="Nama Pengguna" required>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Email</label>
                    <input class="form-control" type="email" name="email" id="email" placeholder="Email Pengguna">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Role</label>
                    <select name="roles" id="roles" class="form-control">
                        <option value="admin">Admin</option>
                        <option value="author">Author</option>
                    </select>
                </div>
                <div class="form-group" id="form-password">
                    <label for="exampleFormControlInput1">Password</label>
                    <input class="form-control" type="password" id="password" placeholder="Password Pengguna" required>
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

@foreach ($pengguna as $item)       
<!-- Modal -->
<div class="modal fade" id="modal-hapus{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Hapus Data Pengguna</h5>
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
        $('#exampleModalLabel').text('Tambah Pengguna');
        $('#modal_form').trigger("reset");
        $("#store").show();
        $("#form-password").show();
        $("#update").hide();
    }

    function edit(data) {
        $('#exampleModalLabel').text('Edit Pengguna');
        $('#modal_form').trigger("reset");
        $('#id').val(data.id);
        $('#name').val(data.name);
        $('#username').val(data.username);
        $('#email').val(data.email);
        $('#roles').val(data.roles);
        // $('#password').val(data.password);
        $("#store").hide();
        $("#form-password").hide();
        $("#update").show();
    }

    function store() {
        var name = $('#name').val();
        var username = $('#username').val();
        var email = $('#email').val();
        var roles = $("#roles").val();
        var password = $('#password').val();
        var form_data = new FormData();
        form_data.append('_token', '{{ csrf_token() }}');
        form_data.append('name', name);
        form_data.append('username', username);
        form_data.append('email', email);
        form_data.append('roles', roles);
        form_data.append('password', password);
        $.ajax({
            type: "POST",
            url: "{!! route('manajemen-pengguna.store') !!}",
            data: form_data,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if(data["status"] == "success") {            
                    toastr.success(data["message"]);
                    setTimeout(function(){ 
                        window.location = "{{ route('manajemen-pengguna.index') }}";
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
            type: "delete",
            url: "{!! route('manajemen-pengguna.destroy',["id"]) !!}",
            data: {
                '_token' : '{{ csrf_token() }}',
                _method: 'DELETE',
                id: id,
            },
            dataType: "json",
            success: function (data) {
                if(data["status"] == "success") {            
                    toastr.success(data["message"]);
                    setTimeout(function(){ 
                        window.location = "{{ route('manajemen-pengguna.index') }}";
                    }, 500);            
                }else {
                    toastr.error(data["message"]);
                }
            }
        });
    }

    function update() {
        var id = $('#id').val();
        var name = $('#name').val();
        var username = $('#username').val();
        var email = $('#email').val();
        var roles = $("#roles").val();
        var password = $('#password').val();
        $.ajax({
            type: "put",
            url: "{!! route('manajemen-pengguna.update',["id"]) !!}",
            data: {
                '_token' : '{{ csrf_token() }}',
                'id' : id,
                'name' : name,
                'username' : username,
                'email' : email,
                'roles' : roles,
                'password' : password,
            },
            dataType: "json",
            success: function (data) {
                if(data["status"] == "success") {            
                    toastr.success(data["message"]);
                    setTimeout(function(){ 
                        window.location = "{{ route('manajemen-pengguna.index') }}";
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

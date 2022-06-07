@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Post</div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="text-right">                                   
                            <a href="{{ route('post.create') }}" class="btn btn-success">Tambah Post</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-stripped" id="dataTable" width="100%" cellspacing="0">
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
                                        <td>{{ $item->title }}</td>
                                        <td>{{ $item->content }}</td>
                                        <td>{{ $item->date }}</td>
                                        <td>{{ $item->users->name }}</td>
                                        <td>
                                            <div class="row d-flex justify-content-center">                                                
                                                <div class="col-lg">
                                                    <a href="{{ route('post.edit',["$item->id"]) }}" class="btn btn-warning btn-sm">Edit</a>
                                                </div>                                                   
                                                <div class="col-lg">
                                                    <a type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal-hapus{{ $item->id }}">Hapus</a>                                            
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@foreach ($post as $item)       
    <!-- Modal -->
    <div class="modal fade" id="modal-hapus{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hapus Data post</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    Apakah anda yakin?
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <form action="{{ route('post.destroy',["$item->id"]) }}" method="post">
                                        
                    @csrf
                    @method("delete")
                    <button type="submit" class="btn btn-danger">Hapus</button>
                    
                </form>
            </div>
          </div>
        </div>
      </div>
@endforeach
@endsection

@section('script')
<script>
    function destroy(id) {
        console.log(id);
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
                    window.location.replace = "{{ route('post.index') }}";
                },
            });
        }
</script>
@endsection

@extends('admin.layouts/verticalLayoutMaster')

@section('title', 'Home')

@section('content')
    <!-- Page layout -->
    <div class="card">
        
        <div class="card-header">
            <h4 class="card-title">All Books List</h4>
        </div>

        <div class="col-md-12 text-right">
            <a href="{{ route('admin.books.add') }}" class="btn btn-primary">Add Books</a>
        </div>

        {{-- image expand modal start --}}
        <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imageModalLabel">Book Image</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <img id="modal-image" src="" alt="Book Image" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
        {{-- image expand modal ends --}}



        <div class="card-body">

            <section id="ajax-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-datatable">
                                <table class="datatables-ajax table" id="BookTable" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Title</th>
                                            <th>Images</th>
                                            <th>Description</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>

@endsection
@section('page-script')

    <script>
        $(function() {
            var BookTable = $('#BookTable');
            BookTable.DataTable().clear().destroy();

            BookTable.DataTable({
                serverSide: true,
                processing: true,
                searching: true,
                order: [],

                ajax: {
                    url: "{{ route('admin.books.data') }}",
                    type: "GET",
                    data: {
                        "_token": "{{ csrf_token() }}"
                    }
                },

                "columns": [{
                        data: 'id'
                    },
                    {
                        data: 'title'
                    },
                    {
                        data: 'images'
                    },
                    {
                        data: 'description'
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'actions'
                    }
                ]
            });

        });

        //image expand show
        $(document).on('click', '.open-image-modal', function() {
            var imageSrc = $(this).data('image');
            $('#modal-image').attr('src', imageSrc);
            $('#imageModal').modal('show');
        });
    </script>
@endsection

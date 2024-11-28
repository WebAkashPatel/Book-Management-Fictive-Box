@extends('admin.layouts/verticalLayoutMaster')

@section('title', 'Home')

@section('content')
    <!-- Page layout -->
    <div class="card">
        
        <div class="card-header">
            <h4 class="card-title">All Feedback List</h4>
        </div>

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
                                            <th>Book Title</th>
                                            <th>Username</th>
                                            <th>Comment</th>
                                            <th>Rating Point</th>
                                            <th>Comment Date</th>
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
                    url: "{{ route('admin.feedback.data') }}",
                    type: "GET",
                    data: {
                        "_token": "{{ csrf_token() }}"
                    }
                },

                "columns": [{
                        data: 'id'
                    },
                    {
                        data: 'book_title'
                    },
                    {
                        data: 'username'
                    },
                    {
                        data: 'comment'
                    },
                    {
                        data: 'rating'
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

@extends('layouts.backendapp')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row justify-content-center">
            <div class="col-md-12 order-0 mb-4">
                <div class="card">
                    <h5 class="card-header">Uploded File Report</h5>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table" id="datatableReport">
                                <thead>
                                    <tr>
                                        <th>Sl.</th>
                                        <th>File</th>
                                        <th>Total</th>
                                        <th>Store</th>
                                        <th>Duplicate</th>
                                        <th>Invalid</th>
                                        <th>Incomplete</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#datatableReport').DataTable({

                ajax: {
                    url: '{{ route('uploaded.csvfile.report.datatable') }}',
                    type: 'GET',
                },
                columns: [{
                        data: 'DT_RowIndex',
                    },
                    {
                        data: 'file_name',
                        name: 'file_name'
                    },
                    {
                        data: 'total_data',
                        name: 'total_data'
                    },
                    {
                        data: 'total_store',
                        name: 'total_store'
                    },
                    {
                        data: 'total_duplicate',
                        name: 'total_duplicate'
                    },
                    {
                        data: 'total_invalid',
                        name: 'total_invalid'
                    },
                    {
                        data: 'total_incomplete',
                        name: 'total_incomplete'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    }
                ]
            });
        });
    </script>
@endsection

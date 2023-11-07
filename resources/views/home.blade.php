@extends('layouts.backendapp')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row justify-content-center">
            <!-- Order Statistics -->
            <div class="col-md-8 order-0 mb-4">
                <div class="card">
                    <h5 class="card-header">Upload Csv File</h5>
                    <div class="card-body demo-vertical-spacing demo-only-element">

                        <div class="mb-3">
                            <label class=" col-form-label" for="basic-default-name">Upload</label>
                            <input type="file" class="form-control" id="inputGroupFile01" name="csvFile">
                        </div>

                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </div>
            </div>
            <!--/ Order Statistics -->

        </div>
    </div>
@endsection

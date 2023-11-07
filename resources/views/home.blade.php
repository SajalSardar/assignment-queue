@extends('layouts.backendapp')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row justify-content-center">
            <div class="col-md-8 order-0 mb-4">
                <div class="card">
                    <h5 class="card-header">Upload CSV File</h5>
                    <div class="card-body demo-vertical-spacing demo-only-element">

                        <form action="{{ route('user.meta.upload') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class=" col-form-label" for="basic-default-name">Upload</label>
                                <input type="file" class="form-control @error('userinfo') is-invalid @enderror"
                                    id="inputGroupFile01" name="userinfo">
                                @error('userinfo')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Send</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

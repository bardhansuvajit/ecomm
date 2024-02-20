@extends('admin.layout.app')
@section('page-title', 'Error')

@section('section')
<section id="err-404">
    <div class="row justify-content-center">
        <div class="col-md-2 text-center">
            <img src="{{ asset('uploads/static-svgs/undraw_blank_canvas_re_2hwy.svg') }}" alt="not-found" class="w-100 mb-4">
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-4 text-center">
            <h6 class="mb-4">Login to access</h6>

            <a href="#loginModal" data-bs-toggle="modal" class="btn btn-sm btn-dark rounded-0">Login now</a>
        </div>
    </div>
</section>
@endsection
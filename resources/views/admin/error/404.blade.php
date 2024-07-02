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
            <h6 class="mb-4">We could not find anything</h6>

            <a href="javascript: void(0)" onclick="history.back(-1)" class="btn btn-sm btn-dark rounded-0">Go back</a>
        </div>
    </div>
</section>
@endsection
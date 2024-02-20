@extends('admin.layout.app')
@section('page-title', 'Error')

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <section id="err-404">
                            <div class="row justify-content-center">
                                <div class="col-md-2 text-center">
                                    <img src="{{ asset('uploads/static-svgs/undraw_blank_canvas_re_2hwy.svg') }}" alt="not-found" class="w-100 mb-4">
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-md-4 text-center">
                                    <h6 class="mb-4">You do not have permission</h6>
    
                                    <a href="javascript: void(0)" onclick="history.back(-1)" class="btn btn-sm btn-dark rounded-0">Go back</a>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
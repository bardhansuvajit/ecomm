@extends('front.layout.app')

@section('page-title', 'Home')

@section('section')
<section class="content mb-3">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 mb-4">
                <div class="card-body text-center py-4">
                    <img src="{{ asset('images/static-svgs/undraw_cancel_re_pkdm.svg') }}" alt="could-not-find" style="height: 100px">

                    <h5 class="display-5 mt-3 mb-4">OOPS !</h5>

                    <p class="text-muted">We could not find what you were looking for.</p>

                    <a href="{{ url('/') }}" class="btn btn-primary">Back to home</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
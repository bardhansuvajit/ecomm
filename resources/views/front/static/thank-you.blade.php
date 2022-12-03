@extends('front.layout.app')

@section('page-title', 'profile')

@section('section')
<section style="background-color: #eee;">
    <div class="container pt-3 pb-5">
        <div class="row mx-0">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body text-center py-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>

                        <h5 class="display-5 mt-3 mb-4">Thank you for your order</h5>

                        <p class="text-muted">We will deliver the products as soon as possible. You will soon hear from us.</p>

                        <a href="{{ url('/') }}" class="btn btn-primary">Back to home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
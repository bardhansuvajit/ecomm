@extends('front.layout.app')

@section('page-title', 'profile')

@section('section')
<section style="background-color: #eee;">
    <div class="container pt-3 pb-5">
        <div class="row mx-0">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body text-center py-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-award"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>

                        <h5 class="display-5 mt-3 mb-4">We are working on it</h5>

                        <p class="text-muted">We are making it better for you. The option will be live within some days. Stay tuned.</p>

                        <a href="{{ url('/') }}" class="btn btn-primary">Back to home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
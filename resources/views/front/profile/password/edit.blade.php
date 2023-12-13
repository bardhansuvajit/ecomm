@extends('front.layout.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-9">
        <section id="my-profile">
            <div class="row mb-5">
                <div class="col-12">
                    <div class="page-head">
                        <div class="redirect me-3">
                            {{-- <a href="javascript: void(0)" onclick="history.back(-1)"> --}}
                            <a href="{{ route('front.user.account') }}">
                                <i class="material-icons">keyboard_arrow_left</i>
                            </a>
                        </div>
                        <div class="text">
                            <h5>Password</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="password-update-content">
                <form action="{{ route('front.user.password.old.verify') }}" method="post" id="passVerifyForm">@csrf
                    <div class="row">
                        <div class="col-md-4 text-end">
                            <h6 class="text-muted-light margin-11">OLD PASSWORD</h6>
                        </div>
                        <div class="col-md-8">
                            <div class="edit-content">
                                <div class="input-group">
                                    <input type="password" class="form-control" name="old-password" id="old-password" placeholder="Enter old password" oninput="maxLengthCheck(this)" maxlength="30" autofocus>

                                    <span class="input-group-text">
                                        <button type="button" class="visibility-toggle">
                                            <i class="material-icons">visibility_off</i>
                                        </button>
                                    </span>
                                </div>

                                <p class="text-muted mt-3">You can update your profile password by entering your Old password &amp; once it is verfied, you will be asked to enter New password &amp; update</p>
                            </div>
                        </div>
                    </div>

                    <hr id="newPassLimiter" style="display: none">

                    <div class="row" id="newPasswordField" style="display: none">
                        <div class="col-md-4 text-end">
                            <h6 class="text-muted-light margin-11">NEW PASSWORD</h6>
                        </div>
                        <div class="col-md-8">
                            <div class="edit-content mb-3">
                                <div class="input-group">
                                    <input type="password" class="form-control" name="new-password" id="new-password" placeholder="Enter new password" oninput="maxLengthCheck(this)" maxlength="30">

                                    <span class="input-group-text">
                                        <button type="button" class="visibility-toggle">
                                            <i class="material-icons">visibility_off</i>
                                        </button>
                                    </span>
                                </div>
                            </div>

                            <div class="edit-content">
                                <div class="input-group">
                                    <input type="password" class="form-control" name="confirm-password" id="confirm-password" placeholder="Confirm new password" oninput="maxLengthCheck(this)" maxlength="30">

                                    <span class="input-group-text">
                                        <button type="button" class="visibility-toggle">
                                            <i class="material-icons">visibility_off</i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-4">
                        </div>
                        <div class="col-8">
                            <button type="submit" class="btn btn-sm btn-dark rounded-0" id="changeBtn">Verify Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
@endsection

@section('script')
    <script>
        @if (request()->input('error') == 'true')
            editProfile();
        @endif
    </script>
@endsection
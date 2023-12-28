<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalTitle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="close-button">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="login-container">
                    <div class="heading">
                        <h5 class="display-6">REGISTER</h5>
                        <p class="small text-muted">Enter Phone number &amp; password to register</p>
                    </div>

                    <div class="message text-center mb-2" id="regMessage"></div>

                    <form action="{{ route('front.user.create') }}" method="post" id="registerForm">@csrf
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" name="phone-number" id="reg-phone-number" placeholder="Enter phone number" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" maxlength="10">
                            <label for="floatingInput">Phone number</label>
                        </div>

                        <div class="input-group mb-3">
                            <div class="form-floating">
                                <input type="password" class="form-control" name="password" id="reg-password" placeholder="Password">
                                <label for="password">Password</label>
                            </div>

                            <span class="input-group-text">
                                <button type="button" class="visibility-toggle">
                                    <i class="material-icons">visibility_off</i>
                                </button>
                            </span>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <div class="forgot-password">
                                <a href="" class="small" target="_blank">Forgot password ?</a>
                            </div>
                            <div class="terms">
                                <a href="" class="small" target="_blank">Terms &amp; conditions</a>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <input type="hidden" name="redirect" value="{{ request()->input('redirect') }}">
                            <button type="submit" class="btn btn-dark rounded-0">Continue</button>
                            <a href="#loginModal" data-bs-toggle="modal" class="btn btn-light rounded-0">Login ?</a>
                        </div>
                    </form>

                    @include('front.quick.social-login')

                </div>
            </div>
        </div>
    </div>
</div>

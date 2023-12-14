<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalTitle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="close-button">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="login-container">
                    <div class="heading">
                        <h5 class="display-6">LOGIN</h5>
                        <p class="small text-muted">Enter Mobile number &amp; password to login</p>
                    </div>

                    <div class="message text-center mb-2" id="loginMessage"></div>

                    <form action="{{ route('front.user.check') }}" method="post" id="loginForm">@csrf
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" name="login-phone-number" id="login-phone-number" placeholder="Enter mobile number" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" maxlength="10">
                            <label for="floatingInput">Mobile number</label>
                        </div>

                        <div class="input-group mb-3">
                            <div class="form-floating">
                                <input type="password" class="form-control" name="login-password" id="login-password" placeholder="Password">
                                <label for="login-password">Password</label>
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
                            <a href="#registerModal" data-bs-toggle="modal" class="btn btn-light rounded-0">New account ?</a>
                        </div>
                    </form>

                    <div class="social-login-container mt-2 mb-3">
                        <div class="login-heading text-center">
                            <div class="row justify-content-center">
                                <div class="col-md-12"><hr></div>
                            </div>
                            <p class="small">Or Continue</p>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-6">
                                <div id="g_id_onload"
                                    data-client_id="65139693010-fg1u8233h518asgsi08noqcefskld8bi.apps.googleusercontent.com"
                                    data-context="signin"
                                    data-ux_mode="popup"
                                    data-callback="handleCredentialResponse"
                                    data-auto_prompt="false">
                                </div>

                                <div class="g_id_signin"
                                    {{-- data-type="icon" --}}
                                    data-type="standard"
                                    {{-- data-shape="circle" --}}
                                    data-shape="rectangular"
                                    data-theme="filled_blue"
                                    data-text="signin_with"
                                    data-size="medium"
                                    data-logo_alignment="left">
                                </div>

                                <script src="https://accounts.google.com/gsi/client" async></script>

                                <script>
                                    function handleCredentialResponse(response) {
                                        let token = '{{ csrf_token() }}';
                                        const headers = {
                                            Authorization: `Bearer ${token}`
                                        };
                                        fetch("{{route('front.user.login.google')}}", {
                                            method: "POST",
                                            headers: {
                                                'Content-Type': 'application/json', 'X-CSRF-TOKEN': token
                                            },
                                            body: JSON.stringify({ 
                                                request_type:'user_auth', credential: response.credential 
                                            }),
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            alert('here 2');

                                            /*
                                            console.log(data);
                                            if(data.status == 200) {
                                                toastFire('success', '345'+data.message);

                                                alert(data.name.split(" ")[0]);

                                                let content = `
                                                <div class="btn-group user-detail">
                                                    <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        ${data.name.split(" ")[0]}
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li>
                                                            <h6 class="dropdown-header">${data.name}</h6>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="${baseUrl}/user/account">Account</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="${baseUrl}/user/order">Orders</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="${baseUrl}/user/profile">Profile</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="javascript: void(0)" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                `;
                                                $('#login-container').html(content);

                                                loginModalEl.hide();

                                                if (data.redirect.length > 0) {
                                                    window.location = res.redirect
                                                }

                                                // window.location.href = data.redirectTo;
                                            } else {
                                                toastFire('failure', data.message);
                                            }
                                            */
                                        });
                                        // .catch(console.error);
                                    }
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

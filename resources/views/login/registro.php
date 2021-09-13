<div id="auth">
    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">
                <div class="auth-logo">
                    <a href="index.html"><img src="public/assets/images/logo/logo.png" alt="Logo"></a>
                </div>
                <h1 class="auth-title">Registro</h1>
                <p class="auth-subtitle mb-5">Ingrese sus datos para registrarse en nuestro sitio web.</p>

                <form>
                    <!--<div class="form-group position-relative has-icon-left mb-4">
                        <input type="text" class="form-control form-control-xl" placeholder="Email">
                        <div class="form-control-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                    </div>-->
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="text" name="userRegistro" class="form-control form-control-xl" placeholder="Usuario">
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="password" name="userRegistro" class="form-control form-control-xl" placeholder="Password">
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="password" name="userRegistro" class="form-control form-control-xl" placeholder="Confirmar Password">
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                    </div>
                    <p id="resLogin" class="text-danger"></p>
                    <p id="resRegistro" class="text-success"></p>
                    <button type="button" class="btnRegistro btn btn-primary btn-block btn-lg shadow-lg mt-5" id="idbtnRegistrar">
                        <span>Registrar</span>
                    </button>
                </form>
                <div class="text-center mt-5 text-lg fs-4">
                    <p class='text-gray-600'>Ya tienes una cuenta? <a href="login" class="font-bold">Login</a>.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right">

            </div>
        </div>
    </div>
</div>
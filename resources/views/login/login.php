<div id="auth">
    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">
                <div class="auth-logo">
                    <a><img src="public/assets/images/logo/logo.png" alt="Logo"></a>
                </div>
                <h1 class="auth-title">Login</h1>
                <?php
                ?>
                <p class="auth-subtitle mb-2">Inicie sesión con sus datos que ingresó durante el registro.</p>

                <form action="">
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="text" class="form-control form-control-xl"value="admin" name="loginUsuario" placeholder="Usuario">
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="password" class="form-control form-control-xl"value="123" name="loginUsuario" placeholder="Password">
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                    </div>
                    <p id="resLogin" class="text-danger"></p>
                    <div class="form-check form-check-lg d-flex align-items-end">
                        <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label text-gray-600" for="flexCheckDefault">Mantenme conectado</label>
                    </div>
                    <button type="button" class="btn btn-primary btn-block btn-lg shadow-lg mt-5 btnLogin">Login</button>
                </form>
                <div class="text-center mt-5 text-lg fs-4">
                    <p class="text-gray-600">No tengo una cuenta? <a href="registro" class="font-bold">Registrar</a>.</p>
                    <p><a class="font-bold" href="auth-forgot-password.html">Se te olvidó tu contraseña?.</a>.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right">
            </div>
        </div>
    </div>
</div>
<div id="error">
    <div class="error-page container">
        <div class="col-md-8 col-12 offset-md-2">
            <img class="img-error" src="public/assets/images/samples/error-404.png" alt="Not Found">
            <div class="text-center">
                <h1><?= $sgbd['error']?></h1>
                <h3><i class="fa fa-warning"></i> Oops! Error en la base de datos!</h3>
                <p><?= $sgbd['sms'] ?></p>
                <a href="home" class="btn btn-primary go-home">Ingresar</a>
            </div>
        </div>
    </div>

</div>
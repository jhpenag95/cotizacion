<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <link rel="stylesheet" href="css/style.css">

    <title>Login | Sistema Cotización</title>
</head>

<body>
    <section class="vh-100 background-radial-gradient text-light fs-4">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="img/login.png" class="img-fluid" alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1 contform p-5">
                <h3 class="text-center pb-4 fs-1">Ingresar</h3>
                    <form action="" method="post">
                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <input type="text" name="usuario" id="form3Example3" class="form-control form-control-lg" placeholder="Ingrese su usuario" />
                            <label class="form-label" for="form3Example3">Usuario</label>
                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-3">
                            <input type="password" name="clave" id="form3Example4" class="form-control form-control-lg" placeholder="Ingrese su contraseña" />
                            <label class="form-label" for="form3Example4">Contraseña</label>
                        </div>
                            
                            <div class="text-center text-lg-start mt-4 pt-2">
                                <button type="button" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Entrar</button>
                                <p class="small fw-bold mt-2 pt-1 mb-0">No tienes cuenta? <a href="#!" class="link-danger">Registrar</a></p>
                                <p class="small fw-bold mt-2 pt-1 mb-0"><a href="#!" class=" text-light">Problemas para ingresar?</a></p>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>
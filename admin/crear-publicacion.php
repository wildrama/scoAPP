<?php
require_once "config.php";


// $ftp_user = 'backend@backend.ketasoftware.com';
// $ftp_pass = 'ramiro123cristal';
// $ftp_server = "98.142.102.50";

// $ftp_conn = ftp_connect($ftp_server, 21) or die("Could not connect to $ftp_server");
// // login with username and password
// $login_result = ftp_login($ftp_conn, $ftp_user, $ftp_pass);


// // check connection
// if ((!$ftp_conn) || (!$login_result)) {
//     echo "FTP connection has failed!";
//     echo "Attempted to connect to $ftp_server for user $ftp_user";
//     exit;
// } else {
//     echo "Connected to $ftp_server, for user $ftp_user";
// }

// Define variables and initialize with empty values
$tipo = $imagen = $titulo = $descripcion = $direccion = $precio = "";

$tipo_err = $imagen_err = $titulo_err = $descripcion_err = $direccion_err = $precio_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // validar Tipo
    $input_tipo = trim($_POST["tipo"]);
    if (empty($input_tipo)) {
        $tipo_err = "Porfavor coloca el tipo";
    } else {
        $tipo = $input_tipo;
    }
    // validar imagen
    $input_imagen = trim($_FILES["file"]["name"]);
    if (empty($input_imagen)) {
        $imagen_err = "Porfavor coloca la imagen";
    } else {
        $imagen = $input_imagen;
    }
    // validar titulo 
    $input_titulo = trim($_POST["titulo"]);
    if (empty($input_titulo)) {
        $titulo_err = "Porfavor coloca el titulo";
    } else {
        $titulo = $input_titulo;
    }
    // validar descripcion
    $input_descripcion = trim($_POST["descripcion"]);
    if (empty($input_descripcion)) {
        $descripcion_err = "Porfavor coloca la descripcion";
    } else {
        $descripcion = $input_descripcion;
    }
    // validar direccion
    $input_direccion = trim($_POST["direccion"]);
    if (empty($input_direccion)) {
        $direccion_err = "Porfavor coloca la direccion";
    } else {
        $direccion = $input_direccion;
    }
    $input_precio = trim($_POST["precio"]);
    if(empty($input_precio)){
        $direccion_err = "Porfavor ingresa un precio.";     
    } else{
        $precio = $input_precio;
    }


    // $imagen = $_FILES["file"]["name"];
    $filePath = 'upload/' . $imagen;

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $filePath)) {
        // If file has uploaded successfully, store its name in data base


        $sql = "INSERT INTO scorcelliDatos (tipo,imagen,titulo,descripcion,direccion,precio) VALUES (?,?,?,?,?,?) ";

        if ($stmt = mysqli_prepare($link, $sql)) {

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssss", $param_tipo, $param_imagen, $param_titulo, $param_descripcion, $param_direccion,$param_precio);
            // Set parameters
            $param_tipo = $tipo;
            $param_imagen = $imagen;
            $param_titulo = $titulo;
            $param_descripcion = $descripcion;
            $param_direccion = $direccion;
            $param_precio = $precio;
            // Attempt to execute the prepared statement

            if (mysqli_stmt_execute($stmt)) {
                // Records created successfully. Redirect to landing page
                header("location:admin.php");
                exit();
            } else {
                echo "Algo salio mal, por favor intenta de nuevo";
            }
        }
    }
    // Close statement
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear publicación</title>
    <meta name="robots" content="none,noarchive">
<meta name="googlebot" content="none,noarchive">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .imgFile {
            width: 100%;
            height: 30vh;
            object-fit: cover;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="mt-4">Crear Publicacion</h2>
                <form class="" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

                    <div class="form-group">

                        <label for="seleccionarTipo" class="form-label mt-2">Seleccion tipo de operacion</label>
                        <select name="tipo" id="seleccionarTipo" class="form-select mb-3 <?php echo (!empty($tipo_err)) ? 'is-invalid' : ''; ?> ">

                            <option value="venta" selected>Venta</option>
                            <option value="alquiler">Alquiler</option>
                        </select>

                        <span class="invalid-feedback"><?php echo $tipo_err; ?></span>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-6">
                            <label for="file">Imagen de la publicación</label>
                            <input id="inputFile" class="form-control" type="file" name="file" id="imagen" onchange="preview()" required>
                        </div>

                        <div class="col-12 col-md-6">
                            <img id="prevImg" class="img-fluid d-none" src="" alt="imagenNueva">
                        </div>
                        <span class="invalid-feedback"><?php echo $imagen_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="titulo">Titulo de la publicación</label>
                        <input type="text" name="titulo" class="form-control <?php echo (!empty($titulo_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $titulo; ?>" required>
                        <span class="invalid-feedback"><?php echo $titulo_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripcion de la publicación</label>
                        <textarea name="descripcion" class="input-group-lg form-control <?php echo (!empty($descripcion_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $descripcion; ?>"  aria-label="With textarea"required></textarea>
                        <span class="invalid-feedback"><?php echo $descripcion_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="direccion">Direccion del inmueble</label>
                        <input type="text" name="direccion" class="form-control  <?php echo (!empty($direccion_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $direccion; ?>" required>
                        <span class="invalid-feedback"><?php echo $direccion_err; ?></span>
                    </div>
                    <div class="form-group">
                            <label for="inputPrecio">Precio del inmueble</label>
                            <input id="inputPrecio" type="text" name="precio" class="form-control <?php echo (!empty($precio_err)) ? 'is-invalid' : ''; ?>"value="<?php echo $precio; ?>" required>
                            <span class="invalid-feedback"><?php echo $precio_err; ?></span>
                        </div>
                    <input type="submit" class="btn btn-primary" value="Cargar">
                    <a href="admin.php" class="btn btn-secondary ml-2">Cancelar</a>
                </form>
            </div>
        </div>
    </div>

    <script>
        let prevImg = document.querySelector('#prevImg')

        function preview() {
            prevImg.src = URL.createObjectURL(event.target.files[0]);
            prevImg.classList.add('imgFile');
            prevImg.classList.remove('d-none');

        }
    </script>
</body>

</html>
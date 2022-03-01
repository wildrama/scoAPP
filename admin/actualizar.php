<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$tipo = $imagen = $titulo = $descripcion = $direccion = $tipo = "";

$tipo_err = $imagen_err = $titulo_err = $descripcion_err = $direccion_err = $precio_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // validar Tipo
    $input_tipo = trim($_POST["tipo"]);
    if(empty($input_tipo)){
        $tipo_err = "Porfavor ingresa un tipo.";     
    } else{
        $tipo = $input_tipo;
    }
    // validar imagen
    $input_imagen = trim($_FILES["file"]["name"]);
    if(empty($input_imagen)){
        $imagen_err = "Porfavor ingresa un imagen";     
    } else{
        $imagen = $input_imagen;
    }
    // validar titulo 
    $input_titulo = trim($_POST["titulo"]);
    if(empty($input_titulo)){
        $titulo_err = "Porfavor ingresa un titulo.";     
    } else{
        $titulo = $input_titulo;
    }
      // validar descripcion
      $input_descripcion = trim($_POST["descripcion"]);
      if(empty($input_descripcion)){
          $descripcion_err = "Porfavor ingresa una descripcion.";     
      } else{
          $descripcion = $input_descripcion;
      }
   // validar direccion
   $input_direccion = trim($_POST["direccion"]);
   if(empty($input_direccion)){
       $direccion_err = "Porfavor ingresa una direccion.";     
   } else{
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
         
        // Prepare an update statement
        $sql = "UPDATE scorcelliDatos SET tipo=?, imagen=?, titulo=?, descripcion=?, direccion=?, precio=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssi",$param_tipo, $param_imagen, $param_titulo,$param_descripcion,$param_direccion, $param_precio, $param_id);
            
            // Set parameters
            $param_tipo = $tipo;
            $param_imagen = $imagen;
            $param_titulo = $titulo;
            $param_descripcion = $descripcion;
            $param_direccion = $direccion;
            $param_id = $id;
            $param_precio = $precio;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: admin.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
        
    }
    
    // Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM datos WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $tipo= $row["tipo"];
                    $titulo = $row["titulo"];
                    $imagen = $row["imagen"];
                    $descripcion = $row["descripcion"];
                    $direccion = $row["direccion"];
                    $precio = $row["precio"];

                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($link);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizá la publicacion del inmueble</title>
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
            <div class="row mx-lg-5 px-lg-5">
                <div class="col-md-12">
                    <h2 class="mt-2 ">Actualizar la publicación</h2>
                    <p>Actualiza los valores de la publicación y presiona Cargar <br>
                    Y Cancelar para volver atras
                </p>
               <form class="" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

                        <div class="form-group ">

                            <label for="seleccionarTipo" class="form-label mt-2">Seleccion tipo de operacion</label>
                            <select name="tipo" id="seleccionarTipo"  class="form-select mb-3 <?php echo (!empty($tipo_err)) ? 'is-invalid' : ''; ?> " >

                                <option value="venta" selected >Venta</option>
                                <option value="alquiler">Alquiler</option>
                            </select>

                            <span class="invalid-feedback"><?php echo $tipo_err; ?></span>
                        </div>
                        <div class="form-group text-center">

                            <label for="inputFile">Imagen de la publicación</label>
                            <input id="inputFile" type="file" class="form-control" name="file" id="imagen" onchange="preview()" required>

                            <div class="row">
                                <div class="col-6 lead  ">
                                    Imagen Actual de la publicación
                                <img class="img-fluid imgFile" src="<?php echo '/upload/'.$row["imagen"]; ?>" alt="">

                                </div>
                                <div class="col-6 lead">
                                  Imagen Nueva para la Publicación
                                <img  id="prevImg" class="img-fluid imgFile" src="" alt="" >
                                </div>
                            </div>
                            <span class="invalid-feedback"><?php echo $imagen_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="inputTitulo">Titulo de la publicación</label>
                            <input id="inputTitulo" type="text" name="titulo" class="form-control <?php echo (!empty($titulo_err)) ? 'is-invalid' : ''; ?>"value="<?php echo $titulo; ?>" required>
                            <span class="invalid-feedback"><?php echo $titulo_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripcion de la publicación</label>
                            <textarea name="descripcion" class="input-group-lg form-control <?php echo (!empty($descripcion_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $descripcion; ?>"  aria-label="With textarea"required></textarea>                            <span class="invalid-feedback"><?php echo $descripcion_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="inputDireccion">Direccion del inmueble</label>
                            <input id="inputDireccion" type="text" name="direccion" class="form-control <?php echo (!empty($direccion_err)) ? 'is-invalid' : ''; ?>"value="<?php echo $direccion; ?>" required>
                            <span class="invalid-feedback"><?php echo $direccion_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="inputPrecio">Precio del inmueble</label>
                            <input id="inputPrecio" type="text" name="precio" class="form-control <?php echo (!empty($precio_err)) ? 'is-invalid' : ''; ?>"value="<?php echo $precio; ?>" required>
                            <span class="invalid-feedback"><?php echo $precio_err; ?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Cargar">
                        <a href="admin.php" class="btn btn-secondary ml-2">Cancelar</a>
                    </form>
                     
                </div>
            </div>        
        </div>
    
    <script>
             let prevImg = document.querySelector('#prevImg')
             function preview() {
                prevImg.src=URL.createObjectURL(event.target.files[0]);
}
      </script>
</body>
</html>
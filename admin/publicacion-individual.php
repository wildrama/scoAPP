<?php
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once "config.php";
    
    // Prepare a select statement
    $sql = "SELECT * FROM scorcelliDatos WHERE id = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id"]);
        
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
                // URL doesn't contain valid id parameter. Redirect to error page
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
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Record</title>
    <meta name="robots" content="none,noarchive">
<meta name="googlebot" content="none,noarchive">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="sass/dubini.css">
    <style>
   

        .card-img-top {
    width: 100%;
    height: 40vh;
    object-fit: cover;
}
    </style>
</head>
<body>
   
        <div class="container">
            
            <a href="admin.php" class="p-2 px-3 mt-2 mb-2 btn btn-primary">Atras</a>

            
            
            <div class="row">
                
                    <div class="col">

                    </div>
                   <div class="col-lg-4"> 
                       <div class="publicacion">
                    
                       <div class="card">
                           <div class="card-top my-1 d-flex justify-content-between mx-4 py-1">
                               
                               
                               
                               <div class="tipo text-muted">
                               <?php echo $row['tipo']; ?>
                               </div>
                           </div>
                           <img src="/upload/<?php echo $row['imagen']; ?>"  class="card-img-top imgPublicacion" alt="imagenDelInmueble">
                           <div class="card-body mx-1">
                               <h4 class="card-title pb-2 text-center">
                               <?php echo $row['titulo']; ?>
                               </h4>
                               <p class=" descripcion"> 
                               <?php echo $row['descripcion']; ?>
                               </p>
                               <h5 class="h6 text-end direccionPublicacion pt-1 p-0">
                               <?php echo $row['direccion']; ?>
                               </h5>
                               <h5 class="h6 text-end precioPublicacion pt-1 p-0">
                               <?php echo $row['precio']; ?>
                               </h5>
                           </div>
                       </div>
       
       
                   </div>
                   </div>
                   <div class="col">

                   </div>
    
    
               
         
            </div>   
            
                
        </div>
    
</body>
</html>
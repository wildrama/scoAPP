<!DOCTYPE html>
<html lang="en">
<!-- 
    armar interfaz de administrador

        armar usuario y contraseña a la interfaz de administrador

    armar interfaz de la web
        agregar el carrousel de publicaciones
        publicaciones destacadas
        
        borrar la extencion .php
        indexar
        ssl


    -->
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador de Publicaciones</title>
    <meta name="robots" content="none,noarchive">
<meta name="googlebot" content="none,noarchive">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="sass/dubini.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
           .card-img-top {
    width: 100%;
    height: 40vh;
    object-fit: cover;
}
    </style>
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>

<body>
   
        <div class="container">
        <div class="mt-3 mb-3 clearfix">
                        <h2 class="pull-left">Publicaciones de inmuebles</h2>
                        <a href="crear-publicacion.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Crear Publicación</a>
                    </div>

            <div class="row">

          
               
                        <?php
                    // Include config file
                    require_once "config.php";
                  

                    // Attempt select query execution
                    $sql = "SELECT * FROM scorcelliDatos ORDER BY id DESC";



                    $result = mysqli_query($link, $sql);

                   while($row = mysqli_fetch_assoc($result)){
                    ?>

                      
                       <div class="col-lg-4 pt-2"> 
                       <div class="publicacion">
                    
                       <div class="card">
                           <div class="card-top my-1 d-flex justify-content-between  py-1">
                               
                               
                               
                               <div class="tipo mx-3 text-muted">
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
                           <div class="actions text-end">
                            <a href="<?php echo 'publicacion-individual.php?id='. $row['id'] .'' ?>" class="mx-2" title="Ver Publicacion" data-toggle="tooltip">Ver publicación<span class="fa fa-eye"></span></a>
                           
                            <a href="<?php echo 'actualizar.php?id='. $row['id'] .'' ?>" class="mx-2" title="Actualizar Publicacion" data-toggle="tooltip"><span class="fa fa-pencil"></span></a> 
                            <a href="<?php echo 'eliminar.php?id='. $row['id'] .'' ?>" title="Eliminar Publicacion" class="mx-2" data-toggle="tooltip"><span class="fa fa-trash"></span></a>
                
                        </div>
                       </div>
       
       
                   </div>
                   </div>
                      


                       <?php } ?>


                   
                
            </div>
        </div>
   
</body>

</html>
 <?php
  require_once "config.php";

  // Attempt select query execution

  $sql = 'SELECT * FROM scorcelliDatos ';
  $result = mysqli_query($link, $sql);
  $carouselItems = '';
  $carouselButtons = '';

  $i = 0;
  while ($row = mysqli_fetch_assoc($result)) {
    $class = ($i == 0) ? 'active' : '';
    $carouselItems .= "<div class='carousel-item $class'>
                <div class='col-lg-12 pt-2 mx-3 px-3'> 
                  <div class='publicacion'>
                    <div class='card'>
              <div class='card-top my-1 d-flex justify-content-between  py-1'>
                       
                  
              <div class='tipo mx-3 text-muted'>
              {$row['tipo']}
              </div>
          </div>
          <img src='/upload/{$row['imagen']}'  class='card-img-top imgPublicacion' alt='imagenDelInmueble'>
          <div class='card-body mx-1'>
              <h4 class='card-title pb-2 text-center'>
               {$row['titulo']} 
              </h4>
              <p class=' descripcion'> 
             {$row['descripcion']}
              </p>
              <h5 class='h6 text-end direccionPublicacion pt-1 p-0'>
               {$row['direccion']}
              </h5>
              <h5 class='h6 text-end direccionPublicacion pt-1 p-0'>
               {$row['precio']}
              </h5>
          </div>
      </div>
  </div>
  </div>
          </div>";
       
                  
         
         
    $i++;
  }
  ?>
 <!DOCTYPE html>
 <html lang="en">

 <head>
   <title>B2ed2ootstrap Examplesss</title>
   <meta name="robots" content="none,noarchive">
<meta name="googlebot" content="none,noarchive">
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

   <style>
     /* Make the image fully responsive */
     .carousel-inner img {
       width: 100%;
       height: 100%;
     }
   </style>
 </head>

 <body>
   <div class="container">
<div id="demo" class="carousel slide" data-ride="carousel">
    
     <!-- The slideshow -->
     <div class="carousel-inner">
       <?php echo $carouselItems; ?>
     </div>
     <!-- Left and right controls -->
     <a class="carousel-control-prev" href="#demo" data-slide="prev">
       <span class="carousel-control-prev-icon"></span>
     </a>
     <a class="carousel-control-next" href="#demo" data-slide="next">
       <span class="carousel-control-next-icon"></span>
     </a>
   </div>
   </div>
   
 </body>

 </html>
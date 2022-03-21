const express = require('express');
const router = express.Router();
const catchAsync =require('../utils/catchAsync');
const {isLoggedIn} = require('../middleware');
const Propiedad = require('../models/propiedad');
const {storage} = require('../cloudinary/index');
const {cloudinary} = require('../cloudinary/index');

const multer = require('multer');
const upload = multer({storage});
// CRUD ADMINNN
// router.get('/inicio', catchAsync(async(req,res)=>{
// const user = new Usuario({email:'rambo1bc@hotmail.com',username: 'scorcelli',password:'123456'})
//   const nuevoUsuario= await User.register(user,'123456')
//   res.send(nuevoUsuario);
// })) 

// RENDER VER mostrar elementos Inicio de CRUD ADMIN
router.get('/', isLoggedIn,catchAsync(async (req, res) => {
    const propiedades = await Propiedad.find({});
    
    res.render('adm/mostrar',{propiedades});
    
  })) ;


  // RENDER agregar elemento
  
  router.get('/nueva',isLoggedIn,(req,res) =>{
    res.render('adm/crearpropiedad');
  });
  // ENVIAR DATOS DEL FORMULARIO A LA BBDD
  
  router.post('/',upload.array('imagenes'),isLoggedIn, catchAsync( async (req,res)=>{
   const nuevaPropiedad = new Propiedad (req.body);
   nuevaPropiedad.imagenes = req.files.map(f => ({ url: f.path, filename: f.filename }));
    console.log(nuevaPropiedad);
    console.log(req.files)

   await nuevaPropiedad.save();
    res.redirect(`/administrador/${nuevaPropiedad._id}`)

    } ));
  
  
  // ACTUALIZAR UN PRODUCTO DEL de la base de datos
      // poblate the products with the form and values
  router.get('/:id/editar',isLoggedIn,catchAsync( async (req,res) =>{
    const {id} = req.params;
    const propiedad = await Propiedad.findById(id);
    if (!propiedad) {
      req.flash('error', 'No se puede encontrar la publicación');
      return res.redirect('/administrador');
  }
    res.render('adm/editarpropiedad', {propiedad})
  }));
  
  // ENVIAR PUT REQUEST
  
  router.put('/:id',upload.array('imagenes'), isLoggedIn,catchAsync( async (req,res)=>{
  const {id} = req.params;
  console.log(req.body);
  const upPropiedad = await Propiedad.findByIdAndUpdate(id, req.body);
    console.log(req.files)
    const imgs = req.files.map(f => ({ url: f.path, filename: f.filename }));
  upPropiedad.imagenes.push(...imgs);
  await upPropiedad.save();

  if (req.body.deleteImagenes) {
    for (let filename of req.body.deleteImagenes) {
        await cloudinary.uploader.destroy(filename);
    }
    await upPropiedad.updateOne({ $pull: { imagenes: { filename: { $in: req.body.deleteImagenes } } } })
}

  req.flash('success', 'Publicación actualizada correctamente');
  res.redirect(`/administrador/${upPropiedad._id}`)
  }))
  
  
  
  // RENDER STOCK INDIVIDUAL
  router.get('/:id', isLoggedIn,catchAsync(async (req, res) =>{
    const {id} = req.params;

   const propiedad = await Propiedad.findById(id)
   res.render('adm/propiedadIndividual',{propiedad});
  } ))
  
  
  // BORRAR STOCK INDIVIDUAL
  
  router.delete('/:id' ,isLoggedIn, catchAsync(async (req, res)=>{
    const {id}= req.params;
    const deletedPropiedad= await Propiedad.findByIdAndDelete(id);
    res.redirect('/administrador');
  }))

  module.exports = router;
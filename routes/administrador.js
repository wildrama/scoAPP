const express = require('express');
const router = express.Router();
const catchAsync =require('../utils/catchAsync');
const ExpressError=require('../utils/ExpressError');
const Usuario = require('../models/usuario');

const Propiedad = require('../models/propiedad');
// CRUD ADMINNN
// router.get('/inicio', catchAsync(async(req,res)=>{
// const user = new Usuario({email:'rambo1bc@hotmail.com',username: 'scorcelli',password:'123456'})
//   const nuevoUsuario= await User.register(user,'123456')
//   res.send(nuevoUsuario);
// })) 

// RENDER VER mostrar elementos Inicio de CRUD ADMIN
router.get('/', catchAsync(async (req, res) => {
    const propiedades = await Propiedad.find({});
    
    res.render('adm/mostrar',{propiedades});
    
  })) ;


  // RENDER agregar elemento
  
  router.get('/nuevo', (req,res) =>{
    res.render('adm/crear');
  });
  // ENVIAR DATOS DEL FORMULARIO A LA BBDD
  
  router.post('/', catchAsync( async (req,res)=>{
   const nuevaPropiedad = new Propiedad (req.body);
   await nuevaPropiedad.save();
    res.redirect(`/administrador/${nuevaPropiedad._id}`)
  } ));
  
  
  // ACTUALIZAR UN PRODUCTO DEL de la base de datos
      // poblate the products with the form and values
  router.get('/:id/edit',catchAsync( async (req,res) =>{
    const {id} = req.params;
    const propiedad = await Propiedad.findById(id);
    res.render('stock/editar', {propiedad})
  }));
  
  // ENVIAR PUT REQUEST
  
  router.put('/:id', catchAsync( async (req,res)=>{
  const {id} = req.params;
  const propiedad = await Propiedad.findByIdAndUpdate(id, req.body,{runValidators:true});
  res.redirect(`/administrador/${propiedad.id}`)
  
  }))
  
  
  
  // RENDER STOCK INDIVIDUAL
  router.get('/:id', catchAsync(async (req, res) =>{
    const {id} = req.params;
   const propiedad = await Propiedad.findById(id)
   res.render('administrador/propiedadIndividual',{propiedad});
  } ))
  
  
  // BORRAR STOCK INDIVIDUAL
  
  router.delete('/:id' , catchAsync(async (req, res)=>{
    const {id}= req.params;
    const deletedPropiedad= await Propiedad.findByIdAndDelete(id);
    res.redirect('/administrador');
  }))

  module.exports = router;
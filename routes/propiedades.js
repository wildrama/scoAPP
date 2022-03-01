const express = require('express');
const router = express.Router();
const Propiedad = require('../models/propiedad.js');
const catchAsync =require('../utils/catchAsync');


// Regular User UI

// renderPropiedades.ejs

router.get('/', catchAsync( async (req, res) => {
const propiedades = await Propiedad.find({});
  res.render('propiedades',{propiedades});
}))

// Mostrar propiedad individual
router.get('/:id',catchAsync( async (req, res) =>{
  const {id} = req.params;
 const propiedad = await Propiedad.findById(id)
 res.render('propiedadIndividual',{propiedad});
} ))


module.exports = router;
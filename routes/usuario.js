const express = require('express');
const router = express.Router();
const catchAsync =require('../utils/catchAsync');
const ExpressError=require('../utils/ExpressError');
const Usuario = require('../models/usuario');

router.get('/registro',  (req,res)=>{
res.render('adm/registro');
});

router.post('/registro', catchAsync(async(req,res)=>{

    try {
        const { email, username, password } = req.body;
        const user = new Usuario({email, username});
        const usuarioRegistrado = await Usuario.register(user,password);
        req.login(usuarioRegistrado, err => {
            if (err) return next(err);
            req.flash('success', 'Bienvenido a la sesión de administrador');
            res.redirect('/administrador');
        })
    } catch (e) {
        req.flash('error', e.message);
        res.redirect('/registro');
    }
   
}))


module.exports= router;
const express = require('express');
const router = express.Router();
const catchAsync =require('../utils/catchAsync');
const ExpressError=require('../utils/ExpressError');
const Usuario = require('../models/usuario');
const passport = require('passport');

router.get('/registro',  (req,res)=>{
res.render('adm/registro');
});

router.post('/r', catchAsync(async(req,res)=>{

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
        const errorRegisterMSG = 'Ya existe un usuario con ese nombre'
        req.flash('error', errorRegisterMSG);
        res.redirect('/registro');
    }
   
}));

router.get('/ingresar', (req, res) => {
    res.render('adm/iniciosesion');
})

router.post('/ingresar', passport.authenticate('local', { failureFlash: true, failureRedirect: '/ingresar' }), (req, res) => {
    req.flash('success', 'Bienvenido');
    const redirectUrl = req.session.returnTo || '/administrador';
    delete req.session.returnTo;
    res.redirect(redirectUrl);
})  

router.get('/cerrarsesion', (req, res) => {
    req.logout();
    req.flash('success', "Cerraste la sesion administrador");
    res.redirect('/');
})


module.exports= router;
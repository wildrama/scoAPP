module.exports.isLoggedIn = (req, res, next) => {
    console.log(req.user, 'req.user....');
    if (!req.isAuthenticated()) {
        req.session.returnTo = req.originalUrl
        req.flash('error', ' Tiene que estar logeado antes');
        return res.redirect('/ingresar');
    }
    next();
}



module.exports.isLoggedIn = (req, res, next) => {
    if (!req.isAuthenticated()) {
        req.session.returnTo = req.originalUrl
        req.flash('error', ' Tiene que estar logeado antes');
        return res.redirect('/iniciosesion');
    }
    next();
}
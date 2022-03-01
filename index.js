// if(process.env.NODE_ENV !== "production") {
//   require('dotenv').config();
// }
const express = require('express');
const app = express();
const port = 3000;
const path = require('path');
const methodOverride = require('method-override')
const mongoose = require('mongoose');
// require mongoose models
const Propiedad = require('./models/propiedad.js');

// utils
const catchAsync =require('./utils/catchAsync');
const ExpressError=require('./utils/ExpressError');


// session
const session =  require('express-session')
const sessionOptions ={secret:'thisisnotagoodsecret',resave: false,saveUninitialized: true,};



// routes

const admRoutes =require('./routes/administrador');
const userUiRoutes= require('./routes/propiedades')

main().catch(err => console.log(err));

async function main() {
  await mongoose.connect('mongodb://localhost:27017/dbScorcelli',{
    useNewUrlParser :true,
    useUnifiedTopology:true,
  });
  console.log("everything abot db is OK")
}


// Routes
app.use('/administrador',admRoutes);
app.use('/propiedades',userUiRoutes);

// statics files
app.use(express.static('public'));
app.use(express.static('files'));

// views and methodOverride
app.set('views', path.join(__dirname, '/views'))
app.set('view engine', 'ejs');
app.use(express.urlencoded({extended:true}));
app.use(methodOverride('_method'));
// sessionMiddleware
app.use(session(sessionOptions)); 
//  flash middleware  

app.get('/register', (req,res)=>{
  const{username = 'Sin Usuario'} = req.query;
  req.session.username = username;
  res.redirect('/greet')
})

app.get('/greet', (req,res)=>{
  const{username } = req.session;
res.send(`bienvenido devuelta ${username}`)
})



// RENDER HOME
app.get('/', (req, res) => {
  res.render('inicio');
})


// error midller ware base

app.use(function (err, req, res, next) {
  const {statusCode = 500, message='Algo salio mal'}= err;
  console.error(err.stack)
  res.status(statusCode).render('errors')
});


// endAPP
app.listen(port, () => console.log(`APPSCORCELLI ${port}!`))


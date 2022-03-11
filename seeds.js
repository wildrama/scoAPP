const mongoose = require('mongoose');
const Propiedad = require('./models/propiedad.js');
main().catch(err => console.log(err));

async function main() {
  await mongoose.connect('mongodb://localhost:27017/dbScorcelli');
  console.log("everything abot db is OK")
}

// const prod = Producto({
//     nombre:'Chocolino cacao',
//     cantidad:50,
//     marca:'la virginia',
//     valor:120,
//     impuestoAplicado:21
// })
// prod.save()
// .then(prod=>{
//     console.log(prod)
// })
// .catch(e=>{
//     console.log(e)
// })

const seedProps = [{
    titulo:'Fideos PRODUCTOIMAGEN',
    precio:30,
    descripcion: 'MUY LINDAS CASA',
    direccion:'Maestro reina 420',
},
{
    titulo:'Fideos PRODUCTOIMAGEN',
    precio:30,
    imagen:'PRODUCTOIMAGEN',
    descripcion: 'MUY LINDAS CASA',
    direccion:'Maestro reina 420',
},
{
    titulo:'Fideos PRODUCTOIMAGEN',
    precio:30,
    imagen:'PRODUCTOIMAGEN',
    descripcion: 'MUY LINDAS CASA',
    direccion:'Maestro reina 420',
},
{
    titulo:'Fideos PRODUCTOIMAGEN',
    precio:30,
    imagen:'PRODUCTOIMAGEN',
    descripcion: 'MUY LINDAS CASA',
    direccion:'Maestro reina 420',
},
{
    titulo:'Fideos PRODUCTOIMAGEN',
    precio:30,
    imagen:'PRODUCTOIMAGEN',
    descripcion: 'MUY LINDAS CASA',
    direccion:'Maestro reina 420',
},
]
Propiedad.insertMany(seedProps)
.then(res =>{
    console.log(res)
})
.catch(e=>{
    console.log(e)
})

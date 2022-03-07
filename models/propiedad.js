const mongoose = require('mongoose');

const propiedadSchema = new mongoose.Schema({
    titulo : {
      type: String,
      required: true
    },
    tipo: {
      type :String,
    },
    precio :{
      type:Number,
    },
    imagen:{
      type:String,
    },
  
    descripcion:{
        type:String

    },
    direccion:{
      type:String

  },


  })
  
  const Propiedad = mongoose.model('Propiedad', propiedadSchema);

module.exports = Propiedad
  
  
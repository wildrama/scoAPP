const mongoose = require('mongoose');
const Schema = mongoose.Schema;


const ImagenSchema = new Schema({
  
    url : String,
   filename: String
})
ImagenSchema.virtual('thumbnail').get(function() {
  return this.url.replace('/upload', '/upload/w_200');
});
ImagenSchema.virtual('show').get(function() {
  return this.url.replace('/upload', '/upload/c_scale,h_400,w_600');
});
ImagenSchema.virtual('crop').get(function(){

  return this.url.replace('/upload', '/upload/c_scale,h_500,w_800');
})
const propiedadSchema = new mongoose.Schema({
    titulo : {
      type: String,
      required: true
    },

    tipo: {
      type: String,
      enum: ['Venta', 'Alquiler'],
      required : true
    },
    precio :{
      type:String,
    },
    imagenes:[ImagenSchema],

    descripcion:{
        type:String

    },
    direccion:{
      type:String

  },


  })
  
  const Propiedad = mongoose.model('Propiedad', propiedadSchema);

module.exports = Propiedad;
  
  
const cloudinary = require('cloudinary').v2;

const { CloudinaryStorage } = require('multer-storage-cloudinary');


 
cloudinary.config({

    cloud_name:'wildrama',
    api_key:'472512529558192',
    api_secret: 'eVoD_WdCtP2Ig6VMogXIxKdaHKM'
});

const storage = new CloudinaryStorage({
  cloudinary: cloudinary,
    params: {
    folder: 'imagenespropiedad',
    allowedFormats: ['jpeg', 'png', 'jpg']
  },
});
 
 


module.exports = {
  cloudinary,
  storage
}
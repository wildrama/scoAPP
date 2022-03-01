const cloudinary = require('cloudinary').v2;
const { CloudinaryStorage } = require('multer-storage-cloudinary');


const express = require('express');
const multer = require('multer');
 
cloudinary.config({

    cloud_name: process.env.CLOUDINARY_CLOUD_NAME,
    api_key: process.env.CLOUDINARY_KEY,
    api_secret: process.env.CLOUDINARY_SECRET
});

const storage = new CloudinaryStorage({
  cloudinary: cloudinary,
  params: {
    folder: 'imagenesProp',
    format: async (req, file) => 'png', // supports promises as well
    public_id: (req, file) => 'computed-filename-using-request',
  },
});
 
const parser = multer({ storage: storage });
 
app.post('/upload', parser.single('image'), function (req, res) {
  res.json(req.file);
});


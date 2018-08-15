var webpack = require('webpack');
var path = require('path');

var BUILD_DIR = path.resolve(__dirname, './build');
var APP_DIR = path.resolve(__dirname, './src');

const config = {
   entry: {
     main: APP_DIR + '/index.js'
   },
   output: {
     filename: 'bundle.js',
     path: BUILD_DIR,
   },
   devtool: 'source-map',
   module: {
    rules: [
     {
       test: /\.(jsx|js)?$/,
       exclude: [/node_modules/, /assets/],
       use: [{
         loader: "babel-loader",
         options: {
           cacheDirectory: true,
           presets: ['react', 'env'] // Transpiles JSX and ES6
         }
       }]
     }
    ],

  }
};

module.exports = config;
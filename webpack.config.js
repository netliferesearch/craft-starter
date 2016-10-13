'use-strict'
require('babel-polyfill')
const webpack = require('webpack')
const path = require('path')
const ExtractTextPlugin = require('extract-text-webpack-plugin')
const BrowserSyncPlugin = require('browser-sync-webpack-plugin')
const nodeModulesPath = path.resolve(__dirname, 'node_modules')
const mainJSPath = path.resolve(__dirname, 'resources/js', 'app.js')
const mainCSSPath = path.resolve(__dirname, 'resources/scss', 'style.scss')
const publicPath = path.resolve(__dirname, 'public')

module.exports = {
  entry: {
    main: [
      'babel-polyfill',
      mainJSPath,
      mainCSSPath
    ]
  },
  output: {
    filename: path.join('js','min','[name].js'),
    path: publicPath,
    publicPath: publicPath
  },
  module: {
    preLoaders: [{
      test: /\.jsx$|\.js$/,
      loader: 'standard',
      exclude: path.join('(node_modules|bower_components)'),
      include: path.join('resources','js')
    }],
    loaders: [
      {
        test: /\.jsx$|\.js$/,
        include: path.join('resources','js'),
        loader: 'babel',
        exclude: [nodeModulesPath]
      },
      {
        test: /\.scss?$/,
        loader: ExtractTextPlugin.extract('css-loader!sass-loader')
      },
      {
        test: /\.(eot|gif|woff|woff2|png|ttf)([\?]?.*)$/,
        loader: path.resolve('file-loader?name=assets','[name].[ext]')
      },
      {
        test: /\.svg/,
        loader: path.resolve('svg-url-loader?name=assets','[name].[ext]')
      }
    ]
  },
  plugins: [
    new BrowserSyncPlugin({
      host: 'localhost',
      port: 3000,
      open: false,
      proxy: 'localhost:5000'
    }),
    new webpack.optimize.UglifyJsPlugin({
      compress: {
        warnings: false
      }
    }),
    new ExtractTextPlugin('css/min/screen.css', {
      allChunks: true
    })
  ],
  resolve: {
    // you can now require('file') instead of require('file.coffee')
    extensions: ['', '.js', '.json']
  }
}

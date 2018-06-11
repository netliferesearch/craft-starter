const path = require('path')
const ExtractTextPlugin = require('extract-text-webpack-plugin')
const BrowserSyncPlugin = require('browser-sync-webpack-plugin')

module.exports = {
  context: path.resolve(__dirname),
  entry: ['./web/js/main.js', './web/css/style.css'],
  output: {
    filename: 'bundle.js',
    path: path.resolve(__dirname, 'web/dist')
  },
  module: {
    rules: [
      {
        test: /\.css$/,
        use: ExtractTextPlugin.extract({
          fallback: 'style-loader',
          use: [{ loader: 'css-loader' }, { loader: 'postcss-loader' }]
        })
      },
      {
        test: /\.(eot|gif|woff|woff2|png|ttf)([?]?.*)$/,
        use: ['file-loader?name=[name].[ext]&publicPath=/webpack-dist/']
      },
      {
        test: /\.js$/,
        exclude: /(node_modules|bower_components)/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: ['@babel/preset-env']
          }
        }
      }
    ]
  },
  plugins: [
    new ExtractTextPlugin('screen.css'),
    new BrowserSyncPlugin({
      host: 'localhost',
      port: 3000,
      cors: true,
      notify: false,
      proxy: 'http://localhost:5000',
      files: ['./config', './templates']
    })
  ]
}

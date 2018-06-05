const path = require('path')
const webpack = require('webpack')

module.exports = {
  entry: ['./web-src/app.js', './web-src/style.css'],
  output: {
    filename: 'bundle.js',
    path: path.resolve(__dirname, 'web')
  },
  module: {
    rules: [
      {
        test: /\.css$/,
        use: [
          'style-loader',
          { loader: 'css-loader', options: { importLoaders: 1 } },
          'postcss-loader'
        ]
      }
    ]
  },
  devServer: {
    contentBase: '/',
    inline: true,
    port: 3000,
    proxy: {
      '**': 'http://0.0.0.0:5000/'
    }
  }
}

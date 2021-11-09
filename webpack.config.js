const path = require('path')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')
const BrowserSyncPlugin = require('browser-sync-webpack-plugin')

module.exports = {
  context: path.resolve(__dirname),
  entry: ['./resources/js/main.js', './resources/css/main.css'],
  output: {
    filename: '[name].dist.js',
    path: path.resolve(__dirname, 'public/dist'),
  },
  module: {
    rules: [
      {
        test: /\.css$/,
        use: [
          MiniCssExtractPlugin.loader,
          { loader: 'css-loader' },
          { loader: 'postcss-loader' },
        ],
      },
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: ['babel-preset-env'],
          },
        },
      },
      {
        // if a JS file requires a file it will be moved to ./public/dist
        test: /\.(eot|gif|woff|woff2|png|ttf)([?]?.*)$/,
        use: ['file-loader?name=[name].[ext]&publicPath=/dist/'],
      },
    ],
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: '[name].dist.css',
    }),
    new BrowserSyncPlugin({
      host: 'localhost',
      port: 3000,
      cors: true,
      notify: false,
      proxy: 'http://localhost:5000',
      files: ['./config', './templates'],
    }),
  ],
}

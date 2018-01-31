const path = require('path')

module.exports = {
  context: path.resolve(__dirname),
  entry: './resources/js/app.js',
  output: {
    filename: 'main.js',
    path: path.resolve(__dirname, 'public')
  }
}

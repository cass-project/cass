var webpack = require('webpack');

function WebpackConfigBuilder() {
  this.publicPath = __dirname + '/../www/app/public';
  this.wwwPath = '/public';
  this.assetsDir = 'assets';
  this.bundlesDir = 'assets/bundles';
}

WebpackConfigBuilder.prototype = {
  build: function() {
    return {
      entry: [
        './index.js'
      ],
      output: {
        filename: '[name].js',
        path: this.publicPath + '/' + this.bundlesDir,
        publicPath: this.wwwPath + '/' + this.bundlesDir
      },
      module: {
        loaders: [
          {
            test: /\.js$/,
            exclude: /(node_modules|bower_components)/,
            loader: 'babel',
            query: {
              presets: ['es2015']
            }
          },
          {
            test: /\.css$/,
            loader: "style-loader!css-loader"
          },
          {
            test: /\.json$/,
            loader: 'json-loader'
          },
          {
            test: /\.html$/,
            loader: 'raw-loader'
          },
          {
            test: /\.scss$/,
            loaders: ["style", "css", "sass"]
          }
        ]
      }
    };
  }
};

module.exports = (new WebpackConfigBuilder()).build();
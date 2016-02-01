var webpack = require("webpack");

var STAGE = 'development';
var PATHS = {
  'www': __dirname + '/../www/app/public/assets'
};

module.exports = {
  entry: [
    './app/app.ts',
  ],
  output: {
    filename: '[name].js',
    path: PATHS.www + '/bundles',
    publicPath: '/public/assets/bundles'
  },
  resolve: {
    extensions: ['', '.webpack.js', '.web.js', '.ts', '.js']
  },
  module: {
    loaders: [
      {
        test: /\.css$/,
        loader: "style-loader!css-loader"
      },
      {
        test: /\.ts$/,
        loader: 'ts-loader',
        query: {
          'ignoreDiagnostics': [
            2403, // 2403 -> Subsequent variable declarations
            2300, // 2300 -> Duplicate identifier
            2374, // 2374 -> Duplicate number index signature
            2375, // 2375 -> Duplicate string index signature,
            1219  // 1219 -> Experimental support for decorators
          ]
        },
        exclude: [
          /\.(spec|e2e)\.ts$/,
          /node_modules\/(?!(ng2-.+))/
        ]
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
  },
  plugins: [
    // new webpack.optimize.UglifyJsPlugin({minimize: true})
  ]
};
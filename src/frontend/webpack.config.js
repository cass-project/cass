var webpack = require("webpack");

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
        './app/index.ts',
      ],
      output: {
        filename: '[name].js',
        path: this.publicPath + '/' + this.bundlesDir,
        publicPath: this.wwwPath + '/' + this.bundlesDir
      },
      resolve: {
        extensions: ['', '.webpack.js', '.web.js', '.ts', '.js']
      },
      watchOptions: {
        poll: true
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
              'compilerOptions': {
                'module': 'commonjs',
                'emitDecoratorMetadata': true,
                'experimentalDecorators': true,
                'sourceMap': true,
                'target': 'es5'
              },
              'ignoreDiagnostics': [
                2403, // 2403 -> Subsequent variable declarations
                2300, // 2300 -> Duplicate identifier
                2374, // 2374 -> Duplicate number index signature
                2375, // 2375 -> Duplicate string index signature
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
            test: /\.head.scss$/,
            loaders: ["style", "css", "sass"]
          },
          {
            test: /\.shadow.scss$/,
            loaders: ["raw-loader", "sass"]
          },
          {
            test: /\.scss$/,
            loaders: ["style", "css", "sass"],
            exclude: /head|shadow\.scss$/
          },
          {
            test: /\.woff(2)?(\?v=[0-9]\.[0-9]\.[0-9])?$/,
            loader: "url-loader?limit=10000&minetype=application/font-woff"
          },
          {
            test: /\.(ttf|eot|svg)(\?v=[0-9]\.[0-9]\.[0-9])?$/,
            loader: "file-loader"
          },
          {
            test: /\.jade$/,
            loaders: ['raw-loader', 'jade-html']
          }
        ]
      }
    }
  }
};

module.exports = (new WebpackConfigBuilder()).build();
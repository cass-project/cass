const webpackMerge = require('webpack-merge');
const commonConfig = require('./webpack.common.js');

function WebpackConfigBuilder() {
    this.publicPath = __dirname + '/../../www/app/dist';
    this.wwwPath = '/dist';
    this.bundlesDir = 'bundles';
}

WebpackConfigBuilder.prototype = {
    build: function () {
        console.log('path: ' + this.publicPath + this.bundlesDir);
        return {
            entry: {
                main: './src/app/frontend-app/app.ts',
                loader: './src/app/loading-indicator-app/index.ts'
            },
            output: {
                filename: '[name].js',
                path: this.publicPath + '/' + this.bundlesDir,
                publicPath: this.wwwPath + '/' + this.bundlesDir + '/'
            }
        }
    }
};

module.exports = webpackMerge(commonConfig, (new WebpackConfigBuilder()).build());
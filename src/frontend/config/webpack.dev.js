const webpackMerge = require('webpack-merge');
const commonConfig = require('./webpack.common.js');

const METADATA = {
    ENV: process.env.ENV = process.env.NODE_ENV = 'development',
    HOST: process.env.HOST || 'localhost',
    PORT: process.env.PORT || 3000
};

function WebpackConfigBuilder() {
    this.publicPath = __dirname + '/../../dev/app/dist';
    this.wwwPath = '/dist';
    this.bundlesDir = 'bundles';
}

WebpackConfigBuilder.prototype = {
    build: function () {
        return {
            context: __dirname + '/../src/app',
            entry: {
                main: './frontend-app/app.ts',
                frontline: './frontline-request-app/index.ts'
            },
            devtool: 'cheap-module-source-map'
        }
    }
};

module.exports = webpackMerge(commonConfig, (new WebpackConfigBuilder()).build());
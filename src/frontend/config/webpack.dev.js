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
            entry: {
                main: './src/app/frontend-app/app.ts',
                frontline: './src/app/frontline-request-app/index.ts'
            },
            output: {
                filename: '[name].js',
                path: this.publicPath + '/' + this.bundlesDir
            },
            devServer: {
                port: METADATA.PORT,
                host: METADATA.HOST,
                watchOptions: {
                    aggregateTimeout: 300,
                    poll: 1000
                },
                inline: true,
                contentBase: this.publicPath + '/../'
            },
            devtool: 'cheap-module-source-map'
        }
    }
};

module.exports = webpackMerge(commonConfig, (new WebpackConfigBuilder()).build());
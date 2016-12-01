const webpackMerge = require('webpack-merge');
const commonConfig = require('./webpack.common.js');

const HtmlWebpackPlugin = require('html-webpack-plugin');

module.exports = webpackMerge(commonConfig, {
    devtool: 'cheap-module-source-map',
    plugins: [
        new HtmlWebpackPlugin({
            template: './frontend-app/index.html',
            filename: '../../frontend.html',
            inject: 'head',
            metadata: {
                isProduction: true
            },
            excludeChunks: ['main']
        })
    ]
});
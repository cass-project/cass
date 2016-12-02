const webpackMerge = require('webpack-merge');
const commonConfig = require('./webpack.common.js');

module.exports = webpackMerge(commonConfig, {
    entry: {
        main: './frontend-app/app.ts',
        loader: './loading-indicator-app-dev/index.ts'
    },
    devtool: 'cheap-module-source-map'
});
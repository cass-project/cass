const webpackMerge = require('webpack-merge');
const commonConfig = require('./webpack.common.js');

module.exports = webpackMerge(commonConfig, {
    entry: {
        main: './src/app/frontend-app/app.ts',
        loader: './src/app/loading-indicator-app/index.ts'
    }
});
const webpack = require("webpack");

const HtmlWebpackPlugin = require('html-webpack-plugin');


function WebpackConfigBuilder() {
    this.publicPath = __dirname + '/../../www/app/dist';
    this.wwwPath = '/dist';
    this.bundlesDir = 'bundles';
}

WebpackConfigBuilder.prototype = {
    build: function () {
        return {
            context: __dirname + '/../src/app',
            output: {
                filename: '[name].js',
                path: this.publicPath + '/' + this.bundlesDir,
                publicPath: this.wwwPath + '/' + this.bundlesDir + '/'
            },
            resolve: {
                extensions: ['', '.webpack.js', '.web.js', '.ts', '.js']
            },
            watchOptions: {
                pull: true,
                ignored: /node_modules/
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
                        loader: 'raw-loader',
                        exclude: [
                            '/Users/artem/Desktop/cass/src/frontend/src/app/frontend-app/index.html'
                        ]
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
            },
            plugins: [
                new webpack.ProvidePlugin({
                    $: "jquery",
                    jQuery: "jquery",
                    "window.jQuery": "jquery",
                    Tether: 'tether',
                    "window.Tether": 'tether',
                    'Promise': 'bluebird'
                }),
                new webpack.NoErrorsPlugin(),
                new HtmlWebpackPlugin({
                    template: './frontend-app/index.html',
                    filename: '../../frontend.html',
                    inject: 'head',
                    excludeChunks: ['main']
                })
            ]
        }
    }
};

module.exports =  (new WebpackConfigBuilder()).build();


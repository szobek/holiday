const webpack = require('webpack');
const path = require('path');
const ExtractTextPlugin = require("extract-text-webpack-plugin");

let DEV_MODE = false;

let config = {
    entry: {
        main: [
            './dev/js/main.js',
            './dev/sass/app.sass'
        ]
    },
    output: {
        path: path.resolve(__dirname, 'public/build/js'),
        filename: 'app.js'
    },
    module: {
        rules: [
            {
                test: /\.js/,
                loader: 'babel-loader'
            },
            {
                test: /\.sass$/,
                use: ExtractTextPlugin.extract({
                    fallback: 'style-loader',
                    use: [
                        {
                            loader: 'css-loader',
                            options: {
                                minimize: true
                            }
                        },
                        'postcss-loader',
                        'sass-loader'
                    ]
                })
            },
            {
                test: /.(png|woff(2)?|eot|ttf|svg)(\?[a-z0-9=\.]+)?$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            name: '../css/[hash].[ext]'
                        }
                    }
                ]
            },
            {
                test : /\.css$/,
                use: ['style-loader', 'css-loader', 'postcss-loader']
            }
        ]
    },
    plugins: [
        new ExtractTextPlugin(path.join('..', 'css', 'app.css'))
    ]
};

config.plugins.push(
    new webpack.optimize.UglifyJsPlugin({
        sourceMap: false,
        compress: {
            sequences: true,
            conditionals: true,
            booleans: true,
            if_return: true,
            join_vars: true,
            drop_console: false,
            warnings: true,
            unused: false // meghagyja a változókat és fnt
        },
        output: {
            comments: false
        },
        minimize: true
    })
);

module.exports = config;

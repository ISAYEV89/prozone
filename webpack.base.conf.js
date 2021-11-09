const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const HtmlWebpackPlugin = require('html-webpack-plugin');

const PATHS = {
    src: path.join(__dirname, './src'),
    dist: path.join(__dirname, './dist'),
    assets: 'assets/'
};

// url list

// let htmlUrl = 'index';
// let htmlUrl = 'blog';
let htmlUrl = 'blog-inner';
// let htmlUrl = 'contact';
// let htmlUrl = 'about-us';
// let htmlUrl = 'element';


// let  publicPath = '/';
let publicPath = './';

module.exports = {

    externals: {
        paths: PATHS
    },

    entry: {
        app: PATHS.src
    },
    output: {
        filename: `${PATHS.assets}js/[name].js`,
        path: PATHS.dist,
        publicPath: publicPath,
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                loader: 'babel-loader',
                exclude: '/node_modules/'
            },
            {
                test: /\.(png|jpg|gif|svg)$/,
                loader: 'file-loader',
                options: {
                    name: '[name].[ext]'
                }
            },
            {
                test: /\.scss$/,
                use: [
                    'style-loader',
                    MiniCssExtractPlugin.loader,
                    {
                        loader: 'css-loader',
                        options: {sourceMap: true}
                    }, {
                        loader: 'postcss-loader',
                        options: {sourceMap: true, config: {path: 'src/assets/js/postcss.config.js'}}
                    }, {
                        loader: 'sass-loader',
                        options: {sourceMap: true}
                    }
                ]
            }, {
                test: /\.css$/,
                use: [
                    'style-loader',
                    MiniCssExtractPlugin.loader,
                    {
                        loader: 'css-loader',
                        options: {sourceMap: true}
                    }, {
                        loader: 'postcss-loader',
                        options: {sourceMap: true, config: {path: 'src/assets/js/postcss.config.js'}}
                    }
                ]
            }]
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: `${PATHS.assets}css/[name].css`,
        }),
        new HtmlWebpackPlugin({
            hash: false,
            template: `${PATHS.src}/${htmlUrl}.html`,
            filename: `./${htmlUrl}.html`
        }),
        new CopyWebpackPlugin([
            {from: `${PATHS.src}/assets/image`, to: `${PATHS.assets}/image`},
            {from: `${PATHS.src}/assets/static`, to: `${PATHS.assets}/static`},
            {from: `${PATHS.src}/assets/fonts`, to: `${PATHS.assets}/fonts`}
        ])
    ]
};

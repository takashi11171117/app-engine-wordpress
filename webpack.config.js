const path = require('path');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const extractSass = new ExtractTextPlugin("[name].css");
module.exports = [{
    context: __dirname,
    entry: {
        style: __dirname + '/wp-content/themes/default_theme/assets/scss/style.scss',
    },
    output: {
        path: __dirname + '/wp-content/themes/default_theme/build/css',
        filename: '[name].css'
    },
    module: {
        rules: [{
            test: /\.(jpg|png|woff|woff2|eot|ttf|svg)$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            name: '[name].[ext]',
                            outputPath: 'img/'
                        }
                    }
                ]
            }, {
            test: /\.scss$/,
            exclude: /node_modules/,
            use: extractSass.extract({
                fallback: "style-loader",
                use: [{
                    loader: 'css-loader'
                }, {
                    loader: "sass-loader",
                    options: {
                        includePaths: [
                            path.join(__dirname) + '/node_modules/compass-mixins/lib',
                        ]
                    }
                }]
            }),
        }]
    },
    plugins: [
        extractSass
    ],
    resolve: {
        // style-loader の中で、.jsファイルを拡張子なしで requireしているところがあるため、'.js'が必要
        extensions: ['.css', '.js']
    },
}];

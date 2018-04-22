const webpack = require('webpack');

module.exports = [{
    entry: {
        index: __dirname + '/wp-content/themes/default_theme/assets/js/index.js',
    },
    output: {
        path: __dirname + '/wp-content/themes/default_theme/build/js',
        filename: '[name].js'
    },
    module: {
         rules: [
            {
                test: /\.js|\.tag$/,
                enforce: 'post',
                exclude: /node_modules/,
                use: [{
                    loader: 'babel-loader',
                    options: {
                        presets: 'es2015'
                    }
                }]
            },
            {
                test: /\.js|\.tag$/,
                exclude: /node_modules/,
                enforce: 'pre',
                use: [{
                    loader: 'eslint-loader',
                    options: {
                        configFile: './.eslintrc',
                        outputReport: {
                            filePath: 'eslint_checkstyle.xml',
                            formatter: require('eslint/lib/formatters/checkstyle'),
                        }
                    }
                }]

            }
         ]
    },
    resolve: {
         extensions: ['*', '.js']
    },
    externals: {
        jquery: 'jQuery'
    },
    plugins: [
         new webpack.optimize.CommonsChunkPlugin({
           name: 'commons',
           filename: 'common/commons.js',
         })
    ]
}]

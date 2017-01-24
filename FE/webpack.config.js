var path = require('path');

module.exports = {
    entry: './src/app.js',
    output: {
        path: path.resolve(__dirname, 'dist/'),
        publicPath: "/dist/",
        filename: 'app.js'
    },
    module: {
        loaders: [{
            test: /.js$/,
            loader: 'buble-loader',
        }, {
            test: /.vue$/,
            loader: 'vue-loader'
        }],
    },
    devServer: {
        inline: true
    }
};
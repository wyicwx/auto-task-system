var WebpackDevServer = require("webpack-dev-server");
var webpack = require("webpack");

var compiler = webpack(require('./webpack.config.js'));
var server = new WebpackDevServer(compiler, {
    // webpack-dev-server options
    // Can also be an array, or: contentBase: "http://localhost/",
    hot: true,
    // Enable special support for Hot Module Replacement
    // Page is no longer updated, but a "webpackHotUpdate" message is sent to the content
    // Use "webpack/hot/dev-server" as additional module in your entry point
    // Note: this does _not_ add the `HotModuleReplacementPlugin` like the CLI option does. 
    contentBase: 'dist',
    historyApiFallback: false,
    // Set this as true if you want to access dev server from arbitrary url.
    // This is handy if you are using a html5 router.

    compress: true,
    // Set this if you want to enable gzip compression for assets

    // proxy: {
    //     "**": "http://localhost:9090"
    // },
    // Set this if you want webpack-dev-server to delegate a single path to an arbitrary server.
    // Use "**" to proxy all paths to the specified server.
    // This is useful if you want to get rid of 'http://localhost:8080/' in script[src],
    // and has many other use cases (see https://github.com/webpack/webpack-dev-server/pull/127 ).

    // pass [static options](http://expressjs.com/en/4x/api.html#express.static) to inner express server
    staticOptions: {},

    clientLogLevel: "info",
    // Control the console log messages shown in the browser when using inline mode. Can be `error`, `warning`, `info` or `none`.

    // It's a required option.
    publicPath: "/static/js/",
    headers: {
        "X-Custom-Header": "yes"
    },
    stats: {
        colors: true
    }
});

server.listen(8080, "localhost", function() {

});
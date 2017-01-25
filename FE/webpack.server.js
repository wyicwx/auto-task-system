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
    publicPath: "/",
    headers: {
        "X-Custom-Header": "yes"
    },
    stats: {
        colors: true
    },
    proxy: {
        '/task/*': {
            target: 'http://task.weixin.com',
            // changeOrigin: true,
            headers: {
                Host: 'task.weixin.com',
                Referer: 'http://task.weixin.com',
                Cookie: 'advanced-frontend=ukk2l4302p4umtsv98ielf0rd6; _csrf-frontend=51ed6b4eb05fbfa8de9e1499307d2b3dad663d330a00417ae886f5fb523f9ccaa%3A2%3A%7Bi%3A0%3Bs%3A14%3A%22_csrf-frontend%22%3Bi%3A1%3Bs%3A32%3A%22ffEU3GXXHPtI7u7FkogGwWrAo5bfYjqi%22%3B%7D; _task_wx_=ac349143d77862cac6bacb0e435b0af8ee3f0dc31fa2f95d39d5bbfd7d54581aa%3A2%3A%7Bi%3A0%3Bs%3A9%3A%22_task_wx_%22%3Bi%3A1%3Bs%3A46%3A%22%5B1%2C%22oRrTor58XmmkaWQmvMSLt79S9oTj73qn%22%2C2592000%5D%22%3B%7D'
            },
            secure: false  
        }
    }
});

server.listen(8080, "localhost", function() {

});
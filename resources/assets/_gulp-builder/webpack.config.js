/**
 * Define NODE_ENV variable for global scope
 * And define necessary variable
 */
const NODE_ENV = process.env.NODE_ENV || 'dev';
const webpack = require('webpack');
const path = require('path');

console.info(`now is ${NODE_ENV} mode`);

module.exports = {
    /**
     * Entry points for scripts and library
     */
    entry: {
        script : path.join(__dirname,'./js/script.js'),
        libs : path.join(__dirname,'./js/libs.js')
    },
    /**
     * Output point.
     */
    output: {
        path: path.join(__dirname,'../../../public_html/js/'),
        publicPath: '/js/',
        filename: '[name].js', // for each of entry point create js
    },
    /**
     * For dev mode enable watch
     */
    watch: NODE_ENV == 'dev',
    mode: NODE_ENV == 'prod' ? 'production': 'development',
    watchOptions: {
        aggregateTimeout: 100 // what time about run rebuild
    },
    /**
     * Resolving need for js loaders
     */
    resolve: {
        modules: [ path.resolve(__dirname, 'node_modules') ]
    },
    resolveLoader: {
        modules: [ path.resolve(__dirname, 'node_modules') ]
    },
    /**
     * build different souce-map for different mode
     * details [https://webpack.github.io/docs/configuration.html#devtool]
     */
    devtool: NODE_ENV == 'dev' ? "source-map" : "cheap-module-source-map",
    /**
     * Define loaders which transpile and compiling js
     */
    module: {
        rules: [
            {
                exclude:path.resolve(__dirname, "node_modules"),
                test: /\.js$/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ["@babel/preset-env"]
                    }
                },

            }
        ],
    },
    /**
     * Define necessary plugins
     */
    plugins:[
        new webpack.ProvidePlugin({
            $: "jquery",
            jQuery: "jquery"
        }),
        new webpack.NoEmitOnErrorsPlugin(), // Disable build js with error
        new webpack.DefinePlugin({
            NODE_ENV: JSON.stringify(NODE_ENV), // Define NODE_ENV global
        }),
    ]
};
/**
 * For prod mode uglify js
 */
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
if(NODE_ENV == 'prod'){
    module.exports.plugins.push(
        new UglifyJsPlugin({
            sourceMap: true
        }),
    );
}
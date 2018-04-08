const path = require('path');
const ExtractTextPlugin = require("extract-text-webpack-plugin");
const CopyWebpackPlugin = require("copy-webpack-plugin");

module.exports = {
    entry: "./resources/assets/assets.js",

    output: {
        filename: "app.js",
        path: __dirname + "/public/assets"
    },

    // Enable sourcemaps for debugging webpack's output.
    devtool: "source-map",

    resolve: {
        extensions: [".ts", ".tsx", ".js", ".json"]
    },

    module: {
        rules: [
            { test: /\.(jpe?g|gif|png)$/, loader: 'file-loader', options: {
                emitFile: false,
                name: '../img/[name].[ext]?[hash]',
            }},

            // All files with a '.ts' or '.tsx' extension will be handled by 'awesome-typescript-loader'.
            { test: /\.tsx?$/, loader: "awesome-typescript-loader" },

            // All output '.js' files will have any sourcemaps re-processed by 'source-map-loader'.
            { enforce: "pre", test: /\.js$/, loader: "source-map-loader" },

            // All files with a '.css' or '.scss' extension will be handled by 'extract-text-webpack-plugin'.
            { test: /\.scss$/, use: ExtractTextPlugin.extract({
                    fallback: 'style-loader', use: ['css-loader', 'sass-loader']
            })}
        ]
    },

    plugins: [
        new ExtractTextPlugin('style.css'),
        new CopyWebpackPlugin([
            {
                context: path.resolve(__dirname),
                from: './node_modules/jquery/dist/jquery.js',
                to: path.resolve(__dirname, './public/assets/vendor/jquery.js')
            }
        ])
    ],

    // When importing a module whose path matches one of the following, just
    // assume a corresponding global variable exists and use that instead.
    // This is important because it allows us to avoid bundling all of our
    // dependencies, which allows browsers to cache those libraries between builds.
    externals: {
        "jquery": "jQuery",
    }
};
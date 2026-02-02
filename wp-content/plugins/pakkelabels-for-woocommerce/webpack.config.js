const defaultConfig = require( '@wordpress/scripts/config/webpack.config' )
const path = require('path')
const fs = require('fs')
const WooCommerceDependencyExtractionWebpackPlugin = require( '@woocommerce/dependency-extraction-webpack-plugin' )


// Tell WordPress to copy .php files
process.env.WP_COPY_PHP_FILES_TO_DIST = 'true'

// Tell wordpress where to find block files
process.env.WP_SRC_DIRECTORY = 'resources/blocks'

let entries = {}

// Find all scripts located top level in resources/js/ and add them as build entries
fs.readdirSync('./resources/js').forEach(file => {
    if (path.extname(file) === '.js' || path.extname(file) === '.jsx') {
        let f = path.parse(file)
        entries['../js/' + f.name] = ['./resources/js/' + file]
    }
})

// Find all SASS stylesheets located top level in resources/css/ and add them as build entries
fs.readdirSync('./resources/css').forEach(file => {
    if (path.extname(file) === '.scss') {
        let f = path.parse(file)
        entries['../css/' + f.name] = ['./resources/css/' + file]
    }
})

module.exports = [
    {
        ...defaultConfig,
        entry:  {
            ...defaultConfig.entry,
            ...entries
        },
        plugins: [
            ...defaultConfig.plugins.filter(
                ( plugin ) =>
                    plugin.constructor.name !== 'DependencyExtractionWebpackPlugin'
            ),
            new WooCommerceDependencyExtractionWebpackPlugin(),
        ]
    },
    {
        ...defaultConfig,
        plugins: [
            ...defaultConfig.plugins.filter(
                ( plugin ) =>
                    plugin.constructor.name !== 'DependencyExtractionWebpackPlugin'
            ),
            new WooCommerceDependencyExtractionWebpackPlugin(),
        ]
    }
]

Encore.addAliases({ 'mapuxevents': __dirname + '/assets/js/mapux' })

const Encore = require('@symfony/webpack-encore');

Encore
    // Directory where compiled assets will be stored
    .setOutputPath('public/build/')

    // Public path used by the web server to access the output path
    .setPublicPath('/build')

    // Only needed for files exceeding 256kb
    .configureFilenames({
        font: 'fonts/[name].[hash:8].[ext]',
        image: 'images/[name].[hash:8].[ext]'
    })

    // Add entry points to build your assets
    .addEntry('app', './assets/js/app.js')

    // Add loaders and plugins if needed

    // Enable SCSS processing
    .enableSassLoader()

    // Enable PostCSS processing
    .enablePostCssLoader()

    // Enable Source Maps
    .enableSourceMaps(!Encore.isProduction())

    // Empty the outputPath dir before each build
    .cleanupOutputBeforeBuild()

    // Enable build notifications
    .enableBuildNotifications()

    // Enable versioning of assets
    .enableVersioning(Encore.isProduction())
;

module.exports = Encore.getWebpackConfig();

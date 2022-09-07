const Encore = require('@symfony/webpack-encore');
const path = require('path');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

let config = Encore

    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')

    .configureSplitChunks(function(splitChunks) {

        splitChunks.automaticNameDelimiter = '_';

        splitChunks.cacheGroups = {
            defaultVendors: {
                test: /[\\/]node_modules[\\/]/,
                priority: -10
            },
        }
    })

    .addEntry('app', './assets/app.js')

    .splitEntryChunks()

    .enableSingleRuntimeChunk()

    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())

    .configureBabel((config) => {
        config.plugins.push('@babel/plugin-proposal-class-properties')
    })

    // enables @babel/preset-env polyfills
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })

    // enables Sass/SCSS support
    .enableSassLoader()

    .enableVueLoader(() => {}, { runtimeCompilerBuild: false })
;

if (Encore.isProduction()) {
    Encore.copyFiles({
        from: './assets/images',
        to: 'images/[path][name].[hash:8].[ext]'
    })
} else {
    Encore.copyFiles({
        from: './assets/images',
        to: 'images/[path][name].[ext]'
    })
}

config = config.getWebpackConfig();

module.exports = config;
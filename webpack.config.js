var Encore = require('@symfony/webpack-encore');

Encore
  .setOutputPath('public/build/')
  .setPublicPath('/build')

  .addEntry('admin/product/index', './assets/admin/js/product/index.js')

  .cleanupOutputBeforeBuild()
  .enableSourceMaps(!Encore.isProduction())
;

module.exports = Encore.getWebpackConfig();

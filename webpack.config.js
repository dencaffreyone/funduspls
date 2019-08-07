var Encore = require('@symfony/webpack-encore');

Encore
	.setOutputPath('public/build/')
	.setPublicPath('/build')

	.cleanupOutputBeforeBuild()

	.enableSassLoader()

	.copyFiles([
		{
			from: './assets/images',
			to: 'images/[path][name].[ext]'
		},
		{
			from: './assets/fonts',
			to: 'fonts/[path][name].[ext]'
		}
	],)

	.addStyleEntry('css/backend', ['./assets/scss/backend/app.scss'])
	.addStyleEntry('css/frontend', ['./assets/scss/frontend/app.sass'])

	.addEntry('js/backend', ['./assets/js/backend/app.js'])
	.addEntry('js/frontend', ['./assets/js/frontend/app.js'])
;

module.exports = Encore.getWebpackConfig();
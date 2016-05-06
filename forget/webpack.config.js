var webpack = require('webpack');

module.exports = {
	entry: {
		react: [
			'./components/index.js'
		],
		js: [
			'./src/js/main.js'
		],
		style: [
			'./src/css/style.js'
		]
	},
	output: {
		path: __dirname + '/build/',
		publicPath: '/build/',
		filename: '[name].js'
	},
	module: {
		loaders: [
			{
				test: /\.js[x]?$/,
				loader: 'babel',
				query: {
					presets: ['es2015', 'react']
				}
			},
			{
				test: /\.less$/,
				loader: 'style!css!autoprefixer!less'
			},
			{
				test: /\.css$/,
				loader: 'style!css'
			},
			{
				test: /\.(jpg|png|woff|woff2|eot|ttf|svg)(\?v=[0-9]\.[0-9]\.[0-9])?$/,
				loader: 'url?limit=8192'
			}
		]
	},
	plugins: [
		new webpack.optimize.DedupePlugin(),
		new webpack.optimize.UglifyJsPlugin({
			compress: {
				warnings: false
			}
		})
	]
}
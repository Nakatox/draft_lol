const express = require("express")

const ChampionsBot = require("./bot/champions.js")
const app = express()
const port = 3000

;(async () => {
	const bot = new ChampionsBot()
	await bot.init()
	await bot.getAllChampionsNamesAndLinks()
	await bot.getAllChampionsItems()
	await bot.stockData()
	app.listen(port, () => {
		console.log(`Example app listening at http://localhost:${port}`)
	})
})()

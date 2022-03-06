const ChampionsBot = require("./bot/champions.js")

;(async () => {
	const bot = new ChampionsBot()
	await bot.init()
	await bot.getAllChampionsNamesAndLinks()
	await bot.getAllChampionsItems()
	await bot.stockData()
})()

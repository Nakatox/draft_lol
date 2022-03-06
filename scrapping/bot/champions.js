class ChampionsBot {
	constructor() {
		this.url = "https://probuildstats.com/champions"
		this.urlChamp = "https://probuildstats.com"
	}

	init = async () => {
		this.puppeteer = require("puppeteer")
		this.fs = require("fs")
		this.browser = await this.puppeteer.launch({
			headless: true
		})

		this.page = await this.browser.newPage()
		await this.page.goto(this.url)
	}

	getAllChampionsNamesAndLinks = async () => {
		// Enter the credentials
		await this.page.waitForTimeout(3000)
		await this.page.click("#qc-cmp2-container .css-bhal5e.css-bhal5e .qc-cmp2-footer .qc-cmp2-summary-buttons button:first-of-type", { delay: 200 })

		this.championsSelector = ".champion-home-page .champion-list .champion-link"
		this.championsNamesAndLinks = await this.page.$$eval(this.championsSelector, (elements) =>
			elements.map((data, index) => {
				return { id: index, name: data.children[1].innerHTML, link: data.getAttribute("href") }
			})
		)
		return this.championsNamesAndLinks
	}

	getAllChampionsItems = async () => {
		this.champions = []
		for (const champion of this.championsNamesAndLinks) {
			try {
				await this.page.goto(this.urlChamp + champion.link)
				await this.page.waitForTimeout(1000)

				await this.page.waitForSelector(".champion-page_bg")
				this.mythicsSelector = ".champion-page_top-bar .champion-mythics .top-items .item"
				this.mythicItems = await this.page.$$eval(this.mythicsSelector, (elements) =>
					elements.map((data, index) => {
						return { name: data.firstElementChild.firstElementChild.getAttribute("alt") }
					})
				)
				this.itemsSelector = ".champion-page_top-bar .champion-items .top-items .item"
				this.items = await this.page.$$eval(this.itemsSelector, (elements) =>
					elements.map((data, index) => {
						return { name: data.firstElementChild.firstElementChild.getAttribute("alt") }
					})
				)

				console.log({ id: champion.id, name: champion.name, mythics: this.mythicItems, popularItems: this.items })

				this.champions.push({ id: champion.id, name: champion.name, mythics: this.mythicItems, popularItems: this.items })
			} catch (error) {
				console.log(error)
			}
		}
		return this.champions
	}

	stockData = async () => {
		try {
			this.fs.writeFileSync("champions.json", JSON.stringify(this.champions))
			return
		} catch (error) {
			console.error(error)
		}
	}
}

module.exports = ChampionsBot

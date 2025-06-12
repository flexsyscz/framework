import netteForms from './core/netteForms';
import naja from "naja/dist/Naja";
import LoadingIndicatorExtension from './core/loadingIndicatorExtension';
import front_loader from "./ui/front/_loader";
import Bootstrap from "./core/bootstrap"
import data from "bootstrap/js/src/dom/data";
import datagrid from "@flexsyscz/datagrids";

class App {
	constructor() {
		this.init()
	}

	init() {
		netteForms()
		naja.initialize()
		naja.registerExtension(new LoadingIndicatorExtension('#globalLoadingIndicator'))

		naja.uiHandler.addEventListener('interaction', (event) => {
			let el = event.detail.element
			if (el.hasAttribute('data-confirm') && ! window.confirm(el.getAttribute('data-confirm'))) {
				event.preventDefault()
			}
		})

		datagrid()
	}

	run() {
		let html = document.querySelector('html')
		if (html) {
			let scope = html.dataset.scope
			if (scope) {
				front_loader(scope)
			}
		}
	}
}


let app = new App()
app.run()

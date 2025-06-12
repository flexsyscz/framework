export default class LoadingIndicatorExtension {
	progressbarValue = 0
	progressbarHandler = null

	constructor(defaultLoadingIndicatorSelector) {
		this.defaultLoadingIndicatorSelector = defaultLoadingIndicatorSelector
	}

	initialize(naja) {
		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', () => {
				this.defaultLoadingIndicator = document.querySelector(this.defaultLoadingIndicatorSelector)
			})
		} else {
			this.defaultLoadingIndicator = document.querySelector(this.defaultLoadingIndicatorSelector)
		}

		naja.uiHandler.addEventListener('interaction', this.locateLoadingIndicator.bind(this))
		naja.addEventListener('start', this.showLoader.bind(this))
		naja.addEventListener('complete', this.hideLoader.bind(this))
	}

	locateLoadingIndicator(event) {
		const loadingIndicator = event.detail.element.closest('[data-loading-indicator]')
		event.detail.options.loadingIndicator = loadingIndicator || this.defaultLoadingIndicator
	}

	showLoader(event) {
		event.detail.options.loadingIndicator?.classList.remove('d-none')
		const progressbar = event.detail.options.loadingIndicator?.querySelector('.progress-bar')
		if (progressbar) {
			progressbar.style.width = 0
			this.progressbarHandler = setInterval(() => {
				this.calculateProgressBarValue()
				if (this.progressbarValue < 95) {
					progressbar.style.width = this.progressbarValue + '%'
				}
			}, 100)
		}
	}

	hideLoader(event) {
		if (this.progressbarHandler) {
			clearInterval(this.progressbarHandler)

			this.progressbarValue = 100
			const progressbar = event.detail.options.loadingIndicator?.querySelector('.progress-bar')
			if (progressbar) {
				progressbar.style.width = this.progressbarValue + '%'
			}
		}

		setTimeout(() => {
			event.detail.options.loadingIndicator?.classList.add('d-none')
			this.progressbarValue = 0
		}, 500)
	}

	calculateProgressBarValue() {
		if (this.progressbarValue < 100) {
			this.progressbarValue = this.progressbarValue + Math.floor(Math.random() * 10)
			if (this.progressbarValue > 100) {
				this.progressbarValue = 100
			}
		}
	}
}

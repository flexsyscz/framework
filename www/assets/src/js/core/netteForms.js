import netteForms from "nette-forms"

export default function() {
	const deleteBtn = document.querySelector('input[type=submit][name=delete]')
	if (deleteBtn) {
		const deleteBtnEvent = (e) => {
			deleteBtn.closest('form.needs-validation').classList.remove('needs-validation')
		}

		deleteBtn.removeEventListener('click', deleteBtnEvent)
		deleteBtn.addEventListener('click', deleteBtnEvent)
	}

	netteForms.showFormErrors = function(form, errors) {
		Array.from(form.querySelectorAll('.invalid-feedback')).forEach(el => {
			const input = el.parentElement.querySelector('.is-invalid')
			if (input) {
				input.classList.remove('is-invalid')
				input.classList.add('is-valid')
			}

			el.remove()
		})

		let focused = false
		for (const i in errors) {
			const el = errors[i].element
			const parent = el.parentElement

			parent.classList.remove('was-validated')
			el.classList.remove('is-valid')
			el.classList.add('is-invalid')

			Array.from(parent.querySelectorAll('.valid-feedback, .invalid-feedback')).forEach(_el => {
				_el.remove()
			})
			
			const div = document.createElement('div')
			div.classList.add('invalid-feedback')
			div.textContent = errors[i].message
			parent.append(div)

			if(!focused) {
				el.focus()
				focused = true
			}

			console.error(errors[i].message)
		}
	}

	let form = document.querySelector('form.needs-validation')
	if (form) {
		form.addEventListener('submit', e => {
			Array.from(form.querySelectorAll('.form-controls .row')).forEach(el => {
				el.classList.add('was-validated')
			})

			if (this.checkValidity() === false) {
				e.preventDefault()
				e.stopPropagation()

				netteForms.validateForm(this)
			}
		})
	}

	window.Nette = netteForms
	netteForms.initOnLoad()
}

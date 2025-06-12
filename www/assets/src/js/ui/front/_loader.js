import sign from "./sign";

export default function(scope) {
	const mapper = {
		sign: sign
	}

	if (scope.search(/front\./) !== -1) {
		const target = scope.split('.')
		try {
			mapper[target[1]]()
		} catch (e) {
			console.error(`Module ${scope} cannot be loaded.`)
		}
	}
}

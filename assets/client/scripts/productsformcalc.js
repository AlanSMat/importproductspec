class ProductFormCalc {
	constructor(formId) {
		this.formId = formId;
		this._formElms = document.getElementById(formId).elements;
	}

	get formElms() {
		return this._formElms;
	}

	set formElms(formElms) {
		this._formElms = formElms;
	}

	addEventListenerAndSetTargetValue(event, elmTarget, callback) {
		const formElmTarget = this._formElms[elmTarget];

		formElmTarget.addEventListener(event, () => {
			formElmTarget.value = callback();
		});
	}
}

// ES6 get and set
class Person {
	constructor(name) {
		this._name = name;
	}

	get name() {
		return this._name.toUpperCase();
	}

	set name(newName) {
		this._name = newName; // validation could be checked here such as only allowing non numerical values
	}

	walk() {
		console.log(this._name + ' is walking.');
	}
}

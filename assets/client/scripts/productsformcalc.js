class ProductFormCalc {
	constructor(formId) {
		this.formId = formId;
		this._formElms = document.getElementById(formId).elements;
		this._elmId = 'xx';
	}

	get elmId() {
		return this._elmId;
	}

	set elmId(formElms) {
		this._elmId = formElms;
	}

	set elmByIdValue(elmId) {
		this._elmId;
		//this._formElms.getElementById(this._elmId).value;
	}

	get elmByIdValue() {
		return this._elmId;
		//return this._formElms.getElementById(this._elmId).value;
	}

	get x() {
		return this._x;
	}

	set x(id) {
		this._x = id;
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
		this._x = 'a';
	}

	get name() {
		return this._name.toUpperCase();
	}

	set name(newName) {
		this._name = newName; // validation could be checked here such as only allowing non numerical values
	}

	get x() {
		return this._x.toUpperCase();
	}

	set x(newName) {
		this._x = newName; // validation could be checked here such as only allowing non numerical values
	}

	walk() {
		console.log(this._x + ' is walking.');
	}
}

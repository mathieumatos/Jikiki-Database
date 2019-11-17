const update = function () {
	const attributes = {};
	Array.from(document.querySelectorAll("input:checked")).forEach((elem) => {
		const attribute = elem.parentElement.parentElement.parentElement.parentElement.firstElementChild.innerText;
		const value = elem.parentElement.parentElement.nextElementSibling.value;
		if (attributes[attribute] == null)
		{
			attributes[attribute] = [];
		}
		attributes[attribute].push(value);
	});

	const search = document.getElementById("search").value.toLowerCase();

	Array.from(document.getElementsByClassName("obj")).forEach((elem) => {
		let hidden = false;

		Object.keys(attributes).forEach((a) => {
			let containsAttribute = false;
			attributes[a].forEach((b) => {
				if (elem.innerHTML.indexOf(b) > 0)
					containsAttribute = true;
			});
			if (!containsAttribute)
				hidden = true;
		});

		if (elem.innerHTML.toLowerCase().indexOf(search) < 0)
		{
			hidden = true;
		}

		if (hidden)
		{
			elem.style.display = "none";
		}
		else
		{
			elem.style.display = "block";
		}
	});
};
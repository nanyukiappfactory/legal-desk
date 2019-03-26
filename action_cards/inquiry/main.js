setTimeout(function () {
	var pageBody = document.getElementById("page-body");
	pageBody.style.display = 'block';
	var welcome = document.getElementById("welcome");
	welcome.style.display = 'none';
}, 5300);

var caseTypes = {};

function getCaseTypes() {
	var xhttp = new XMLHttpRequest();
	var url = "https://legal-desk.azurewebsites.net/case_types/get_all_case_types";
	xhttp.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			try {
				caseTypes = JSON.parse(this.responseText);
			} catch (e) {
				caseTypes = this.responseText;
			}
			setCaseTypes(caseTypes);
		}
	};
	xhttp.open("GET", url, true);
	xhttp.send();
}

function setCaseTypes(caseTypes) {
	let totalCaseTypes = caseTypes.length;
	let cases = [];

	let casesSelect = '<option value="">';
	casesSelect += '---Select Case Type---';
	casesSelect += '</option>';

	for (r = 0; r < totalCaseTypes; r++) {
    if(caseTypes[r].case_type_parent == 0){
      let totalCases = cases.length;
      let check = false;
      for (t = 0; t < totalCases; t++) {
        let currentCase = cases[t];
        if (currentCase === caseTypes[r].case_type_name) {
          check = true;
        }
      }
      if (check === false) {
        cases.push(caseTypes[r].case_type_name);
        casesSelect += '<option value="' + caseTypes[r].case_type_id + '">' + caseTypes[r].case_type_name + '</option>';
      }
    }
	}
	//console.log(cases);
	// autocomplete(document.getElementById("Case"), cases);
	document.getElementById("case_type_parent").innerHTML = casesSelect;

	onPageLoad();
}

function select_child_case_type() {
  // alert("here");
	let totalCaseTypes = caseTypes.length;
	let childCases = [];
	let case_type_parent = document.getElementById("case_type_parent").value;

	let childCaseSelect = '<option value="">';
	childCaseSelect += '---Select Case Type---';
	childCaseSelect += '</option>';

	for (r = 0; r < totalCaseTypes; r++) {
		let totalChildCases = childCases.length;
		let check = false;
		if (case_type_parent === caseTypes[r].case_type_parent) {
			for (t = 0; t < totalChildCases; t++) {
				let currentCaseType = childCases[t];
				if (currentCaseType === caseTypes[r].case_type_id) {
					check = true;
				}
			}
			if (check === false) {
				childCases.push(caseTypes[r].case_type_id);
				childCaseSelect += '<option value="' + caseTypes[r].case_type_id + '">' + caseTypes[r].case_type_name + '</option>';

      }
      else{
        
        // alert("not false");
      }
		}

	}
	//console.log(childCases);
	// autocomplete(document.getElementById("SalesArea"), childCases);
	document.getElementById("case_type_child").innerHTML = childCaseSelect;
}

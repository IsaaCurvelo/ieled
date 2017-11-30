$(document).ready(function(){
	$("#telefone").mask("(00)00000-0000", {placeholder: "(xx)9xxxx-xxxx"});

	buscar();
});


var substringMatcher = function(strs) {
	return function findMatches(q, cb) {
		var matches, substringRegex;

		// an array that will be populated with substring matches
		matches = [];

		// regex used to determine if a string contains the substring `q`
		substrRegex = new RegExp(q, 'i');

		// iterate through the pool of strings and for any string that
		// contains the substring `q`, add it to the `matches` array
		$.each(strs, function(i, str) {
			if (substrRegex.test(str)) {
				matches.push(str);
			}
		});

		cb(matches);
	};
};


function buscar() {
	var method = "GET";
	var url = "/orgao-investigador/nomes";



	var xhttp;
	if (window.XMLHttpRequest) {
		xhttp = new XMLHttpRequest();
	}
	else {
		xhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}

	xhttp.onreadystatechange = function () {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			var textoResposta = xhttp.responseText;

			var options = JSON.parse(textoResposta);

			// $( "#orgao-investigador" ).autocomplete( {
			// 	source: options
			// }); 


			// $('#orgao-investigador').typeahead({

			// 	hint: true,
			// 	highlight: true,
			// 	minLength: 1

			// },
			// {

			// 	name: 'orgao-investigador',
			// 	source: substringMatcher(options)

			// });

			var states = new Bloodhound({
			  datumTokenizer: Bloodhound.tokenizers.whitespace,
			  queryTokenizer: Bloodhound.tokenizers.whitespace,
			  // `states` is an array of state names defined in "The Basics"
			  local: options
			});

			$('#orgao-investigador').typeahead({
			  hint: true,
			  highlight: true,
			  minLength: 1
			},
			{
			  name: 'states',
			  source: states
			});



			$('.tt-query').css('background-color','white'); 
			$('.tt-sugestion').css('cursor','pointer'); 
			$('.tt-selectable').css('cursor','pointer'); 
			$('.tt-sugestion').css('background-color','blue'); 
			$('.tt-menu').css('background-color','white'); 
			$('.twitter-typeahead').css('background-color', 'white');



		}
	}

	xhttp.open(method, url, true);
	xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhttp.send();
}
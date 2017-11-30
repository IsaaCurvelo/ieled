
$(document).ready(function() {
	$("#cnpj-empresa").mask("00.000.000/0000-00", {placeholder:'00.000.000/0000-00'});
	$("#data-inicio").mask("00/00/0000", {placeholder:'dd/mm/aaaa'});
	$("#data-fim").mask("00/00/0000", {placeholder:'dd/mm/aaaa'});

	$("#time-line-nav").css('display', 'none');
});

function buscaSimples(form) {

	var modo = document.getElementById('modoDeBusca').getAttribute('value');

	if (!modo) {
		document.getElementById('dropdownmenu').setAttribute("aria-expanded","true");
		document.getElementById('drop-list-open').classList.toggle("open");

		return false;
	}

	var textInput = document.getElementById('texto-busca'); 

	if (textInput == '') {

		alert("Digite algum texto no campo de busca.");
		return false;

	}

	textInput.setAttribute('value', textInput.value ); 
	

	form.submit();
}




function clickSearchOption(evtSrc) {

	var options = document.getElementsByClassName("drop-li");

	for (var i = options.length - 1; i >= 0; i--) {
		
		if (options[i].classList.contains('active')) {

			options[i].classList.remove('active');

		}

	}

	evtSrc.parentElement.classList.add('active');

	document.getElementById('modoDeBusca').setAttribute('value', evtSrc.getAttribute('value'));
	
	var textInput = document.getElementById('texto-busca'); 

	if (!textInput.value) 
		return false;

	textInput.setAttribute('value', textInput.value ); 
	
	
	var form = document.getElementById("form-navbar");

	form.submit();

}








function buscaAvancada(form) {
	var inpDataIn = document.getElementById("data-inicio").value;
	var inpDataFi = document.getElementById("data-fim").value;

	if ((inpDataIn && inpDataIn.length!= 10) || (inpDataFi && inpDataFi.length!= 10)){
		alert('preencha corretamente os campos de data ou os deixe completamente vazios.');
		return false;
	}


	form.submit();
}

function markRadio( radio ) {
	radio.checked = true;
	console.log(radio);
}


function habilita(num) {
	var select = document.getElementById('select' + num);
	if (select.getAttribute('disabled') == null) {
		select.setAttribute('disabled','');
	} else {
		select.removeAttribute('disabled');
	}
}

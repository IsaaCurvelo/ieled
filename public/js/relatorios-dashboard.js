
$(document).ready(function() {
	$("#data-inicio").mask("00/00/0000", {placeholder:'dd/mm/aaaa'});
	$("#data-fim").mask("00/00/0000", {placeholder:'dd/mm/aaaa'});
	document.getElementById('wrapper').setAttribute('class', 'col-md-12');

	$( "#progressbar" ).progressbar({
		value: false
	});

	$( '.ui-progressbar-value' ).css('height','110%');
	$('#sidebar-wrapper').css('height', window.innerHeight - 50);
});



$("#menu-toggle").click(function(e) {
	e.preventDefault();
	$("#wrapper").toggleClass("toggled");

	var toggleButton = document.getElementById('menu-toggle');
	toggleButton.innerHTML = toggleText(toggleButton.innerHTML);

});


function toggleText(text) {
	return text == 
		'mostrar <span class="glyphicon glyphicon-chevron-right"></span>' 
			? '<span class="glyphicon glyphicon-chevron-left"></span> esconder' 
			: 'mostrar <span class="glyphicon glyphicon-chevron-right"></span>';
}


function pressFilter(element) {
	element.classList.toggle('unselected');
}

function exportCSV(form) {
	var inptCtt;
	var valorSelect = document.getElementById("select").options[select.selectedIndex].value;

	inptCtt = document.createElement("input");
	inptCtt.setAttribute("type", "hidden");
	inptCtt.setAttribute("name", "contratante");
	inptCtt.setAttribute("value", valorSelect);
	form.appendChild(inptCtt);

	var situacaos = getSelectedSituacaos();
	for (var i = situacaos.length - 1; i >= 0; i--) {
		inptCtt = document.createElement("input");
		inptCtt.setAttribute("type", "hidden");
		inptCtt.setAttribute("name", "situacao"+i);
		inptCtt.setAttribute("value", situacaos[i]);
		form.appendChild(inptCtt);
	}

	var di = document.getElementById('data-inicio').value;
	var df = document.getElementById('data-fim').value;

	inptCtt = document.createElement("input");
	inptCtt.setAttribute("type", "hidden");
	inptCtt.setAttribute("name", "data-inicio");
	inptCtt.setAttribute("value", di);
	form.appendChild(inptCtt);




	inptCtt = document.createElement("input");
	inptCtt.setAttribute("type", "hidden");
	inptCtt.setAttribute("name", "data-fim");
	inptCtt.setAttribute("value", df);
	form.appendChild(inptCtt);

	// form.submit();
}

function submitFilters() {

	// UI wait

	$( "#loading" ).css('display', 'block');
	

	var data = {};
	var valorSelect = document.getElementById("select").options[select.selectedIndex].value;
	data['contratante'] = valorSelect;

	data['situacaos'] = getSelectedSituacaos();

	data['data-inicio'] = document.getElementById('data-inicio').value;
	data['data-fim'] = document.getElementById('data-fim').value;

	postRequest(data, '/novo', function(response) {
		// do something with response
		// colapse the lateral menu
		$("#loading").css('display', 'none');
		document.getElementById('content').innerHTML = response;

		var qtd = document.getElementById('qtd-items').innerHTML;
		document.getElementById('breadcrumb-qtd').innerHTML = 'Foram encontrados ' + qtd + ' registros';

		document.getElementById('btn-export').style.display = 'inline';
		document.getElementById('breadcrumbs').style.display = 'inline';

	});


}

function getSelectedSituacaos() {

	var botoes = document.querySelectorAll('a[idsit]');
	var situacoes = [];

	for (var i = 0;i < botoes.length; i++) {
		if(!botoes[i].classList.contains('unselected')){
			situacoes.push(botoes[i].attributes.idsit.value);
		}
	}
	return situacoes;
}


function postRequest(data, uri, callback) {
	var method = "POST";
	var url = url_base + "/relatorios" + uri;

	var params = "data=" + JSON.stringify(data);
	
	var xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function () {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			var textoResposta = xhttp.responseText;
				callback(textoResposta);
			
		}
	}
	//~ enviar requisição:

	var meta = $('meta[name="csrf-token"]').attr('content');
	
	xhttp.open(method, url, true);
	xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhttp.setRequestHeader("X-CSRF-TOKEN", meta);
	xhttp.send(params);
}


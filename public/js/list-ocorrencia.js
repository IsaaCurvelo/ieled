var globalStore = [];


$(document).ready(function(){
	$("#busca-ocorrencia-cnpj").mask("00.000.000/0000-00");
	$( "#progressbar" ).progressbar({
		value: false
	});

	$( '.ui-progressbar-value' ).css('height','110%');
});

function info(id) {

	$( "#loading" ).css('display', 'block');

	getOcorrencia(id, function (resposta) {
		$( "#loading" ).css('display', 'none');
		o = JSON.parse(resposta);
		var modal = document.getElementById("modal");
		var html = '<table class="table ">';
		html += '<tr><td><b>Nome da empresa: </b></td><td>' + o.empresa.nome + '</td></tr>';
		html += '<tr><td><b>Cnpj da empresa: </b></td><td>' + o.empresa.cnpj + '</td></tr>';
		try{
			html += '<tr><td><b>Área da contratação: </b></td><td>' + o.area_despesa.nome + '</td></tr>';
		} catch(e){} 
		try{
			html += '<tr><td><b>Tipo da contratação: </b></td><td>' + o.tipo_despesa.nome + '</td></tr>';
		} catch(e){}
		html += '<tr><td><b>Município contratante: </b></td><td>' + o.contratante.nome + '</td></tr>';
		if(o.valor){
			html += '<tr><td><b>Valor de contratação (R$): </b></td><td> ' + o.valor + '</td></tr>';
		}
		if(o.procedimento){
			html += '<tr><td><b>Fonte: </b></td><td>' + o.procedimento + '</td></tr>';
		}
		html += '<tr><td><b>Data de inserção: </b></td><td>' + o.data + '</td></tr>';
		html += '<tr><td><b>Situação: </b></td><td>' + o.situacao.nome + '</td></tr>';
		html += "</table>";
		modal.innerHTML = html;
    	var dWidth = $(window).width() * 0.8;
		$("#modal").dialog({
			closeText: "fechar"
			, closeOnEscape: true
			, width: dWidth
			, title: "Detalhes da contratação"
			, buttons: [
				{
					text: "fechar"
					, class: "btn-dismiss-dialog"
					, click: function () {
						$(this).dialog("close");
					}
				}
			]
		}).prev(".ui-dialog-titlebar").css("background", "#5bc0de");
	});
}

function editar(id) {
	$( "#loading" ).css('display', 'block');


	$.when(
		// Get the ocorrencia itself
		$.get(url_base + "/ocorrencias/get/" +id, function(ocorrencia) {
			globalStore.ocorrencia = ocorrencia;
		}),

		// Get the empresas
		$.get(url_base + "/empresas/json", function(empresas) {
			globalStore.empresas = empresas;
		}),

		$.get(url_base + "/contratantes/json", function(contratantes) {
			globalStore.contratantes = contratantes;
		}),

		$.get(url_base + "/area-despesas/json", function(areaDespesas) {
			globalStore.areaDespesas = areaDespesas;
		}),

		$.get(url_base + "/tipo-despesas/json", function(tipoDespesas) {
			globalStore.tipoDespesas = tipoDespesas;
		}),

		$.get(url_base + "/situacaos/json", function(situacaos) {
			globalStore.situacaos = situacaos;
		})

	).then(function() {
		$( "#loading" ).css('display', 'none');
		

		// console.log(globalStore);

		emp = globalStore.empresas;
		con = globalStore.contratantes;
		are = globalStore.areaDespesas;
		oco = globalStore.ocorrencia;
		tip = globalStore.tipoDespesas;
		sit = globalStore.situacaos;


		var modal = document.getElementById("modal");
		var html = '<table class="table ">';
		html += '<tr><td><b>Nome da empresa*: </b></td><td>';
		html += '<input type="text" class="form-control" ';
		html += 'id ="nome-empresa-campo" value="' + oco.empresa.nome + '"></td>';
		html += '</tr>';
		html += '<tr><td><b>CNPJ da empresa*: </b></td><td>';
		html += '<input type="text" class="form-control" ';
		html += 'id ="cnpj-empresa-campo" value="' + oco.empresa.cnpj + '"></td>';
		html += '</tr>';
	    html += '<tr><td><b>Situação*: </b></td>';
	    html += '<td>';
	    html += '<select class="form-control" ';
	    html += 'id ="situacao-campo" >';
	    html += '<option value = "-13">Selecione...</option>';
	    for (i = 0; i < sit.length; i++) {
	      html += '<option value="' + sit[i].id + '">' + sit[i].nome + '</option>';
	    }
	    html += '</select>';
	    html += '</td>';
	    html += '</tr>';
		html += '<tr><td><b>Área da contratação: </b></td>';
		html += '<td>';
		html += '<select class="form-control" ';
		html += 'id ="area-despesa-campo" >';
		html += '<option value = "-13">Selecione...</option>';
		for (i = 0; i < are.length; i++) {
			html += '<option value="' + are[i].id + '">' + are[i].nome + '</option>';
		}
		html += '</select>';
		html += '</td>';
		html += '</tr>';
		html += '<tr><td><b>Tipo da contratação: </b></td>';
		html += '<td>';
		html += '<select class="form-control" ';
		html += 'id ="tipo-despesa-campo" >';
		html += '<option value = "-13">Selecione...</option>';
		for (i = 0; i < tip.length; i++) {
			html += '<option value="' + tip[i].id + '">' + tip[i].nome + '</option>';
		}
		html += '</select>';
		html += '</td>';
		html += '</tr>';
		html += '<tr><td><b>Município contratante*: </b></td>';
		html += '<td>';
		html += '<select class="form-control" ';
		html += 'id ="municipio-contratante-campo" >';
		html += '<option value = "-13">Selecione...</option>';
		for (i = 0; i < con.length; i++) {
			html += '<option value="' + con[i].id + '">' + con[i].nome + '</option>';
		}
		html += '</select>';
		html += '</td>';
		html += '</tr>';
		html += '<tr><td><b>Valor da contratação: </b></td><td>';
		html += '<input type="text" class="form-control" ';
		html += 'id ="valor-campo" value="' + oco.valor + '"></td>'
		html += '</tr>';
		html += '<tr><td><b>Fonte: </b></td><td>';
		html += '<textarea rows="8" class="form-control" maxlength="240" ';
		html += 'id ="procedimento-campo" value="" onkeyup="contador()" >' + oco.procedimento +'</textarea></td>';
		html += '</tr>';

		html += "</table>";

		html += '<small id = "contador-caracteres" class = "pull-right" style="margin-top : 0.5ch">';
		html += '240 caractere(s) restante(s).';
		html += '</small>';
		modal.innerHTML = html;
    	var dWidth = $(window).width() * 0.8;

		$("#modal").dialog({
			closeText: "fechar"
			,open: function(event, ui) {
        $(".ui-dialog-titlebar-close", ui.dialog | ui).hide();
			}
			, closeOnEscape: true
			, width: dWidth
			,position: {
				my: "bottom",
				at: "center",
				of: window
			}
			, title: "Editar informações da contratação"
			, buttons: [
				{
					text: "salvar"
					, "style": "background:#5cb85c;	color: white; margin-left:2ch"
					, class: "btn-salvar-alteracoes"
					, click: function () {
						var selArDsp = document.getElementById("area-despesa-campo");
						var selTpDsp = document.getElementById("tipo-despesa-campo");
						var selMncCtt = document.getElementById("municipio-contratante-campo");
						var selSit = document.getElementById("situacao-campo");

						var novo = {
							//campos de texto:
							empresa: {
								nome: document.getElementById("nome-empresa-campo").value,
								cnpj: document.getElementById("cnpj-empresa-campo").value,
							},							
							valor: document.getElementById("valor-campo").value,
							procedimento: document.getElementById("procedimento-campo").value, //campos de select:,
							area_despesa_id: selArDsp.options[selArDsp.selectedIndex].value,
							tipo_despesa_id: selTpDsp.options[selTpDsp.selectedIndex].value,
							contratante_id: selMncCtt.options[selMncCtt.selectedIndex].value,
							situacao_id: selSit.options[selSit.selectedIndex].value
						};
						atualizaOcorrencia(oco, novo);
					}
				},
				{
					text: "deletar",
					class: "btn-deletar-ocorrencia",
					"style": "background:#d9534f;	color: white;",
					click: function () {
						deletaOcorrencia(oco.id);
					}
				},

				{
					text: "cancelar",
					class: "btn-dismiss-dialog",
					click: function () {
						try{
							$("#modal-confirm").dialog("close");
						}
            			catch(err){
              				// malandramente... o catch inocente, tranquilamente
              				// não faz nada aquIiiiiiIiiI.
            			}

						$(this).dialog("close");
					}
				}

			]
		}).prev(".ui-dialog-titlebar").css("background", "#FFCC00");

		// preparando a interface:
		$('.ui-dialog-buttonpane').find('button:contains("deletar")').prepend('<span class="glyphicon glyphicon-trash"></span> ');
		$('.ui-dialog-buttonpane').find('button:contains("salvar")').prepend('<span class="glyphicon glyphicon-floppy-disk"></span> ');

		$("#valor-campo").mask("000.000.000.000.000,00", {reverse: true, placeholder:"0,00"});
		$("#cnpj-empresa-campo").mask("00.000.000/0000-00", {placeholder:'00.000.000/0000-00'});

		// ----------------------

		// fazer com que as select exibam o conteúdo que voltou da requisição, ou "Selecione..." caso o campo seja null
		var selectArea = document.getElementById("area-despesa-campo");
		var selectTipo = document.getElementById("tipo-despesa-campo");
		var selectMunicipio = document.getElementById("municipio-contratante-campo");
		var selectSituacao = document.getElementById("situacao-campo");

		if (oco.area_despesa) {
			for (var i = 0; i < selectArea.options.length; i++) {
				if (selectArea.options[i].text === oco.area_despesa.nome) {
					selectArea.value = selectArea.options[i].value;
					break;
				}
			}
		}
		if (oco.tipo_despesa) {
			for (var i = 0; i < selectTipo.options.length; i++) {
				if (selectTipo.options[i].text === oco.tipo_despesa.nome) {
					selectTipo.value = selectTipo.options[i].value;
					break;
				}
			}
		}
	
		for (var i = 0; i < selectMunicipio.options.length; i++) {
			if (selectMunicipio.options[i].text === oco.contratante.nome) {
				selectMunicipio.value = selectMunicipio.options[i].value;
				break;
			}
		}
	
		for (var i = 0; i < selectSituacao.options.length; i++) {
			if (selectSituacao.options[i].text == oco.situacao.nome) {
				//console.log(i)
				selectSituacao.value = selectSituacao.options[i].value;
				break;
			}
		}
		

		if (!oco.procedimento){
			var inpt = document.getElementById("procedimento-campo");
			inpt.value = "";
			inpt.setAttribute("placeholder", "Não especificado ainda");
		}

		if (!oco.procedimento){
			var inpt = document.getElementById("valor-campo");
			inpt.value = "";
			inpt.setAttribute("placeholder", "Não especificado ainda");
		}



	});
}

function contador(){
	var tequstArea = $("#procedimento-campo");
	var limite = 240;
	var out = document.getElementById("contador-caracteres");
	var escrito = tequstArea.val().length;
	out.innerHTML = 240 - escrito + " caractere(s) restante(s)";
}

function getOcorrencia(id, callback, asynchronous = true ){
	var method = "GET";
	var url = url_base +"/ocorrencias/get/" + id;
	var asynchronous = true;

	var xhttp;

	if (window.XMLHttpRequest) {
		xhttp = new XMLHttpRequest();
	} else {
		// para IE6, IE5
		xhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}

	xhttp.onreadystatechange = function() {
	    if (xhttp.readyState == 4 && xhttp.status == 200) {
	      var textoResposta = xhttp.responseText;
	      // console.log (textoResposta);
	      callback(textoResposta);
	  	}
  	}

  	xhttp.open(method, url, asynchronous);
	xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhttp.send();
}


function atualizaOcorrencia(original, modificado) {
	modificado.id = original.id;
	if (!validaCampos(modificado)) {
		modalConfirm = document.getElementById("modal-confirm");
		var html = '<p>Por favor, preencha todos os campos obrigatórios.'+
							 ' Eles estão marcados com o <b> * </b> (asterisco).</p>';
		modalConfirm.innerHTML = html;
		$("#modal-confirm").dialog({
			closeText: "fechar",
			closeOnEscape: true,
			width: 450,
			position: {
				my: "bottom",
				at: "bottom",
				of: document.getElementById("modal")
			},
			title: "Aviso!",
			buttons: [
				{
					text: "OK",
					class: "btn-dismiss-dialog",
					click: function () {
						$(this).dialog("close");
					}
				}
			]
		}).prev(".ui-dialog-titlebar").css("background", "#FFCC00");
		$("#modal-confirm").dialog('open');

	} else if (modificado.empresa.cnpj.length != 18 && modificado.empresa.cnpj != '') {
    	modalConfirm = document.getElementById("modal-confirm");
		var html = '<p>Por favor, preencha todos os 18 dígitos do campo CNPJ.</p>';
		modalConfirm.innerHTML = html;
		$("#modal-confirm").dialog({
			closeText: "fechar"
			, closeOnEscape: true
			, width: 450
			, position: {
				my: "bottom"
				, at: "bottom"
				, of: document.getElementById("modal")
			}
			, title: "Aviso!"
			, buttons: [
				{
					text: "OK"
					, class: "btn-dismiss-dialog"
					, click: function () {
						$(this).dialog("close");
					}
				}
			]
		}).prev(".ui-dialog-titlebar").css("background", "#FFCC00");
		$("#modal-confirm").dialog('open');
	}

   else{

		modalConfirm = document.getElementById("modal-confirm");
		var html = "<p>Deseja realmente alterar a ocorrência?</p>";
		modalConfirm.innerHTML = html;
		$("#modal-confirm").dialog({
			closeText: "fechar",
			closeOnEscape: true,
			width: 450,
			title: "Confirmação de alteração",
			buttons: [
				{
					text: "alterar",
					id: "confirmar-alterar",
					class: "btn-salvar-alteracoes",
					"style": "background:#5cb85c;	color: white;",
					click: function () {
						//codigo para realizar as atualizações
						requisicaoEditarOcorrencia(modificado);
					}
				},
				{
					text: "cancelar",
					class: "btn-dismiss-dialog",
					click: function () {
						$(this).dialog("close");
					}
				}
			]
		}).prev(".ui-dialog-titlebar").css("background", "#5cb85c");
		$("#modal-confirm").dialog('open');
		$('#confirmar-alterar').prepend('<span class="glyphicon glyphicon-floppy-disk"></span> ');


	}
}


function validaCampos(modificado){
	var res = true;
	if(modificado.empresa.nome == ''
		||modificado.situacao_id == -13
		||modificado.contratante_id == -13)
	{
		res = false;
	}

	return res;
}

function requisicaoEditarOcorrencia(ocorrencia){
	var method = "POST";
	var url = url_base + "/ocorrencias/editar/" + ocorrencia.id;

	//setar os parametros da requisição:
	var params = "req_data=" + JSON.stringify(ocorrencia);
	
	var xhttp;
	if (window.XMLHttpRequest) {
		xhttp = new XMLHttpRequest();
	}
	else {
		// para IE6, IE5
		xhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}

	xhttp.onreadystatechange = function () {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			var textoResposta = xhttp.responseText;
			if (textoResposta == 'ok'){
				modalConfirm = document.getElementById("modal-confirm");
				var html = "<p>A alteração foi realizada com sucesso... Aguarde.</p>";
				modalConfirm.innerHTML = html;
				$("#modal-confirm").dialog({
					closeText: "fechar",
					closeOnEscape: true,
					width: 450,
					buttons: [],
					title: "SUCESSO!",

				}).prev(".ui-dialog-titlebar").css("background", "#5cb85c");
				$("#modal-confirm").dialog('open');

				setTimeout(function() {
								window.location.reload();
								window.scrollTo(0, 0);
							}, 1500);

				
			}
		} else {

		}
	}
	var meta = $('meta[name="csrf-token"]').attr('content');

	xhttp.open(method, url, true);
	xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhttp.setRequestHeader("X-CSRF-TOKEN", meta);

	//~ console.log("params:  " + params);
	xhttp.send(params);
}

function pegaData(){
  var hoje = new Date();
  var strData = "";
  dia = "" + hoje.getDate();
  mes = hoje.getMonth();
  mes++;
  mes = "" + mes;

  if(mes.length == 1){
    mes = "0" + mes;
  }

  if(dia.length == 1){
    dia = "0" + dia;
  }

  strData += hoje.getFullYear()+ "-";
  strData += mes + "-";
  strData += dia;



  return strData;
}



function deletaOcorrencia(id) {
	// Deletar a ocorrencia de id "id"
	modalConfirm = document.getElementById("modal-confirm");
	var html = "<p>Deseja realmente excluir a ocorrência?</p>";
	modalConfirm.innerHTML = html;
	$("#modal-confirm").dialog({
		closeText: "fechar"
		, closeOnEscape: true
		, width: 450
		, position: {
			my: "bottom"
			, at: "bottom"
			, of: document.getElementById("modal")
		}
		, title: "Confirmação de exclusão"
		, buttons: [
			{
				text: "deletar"
				, id: "confirmar-deletar"
				, class: "btn-deletar-ocorrencia"
				, "style": "background:#d9534f;	color: white;"
				, click: function () {
					requisicaoDeletarOcorrencia(id);
				}
			},
			{
				text: "cancelar"
				, class: "btn-dismiss-dialog"
				, click: function () {
					$(this).dialog("close");
				}
			}
		]
	}).prev(".ui-dialog-titlebar").css("background", "#d9534f");
	$("#modal-confirm").dialog('open');
	$('#confirmar-deletar').prepend('<span class="glyphicon glyphicon-trash"></span> ');
}


function requisicaoDeletarOcorrencia(id){
	var method = "POST";
	var url = url_base + "/ocorrencias/excluir/" + id;

	//setar os parametros da requisição:
	var params = "id-oco=" + id;
	
	var xhttp;
	if (window.XMLHttpRequest) {
		xhttp = new XMLHttpRequest();
	}
	else {
		// para IE6, IE5
		xhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}

	xhttp.onreadystatechange = function () {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			var textoResposta = xhttp.responseText;
			if (textoResposta == 'ok'){
				$("#modal-confirm").dialog('close');
				modalConfirm = document.getElementById("modal-confirm");
				var html = "<p>A exclusão foi realizada com sucesso... Aguarde.</p>";
				modalConfirm.innerHTML = html;
				$("#modal-confirm").dialog({
					closeText: "fechar",
					closeOnEscape: true,
					width: 450,
					buttons: [],
					title: "SUCESSO!",

				}).prev(".ui-dialog-titlebar").css("background", "#5cb85c");
				$("#modal-confirm").dialog('open');

				setTimeout(function() {
								window.location.reload();
								window.scrollTo(0, 0);
							}, 1500);

				
			}
		} else {

		}
	}
	var meta = $('meta[name="csrf-token"]').attr('content');

	xhttp.open(method, url, true);
	xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhttp.setRequestHeader("X-CSRF-TOKEN", meta);

	//~ console.log("params:  " + params);
	xhttp.send(params);
}

function buscaOcorrencia(metodo){

  var elemento = document.getElementById("busca-ocorrencia-" + metodo);
  var texto = elemento.value;

 	texto = texto.replace('\/','@$');

	if (texto){
		requisicaoBusca(texto, metodo, function(resposta) {
			console.log(resposta); 
			document.getElementsByTagName("html")[0].innerHTML = resposta;
		});
	}
}



function requisicaoBusca(data, metodoBusca, callback) {
	//configurações da requisição.
	var method = "POST";
	var url = url_base + "/ocorrencias/busca/" + data;
	console.log('->' + url);

	//setar os parametros da requisição:
	var params = "modo=" + metodoBusca;
	//objeto para requisição;
	var xhttp;
	if (window.XMLHttpRequest) {
		xhttp = new XMLHttpRequest();
	}
	else {
		// para IE6, IE5
		xhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}

	xhttp.onreadystatechange = function () {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			var textoResposta = xhttp.responseText;
			if (textoResposta == "erro") {
				console.log('Deu erro');
			}
			else {
				//console.log("->>" + textoResposta);
				callback(textoResposta);
			}
		}
	}
	//~ enviar requisição:

	var meta = $('meta[name="csrf-token"]').attr('content');
	
	xhttp.open(method, url, true);
	xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhttp.setRequestHeader("X-CSRF-TOKEN", meta);
	xhttp.send(params);
}



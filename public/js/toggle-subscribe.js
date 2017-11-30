function toggleSubscribe(contratante_empresa, tipo) {
	inscricao = {
		'id': null,
		'user_id': null,
		'contratante_empresa': contratante_empresa,
		'tipo': tipo
	};

	assyncReq('/toggleSubscribe', 'POST', inscricao, function(response) {

		if(response) {
			window.location.reload();
		} else {
			alert("Ops...   Aconteceu algum imprevisto, por favor, recarregue a página...")
		}
		
	});

}





function assyncReq(uri, method, data, callback){

	var url = url_base + uri;
	var params = "data=" + JSON.stringify(data);
	
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

				callback(textoResposta);
		}
	}


	// enviar requisição:
	var meta = $('meta[name="csrf-token"]').attr('content');
	
	xhttp.open(method, url, true);
	xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhttp.setRequestHeader("X-CSRF-TOKEN", meta);
	xhttp.send(params);
}
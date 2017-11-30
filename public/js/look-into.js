function mais(procedimento){
	var modal = document.getElementById("modal");
	if (procedimento){
		modal.innerHTML = '<p><strong>Procedimento:</strong>'+procedimento+'</p>'
	} else{
		modal.innerHTML = 'Não há mas informações sobre esta contratação'
	}
	$("#modal").dialog({
		closeText: "fechar",
		closeOnEscape: true,
		title: "Detalhes da contratação",			
		buttons: [
			{
				text: "fechar"
				, class: "btn-dismiss-dialog"
				, click: function () {
					$(this).dialog("close");
				}
			}
		]
	}).prev(".ui-dialog-titlebar").css("background", "#5bc0de");

}
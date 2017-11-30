$(document).ready(function(){
		$("#data").attr("value", pegaData());
		$("#valor").mask("000.000.000.000.000,00", {reverse: true, placeholder:"0,00"});
		$("#cnpj-empresa").mask("00.000.000/0000-00", {placeholder:'00.000.000/0000-00'});
    var submit = document.getElementById("submit-button");
    submit.disabled = true;
    submit.setAttribute('title','Preencha todos os campos obrigatórios antes...');

});



var tequstArea = document.getElementById("texto-fonte");
tequstArea.onkeyup = function(e){
	e = e || event;
	var limite = 240;
	var out = document.getElementById("contador-caracteres");
	var escrito = tequstArea.value.length;
	out.innerHTML = 240 - escrito + " caractere(s) restante(s)";
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



  document.getElementById("data").value = strData;

}

function buscaEmpresa(){

  /* Etapas:
  *
  * 1- Requisição ajax com o nome da empresa e trazer o resultado em modal
  * 2.0 - Caso o registro tenha sido encontrado, preencher o campo CNPJ
  * 2.1 - Caso o registro não tenha sido encontrado, obrigar o usuário informar o CNPJ
  * 2.1.2 - Caso a empresa não tenha sido encontrada, inserir no banco antes de inserir a Ocorrencia
  */

  // configurações da requisição:

  // pegar conteúdo do input de id=nome-empresa
  var texto = document.getElementById("nome-empresa").value;

  var method = "GET";
  var url = url_base +"/empresas/sugestoes/" + texto;
  var asynchronous = true;

  var modal = document.getElementById("mensagem-modal");
  if (texto===''){

    // lidar com isso quando houver tempo
    // solução temporária: se estiver vazia não faz nada

    return;
  }

  //objeto para requisição;
  var xhttp;

  if (window.XMLHttpRequest) {
   xhttp = new XMLHttpRequest();
  } else {
   // para IE6, IE5
   xhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }

  //função para lidar com o retorno do servidor

  /**
   *O retorno da requisição do servidor poderá ser uma das duas opções abaixo:
   *1) Uma string com o texto "não encontrado",
   *2) Um array de sugestões, no caso de haver alguma.
  */
    xhttp.onreadystatechange = function() {
      if (xhttp.readyState == 4 && xhttp.status == 200) {
        var textoResposta = xhttp.responseText;
        // console.log (textoResposta);
      if (textoResposta == "nope"){

        modal.innerHTML = "<p><span class='glyphicon glyphicon-exclamation-sign'></span>Não encontramos registros da empresa digitada. "+
                          "Mas não se preocupe, basta especificar o nome e o CNPJ da " +
                          "empresa que o cadastro será efetuado automaticamente.</p>";
        $("#mensagem-modal").dialog({
          position: {
            my:"center", at:"center", of: $('main')
          },
          closeText: "fechar",
          closeOnEscape: true,
          title: "Empresa ainda não cadastrada",
          buttons: {Ok: function() {
                      $( this ).dialog( "close" );
                      document.getElementById("input-id-empresa").value = '-1';

                      }
                    }

        }).prev(".ui-dialog-titlebar").css("background","#FFCC00");

      } else{

        var empresa = JSON.parse(textoResposta);
        console.log(empresa.length);
        console.log(empresa);

        // o >= garante que o usuário escolha a empresa se quiser
        if(empresa.length >= 1){

            var html = "<table class='table table-bordered table-hover' >";
            html += "<tr class='success'> <th>Nome</th> <th>CNPJ</th> <th>Ação</th> </tr>";
            for ( var i = 0 ; i < empresa.length; i++){

                var cnpjota = (empresa[i].cnpj == null) ? 'não informado' : empresa[i].cnpj
                html += "<tr >";
                html += "<td align='center'> <div style='margin-top:0.8ch;'>" + empresa[i].nome + "</div></td>";
                html += "<td align='center'> <div style='margin-top:0.8ch;'>" + cnpjota + "</div></td>";
                html += "<td align='center'> <button style = 'margin-top: 0;' class='btn btn-success' onclick='selecionaEmpresa(" + empresa[i].id + ",\"" + empresa[i].nome +"\",\""  + empresa[i].cnpj+ "\"  )' >Escolher</button> </td>";
                html += "</tr>";
            }
            html += "</table>";
            modal.innerHTML = html;

            $("#mensagem-modal").dialog({
              
              closeText: "fechar",
              closeOnEscape: true,
              width: 500,
              title: "Sugestões de empresas já cadastradas",
              buttons:{"Não é nenhuma dessas, continuar digitando": function() {$( this ).dialog( "close" );}}

            }).prev(".ui-dialog-titlebar").css("background","#d9d9d9");

        } else{

            modal.innerHTML = "<p>Já encontramos a empresa com o nome que você digitou e "+
                              "o campo do CNPJ foi automaticamente preenchido.</p>";
            $("#mensagem-modal").dialog({
              position: {
                my:"center", at:"center", of: $('main')
              },
              closeText: "fechar",
              width: $(window).width() * 0.65,
              closeOnEscape: true,
              title: "Empresa encontrada!",
              buttons: {Ok: function() {$( this ).dialog( "close" );}}
            }).prev(".ui-dialog-titlebar").css("background","#99CC99");

              document.getElementById("cnpj-empresa").value = empresa[0].cnpj;
              document.getElementById("input-id-empresa").value = empresa[0].id;

        }
      }
    }
  };


  //enviar requisição:
  xhttp.open(method, url, asynchronous);
  xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhttp.send();
}


function selecionaEmpresa(id,nome, cnpj){
  //console.log(id+ '|' + nome + '|' + cnpj);
  document.getElementById("nome-empresa").value = nome;
  document.getElementById("input-id-empresa").value = id;

  if (cnpj != "null") {
    document.getElementById("cnpj-empresa").value = cnpj;
  }


  $("#mensagem-modal").dialog("close");
}


function validaSelect(){
  var ok = true;
  for (i = 1 ; i <= 2; i++){
    var select = document.getElementById("select" + i );
    var valor = select.options[select.selectedIndex].text;
    //console.log("iteração "+ i + ": "+valor);
    if (valor === 'Selecione...') {
      ok = false;
    }
  }

  if(ok){
    var submit = document.getElementById("submit-button");
    submit.disabled = false;
    submit.setAttribute('title','');
  }
  else{
    var submit = document.getElementById("submit-button");
    submit.disabled = true;
    submit.setAttribute('title','Preencha todos os campos antes...');
  }
}

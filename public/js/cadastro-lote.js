if( window.innerWidth >= 360) {
	var btns = document.getElementById("actions-bar");
	btns.className += ' btn-group-lg';
}

$("#fileupload").click(function(){

});

$( "#progressbar" ).progressbar({
      value: false
});

$("#form").submit(function(event) {
	$( "#loading" ).css('display', 'block');
	document.getElementById("loading").focus();
	window.setTimeout(changeWaitText, 10000);
	console.log("birl1");
});


function changeWaitText(){
	document.getElementById('wait-text').innerHTML = "Este processo pode realmente demorar muito, por favor, aguarde...";
	console.log('birl2');
}
$(document).ready(function () {
	$('#cep').blur(
		function(){
			if($('#cep').val().length==0) {
			   $('#modalMensagem').modal('show'); 
			 
			}
			else{
				
				let dados;
				dados={cep:$('#cep').val()};
				 console.log(dados);  
			}
 
   });
 $('#modalMensagem').on('hidden.bs.modal', function(){
   $("#cep").focus();
 });



  	
});


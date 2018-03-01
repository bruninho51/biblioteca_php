/*    function tratarDadosMaterial(){
	
	    form_material.submit();
	    //COMBOBOX CORINGA
	    alert('Oi');
	    var tipo_material_escolhido = form_material.tipo_material_escolhido.value;
	    //ABSTRACTINFORMACIONAL
	    var titulo = form_material.titulo_absi.value;
	    var codigobarras = form_material.codigobarras_absi.value;
	    var estante = form_material.estante_absi.value;
	    var exemplares = form_material.exemplares_absi.value;
	    var disponiveis = form_material.exemplares_absi.value;
	    //LIVRO
	    var editora = form_material.editora_livro.value;
	    var isbn = form_material.isbn_livro.value;
	    var ano = form_material.ano_livro.value;
	    var volume = form_material.volume_livro.value;
	    var edicao = form_material.edicao_livro.value;
	    var autores = form_material.autores_livro.value;

	    //PERIÓDICO
	    var issn = form_material.issn_periodico.value;
	    var volume = form_material.volume_periodico.value;
	    var ano = form_material.ano_periodico.value;
	    var descricao = form_material.descricao_periodico.value;

	    //MATERIAL ESPECIAL
	    var tipo = form_material.tipo_material_especial.value;

	
	    }
    }

	function validaCPF(cpf){
	    var numeros, digitos, soma, i, resultado, digitos_iguais;
	    digitos_iguais = 1;
	    if (cpf.length < 11){
          return false;
	    }
    	for (i = 0; i < cpf.length - 1; i++){
          	if (cpf.charAt(i) != cpf.charAt(i + 1)){
               	digitos_iguais = 0;
              	break;
            }
    	}
    	if (!digitos_iguais){
          	numeros = cpf.substring(0,9);
          	digitos = cpf.substring(9);
          	soma = 0;
          	for (i = 10; i > 1; i--){
                soma += numeros.charAt(10 - i) * i;
          	}
          	resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
          	if (resultado != digitos.charAt(0)){
                return false;
          	}
          	numeros = cpf.substring(0,10);
          	soma = 0;
          	for (i = 11; i > 1; i--){
                soma += numeros.charAt(11 - i) * i;
          	}
          	resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
          	if (resultado != digitos.charAt(1)){
                return false;
          	}
         	return true;
        }else{
        	return false;	
        }
        
  	}
*/

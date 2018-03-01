//MOSTRA OU ESCONDE FORMULÁRIOS DE CADASTRO DE ACORDO COM A ESCOLHA FEITA NA PÁGINA DE CADASTRO DE MATERIAIS
function tipoMaterial(materialEscolhido) {
    //FUNÇÃO QUE DEIXA FORMULÁRIO ESCOLHIDO VISÍVEL E ESCONDE OS DEMAIS.
    //USADO NA VIEW DE CADASTRO DE MATERIAIS
	if (materialEscolhido == 'livro') {
		$('#form-livro').css("display", "block");
		$('#form-periodico').css("display", "none");
		$('#form-material-especial').css("display", "none");	
	}

	if (materialEscolhido == 'periodico') {
		$('#form-periodico').css("display", "block");
		$('#form-livro').css("display", "none");
		$('#form-material-especial').css("display", "none");	
	}

	if (materialEscolhido == 'material-especial') {
		$('#form-material-especial').css("display", "block");
		$('#form-periodico').css("display", "none");
		$('#form-livro').css("display", "none");	
	}
	
}

//TRABALHA COM A SELEÇÃO DOS AUTORES DO LIVRO A SER CADASTRADO, NA PÁGINA PARA CADASTRAR MATERIAIS NA BASE DE DADOS
function addAutor(elemento) {
	var id = $(elemento).attr('id');
	var nome = $(elemento).text();
	$('#autores-livro').prepend("<div id='" + id + "' onclick='remAutor(this);'></div");
	var qtde = $('#autores-livro div').length - 1;
	//qtde = qtde - 1;
	$("#autores-livro div[id='" + id + "']").prepend("<input type='hidden' value='" + id + "' name='autores[" + (qtde) + "]'>");
	$("#autores-livro div[id='" + id + "']").prepend("<label class='autor'>" + nome + "</label>");	
	$(elemento).remove();

}

//CASO O USUÁRIO TENHA SELECIONADO UM AUTOR SEM QUERER, ESSA FUNÇÃO É USADA PARA REMOVE-LO E ACRESCENTA-LO DE VOLTA NA LISTA DE AUTORES DISPONÍVEIS.
function remAutor(elemento) {
	var id = $(elemento).attr('id');
	var nome = $(elemento).text(); 
	
	$("#autores-todos-livro").prepend("<label id='" + id + "' class='autor' onclick='addAutor(this)'>" + nome + "</label>");
	$("#autores-livro div[id='" + id + "']").remove();

}

//TRABALHA NA PARTE DE SELEÇÃO DE MATERIAIS A SEREM EMPRESTADOS, NA PÁGINA DE CADASTRO DE EMPRÉSTIMOS
function selecionarMaterialEmprestimo(item_lista, tipo_material) {
    var titulo = item_lista.children[0].value;
    var codigo = item_lista.children[1].value;
    var disponiveis = item_lista.children[2].value;
    
    if (tipo_material == 'livro') {
        $('.items_emprestimo').append('<div class="item_emprestimo emprestimo-livro" id="' + codigo + '"><input type="hidden" name="item_emprestimo[]" value="'+ titulo +'"><input type="hidden" name="tipo_item_emprestimo[]" value="' + codigo + '"><span class="cabecario_lista"><p>' + titulo + '</p><p>isbn: ' + codigo + '</p></span><span class="exclui_item"><img src="../view/img/x.png" onclick="remMaterialEmprestimo(' + codigo + ')"></span></div>');   
    }
    if (tipo_material == 'periodico') {
        $('.items_emprestimo').append('<div class="item_emprestimo emprestimo-periodico" id="' + codigo + '"><input type="hidden" name="item_emprestimo[]" value="'+ titulo +'"><input type="hidden" name="tipo_item_emprestimo[]" value="' + codigo + '"><span class="cabecario_lista"><p>' + titulo + '</p><p>issn: ' + codigo + '</p></span><span class="exclui_item"><img src="../view/img/x.png" onclick="remMaterialEmprestimo(' + codigo + ')"></span></div>');
    }
    
    if (tipo_material == 'material-especial') {
        $('.items_emprestimo').append('<div class="item_emprestimo emprestimo-material-especial" id="' + codigo + '"><input type="hidden" name="item_emprestimo[]" value="'+ titulo +'"><input type="hidden" name="tipo_item_emprestimo[]" value="' + codigo + '"><span class="cabecario_lista"><p>' + titulo + '</p><p>identificador: ' + codigo + '</p></span><span class="exclui_item"><img src="../view/img/x.png" onclick="remMaterialEmprestimo(' + codigo + ')"></span></div>');
    }
    
    
}

//CASO O USUÁRIO TENHA SELECIONADO UM MATERIAL SEM QUERER, ESSA FUNÇÃO É USADA PARA REMOVE-LO.
function remMaterialEmprestimo(variavel) {
    $('.item_emprestimo[id="' + variavel + '"]').remove();
}


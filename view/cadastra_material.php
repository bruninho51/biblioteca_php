<?php
    /* @author BRUNO MENDES PIMENTA
    * VIEW QUE SERVIRÁ PARA CADASTRO DE MATEIAIS
    * NA BASE DE DADOS
    */
?>

    <body>
		<script>//RESPONSÁVEL POR MANDAR ALERTA DE CADASTRO INSERIDO COM SUCESSO
			<?php if($gravado == true): ?>
				$(function(e){
					alert("Material gravado com sucesso!");
				});
				
			<?php endif;?>
		</script>
        
		<div class="container-formulario"><!--INICIO CONTAINER-->
            
		<!--RESPONSÁVEL POR SELECIONAR QUAL FORMULÁRIO DEVERÁ APARECER PARA CADASTRO-->
		<label>Tipo Material:</label>
		<select name="tipo_material_escolhido" id="sel-material-escolhido">
			<option value="livro" selected="selected" onclick="tipoMaterial('livro');">
				Livro
			</option>
			<option value="periodico" onclick="tipoMaterial('periodico');">
				Periódico
			</option>
			<option value="material-especial" onclick="tipoMaterial('material-especial');">
				Material Especial
			</option>
		</select>

		<?php 
			//IMPRESSÃO DO ERRO
			if(isset($erro['tipo_material_escolhido'])) : ?>
				<div class="erro" id="erro_tipo_material_escolhido">
					<?php echo $erro['tipo_material_escolhido']?>
				</div>
		<?php endif;?>
                     
        
        <?php //INCLUINDO MINI-MENU NA PÁGINA
            include_once('../view/template/minimenu.php')
        ?>
                                                                                                   
        <?php //INCLUINDO FORMULÁRIOS DE CADASTRO NA PÁGINA
            require_once('../view/forms/form_periodico.php');
            require_once('../view/forms/form_livro.php');
            require_once('../view/forms/form_material_especial.php');
        ?>

		
		</div><!--FIM CONTAINER-->


		<script> //EVENTOS(JQUERY)
            
            //FORMATAÇÃO DE CPF
			$('#cpf_pessoa').keypress(function(e){

				if(!(e.wich == 8 || e.keyCode == 8)){
					var tamanho = $('#cpf_pessoa').val().length;
					if(tamanho == 3 || tamanho == 7){
						$('#cpf_pessoa').val(
							$('#cpf_pessoa').val() + '.'
						); 
					}
					if(tamanho == 11){
						$('#cpf_pessoa').val(
							$('#cpf_pessoa').val() + '-'
						);	
					}
					if(tamanho == 14){
						var texto = $("#cpf_pessoa").val();
						$("#cpf_pessoa").val(texto.substring(0, 14 - 1));
						
					}	
				}
				
			});

			//FORMATAÇÃO DE TELEFONE
			$('#telefone_pessoa').keypress(function(e){
				if(!(e.wich == 8 || e.keyCode == 8)){
					var tamanho = $('#telefone_pessoa').val().length;
					if(tamanho == 0){
						$('#telefone_pessoa').val(
							$('#telefone_pessoa').val() + '('
						); 
					}
					if(tamanho == 3){
						$('#telefone_pessoa').val(
							$('#telefone_pessoa').val() + ')'
						); 
					}

					if(tamanho == 8){
						$('#telefone_pessoa').val(
							$('#telefone_pessoa').val() + '-'
						);	
					}
					if(tamanho == 13){
						var texto = $("#telefone_pessoa").val();
						$("#telefone_pessoa").val(texto.substring(0, 13 - 1));
						
					}	
				}
			});
		</script>
	<body>
</html>
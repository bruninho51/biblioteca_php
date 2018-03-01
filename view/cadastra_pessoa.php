<body>
		<script>
			<?php if($gravado == true): ?>
				$(function(e){
					alert("Pessoa gravada com sucesso!");
				});
				
			<?php endif;?>
		</script>

		<div class="container-formulario">
		
			<!--FORMULÁRIO PARA ENVIAR A PESSOA-->
			<form action="../controller/cadastrar_pessoa.php" method="post" id="form-pessoa" name="form_pessoa">
				<ul class="flex-outer">
					<li>
						<label>CPF:</label>
						<span>
							<input type="text" id="cpf_pessoa" name="cpf_pessoa">
							<?php
							//IMPRESSÃO DO ERRO
							if(isset($erro['cpf_pessoa'])) : ?>
								<div class="erro">
									<?php echo $erro['cpf_pessoa']?>
								</div>
							<?php endif;?>
						</span>
					</li>
					<li>
						<!--AQUI PODERÁ SER COLOCADO DATETIMEPICKER DO JQUERY UI-->
						<label>Nome:</label>
						<span>
							<input type="text" id="nome_pessoa" name="nome_pessoa">
							<?php
							//IMPRESSÃO DO ERRO
							if(isset($erro['nome_pessoa'])) : ?>
								<div class="erro">
									<?php echo $erro['nome_pessoa']?>
								</div>
							<?php endif;?>
						</span>
					</li>
					<li>
						<label>Telefone:</label>
						<span>
							<input type="text" id="telefone_pessoa" name="telefone_pessoa"></input>
							<?php
							//IMPRESSÃO DO ERRO
							if(isset($erro['telefone_pessoa'])) : ?>
								<div class="erro">
									<?php echo $erro['telefone_pessoa']?>
								</div>
							<?php endif;?>
						</span>
					</li>
					<li>
						<button id="btn-salvar-pessoa" onclick="tratarDadosMaterial();">Salvar</button>
					</li>
				</ul>	
			</form>
		</div>


		<script>
		//EVENTOS

			//EVENTO PARA QUANDO PASSAR O MOUSE POR CIMA DA MENSAGEM DE ERRO
			$('.erro').mouseout(function(e){
    			$(this).fadeOut(1000);
			});

			//COLOCANDO VALIDAÇÃO DE CPF
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

			//COLOCANDO VALIDAÇÃO DE TELEFONE
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
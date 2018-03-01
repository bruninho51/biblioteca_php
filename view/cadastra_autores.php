<body>
		<script>
			<?php if($gravado == true): ?>
				$(function(e){
					alert("Autor gravado com sucesso!");
				});
				
			<?php endif;?>
		</script>

		<div class="container-formulario">
            <!--FORMULÁRIO PARA ENVIAR LIVROS-->
            <form action="../controller/cadastrar_autores.php" method="post" id="form-autor" name="form_autor">
                <ul class="flex-outer">
                    <li>
                        <label>Nome:</label>
                        <span>
                            <input type="text" name="nome_autor">
                            <?php 
                            //IMPRESSÃO DO ERRO
                            if(isset($erro['nome_autor'])) : ?>
                                <div class="erro">
                                    <?php echo $erro['nome_autor']?>
                                </div>
                            <?php endif;?>
                        </span>
                    </li>
                    <li>
                        <label>Sobrenome:</label>
                        <!--SOBRENOME DO AUTOR-->
                        <span>
                            <input type="text" name="sobrenome_autor">
                            <?php 
                            //IMPRESSÃO DO ERRO
                            if(isset($erro['sobrenome_autor'])) : ?>
                                <div class="erro">
                                    <?php echo $erro['sobrenome_autor']?>
                                </div>
                            <?php endif;?>
                        </span>
                    </li>
                    <li>
                        <button id="btn-salvar-autor" type="submit">Salvar</button>
                    </li>
                </ul>
            </form>
		</div>
        <script>
		//EVENTOS
			$('.erro').mouseout(function(e){
    			$(this).fadeOut(1000);
			});
		</script>
	<body>
</html>
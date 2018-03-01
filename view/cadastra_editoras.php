<body>
		<script>
			<?php if($gravado == true): ?>
				$(function(e){
					alert("Editora gravada com sucesso!");
				});
				
			<?php endif;?>
		</script>

		<div class="container-formulario">
            <!--FORMULÁRIO PARA ENVIAR LIVROS-->
            <form action="../controller/cadastrar_editoras.php" method="post" id="form-editora" name="form_editora">
                <ul class="flex-outer">
                    <li>
                        <label>Nome:</label>
                        <span>
                            <input type="text" name="nome_editora">
                            <?php 
                            //IMPRESSÃO DO ERRO
                            if(isset($erro['nome_editora'])) : ?>
                                <div class="erro">
                                    <?php echo $erro['nome_editora']?>
                                </div>
                            <?php endif;?>
                        </span>
                    </li>
                    <li>
                        <label>Tipo:</label>
                        <!--TIPO EDITORA-->
                        <span>
                            <select name="tipo_editora">
                                <option id="editora_nacional" value="0">Nacional</option>
                                <option id="editora_internacional" value="1">Internacional</option>
                            </select>
                            <?php 
                            //IMPRESSÃO DO ERRO
                            if(isset($erro['tipo_editora'])) : ?>
                                <div class="erro">
                                    <?php echo $erro['tipo_editora']?>
                                </div>
                            <?php endif;?>
                        </span>
                    </li>
                    <li>
                        <button id="btn-salvar-editora" type="submit">Salvar</button>
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
<body>
		<script>
			<?php if($gravado == true): ?>
				$(function(e){
					alert("Empréstimo gravado com sucesso!");
				});
				
			<?php endif;?>
		</script>
        <div class="container">
            <div class="container-medio">
                <div class="container-mini">
                    <span>
                        <span class="pesquisa">
                            <input type="search" id="pesquisa_livros" placeholder="Pesquisar livros">
                            <button>🔎</button>
                        </span><br>
                        <div class="container-tabela">
                            <table id="tabela_livros">
                                <?php foreach($livros as $livro): ?>
                                    <tr><td onclick="selecionarMaterialEmprestimo(this, 'livro')">
                                        <?php echo $livro->titulo?>
                                        <input type="hidden" id="titulo" value="<?php echo $livro->titulo?>">
                                        <input type="hidden" id="isbn" value="<?php echo $livro->isbn?>">
                                        <input type="hidden" id="disponiveis" value="<?php echo $livro->disponiveis?>">
                                    </td></tr>
                                <?php endforeach;?>
                            </table>
                        </div>
                    </span>
                </div>
                <div class="container-mini">
                    <span class="pesquisa">
                        <input type="search" id="pesquisa_periodicos" placeholder="Pesquisar periódicos">
                        <button>🔎</button>
                    </span>
                    <br>
                    <div class="container-tabela">
                        <table id="tabela_periodicos">
                            <?php foreach($periodicos as $periodico): ?>
                            
                                    <tr><td onclick="selecionarMaterialEmprestimo(this, 'periodico')">
                                        <?php echo $periodico->titulo?>
                                        <input type="hidden" id="titulo" value="<?php echo $periodico->titulo?>">
                                        <input type="hidden" id="issn" value="<?php echo $periodico->issn?>">
                                        <input type="hidden" id="disponiveis" value="<?php echo $periodico->disponiveis?>">
                                    </td></tr>
                                <?php endforeach;?>
                        </table>
                    </div>
                </div>
                <div class="container-mini">
                    <span class="pesquisa">
                        <input type="search" id="pesquisa_materiais_especiais" placeholder="Pesquisar materiais especiais">    
                        <button>🔎</button>
                    </span>
                    <br>
                    <div class="container-tabela">
                        <table id="tabela_materiais_especiais">
                            <?php foreach($mat_especiais as $material_especial): ?>
                                    <tr><td onclick="selecionarMaterialEmprestimo(this, 'material-especial')">
                                        <?php echo $material_especial->titulo?>
                                        <input type="hidden" id="titulo" value="<?php echo $material_especial->titulo?>">
                                        <input type="hidden" id="id" value="<?php echo $material_especial->id?>">
                                        <input type="hidden" id="disponiveis" value="<?php echo $material_especial->disponiveis?>">
                                    </td></tr>
                                <?php endforeach;?>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="container-medio">
                <div class="container_emprestimos">
                    
                    <form action="../controller/cadastrar_emprestimo.php" method="post" id="form-emprestimo" name="form_emprestimo">
                        <label for="seleciona_pessoa">Pessoa:</label>
                        <select name="id_pessoa" id="seleciona_pessoa">
                            <?php foreach($pessoas as $pessoa): ?>
                                <option value="<?php echo $pessoa->id?>"><?php echo $pessoa->nome?></option>
                            <?php endforeach;?>
                        </select>
                        <label for="data_devolucao">Devolução:</label>
                        <input name="data_devolucao" id="data_devolucao" type="date" value="<?php echo date('Y-m-d', strtotime('+15 days'));?>" disabled>
                        
                        <h1>Lista de Empréstimo:</h1>
                        <div class="items_emprestimo">
                            <!--AQUI O JS COLOCARÁ OS MATERIAIS A SEREM EMPRESTADOS-->
                        </div>
                
                        <button id="btn-salvar-emprestimo" type="submit">Salvar</button>
                    </form>
                </div>
            </div>
    
        </div>
    
        <script>
		//EVENTOS
			$('.erro').mouseout(function(e){
    			$(this).fadeOut(1000);
			});
		</script>
	<body>
</html>
<?php
    /* @author BRUNO MENDES PIMENTA
    * ARQUIVO RESPONSÁVEL PELO FORMULÁRIO 
    * DE CADASTRO DE LIVROS
    */
?>

<form action="../controller/cadastrar_material.php" method="post" id="form-livro" name="form_livro">
    <!--CAMPO OCULTO RESPONSÁVEL POR DIZER AO SERVIDOR O TIPO DE FORMULÁRIO QUE ESTÁ SENDO ENVIADO-->
    <input type="hidden" name="tipo_material_escolhido" value="livro">
    <ul class="flex-outer"><!--COMEÇO DA LISTA DE CAMPOS-->
        <li>
            <label>ISBN:</label>
            <span>
                <input type="text" name="isbn_livro">
                <?php 
                //IMPRESSÃO DO ERRO
                if(isset($erro['isbn_livro'])) : ?>
                    <div class="erro">
                        <?php echo $erro['isbn_livro']?>
                    </div>
                <?php endif;?>
            </span>
        </li>
        <li>
            <label>Editora:</label>
            <span>
                <select name="editora_livro">
                    
                    <?php //COLOCANDO AS EDITORAS 
                    foreach ($editoras as $editora): ?>
                        <option id="<?php echo $editora->id ?>" value="<?php echo $editora->id ?>"><?php echo $editora->nome ?></option>
                    <?php endforeach;?>
                    
                </select>
                <?php 
                //IMPRESSÃO DO ERRO
                if(isset($erro['editora_livro'])) : ?>
                    <div class="erro">
                        <?php echo $erro['editora_livro']?>
                    </div>
                <?php endif;?>
            </span>
        </li>
        <li>
            <label>Ano:</label>
            <span>
                <input type="text" name="ano_livro">
                <?php 
                //IMPRESSÃO DO ERRO
                if(isset($erro['ano_livro'])) : ?>
                    <div class="erro">
                        <?php echo $erro['ano_livro']?>
                    </div>
                <?php endif;?>
            </span>	
        </li>
        <li>
            <label>Volume:</label>
            <span>	
                <input type="number" min=1 value=1 name="volume_livro">	
                <?php 
                //IMPRESSÃO DO ERRO
                if(isset($erro['volume_livro'])) : ?>
                    <div class="erro">
                        <?php echo $erro['volume_livro']?>
                    </div>
                <?php endif;?>	
            </span>		
        </li>
        <li>
            <label>Edição:</label>
            <span>
                <input type="number" min=1 value=1 name="edicao_livro">
                <?php 
                //IMPRESSÃO DO ERRO
                if(isset($erro['edicao_livro'])) : ?>
                    <div class="erro">
                        <?php echo $erro['edicao_livro']?>
                    </div>
                <?php endif;?>
            </span>
        </li>
        <li>
            <!--CAMPOS DO ABSTRACTINFORMACIONAL-->
            <label>Titulo:</label>
            <span>
                <input type="text" name="titulo_absi">
                <?php 
                //IMPRESSÃO DO ERRO
                if(isset($erro['titulo_absi'])) : ?>
                    <div class="erro">
                        <?php echo $erro['titulo_absi']?>
                    </div>
                <?php endif;?>
            </span>
        </li>
        <li>
            <label>Estante:</label>
            <span>
                <input type="number" min=1 value=1 name="estante_absi">
                <?php 
                //IMPRESSÃO DO ERRO
                if(isset($erro['estante_absi'])) : ?>
                    <div class="erro">
                        <?php echo $erro['estante_absi']?>
                    </div>
                <?php endif;?>
            </span>
        </li>
        <li>
            <label>Exemplares:</label>
            <span>
                <input type="number" min=1 value=1 name="exemplares_absi">
                <?php 
                //IMPRESSÃO DO ERRO
                if(isset($erro['exemplares_absi'])) : ?>
                    <div class="erro">
                        <?php echo $erro['exemplares_absi']?>
                    </div>
                <?php endif;?>
            </span>
        </li>
        <li>
            <label>Código de Barras:</label>
            <span>
                <input type="text" name="codigobarras_absi">
                <?php 
                //IMPRESSÃO DO ERRO
                if(isset($erro['codigobarras_absi'])) : ?>
                    <div class="erro">
                        <?php echo $erro['codigobarras_absi']?>
                    </div>
                <?php endif;?>
            </span>
        </li>
        <!--CONTROLE FEITO COM HTML, CSS E JS PARA ADIÇÃO DE AUTORES COM CLICK-->
            <li>
                <label>Clique nos autores para adiciona-los:</label>
                <fieldset name="autores-todos" id="autores-todos-livro" class="container-autores">	
                    <?php foreach ($autores as $autor): ?>
                        <label id="<?php echo $autor->id ?>" class="autor" onclick="addAutor(this);"><?php echo $autor->nomeCompleto() ?></label>
                    <?php endforeach;?>
                </fieldset>
            </li>
            <li>
                <label>Autores:</label>
                <span>
                    <fieldset name="autores-livro" id="autores-livro" class="container-autores">
                        <!--AQUI FICARÃO OS AUTORES QUE FORAM SELECIONADOS.
                        ELES SERÃO ADICIONADOS AQUI PELA FUNÇÃO addAutor().
                        -->
                    </fieldset>
                    <?php 
                    //IMPRESSÃO DO ERRO
                    if(isset($erro['autores'])) : ?>
                        <div class="erro">
                            <?php echo $erro['autores']?>
                        </div>
                    <?php endif;?>
                </span>
            </li>
        <li>
            <button id="btn-salvar-livro" onclick="tratarDadosMaterial();">Salvar</button>
        </li>
    </ul><!--FIM DA LISTA DE CAMPOS-->

</form>
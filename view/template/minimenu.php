<?php
    /* @author BRUNO MENDES PIMENTA
    * ARQUIVO RESPONSÁVEL PELO MINI-MENU QUE FICA NA PÁGINA DE CADASTRO
    * DE MATERIAIS E DE EMPRÉSTIMOS. ESSA BARRA DE MENU SERVE PARA REALIZAÇÃO
    * DE CADASTROS RÁPIDOS
    */
?>

<div class="mini-menu"><!--INICIO DO MINIMENU-->
    <!--POPUP PARA ADICIONAR PESSOAS-->
    <span class="container_add_pessoa">
        <img src="../view/img/add_pessoa.png" id="btn_add_pessoa" class="btnplus" title="Adicionar Pessoa" alt="botão para adicionar pessoas">
        <div class="add_pessoa">
            <p>Adicionar Pessoa:</p>
            <form action="../controller/cadastrar_pessoa.php" method="post" id="form-pessoa" name="form_pessoa">
                <!--CAMPO OCULTO RESPONSÁVEL POR DIZER AO SERVIDOR QUE REQUISIÇÃO VEIO DO MINI-MENU-->
                <input type="hidden" name="popup" value="1">
                
                <ul><!--COMEÇA LISTA COM OS CAMPOS-->
                    <li>
                        <label>CPF:</label>
                        <span>                                                                 
                            <input type="text" id="cpf_pessoa" name="cpf_pessoa">
                            <?php 
                            //IMPRESSÃO DO ERRO
                                if(isset($erro['cpf_pessoa'])) : ?>
                                    <div class="erro">
                                        <?php echo $erro['nome_autor']?>
                                    </div>
                                <?php endif;?>
                        </span>
                    </li>
                    <li>
                        <label>Nome:</label>
                        <!--NOME DA PESSOA-->
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
                        <!--TELEFONE DA PESSOA-->
                        <span>
                            <input type="text" id="telefone_pessoa" name="telefone_pessoa">
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
                        <button id="btn-salvar-pessoa" onclick="$('form_pessoa').submit()">Salvar</button>
                    </li>
                </ul><!--TERMINA LISTA COM OS CAMPOS-->
            </form>
        </div>
    </span>    

    <!--POPUP PARA ADICIONAR AUTORES-->
    <span class="container_add_editora">
        <img src="../view/img/add_autor.png" id="btn_add_autor" class="btnplus" title="Adicionar Autor" alt="botão para adicionar autores">
        <div class="add_autor">
            <p>Adicionar Autor:</p>
            <form action="../controller/cadastrar_autores.php" method="post" id="form-autor" name="form_autor">
                <!--CAMPO OCULTO RESPONSÁVEL POR DIZER AO SERVIDOR QUE REQUISIÇÃO VEIO DO MINI-MENU-->
                <input type="hidden" name="popup" value="1">
                <ul><!--COMEÇA LISTA COM OS CAMPOS-->
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
                        <button id="btn-salvar-autor" onclick="$('form_autor').submit()">Salvar</button>
                    </li>
                </ul><!--TERMINA LISTA COM OS CAMPOS-->
            </form>
        </div>
    </span>

    <!--POPUP PARA ADICIONAR EDITORAS-->
    <span class="container_add_editora">
        <img src="../view/img/add_editora.png" id="btn_add_editora" class="btnplus" title="Adicionar Editora" alt="botão para adicionar editoras">
        <div class="add_editora">
            <p>Adicionar Editora:</p>
            <form action="../controller/cadastrar_editoras.php" method="post" id="form-editora" name="form_editora">
                <!--CAMPO OCULTO RESPONSÁVEL POR DIZER AO SERVIDOR QUE REQUISIÇÃO VEIO DO MINI-MENU-->
                <input type="hidden" name="popup" value="1">
                <ul><!--COMEÇA LISTA COM OS CAMPOS-->
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
                        <button id="btn-salvar-editora" onclick="$('form_editora')submit()">Salvar</button>
                    </li>
                </ul><!--TERMINA LISTA COM OS CAMPOS-->
            </form>
        </div>
    </span>
    
    <!--POPUP PARA ADICIONAR TIPOS DE MATERIAL ESPECIAL-->
    <span class="container_add_tipo_material">
        <img src="../view/img/add_tipo_material_especial.png" id="btn_add_tipo_material" class="btnplus" title="Adicionar Tipo de Material Especial" alt="botão para adicionar tipos de materiais especiais">
        <div class="add_tipo_material">
            <p>Adicionar Tipo de Material Especial:</p>
            <form action="../controller/cadastrar_tipo_material.php" method="post" id="form-tipo_material" name="form_tipo_material">
                <!--CAMPO OCULTO RESPONSÁVEL POR DIZER AO SERVIDOR QUE REQUISIÇÃO VEIO DO MINI-MENU-->
                <input type="hidden" name="popup" value="1">
                <ul><!--COMEÇA LISTA DE CAMPOS-->
                    <li>
                        <label>Nome:</label>
                        <span>                                                        
                            <input type="text" name="nome_tipo_material">
                            <?php 
                            //IMPRESSÃO DO ERRO
                                if(isset($erro['nome_tipo_material'])) : ?>
                                    <div class="erro">
                                        <?php echo $erro['nome_tipo_material']?>
                                    </div>
                                <?php endif;?>
                        </span>
                    </li>
                    <li>
                        <button id="btn-salvar-tipo-material" onclick="$('form_tipo_material').submit()">Salvar</button>
                    </li>
                </ul><!--TERMINA LISTA DE CAMPOS-->
            </form>
        </div>
    </span>
</div><!--FIM DO MINIMENU-->

<script>
    //EVENTOS(JQUERY)
    $('.erro').mouseout(function(e){
        $(this).fadeOut(1000);
    });

    $('#btn_add_editora').click(function(e){
        $('.add_editora').toggle(1000);
    });

    $('#btn_add_autor').click(function(e){
        $('.add_autor').toggle(1000);
    });

    $('#btn_add_pessoa').click(function(e){
        $('.add_pessoa').toggle(1000);
    });

    $('#btn_add_tipo_material').click(function(e){
        $('.add_tipo_material').toggle(1000);
    });
</script>
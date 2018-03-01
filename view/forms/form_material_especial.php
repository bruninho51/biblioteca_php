<?php
    /* @author BRUNO MENDES PIMENTA
    * ARQUIVO RESPONSÁVEL PELO FORMULÁRIO 
    * DE CADASTRO DE MATERIAIS ESPECIAIS
    */
?>

<form action="../controller/cadastrar_material.php" method="post" id="form-material-especial" name="form_material_especial">
    <!--CAMPO OCULTO RESPONSÁVEL POR DIZER AO SERVIDOR QUAL O TIPO DE FORMULÁRIO FOI ENVIADO-->
    <input type="hidden" name="tipo_material_escolhido" value="material-especial">
    <ul class="flex-outer"><!--COMEÇA LISTA DE CAMPOS-->
        <li>
            <label>Tipo de Material Especial:</label>
            <select name="tipo_material_especial">
                <?php foreach($tipos_material_especial as $tipo_material_especial): ?>
                    <option value="<?php echo $tipo_material_especial->id?>"><?php echo $tipo_material_especial->nome?></option>
                <?php endforeach;?>
            </select>
            <?php 
                //IMPRESSÃO DO ERRO
                if(isset($erro['tipo_material_especial'])) : ?>
                    <div class="erro">
                        <?php echo $erro['tipo_material_especial']?>
                    </div>
                <?php endif;?>
        </li>
        <li>
            <label>Descrição:</label>
            <textarea id="descricao" name="descricao_material_especial"></textarea>
            <?php 
                //IMPRESSÃO DO ERRO
                if(isset($erro['descricao_material_especial'])) : ?>
                    <div class="erro">
                        <?php echo $erro['descricao_material_especial']?>
                    </div>
                <?php endif;?>
        </li>
        <li>
            <label>Titulo:</label>
            <input type="text" name="titulo_absi">
            <?php 
                //IMPRESSÃO DO ERRO
                if(isset($erro['titulo_absi'])) : ?>
                    <div class="erro">
                        <?php echo $erro['titulo_absi']?>
                    </div>
                <?php endif;?>
        </li>
        <li>
            <label>Estante:</label>
            <input type="number" min=1 value=1 name="estante_absi">
            <?php 
                //IMPRESSÃO DO ERRO
                if(isset($erro['estante_absi'])) : ?>
                    <div class="erro">
                        <?php echo $erro['estante_absi']?>
                    </div>
                <?php endif;?>
        </li>
        <li>
            <label>Exemplares:</label>
            <input type="number" min=1 value=1 name="exemplares_absi">
            <?php 
                //IMPRESSÃO DO ERRO
                if(isset($erro['exemplares_absi'])) : ?>
                    <div class="erro">
                        <?php echo $erro['exemplares_absi']?>
                    </div>
                <?php endif;?>
        </li>
        <li>
            <label>Código de Barras:</label>
            <input type="text" name="codigobarras_absi">
            <?php 
                //IMPRESSÃO DO ERRO
                if(isset($erro['codigobarras_absi'])) : ?>
                    <div class="erro">
                        <?php echo $erro['codigobarras_absi']?>
                    </div>
                <?php endif;?>
        </li>
        <li>
            <button id="btn-salvar-material-especial" onclick="tratarDadosMaterial();">Salvar</button>
        </li>
    </ul><!--TERMINA LISTA DE CAMPOS-->

</form>
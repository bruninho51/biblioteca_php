<?php
    /* @author BRUNO MENDES PIMENTA
    * ARQUIVO RESPONSÁVEL PELO FORMULÁRIO 
    * DE CADASTRO DE PERIÓDICOS
    */
?>

<form action="../controller/cadastrar_material.php" method="post" id="form-periodico" name="form_periodico">
    <!--CAMPO OCULTO RESPONSÁVEL POR DIZER AO SERVIDOR QUAL O TIPO DE FORMULÁRIO FOI ENVIADO-->
    <input type="hidden" name="tipo_material_escolhido" value="periodico">
    <ul class="flex-outer"><!--COMEÇA LISTA DE CAMPOS-->
        
        <li>
            <label>ISSN:</label>
            <input type="text" name="issn_periodico">
            <?php 
                //IMPRESSÃO DO ERRO
                if(isset($erro['issn_periodico'])) : ?>
                    <div class="erro">
                        <?php echo $erro['issn_periodico']?>
                    </div>
                <?php endif;?>
        </li>
        <li>
            <label>Volume:</label>
            <input type="number" min=1 value=1 name="volume_periodico">
            <?php 
                //IMPRESSÃO DO ERRO
                if(isset($erro['volume_periodico'])) : ?>
                    <div class="erro">
                        <?php echo $erro['volume_periodico']?>
                    </div>
                <?php endif;?>
        </li>
        <li>
            <label>Ano:</label>
            <input type="text" name="ano_periodico">
            <?php 
                //IMPRESSÃO DO ERRO
                if(isset($erro['ano_periodico'])) : ?>
                    <div class="erro">
                        <?php echo $erro['ano_periodico']?>
                    </div>
                <?php endif;?>
        </li>
        <li>
            <label>Descrição:</label>
            <textarea id="descricao" name="descricao_periodico"></textarea>
            <?php 
                //IMPRESSÃO DO ERRO
                if(isset($erro['descricao_periodico'])) : ?>
                    <div class="erro">
                        <?php echo $erro['descricao_periodico']?>
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
            <button id="btn-salvar-periodico" onclick="tratarDadosMaterial();">Salvar</button>
        </li>
    </ul><!---TERMINA LISTA DE CAMPOS-->
</form>
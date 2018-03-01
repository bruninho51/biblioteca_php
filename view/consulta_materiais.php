			<table class="tabela-biblioteca">
				<th>Editora</th>
				<th>ISBN</th>
				<th>Ano</th>
				<th>Volume</th>
				<th>Edição</th>
				<th>Título</th>
				<th>Codigo de Barras</th>
				<th>Estante</th>
				<th>Exemplares</th>
				<th>Disponíveis</th>
                <th>Autores</th>
				<?php foreach($livros as $livro) : ?>
					<tr>
						<td><?php echo $livro->editora->nome ?></td>
						<td><?php echo $livro->isbn ?></td>
						<td><?php echo $livro->ano ?></td>
						<td><?php echo $livro->volume ?></td>
						<td><?php echo $livro->edicao ?></td>
						<td><?php echo $livro->titulo ?></td>
						<td><?php echo $livro->codBarras ?></td>
						<td><?php echo $livro->estante ?></td>
						<td><?php echo $livro->exemplares ?></td>
						<td><?php echo $livro->disponiveis ?></td>
                        <td>
                            <?php
                                foreach($livro->autores as $autor){
                                    echo $autor->nomeCompleto() . " ";
                                }
                                
                            ?>
                                
                        </td>
					</tr>
				<?php endforeach;?>
			</table>

		</div>

		
	</body>
</html>
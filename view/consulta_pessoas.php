            <table class="tabela-biblioteca">
				<th>ID</th>
				<th>CPF</th>
				<th>Nome</th>
				<th>Telefone</th>
				<?php foreach($pessoas as $pessoa) : ?>
					<tr>
						<td><?php echo $pessoa->id ?></td>
						<td><?php echo formatarCpf($pessoa->cpf) ?></td>
						<td><?php echo $pessoa->nome ?></td>
						<td><?php echo formatarTelefone($pessoa->telefone) ?></td>
					</tr>
				<?php endforeach;?>
			</table>

        </div>
		
	</body>
</html>
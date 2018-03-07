<?php
	function validarData($dat){
		$data = explode("-", $dat); // fatia a string $dat em pedados, usando / como referência
		$d = $data[2];
		$m = $data[1];
		$y = $data[0];
		// verifica se a data é válida!
		// 1 = true (válida)
		// 0 = false (inválida)
		return checkdate($m, $d, $y);
	}

	function requires_model(){
 	    foreach(glob('model/*.php') as $arquivo){
            echo $arquivo;
    		require_once $arquivo;
    	}
	}

	function validaCPF($cpf = null) {
 
	    // Verifica se um número foi informado
	    if(empty($cpf)) {
	        return false;
	    }
	 
	    // Elimina possivel mascara
	    $cpf = ereg_replace('[^0-9]', '', $cpf);
	    $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
	     
	    // Verifica se o numero de digitos informados é igual a 11 
	    if (strlen($cpf) != 11) {
	        return false;
	    }
	    // Verifica se nenhuma das sequências invalidas abaixo 
	    // foi digitada. Caso afirmativo, retorna falso
	    else if ($cpf == '00000000000' || 
	        $cpf == '11111111111' || 
	        $cpf == '22222222222' || 
	        $cpf == '33333333333' || 
	        $cpf == '44444444444' || 
	        $cpf == '55555555555' || 
	        $cpf == '66666666666' || 
	        $cpf == '77777777777' || 
	        $cpf == '88888888888' || 
	        $cpf == '99999999999') {
	        return false;
	     // Calcula os digitos verificadores para verificar se o
	     // CPF é válido
	     } else {   
	         
	        for ($t = 9; $t < 11; $t++) {
	             
	            for ($d = 0, $c = 0; $c < $t; $c++) {
	                $d += $cpf{$c} * (($t + 1) - $c);
	            }
	            $d = ((10 * $d) % 11) % 10;
	            if ($cpf{$c} != $d) {
	                return false;
	            }
	        }
	 
	        return true;
	    }
	}

    function soNumeros($str) {
        return preg_replace("/[^0-9]/", "", $str);
    }

    function formatarCpf($cpf){
    	//SEPARANDO O CPF EM PEDAÇOS
    	$array[0] = substr($cpf, 0, 3);
    	$array[1] = substr($cpf, 3, 3);
    	$array[2] = substr($cpf, 6, 3);
    	$array[3] = substr($cpf, -2); 
    	//COLOCANDO OS CARACTERES ESPECIAIS
    	$array[0] .= '.'; 
    	$array[1] .= '.';
    	$array[2] .= '-';
    	//JUNTANDO NOVAMENTE OS PEDAÇOS DO CPF, GERANDO UM CPF FORMATADO
    	$form_cpf = implode('', $array);
    	return $form_cpf;
    }
    function formatarTelefone($telefone){
    	//SEPARANDO O TELEFONE EM PEDAÇOS
    	$array[0] = substr($telefone, 0, 2);
    	$array[1] = substr($telefone, 2, 4);
    	$array[2] = substr($telefone, 6, 4);
    	//COLOCANDO OS CARACTERES ESPECIAIS
    	$array[0]  = '(' . $array[0] . ')'; 
    	$array[1] .= '-';
    	//JUNTANDO NOVAMENTE OS PEDAÇOS DO CPF, GERANDO UM CPF FORMATADO
    	$form_telefone = implode('', $array);
    	return $form_telefone;
    }

?>

<?php

//include("functions.php");

if ($estagio == '2'){
	
if (!ctype_digit($msg)) {
	
	$data = array(
		'recipient' => array('id' =>"$rid"),
		'message' => array('text'=>"Mensagem enviada contem caracteres não númericos. Por favor digite um número válido sem pontos ou traços.")
	);
	
	$options = array(
		'http' => array(
			'method' => 'POST',
			'content' => json_encode($data),
			'header' => "Content-Type: application/json\n"
	));

	$context = stream_context_create($options);

	file_get_contents("https://graph.facebook.com/v2.6/me/messages?access_token=$token", false, $context);

}

if (ctype_digit($msg)){
	
	if($msg < 1 || $msg > 2){
		
		$data = array(
			'recipient' => array('id' =>"$rid"),
			'message' => array('text'=>"Número inválido. Por favor digite um número válido (1 ou 2).")
		);
	
		$options = array(
			'http' => array(
				'method' => 'POST',
				'content' => json_encode($data),
				'header' => "Content-Type: application/json\n"
		));

		$context = stream_context_create($options);

		file_get_contents("https://graph.facebook.com/v2.6/me/messages?access_token=$token", false, $context);
		
	}
	
	if($msg == 1){
		
		$rv = mysqli_query($db, "UPDATE db.tabela SET tipoenvio = 'E', estagio = '3', unixtime = $currentunix WHERE senderid = $rid;");
		
        // Caso ocorra erro ao atualizar o estagio ou conectar com o banco de dados-- 
    if ($rv == false ){
        // Mensagem de erro 
        $data = array(
	'recipient' => array('id' =>"$rid"),
	'message' => array('text'=>"Erro de conexão com o servidor. Tente novamente.")
	);
	
	$options = array(
		'http' => array(
			'method' => 'POST',
			'content' => json_encode($data),
			'header' => "Content-Type: application/json\n"
	));

	$context = stream_context_create($options);

	file_get_contents("https://graph.facebook.com/v2.6/me/messages?access_token=$token", false, $context);	
    }
    else {
        
        $data = array(
			'recipient' => array('id' =>"$rid"),
			'message' => array('text'=>"Entendido, por favor digite o e-mail no qual você gostaria de receber o boleto.")
		);
	
		$options = array(
			'http' => array(
				'method' => 'POST',
				'content' => json_encode($data),
				'header' => "Content-Type: application/json\n"
		));

		$context = stream_context_create($options);

		file_get_contents("https://graph.facebook.com/v2.6/me/messages?access_token=$token", false, $context);
        
    }
	}
	
	if($msg == 2){
	
		$rv = mysqli_query($db, "UPDATE db.tabela SET tipoenvio = 'S', estagio = '3', unixtime = $currentunix WHERE senderid = $rid;");
		
        // Caso ocorra erro ao atualizar o estagio ou conectar com o banco de dados-- 
    if ($rv == false ){
        // Mensagem de erro 
        $data = array(
	'recipient' => array('id' =>"$rid"),
	'message' => array('text'=>"Erro de conexão com o servidor. Tente novamente.")
	);
	
	$options = array(
		'http' => array(
			'method' => 'POST',
			'content' => json_encode($data),
			'header' => "Content-Type: application/json\n"
	));

	$context = stream_context_create($options);

	file_get_contents("https://graph.facebook.com/v2.6/me/messages?access_token=$token", false, $context);	
    }
    else {
        
        $data = array(
			'recipient' => array('id' =>"$rid"),
			'message' => array('text'=>"Entendido, por favor digite o número com (DDD) no qual você gostaria de receber a linha digitável.")
		);
	
		$options = array(
			'http' => array(
				'method' => 'POST',
				'content' => json_encode($data),
				'header' => "Content-Type: application/json\n"
		));

		$context = stream_context_create($options);

		file_get_contents("https://graph.facebook.com/v2.6/me/messages?access_token=$token", false, $context);
        
    }
	}
	
}

}

?>
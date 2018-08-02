<?php
if ($counter==0){

	$rv = mysqli_query($db, "INSERT INTO db.tabela(senderid, estagio, unixtime) VALUES ('$rid','1',$currentunix);");

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
		'message' => array('text'=>"Olá, sou Carol sua agente digital abc. Para que possamos começar seu atendimento, por favor digite seu CPF/CNPJ, sem pontos ou traços.")
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

?>
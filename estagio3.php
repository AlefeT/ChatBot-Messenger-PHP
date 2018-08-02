<?php

//include("functions.php");

if ($estagio == '3'){
	
	$query = mysqli_query($db, "SELECT tipoenvio FROM db.tabela WHERE senderid=$rid;");
	$row = mysqli_fetch_row($query);
	$tipoenvio = $row[0];
	
	if ($tipoenvio == "E")
	{
		
		$query = mysqli_query($db, "SELECT numdivida FROM db.tabela WHERE senderid=$rid;");
		$row = mysqli_fetch_row($query);
		$numdivida = $row[0];
	
		$query = mysqli_query($db, "SELECT numcredor FROM db.tabela WHERE senderid=$rid;");
		$row = mysqli_fetch_row($query);
		$numcredor = $row[0];
	
		$hoje = (string)date("d/m/Y");
		$datapagto = $hoje;
	
		$query = mysqli_query($db, "SELECT cpf FROM db.tabela WHERE senderid=$rid;");
		$row = mysqli_fetch_row($query);
		$cpfcliente = $row[0];
	
		$email = $msg;
	
		$resultado = enviarFaturaemail($numcredor,$numdivida,$cpfcliente,$datapagto,$email);
		
        // Caso ocorra erro ao conectar ao webservice
        if ($resultado != 1) {
        
		$data = array(
			'recipient' => array('id' =>"$rid"),
			'message' => array('text'=>"O boleto foi enviado para o seu e-mail com sucesso. A abc agradece pelo contato, tenha um bom dia.")
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
        
		// Mensagem de erro 
            $data = array(
	'recipient' => array('id' =>"$rid"),
	'message' => array('text'=>"Serviço temporariamente indisponível. Tente novamente mais tarde.")
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
	
	if ($tipoenvio == "S")
	{
		
		$sms = $msg;
	
		$query = mysqli_query($db, "SELECT numdivida FROM db.tabela WHERE senderid=$rid;");
		$row = mysqli_fetch_row($query);
		$numdivida = $row[0];
	
		$query = mysqli_query($db, "SELECT numcredor FROM db.tabela WHERE senderid=$rid;");
		$row = mysqli_fetch_row($query);
		$numcredor = $row[0];
		
		$query = mysqli_query($db, "SELECT datapagto FROM db.tabela WHERE senderid=$rid;");
		$row = mysqli_fetch_row($query);
		$datapagto = $row[0];
	
		$query = mysqli_query($db, "SELECT cpf FROM db.tabela WHERE senderid=$rid;");
		$row = mysqli_fetch_row($query);
		$cpfcliente = $row[0];
	
		$resultado = enviarFaturasms($numcredor,$numdivida,$cpfcliente,$datapagto,$sms);
		
        // Caso ocorra erro ao conectar ao webservice
        if ($resultado != 1) {
        
		$data = array(
			'recipient' => array('id' =>"$rid"),
			'message' => array('text'=>"A linha digitável foi enviada via SMS com sucesso. A abc agradece pelo contato, tenha um bom dia.")
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
        
		// Mensagem de erro 
            $data = array(
	'recipient' => array('id' =>"$rid"),
	'message' => array('text'=>"Serviço temporariamente indisponível. Tente novamente mais tarde.")
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
	
	mysqli_query($db, "DELETE FROM db.tabela WHERE senderid = $rid;");
	
	//RECORD ACORDO
	date_default_timezone_set('America/Sao_Paulo');

	$horario = date("y-m-d H:i:s");

	$db2 = mysqli_connect("db.db.db.db", "db", "db", "db"); 

	mysqli_query($db2, "INSERT INTO ACORDO_LOG (canal, horario, contratante, cpfcliente) VALUES ('MESSENGER','$horario','abcTEL','$cpfcliente');");
	//END RECORD ACORDO

}

?>
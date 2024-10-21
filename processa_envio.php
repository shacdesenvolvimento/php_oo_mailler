<?php

	require "./bibliotecas/PHPMailer/Exception.php";
	require "./bibliotecas/PHPMailer/OAuth.php";
	require "./bibliotecas/PHPMailer/PHPMailer.php";
	require "./bibliotecas/PHPMailer/POP3.php";
	require "./bibliotecas/PHPMailer/SMTP.php";

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	//print_r($_POST);

	class Mensagem {
		private $para = null;
		private $assunto = null;
		private $mensagem = null;
		private $retorno=null;
		private $status=null;

		public function __get($atributo) {
			return $this->$atributo;
		}

		public function __set($atributo, $valor) {
			$this->$atributo = $valor;
		}

		public function mensagemValida() {
			if(empty($this->para) || empty($this->assunto) || empty($this->mensagem)) {
				return false;
			}

			return true;
		}
	}

	$mensagem = new Mensagem();

	$mensagem->__set('para', $_POST['para']);
	$mensagem->__set('assunto', $_POST['assunto']);
	$mensagem->__set('mensagem', $_POST['mensagem']);

	//print_r($mensagem);

	if(!$mensagem->mensagemValida()) {
		$mensagem->__set('retorno','com preenchimento das informações');
	}
//mudei
	$mail = new PHPMailer(true);
	try {
			//Server settings
			$mail->SMTPDebug = 2;                      //Enable verbose debug output
			$mail->isSMTP();                                            //Send using SMTP
			$mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
			$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
			$mail->Username   = 'infoshac@gmail.com';                     //SMTP username
			$mail->Password   = 'pijv lrxl osvr wyf';                               //SMTP password
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;       //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
			$mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

			//Recipients
			$mail->setFrom('webcompleto2@gmail.com', 'Web Completo Remetente');
			$mail->addAddress($mensagem->__get('para'));     //Add a recipient
			//$mail->addReplyTo('info@example.com', 'Information');
			//$mail->addCC('cc@example.com');
			//$mail->addBCC('bcc@example.com');

			//Attachments
			//$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
			//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

			//Content
			$mail->isHTML(true);                                  //Set email format to HTML
			$mail->Subject = $mensagem->__get('assunto');
			$mail->Body    = $mensagem->__get('mensagem');
			$mail->AltBody = 'É necessario utilizar um client que suporte HTML para ter acesso total ao conteúdo dessa mensagem';

			$mail->send();
			$mensagem->__set('retorno','Menssagem enviada com Sucesso!!');
			$mensagem->__set('status',1);
	} catch (Exception $e) {
		/* echo "Não foi possível enviar este e-mail! Por favor tente novamente mais tarde.";
		echo 'Detalhes do erro: ' . $mail->ErrorInfo; */
		$mensagem->__set('status',2);
		$mensagem->__set('retorno','Mensagem com erro'.$mail->ErrorInfo);
	}
?>
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>retorno</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	</head>
	<body>
		<div class="container mt-5">
			<div class="row justify-content-md-center">
				<div class="col-md-auto">
					<?php if ($mensagem->__get("status")==1) {						
					?>
					<div class="alert alert-success" role="alert">
						<h2>Mesangem enviada com sucesso</h2>
					</div>
					<?php } ?>
					<?php if ($mensagem->__get("status")==2) {						
					?>
					<div class="alert alert-danger" role="alert">
						<h2>Erro inesperado</h2>
					</div>
					<?php  }?>
				</div>				
			</div>
				<div class="row ">
					<div class="col-md-auto text-end">
						<a href="index.php" class="btn btn-primary mt-3">Voltar</a>
					</div>
				</div>
		</div>
	</body>
	</html>
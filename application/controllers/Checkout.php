<?php

class Checkout extends CI_Controller {


	function paso1()
	{
		
		
		$this->load->view("checkout/paso1");
	}

	function paso2()
	{
		$this->load->view("checkout/paso2");
	}

	function paso3()
	{
		require_once APPPATH .'libraries/MercadoPago/lib/mercadopago.php';
		require_once APPPATH .'libraries/WebPay-sdk-php-2.0.4/libwebpay/webpay.php';
		require_once APPPATH .'libraries/WebPay-sdk-php-2.0.4/sample/certificates/cert-normal.php';

		//Monto Total
		$Monto_Total = 12250;
		
		$view = array();
		
		//MERCADOPAGO
		$mp = new MP('8394836003527636', '357kcwgkThN5MTJIIixfwHwufXsCfdv7');

		$preference_data = array(
			"items" => array(
				array(
					"title" => "Multicolor kite",
					"quantity" => 1,
					"currency_id" => "CLP", // Available currencies at: https://api.mercadopago.com/currencies
					"unit_price" => $Monto_Total
				)
			)
		);
		
		$preference = $mp->create_preference($preference_data);

		/** Configuracion parametros de la clase Webpay */
		$sample_baseurl = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];

		$configuration = new Configuration();
		$configuration->setEnvironment($certificate['environment']);
		$configuration->setCommerceCode($certificate['commerce_code']);
		$configuration->setPrivateKey($certificate['private_key']);
		$configuration->setPublicCert($certificate['public_cert']);
		$configuration->setWebpayCert($certificate['webpay_cert']);

		/** Creacion Objeto Webpay */
		$webpay = new Webpay($configuration);

		$action = isset($_GET["action"]) ? $_GET["action"] : 'init';

		$post_array = false;

		switch ($action) {

			default:

				$tx_step = "Init";

				/** Monto de la transacción */
				$amount = $Monto_Total;

				/** Orden de compra de la tienda */
				$buyOrder = rand();

				/** Código comercio de la tienda entregado por Transbank */
				$sessionId = uniqid();

				/** URL de retorno */
				$urlReturn = $sample_baseurl."?action=getResult";

				/** URL Final */
			$urlFinal  = $sample_baseurl."?action=end";

				$request = array(
					"amount"    => $amount,
					"buyOrder"  => $buyOrder,
					"sessionId" => $sessionId,
					"urlReturn" => $urlReturn,
					"urlFinal"  => $urlFinal,
				);

				/** Iniciamos Transaccion */
				$result = $webpay->getNormalTransaction()->initTransaction($amount, $buyOrder, $sessionId, $urlReturn, $urlFinal);

				/** Verificamos respuesta de inicio en webpay */
				if (!empty($result->token) && isset($result->token)) {
					$message = "Sesion iniciada con exito en Webpay";
					$token = $result->token;
					$next_page = $result->url;
				} else {
					$message = "webpay no disponible";
				}

				$button_name = "Continuar &raquo;";

				break;

			case "getResult":

				$tx_step = "Get Result";

				if (!isset($_POST["token_ws"]))
					break;

				/** Token de la transacción */
				$token = filter_input(INPUT_POST, 'token_ws');

				$request = array(
					"token" => filter_input(INPUT_POST, 'token_ws')
				);

				/** Rescatamos resultado y datos de la transaccion */
				$result = $webpay->getNormalTransaction()->getTransactionResult($token);

				/** Verificamos resultado  de transacción */
				if ($result->detailOutput->responseCode === 0) {

					/** propiedad de HTML5 (web storage), que permite almacenar datos en nuestro navegador web */
					echo '<script>window.localStorage.clear();</script>';
					echo '<script>localStorage.setItem("authorizationCode", '.$result->detailOutput->authorizationCode.')</script>';
					echo '<script>localStorage.setItem("amount", '.$result->detailOutput->amount.')</script>';
					echo '<script>localStorage.setItem("buyOrder", '.$result->buyOrder.')</script>';

					$message = "Pago ACEPTADO por webpay (se deben guardatos para mostrar voucher)";
					$next_page = $result->urlRedirection;

				} else {
					$message = "Pago RECHAZADO por webpay - " . utf8_decode($result->detailOutput->responseDescription);
					$next_page = '';
				}

				$button_name = "Continuar &raquo;";

				break;

			case "end":

				$post_array = true;

				$tx_step = "End";
				$request = "";
				$result = $_POST;

				$message = "Transacion Finalizada";
				$next_page = $sample_baseurl."?action=nullify";
				$button_name = "Anular Transacci&oacute;n &raquo;";

				break;


			case "nullify":

				$tx_step = "nullify";

				$request = $_POST;

				/** Codigo de Comercio */
				$commercecode = null;

				/** Código de autorización de la transacción que se requiere anular */
				$authorizationCode = filter_input(INPUT_POST, 'authorizationCode');

				/** Monto autorizado de la transacción que se requiere anular */
				$amount =  filter_input(INPUT_POST, 'amount');

				/** Orden de compra de la transacción que se requiere anular */
				$buyOrder =  filter_input(INPUT_POST, 'buyOrder');

				/** Monto que se desea anular de la transacción */
				$nullifyAmount = 200;

				$request = array(
					"authorizationCode" => $authorizationCode, // Código de autorización
					"authorizedAmount" => $amount, // Monto autorizado
					"buyOrder" => $buyOrder, // Orden de compra
					"nullifyAmount" => $nullifyAmount, // idsession local
					"commercecode" => $configuration->getCommerceCode(), // idsession local
				);

				$result = $webpay->getNullifyTransaction()->nullify($authorizationCode, $amount, $buyOrder, $nullifyAmount, $commercecode);

				/** Verificamos resultado  de transacción */
				if (!isset($result->authorizationCode)) {
					$message = "webpay no disponible";
				} else {
					$message = "Transaci&oacute;n Finalizada";
				}

				$next_page = '';

				break;
		}
		
		$NoWebplay = false;
		if (!isset($request) || !isset($result) || !isset($message) || !isset($next_page)) {
			//$result = "Ocurri&oacute; un error al procesar tu solicitud";
			//echo "<div style = 'background-color:lightgrey;'><h3>result</h3>$result;</div><br/><br/>";
			//echo "<a href='.'>&laquo; volver a index</a>";
			//die;
			$NoWebplay = true;
		}
	
		$view["Monto_Total"]	= $Monto_Total;
		
		$view["request"] 		= $request;
		$view["result"] 		= $result;
		$view["message"] 		= $message;
		$view["next_page"] 		= $next_page;
		$view["button_name"] 	= $button_name;
		$view["tx_step"] 		= $tx_step;
		$view["token"] 			= $token;
		$view["NoWebplay"] 		= $NoWebplay;
				
		$view["preference"] = $preference;
		
		$this->load->view("checkout/paso3",$view);
	}	
}
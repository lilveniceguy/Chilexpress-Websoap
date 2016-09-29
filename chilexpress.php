<?php

function tarificacionDespacho(){
	try{
		$WSDL = 'WSDL_Tarificacion_QA.wsdl';
		$client = new SoapClient($WSDL);

		/* HEADER */
		$ns = 'http://www.chilexpress.cl/TarificaCourier/';

		$headerbody = array('transaccion'=>array('fechaHora'=>'2015-02-18T14:51:00', 
			'idTransaccionNegocio'=>'?',
			'sistema'=>'?', 
			'login'=>'UsrTestServicios',
			'password'=>'U$$vr2$tS2T',
			'soap_version' => SOAP_1_2
			)
		); 

			//Create Soap Header.        
		$header = new SOAPHeader($ns, 'headerRequest', $headerbody);        

			//set the Headers of Soap Client. 
		$client->__setSoapHeaders($header);	

		/* BODY */


		$result = $client->__soapCall('TarificarCourier', array(
			"TarificarCourier" => array('reqValorizarCourier'=>array('CodCoberturaOrigen'=>'STGO',
				'CodCoberturaDestino'=>'VALP',
				'PesoPza'=>1,
				'DimAltoPza'=>1,
				'DimAnchoPza'=>1,
				'DimLargoPza'=>1
				)
			)
			)
		, array(), null, $outputHeaders);


		$resultado = $result->respValorizarCourier;

		echo "<pre>".var_dump($resultado)."</pre>";




	} catch(SoapFault $e){
		echo "Error \n";
		$msj=$e->getMessage();
		echo "<pre>".var_dump($e)."</pre>";
	}	
}

tarificacionDespacho();

?>

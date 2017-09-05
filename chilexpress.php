<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
//depura variable y no detiene ejecucion
    function pr($val){
        echo '<pre>'.var_export($val,true).'</pre>';
        return $val;    
    };
    
     //depura variable y detiene ejecucion
    function prx($val){
        echo '<pre>'.var_export($val,true).'</pre>';
        return $val;
        exit;
    };

function tarificacionDespacho($height,$width,$weight,$length,$destino){
	try{
		$WSDL = 'http://localhost/oc/upload/WSDL_Tarificacion_QA.wsdl';
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
				'CodCoberturaDestino'=>$destino,
				'PesoPza'=>$width,
				'DimAltoPza'=>$height,
				'DimAnchoPza'=>$width,
				'DimLargoPza'=>$length
				)
			)
		)
		, array(), null, $outputHeaders);
		$resultado = $result->respValorizarCourier;
		return $resultado;
				// return "<pre>".var_dump($resultado)."</pre>";
	} catch(SoapFault $e){
		return "Error \n";
		$msj=$e->getMessage();
		return "<pre>".var_dump($e)."</pre>";
	}	
}

function sucursalesDespacho($destino){
	try{
		$WSDL = 'http://localhost/oc/upload/WSDL_GeoReferencia_QA.wsdl';
		$client = new SoapClient($WSDL);
		/* HEADER */
		$ns = 'http://www.chilexpress.cl/GeoReferencia/';
		$headerbody = array('transaccion'=>array('fechaHora'=>'2015-02-18T14:51:00', 
			'idTransaccionNegocio'=>'?',
			'sistema'=>'?', 
			'login'=>'UsrTestServicios',
			'password'=>'U$$vr2$tS2T',
			'soap_version' => SOAP_1_2
			)
		); 
		$header = new SOAPHeader($ns, 'headerRequest', $headerbody);   
		$client->__setSoapHeaders($header);	

		$result = $client->__soapCall('ConsultarOficinas', array(
			"ConsultarOficinas" => 
			array('reqObtenerOficinas'=>
				array(
					'GlsComuna'=>$destino
				)
			)
			)
		, array(), null, $outputHeaders);
		$resultado = $result->respObtenerOficinas;
		return $resultado;
	} catch(SoapFault $e){
		return "Error \n";
		$msj=$e->getMessage();
		return "<pre>".var_dump($e)."</pre>";
	}	
}	


function todasRegiones(){
	try{
		$client = new SoapClient("http://localhost/oc/upload/WSDL_GeoReferencia_QA.wsdl");
		$ns = 'http://www.chilexpress.cl/CorpGR/ConsultarRegiones';
		$headerbody = array('transaccion'=>array('fechaHora'=>'2015-02-18T14:51:00', 
			'idTransaccionNegocio'=>'?',
			'sistema'=>'?', 
			'login'=>'UsrTestServicios',
			'password'=>'U$$vr2$tS2T'
			)
		); 
		$header = new SOAPHeader($ns, 'headerRequest', $headerbody);   
		$client->__setSoapHeaders($header);	
		$params = array (
			"ConsultarRegiones"=>array(
		    	"reqObtenerRegion" => null
			)
		);

		$response = $client->__soapCall('ConsultarRegiones',$params);

		return $response;

	} catch(SoapFault $e){
		// return "Error \n";
		$msj=$e->getMessage();
		return $msj;
	}	
}

function getComunas($region){
		$WSDL = 'http://localhost/oc/upload/WSDL_GeoReferencia_QA.wsdl';
		$client = new SoapClient($WSDL);
		/* HEADER */
		// prx($client->__getFunctions()); 
		// prx($client->__getTypes());
		$regiones=todasRegiones();
		$ns = 'http://www.chilexpress.cl/GeoReferencia/';
		$headerbody = array('transaccion'=>array('fechaHora'=>'2015-02-18T14:51:00', 
			'idTransaccionNegocio'=>'?',
			'sistema'=>'?', 
			'login'=>'UsrTestServicios',
			'password'=>'U$$vr2$tS2T',
			'soap_version' => SOAP_1_2
			)
		); 
		$header = new SOAPHeader($ns, 'headerRequest', $headerbody);   
		$client->__setSoapHeaders($header);	

		$result = $client->__soapCall('ConsultarCoberturas', array(
			"ConsultarCoberturas" => 
			array('reqObtenerCobertura'=>
				array(
					'CodRegion'=>$region,
					'CodTipoCobertura'=>2
				)
			)
		)
		, array(), null, $outputHeaders);
		$resultado = $result->respObtenerCobertura->Coberturas;
		return $resultado;
}

function getCalles($comuna,$calle){
	$WSDL = 'http://localhost/oc/upload/WSDL_GeoReferencia_QA.wsdl';
	$client = new SoapClient($WSDL);
	/* HEADER */
	// prx($client->__getFunctions()); 
	// prx($client->__getTypes());
	$regiones=todasRegiones();
	$ns = 'http://www.chilexpress.cl/GeoReferencia/';
	$headerbody = array('transaccion'=>array('fechaHora'=>'2015-02-18T14:51:00', 
		'idTransaccionNegocio'=>'?',
		'sistema'=>'?', 
		'login'=>'UsrTestServicios',
		'password'=>'U$$vr2$tS2T',
		'soap_version' => SOAP_1_2
		)
	); 
	$header = new SOAPHeader($ns, 'headerRequest', $headerbody);   
	$client->__setSoapHeaders($header);	

	$result = $client->__soapCall('ConsultarCalles', array(
		"ConsultarCalles" => 
		array('reqObtenerCalle'=>
			array(
				'GlsComuna'=>$comuna,
				'GlsCalle'=>$calle
			)
		)
	)
	, array(), null, $outputHeaders);
	$resultado = $result->respObtenerCalle->Calles;
	return $resultado;
}

function getNumero($idcalle,$numero){
	$WSDL = 'http://localhost/oc/upload/WSDL_GeoReferencia_QA.wsdl';
	$client = new SoapClient($WSDL);
	/* HEADER */
	// prx($client->__getFunctions()); 
	// prx($client->__getTypes());
	$regiones=todasRegiones();
	$ns = 'http://www.chilexpress.cl/GeoReferencia/';
	$headerbody = array('transaccion'=>array('fechaHora'=>'2015-02-18T14:51:00', 
		'idTransaccionNegocio'=>'?',
		'sistema'=>'?', 
		'login'=>'UsrTestServicios',
		'password'=>'U$$vr2$tS2T',
		'soap_version' => SOAP_1_2
		)
	); 
	$header = new SOAPHeader($ns, 'headerRequest', $headerbody);   
	$client->__setSoapHeaders($header);	

	$result = $client->__soapCall('ConsultarNumeros', array(
		"ConsultarNumeros" => 
		array('reqObtenerNumero'=>
			array(
				'idNombreCalle'=>$idcalle,
				'Numeracion'=>$numero
			)
		)
	)
	, array(), null, $outputHeaders);
	$resultado = $result->respObtenerNumero->Numeros;
	return $resultado;
}

?>

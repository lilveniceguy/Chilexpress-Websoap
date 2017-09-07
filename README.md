- Funciones PHP para conexión, calculo de Tarifa y geolocalización/normalización de Regiones, comunas, calles y numeros vía Chilexpress.

- Subir archivos WSDL a su server

Utilicé algo de ayuda de un plugin que habían desarrollado para Drupal, básicamente la función, pero estaba desactualizado y tuve que hacer unos cambios con la guia recibida de parte de Chilexpress para conexión a sus datos

Para ver las respuestas posibles del webservice utilicé:
- $WSDL = 'http://rutadelarchivo/WSDL_GeoReferencia_QA.wsdl';
- $client = new SoapClient($WSDL);
- print_r($client->__getFunctions()); 
- print_r($client->__getTypes());

Los datos que utilizo para el calculo de las dimensiones para el tarificador (que aún no encuentro la adecuada pero es la mas cercana a lo real) son los siguientes:
- El ancho mas grande.
- El largo mas grande.
- La suma de todos las medidas de altura.
- La suma de todos los pesos.

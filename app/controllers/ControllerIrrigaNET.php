<?php
/*

	Exibir:
		- Umidade de solo 
		- Temperatura
		- Umidade do ar 
		- Nível de água do reservatório (para encher assim que necessário)

	Função:
		- Ligar / liberar irrigação
		
	App vai pegar as informações do dispositivo
	dispositivo vai enviar os indicadores. 
	dispositivo vai verificar se tem comando para irrigar

	public function atualizaDispositivo($requisicao)
	public function consultarDispositivo($dispositivo)
	public function consultarDispositivos()
	public function consultaComandoIrrigar($dispositivo)
	public function atualizaFlagIrrigar($dispositivo, $flag)
	public function populaIrrigaNET($row)
*/

	//Usado no Arduino -> atualizaDispositivo();
	$app->put('/atualiza', function () use ($app) {
		$body = stripcslashes($app->request->getBody());
		$body =json_decode($body, true);
		$dao = new DAOIrrigaNET();
		$retorno = $dao->atualizaDispositivo($body);
		helpers::jsonResponse($app, $retorno);
	});
	
	//Usado no Arduino -> verifica se precisa irrigar
	$app->get('/consulta/irrigar/:dispositivo', function ($dispositivo = '') use ($app) {
		$dao = new DAOIrrigaNET();
		$r = $dao->consultaComandoIrrigar($dispositivo);
		helpers::jsonResponse($app, $r);
	});
	
	//Usado no Android -> Consulta dados da horta.
	$app->get('/consulta(/:dispositivo)', function ($dispositivo = '') use ($app) {
		$dao = new DAOIrrigaNET();
		if ($dispositivo == '') {
			$r = $dao->consultarDispositivos();
		}
		else { 
			$r = $dao->consultarDispositivo($dispositivo);
		}
		helpers::jsonResponse($app, $r);
	});
	
	//Usado no Android -> Comando para irrigar a horta
	  $app->get('/irrigar/:dispositivo',function ($dispositivo) use ($app) {
		$dao = new DAOIrrigaNET();
		$r = $dao->atualizaFlagIrrigar($dispositivo,1);
		helpers::jsonResponse($app, $r);
	  });
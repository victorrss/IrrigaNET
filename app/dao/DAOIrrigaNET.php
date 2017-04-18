<?php
class DAOIrrigaNET
{
    public static $instance;

    public function __construct()
    {  }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new DAOIrrigaNET();
        }

        return self::$instance;
    }
    
    //Usado no ARDUINO
    public function atualizaDispositivo($requisicao)
    {
        $ir = self::populaIrrigaNET($requisicao);
        try {
            $sql = "UPDATE irriga SET umidadeSolo = :umidadeSolo, umidadeAr = :umidadeAr, temperatura = :temperatura, nivelAgua = :nivelAgua, dataArduino = :dataArduino WHERE dispositivo = :dispositivo";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":dispositivo", 	$ir->getDispositivo());
			$p_sql->bindValue(":umidadeSolo", 	$ir->getUmidadeSolo());
			$p_sql->bindValue(":umidadeAr",  	$ir->getUmidadeAr());
			$p_sql->bindValue(":temperatura",  	$ir->getTemperatura());
			$p_sql->bindValue(":nivelAgua",  	$ir->getNivelAgua());
			$p_sql->bindValue(":dataArduino", 	date('Y-m-d H:i:s'));
            return $p_sql->execute();
        } catch (Exception $e) {
            return null;
        }
    }

	//Usado no Arduino
    //verifica se tem comando para irrigar
    public function consultaComandoIrrigar($dispositivo)
    {
        try {
            $sql = "SELECT irrigar FROM irriga WHERE dispositivo = :dispositivo AND irrigar = 1";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":dispositivo", $dispositivo);
            $p_sql->execute();
            $row = $p_sql->fetch(PDO::FETCH_ASSOC);
            if ($p_sql->rowCount() == 1) {
				self::atualizaDataArduino($dispositivo);
                self::atualizaFlagIrrigar($dispositivo,0);
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return null;
        }
    }
	
    //Usado no android
    public function consultarDispositivo($dispositivo)
    {
        try {
            $sql = "SELECT * FROM irriga WHERE dispositivo = :dispositivo";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":dispositivo", $dispositivo);
            $p_sql->execute();
            $row = $p_sql->fetch(PDO::FETCH_ASSOC);
            if ($p_sql->rowCount() == 1) {
                self::atualizaDataAndroid($dispositivo);
                return $row;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return null;
        }
    }

    //Usado no android
    public function consultarDispositivos()
    {
        try {
            $sql = "SELECT * FROM irriga ";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->execute();
            $row = $p_sql->fetch(PDO::FETCH_ASSOC);
            return $row;
        } catch (Exception $e) {
            return null;
        }
    }

    // Comando para irrigar
    public function atualizaFlagIrrigar($dispositivo, $flag)
    {

        try {
            $sql = "UPDATE irriga SET irrigar = :flag WHERE dispositivo = :dispositivo";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":dispositivo", $dispositivo);
            $p_sql->bindValue(":flag", $flag, PDO::PARAM_INT);
			//Atualiza data, pq é requisição android
            if($flag == 1){
                self::atualizaDataAndroid($dispositivo);
            }
            return $p_sql->execute();

        } catch (Exception $e) {
            return null;
        }
    }

    //Uso interno da classe
    private function atualizaDataArduino($dispositivo)
    {
        try {
            $sql = "UPDATE irriga SET dataArduino = :dataArduino WHERE dispositivo = :dispositivo";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":dispositivo", $dispositivo);
            $p_sql->bindValue(":dataArduino", date('Y-m-d H:i:s'));
            return $p_sql->execute();
        } catch (Exception $e) {
            return null;
        }
    }

    //Uso interno da classe
    private function atualizaDataAndroid($dispositivo)
    {
        try {
            $sql = "UPDATE irriga SET dataAndroid = :dataAndroid WHERE dispositivo = :dispositivo";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":dispositivo", $dispositivo);
            $p_sql->bindValue(":dataAndroid", date('Y-m-d H:i:s'));
            return $p_sql->execute();
        } catch (Exception $e) {
            return null;
        }
    }
	
	public function populaIrrigaNET($row)
    {
		$model = new ModelIrrigaNET();
		$model->setDispositivo($row['dispositivo']);
		$model->setUmidadeSolo($row['umidadeSolo']);
		$model->setUmidadeAr($row['umidadeAr']);
		$model->setTemperatura($row['temperatura']);
		$model->setNivelAgua($row['nivelAgua']);
		//$model->setIrrigar($row['irrigar']);
		return $model;
	}
    
}

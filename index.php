<?php

 # === constants
# ==================================================
define("_APP", dirname(__FILE__) . '/app');

# === PHPMailer
# ==================================================
//require 'vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
 
# === Slim Framework v2
# ==================================================
require 'vendor/autoload.php';
$app = new \Slim\Slim();
         //$mail = new PHPMailer;

# === database conection
# ==================================================
require_once _APP . '/config/database.php';

# === models
# ==================================================
require_once _APP . "/models/ModelIrrigaNET.php";

# === dao
# ==================================================
require_once _APP . "/dao/DAOIrrigaNET.php";

# === helpers
# ==================================================
require_once _APP . '/helpers/appHelpers.php';

# === controllers
# ==================================================
require_once _APP . "/controllers/ControllerIrrigaNET.php";

 # === run slim
$app->run();

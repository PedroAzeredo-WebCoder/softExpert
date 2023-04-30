<?php
error_reporting(E_ERROR);

/**
 * @package common
 * @version 1.0.0
 * @author pedro-azeredo <pedro.azeredo93@gmail.com>
 */

session_start();

/**
 * @package common
 * @subpackage third-itens
 */
require_once("config.php"); 						// configuration
require_once("class.template.php"); 				// template.class
require_once("class.table.php"); 					// table.class
require_once("class.form.php"); 					// form.class
require_once("class.sqlQuery.php"); 				// query.class
require_once("class.pagination.php"); 			// pagination.class
require_once("class.bootstrap.php"); 				// bootstrap functions
require_once("class.phpzip.php");					// zip.class
require_once("class.tabs.php");					// tabs.class
require_once("connection.php");					// connection mysql
require_once("phpmailer/Exception.php");			// phpmailer.class
require_once("phpmailer/PHPMailer.php");			// phpmailer.class
require_once("phpmailer/SMTP.php");				// phpmailer.class
require_once("functions.asaas.php");				// asaas.functions

date_default_timezone_set('America/Sao_Paulo');

// função de redirect em JS
function redirect($url)
{
	if ($url == 'volta') {
		$url = $_SERVER["HTTP_REFERER"];
	}
	echo "
			<script>
				window.location = '" . $url . "';
			</script>
		";
	die();
}

// funcao de alerta
function alert($mensagem)
{
	echo "
			<script>
				alert('$mensagem');
			</script>
		";
}

// funcao para pegar parametros
function getParam($name, $encriptado = false)
{
	if ($encriptado == false) {
		if ($_POST[$name] != "") {
			return $_POST[$name];
		} else {
			if ($_GET[$name] != "") {
				return $_GET[$name];
			}
		}
	} else {
		$e = $_GET[$name];
		$getIn = strrev(base64_decode(strrev($e)));
		$explodeGet = explode("&", $getIn);
		$out = array();
		for ($x = 0; $x < COUNT($explodeGet); $x++) {
			$explodeVal = explode("=", $explodeGet[$x]);
			$out[$explodeVal[0]] = $explodeVal[1];
		}

		return $out;
	}
}

function getFileParam($name)
{
	return $_FILES[$name];
}

// sessoes  setar e pegar
function setSession($name, $value)
{
	$_SESSION["sistema"][$name] = $value;
}

function getSession($name)
{
	return $_SESSION["sistema"][$name];
}

// funcao para imprimir arrays do sistema
function print_p($array)
{
	echo "<pre>";
	print_r($array);
	echo "</pre>";
}

// funcao de hash md5 modificadinha
function hash_md5($string)
{
	return md5("sistema" . $string);
}

// funcao para testar login na página
function checkAccess()
{
	$access = getDbValue("SELECT id FROM cad_usuarios WHERE uniqid = '" . getSession('SYSGER') . "'");
	if (empty($access)) {
		setSession("SYSGER", "");
		redirect('login.php');
	}
}

/*****************************************************************************************************
		retorna o valor de um campo através de expressão sql
 */
function getDbValue($sql)
{
	$conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE, DB_USER, DB_PASSWORD) or print($conn->errorInfo());
	foreach ($conn->query($sql) as $row) {
		return $row[0];
	}
}


// funcao para setar erro
function setAlert($mensagem, $tipo, $extend = NULL)
{
	setSession('title',	$mensagem);
	setSession('icon',		$tipo);
	setSession('extend', $extend);
}

//funcao para mostrar erro
function getAlert()
{
	if (getSession('title') != "") {

		$out = "
			<script>
				Swal.fire({
					showConfirmButton: false,
					timer: 2500,
					title: '" . getSession('title') . "',
					icon: '" . getSession('icon') . "',
					" . getSession('extend') . "
				});
			</script>
			";

		setSession('title',		'');
		setSession('icon',		'');
		setSession('extend',	'');
		return $out;
	}
}

// funcao para arrumar data BR -> US
function ChangeDate($date)
{
	$str = explode(" ", $date);
	$data = implode("-", array_reverse(explode("/", $str[0])));
	$time = $str[1];
	return $data . " " . $time . ":00";
}

// funcao para arrumar data BR -> US
function DateToBR($date)
{
	$str = explode(" ", $date);
	$data = implode("/", array_reverse(explode("-", $str[0])));
	$time = $str[1];
	return $data . " " . $time;
}

// funcao para saber qual script esta sendo executado
function QuemSou($url = null)
{
	if ($url == NULL) {
		$url = $_SERVER["SCRIPT_FILENAME"];
	}
	$st = array_reverse(explode("/", $url));
	$st = explode("_", $st[0]);
	// $st = explode(".",$st[0]);
	return $st[0];
}

// funcao para criar senha randomica
function criaSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false)
{
	$lmin 		= 'abcdefghijklmnopqrstuvwxyz';
	$lmai 		= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$num 		= '1234567890';
	$simb 		= '!@#$%*-';
	$retorno 	= '';
	$caracteres = '';

	$caracteres .= $lmin;
	if ($maiusculas) $caracteres .= $lmai;
	if ($numeros) $caracteres .= $num;
	if ($simbolos) $caracteres .= $simb;

	$len = strlen($caracteres);
	for ($n = 1; $n <= $tamanho; $n++) {
		$rand = mt_rand(1, $len);
		$retorno .= $caracteres[$rand - 1];
	}
	return $retorno;
}

/***************************************************************************
		Função para formatar qualquer valor
 */
function mascara($format, $value)
{
	if ($format == "") {
		$out = $value;
	} else {
		$out = "";
		$j = 0;
		for ($i = 0; $i < strlen($format); $i++) {
			if ($format[$i] == "9" or $format[$i] == "X") {
				$out .= $value[$j];
				$j++;
			} else {
				$out .= $format[$i];
			}
		}
	}
	return $out;
}

// pega só numeros
function soNumero($str)
{
	return preg_replace("/[^0-9]/", "", $str);
}

function getFUllUrl()
{
	$link =  "http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
	return htmlspecialchars($link, ENT_QUOTES, 'UTF-8');
}

// funcao para limitar textos
function limita_caracteres($texto, $limite, $quebra = false)
{
	$tamanho = strlen($texto);

	if ($tamanho <= $limite) {
		$novo_texto = $texto;
	} else {
		if ($quebra == true) {
			$novo_texto = trim(substr($texto, 0, $limite)) . ' ...';
		} else {
			$ultimo_espaco = strrpos(substr($texto, 0, $limite), ' ');
			$novo_texto = trim(substr($texto, 0, $ultimo_espaco)) . ' ...';
		}
	}

	return $novo_texto;
}

// funcao de uniqueID
function uniqIdNew()
{
	return md5(uniqid(rand(), true));
}

// funcao para criar slugs
function slug($string)
{
	$baseCaracters = array(
		'Š' => 'S', 'š' => 's', 'Ð' => 'Dj', '' => 'Z', '' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A',
		'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',  'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I',
		'Ï' => 'I', 'Ñ' => 'N', 'Ń' => 'N', 'Ò' => 'O', 'Ó' => 'O',  'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U',
		'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a',
		'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e',  'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i',
		'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ń' => 'n', 'ò' => 'o',  'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u',
		'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ý' => 'y', 'ý' => 'y',  'þ' => 'b', 'ÿ' => 'y', 'ƒ' => 'f',
		'ă' => 'a', 'î' => 'i', 'â' => 'a', 'ș' => 's', 'ț' => 't',  'Ă' => 'A', 'Î' => 'I', 'Â' => 'A', 'Ș' => 'S', 'Ț' => 'T',
	);
	$string = strtr(trim($string), $baseCaracters);
	$string = str_replace("-", "", $string);
	$string = str_replace(" ", "_", $string);

	return strtolower($string);
}

function printSQL($sql, $dados, $print = NULL)
{
	foreach ($dados as $key => $value) {
		$sql = str_replace(":" . $key, "'" . $value . "'", $sql);
	}
	if ($print == NULL) {
		print_p($sql);
	} else {
		print_r($sql, true);
	}
}

function encodeGet($href)
{
	$hrefOut = "";
	if (is_array($href)) {
		$e = array();
		foreach ($href[1] as $key => $value) {
			$e[] = $key . "=" . $value;
		}
		$e = implode("&", $e);
		$hrefOut = $href[0] . "?e=" . strrev(base64_encode(strrev($e)));
	} else {
		$hrefOut = $href;
	}

	return $hrefOut;
}

function getUserInfo($field)
{
	return getDbValue("SELECT " . $field . " FROM cad_usuarios WHERE uniqid = '" . getSession("SYSGER") . "'");
}

function br_DiaSemana($w)
{
	$dia = array(
		"1" => "DOM",
		"2" => "SEG",
		"3" => "TER",
		"4" => "QUA",
		"5" => "QUI",
		"6" => "SEX",
		"7" => "SÁB",
	);
	return $dia[$w];
}

function writeLogs($logs, $file = NULL)
{
	if ($file == NULL) {
		$file = date("Y-m-d") . ".log";
	} else {
		$file = date("Y-m-d") . "_" . $file . ".log";
	}
	$fileOp = fopen(PATH_LOGS . $file, "a");
	fwrite($fileOp, "[" . date("Y-m-d H:i:s") . "] " . $logs . "\r\n");
	fclose($fileOp);
}

function validar_cpf_cnpj($valor)
{
	if (!empty($valor)) {
		$valor = preg_replace('/[^0-9]/', '', $valor);

		// Verifica se o valor é numérico
		if (!is_numeric($valor)) {
			setAlert('CPF/CNPJ Inválido!', 'error');
			header(sprintf('location: %s', $_SERVER['HTTP_REFERER']));
			exit;
		}

		// CPF
		if (strlen($valor) === 11) {
			// Verifica se todos os dígitos são iguais
			if (preg_match('/^(\d)\1{10}$/', $valor)) {
				setAlert('CPF Inválido!', 'error');
				header(sprintf('location: %s', $_SERVER['HTTP_REFERER']));
				exit;
			}

			// Calcula os dígitos verificadores
			$digito1 = 0;
			$digito2 = 0;
			for ($i = 0; $i < 9; $i++) {
				$digito1 += ($valor[$i] * (10 - $i));
				$digito2 += ($valor[$i] * (11 - $i));
			}
			$digito2 += ($valor[9] * 2);

			$resto1 = ($digito1 % 11);
			$digito1 = ($resto1 < 2) ? 0 : (11 - $resto1);

			$resto2 = ($digito2 % 11);
			$digito2 = ($resto2 < 2) ? 0 : (11 - $resto2);

			// Verifica se os dígitos verificadores são válidos
			if (($valor[9] != $digito1) || ($valor[10] != $digito2)) {
				setAlert('CPF Inválido!', 'error');
				header(sprintf('location: %s', $_SERVER['HTTP_REFERER']));
				exit;
			}
		}

		// CNPJ
		elseif (strlen($valor) === 14) {
			// Verifica se todos os dígitos são iguais
			if (substr_count($valor, $valor[0]) === 14) {
				setAlert('CNPJ Inválido!', 'error');
				header(sprintf('location: %s', $_SERVER['HTTP_REFERER']));
				exit;
			}

			// Cálculo do primeiro dígito verificador
			$soma = 0;
			$pesos = array(5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2);
			for ($i = 0; $i < 12; $i++) {
				$soma += intval($valor[$i]) * $pesos[$i];
			}
			$resto = $soma % 11;
			$digito1 = $resto < 2 ? 0 : 11 - $resto;

			// Cálculo do segundo dígito verificador
			$soma = 0;
			$pesos = array(6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2);
			for ($i = 0; $i < 12; $i++) {
				$soma += intval($valor[$i]) * $pesos[$i];
			}
			$soma += $digito1 * 2;
			$resto = $soma % 11;
			$digito2 = $resto < 2 ? 0 : 11 - $resto;

			// Verifica se os dígitos verificadores estão corretos
			if (intval($valor[12]) !== $digito1 || intval($valor[13]) !== $digito2) {
				setAlert('CNPJ Inválido!', 'error');
				header(sprintf('location: %s', $_SERVER['HTTP_REFERER']));
				exit;
			}
			return true;
		}
	}
}

function validar_email($email)
{
	if (!empty($email)) {
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return true;
		} else {
			setAlert('Email inválido!', 'error');
			header(sprintf('location: %s', $_SERVER['HTTP_REFERER']));
			exit;
		}
	}
}

function validar_senha($f_senha, $f_confirmar_senha)
{
	if (isset($f_senha) && !empty($f_senha) && isset($f_confirmar_senha) && !empty($f_confirmar_senha)) {
		if ($f_senha === $f_confirmar_senha) {
			return md5($f_senha);
		} else {
			setAlert('Senhas não conferem!', 'error');
			header(sprintf('location: %s', $_SERVER['HTTP_REFERER']));
			exit;
		}
	}
}

<?php

// Created by avid
// xn script v1.5

if (PHP_VERSION < 6.7) {
	throw new Error("<b>xn library</b> needs more than or equal to 6.7 version");
	exit;
}

$GLOBALS['-XN-'] = [];
$GLOBALS['-XN-']['startTime'] = microtime(1);
$GLOBALS['-XN-']['dirName'] = substr(__FILE__, 0, strrpos(__FILE__, DIRECTORY_SEPARATOR));
$GLOBALS['-XN-']['dirNameDir'] = $GLOBALS['-XN-']['dirName'] . DIRECTORY_SEPARATOR;
$GLOBALS['-XN-']['lastUpdate'] = "0{[LASTUPDATE]}";
$GLOBALS['-XN-']['lastUse'] = "1528112107{[LASTUSE]}";
$GLOBALS['-XN-']['DATA'] = "W10={[DATA]}";
$DATA = json_decode(base64_decode(substr($GLOBALS['-XN-']['DATA'], 0, -8)) , @$XNDATA === 1);
class ThumbCode

{
	private $code = false;
	public

	function __construct($func)
	{
		$this->code = $func;
	}

	public

	function __destruct()
	{
		if ($this->code) ($this->code) ();
	}

	public

	function close()
	{
		$this->code = false;
	}

	public

	function clone ()
	{
		return new ThumbCode($this->code);
	}
}

function thumbCode($func)
{
	return new ThumbCode($func);
}

function set_last_update_nter()
{
	$file = $GLOBALS['-XN-']['dirNameDir'] . 'xn.php';
	$f = file_get_contents($file);
	$p = strpos($f, "{[LASTUPDATE]}");
	while ($p > 0 && $f[$p--] != '"');
	if ($p <= 0) return false;
	$h = '';
	$p+= 2;
	while ($f[$p] != '{') $h.= $f[$p++];
	if (!is_numeric($h)) return false;
	$f = str_replace("$h{[LASTUPDATE]}", time() . "{[LASTUPDATE]}", $f);
	return file_put_contents($file, $f);
}

function set_last_use_nter()
{
	$file = $GLOBALS['-XN-']['dirNameDir'] . 'xn.php';
	$f = file_get_contents($file);
	$p = strpos($f, "{[LASTUSE]}");
	while ($p > 0 && $f[$p--] != '"');
	if ($p <= 0) return false;
	$h = '';
	$p+= 2;
	while ($f[$p] != '{') $h.= $f[$p++];
	if (!is_numeric($h)) return false;
	$f = str_replace("$h{[LASTUSE]}", time() . "{[LASTUSE]}", $f);
	return file_put_contents($file, $f);
}

function set_data_nter()
{
	$data = base64_encode(json_encode($GLOBALS['DATA']));
	$file = $GLOBALS['-XN-']['dirNameDir'] . 'xn.php';
	$f = file_get_contents($file);
	$p = strpos($f, "{[DA" . "TA]}");
	while ($p > 0 && $f[$p--] != '"');
	if ($p <= 0) return false;
	$h = '';
	$p+= 2;
	while ($f[$p] != '{') $h.= $f[$p++];
	$f = str_replace("$h{[DA" . "TA]}", "$data{[D" . "ATA]}", $f);
	return file_put_contents($file, $f);
}

function xnupdate()
{
	copy("https://raw.githubusercontent.com/xnlib/xnphp/master/xn.php", $GLOBALS['-XN-']['dirNameDir'] . "xn.php");
	if (file_exists("xn.beautify.php")) copy("https://raw.githubusercontent.com/xnlib/xnphp/master/xn.beautify.php", $GLOBALS['-XN-']['dirNameDir'] . "xn.beautify.php");
	set_last_update_nter();
}

if (@$XNUPDATE === 2 || (@$XNUPDATE === 1 && substr($GLOBALS['-XN-']['lastUpdate'], 0, -14) + 10000 <= time())) xnupdate();
$GLOBALS['-XN-']['runEnd'] = thumbCode(
function ()
{
	global $DATA;
	set_data_nter();
	set_last_use_nter();
});

// XNCodes
// Root-------------------------------------

$GLOBALS['-XN-']['errorShow'] = true;
class XNError extends Error

{
	protected $message;
	static
	function show($sh = null)
	{
		if ($sh === null) $GLOBALS['-XN-']['errorShow'] = !$GLOBALS['-XN-']['errorShow'];
		else $GLOBALS['-XN-']['errorShow'] = $sh;
	}

	static
	function handlr($func)
	{
		$GLOBALS['-XN-']['errorHandlr'] = $func;
	}

	public

	function __construct($in, $text, $level = 0)
	{
		$type = ["Warning", "Notic", "User Error", "User Warning", "User Notic", "Recoverable Error", "Syntax Error", "Unexpected", "Undefined", "Anonimouse", "System Error", "Secury Error", "Fatal Error", "Arithmetic Error", "Parse Error", "Type Error"][$level];
		$debug = debug_backtrace();
		$th = end($debug);
		$date = date("ca");
		$console = "[$date]XN $type > $in : $text in {$th['file']} on line {$th['line']}\n";
		$message = "<br />\n[$date]<b>XN $type</b> &gt; <i>$in</i> : " . str_replace("\n", "<br />", $text) . " in <b>{$th['file']}</b> on line <b>{$th['line']}</b>\n<br />";
		$this->HTMLMessage = $message;
		$this->consoleMessage = $console;
		$this->message = "XN $type > $in : $text";
		if (isset($GLOBALS['-XN-']['errorHandlr'])) {
			try {
				$GLOBALS['-XN-']['errorHandlr']($this);
			}

			catch(Error $e) {
			}

			catch(Expection $e) {
			}

			catch(XNError $e) {
			}
		}

		if ($GLOBALS['-XN-']['errorShow']) echo $message;
		if ($GLOBALS['-XN-']['errorShow'] && is_string($GLOBALS['-XN-']['errorShow'])) fadd($GLOBALS['-XN-']['errorShow'], $console);
	}

	public

	function __toString()
	{
		return $this->message;
	}
}

function subsplit($str, $num = 1, $rms = false)
{
	$arr = [];
	$f = 0;
	if ($rms) {
		$len = strlen($str);
		if ($len % $num) {
			$f = $len % $num;
			$arr[] = substr($str, 0, $f);
		}
	}

	while (isset($str[$f])) {
		$arr[] = substr($str, $f, $num);
		$f+= $num;
	}

	return $arr;
}

function mb_subsplit($str, $num = 1, $rms = false)
{
	$arr = [];
	$f = 0;
	if ($rms) {
		$len = mb_strlen($str);
		if ($len % $num) {
			$f = $len % $num;
			$arr[] = mb_substr($str, 0, $f);
		}
	}

	while (isset($str[$f])) {
		$arr[] = mb_substr($str, $f, $num);
		$f+= $num;
	}

	return $arr;
}

function var_read( . . . $var)
{
	ob_start();
	var_dump( . . . $var);
	$r = ob_get_contents();
	ob_end_clean();
	return $r;
}

function replaceone($from, $to, $str)
{
	return substr_replace($str, $to, strpos($str, $from) , strlen($from));
}

function var_move(&$var1, &$var2)
{
	$var3 = $var1;
	$var1 = $var2;
	$var2 = $var3;
}

function var_add($to, . . . $args)
{
	$t = gettype($to);
	switch ($t) {
	case "NULL":
		return null;
		break;

	case "boolean":
		foreach($args as $arg) {
			if ($arg) return true;
		}

		return false;
		break;

	case "integer":
	case "float":
	case "double":
		foreach($args as $arg) {
			$to+= $arg;
		}

		return $to;
		break;

	case "string":
		foreach($args as $arg) {
			$to.= $arg;
		}

		return $to;
		break;

	case "array":
		foreach($args as $arg) {
			$to = array_merge($to, $arg);
		}

		return $to;
		break;

	case "object":
		if (get_class($to) == "stdClass") {
			$to = (array)$to;
			foreach($args as $arg) {
				$to = array_merge($to, (array)$arg);
			}

			return (object)$to;
		}

		break;
	}

	new XNError("var_add", "type invalid");
}

function xneval($code, &$save = 5636347437634)
{
	$p = strpos($code, "<?");
	if ($p === false || $p == - 1) $code = "<?php " . $code;
	$random = rand(0, 99999999) . rand(0, 99999999);
	fput("xn$random.log", $code);
	$z = new thumbCode(
	function () use($random)
	{
		unlink("xn$random.log");
	});
	if ($save === 5636347437634) {
		$r = @require "xn$random.log";

	}
	else {
		ob_start();
		$r = @require "xn$random.log";

		$save = ob_get_contents();
		ob_end_clean();
	}

	return $r;
}

function thecode()
{
	$t = debug_backtrace();
	$t = end($t);
	$l = file($t['file']);
	$c = $l[$t['line'] - 1];
	return $c;
}

function theline()
{
	$t = debug_backtrace();
	$t = end($t);
	return $t['line'];
}

function thefile()
{
	$t = debug_backtrace();
	$t = end($t);
	return $t['file'];
}

function thedir()
{
	$t = debug_backtrace();
	$t = end($t);
	return dirname($t['file']);
}

function var_name(&$var)
{
	$t = debug_backtrace();
	$l = file($t[0]['file']);
	$c = $l[$t[0]['line'] - 1];
	preg_match('/var_name[\n ]*\([@\n ]*\$([a-zA-Z_0-9]+)[\n ]*((\-\>[a-zA-Z0-9_]+)|(\:\:[a-zA-Z0-9_]+)|(\[[^\]]+\])|(\([^\)]*\)))*\)/', $c, $s);
	$s[0] = substr($s[0], 9, -1);
	preg_match_all('/(\-\>[a-zA-Z0-9_]+)|(\:\:[a-zA-Z0-9_]+)|(\[[^\]]+\])|(\([^\)]*\))/', $s[0], $j);
	$u = [];
	foreach($j[1] as $e) {
		if ($e) $u[] = ["caller" => '->', "type" => "object_method", "value" => substr($e, 2) ];
	}

	foreach($j[2] as $e) {
		if ($e) $u[] = ["caller" => "::", "type" => "static_method", "value" => substr($e, 2) ];
	}

	foreach($j[3] as $e) {
		if ($e) $u[] = ["caller" => "[]", "type" => "array_index", "value" => substr($e, 1, -1) ];
	}

	foreach($j[4] as $e) {
		if ($e) $u[] = ["caller" => "()", "type" => "closure_call", "value" => substr($e, 1, -1) ];
	}

	if (isset($s[1])) return ["name" => $s[1], "full" => $s[0], "calls" => $u];
	new XNError("var_name", "invalid variable");
	return false;
}

function define_name($define)
{
	$t = debug_backtrace();
	$l = file($t[0]['file']);
	$c = $l[$t[0]['line'] - 1];
	preg_match('/define_name[\n ]*\([@\n ]*([a-zA-Z_0-9]+)[\n ]*\)/', $c, $s);
	if (isset($s[1])) return $s[1];
	new XNError("define_name", "define type error");
	return false;
}

function countin($text, $in)
{
	return count(explode($in, $text)) - 1;
}

function function_name($func)
{
	$t = debug_backtrace();
	$l = file($t[0]['file']);
	$c = $l[$t[0]['line'] - 1];
	preg_match('/function_name[\n ]*\([@\n ]*([a-zA-Z_0-9]+)[\n ]*\(/', $c, $s);
	if (isset($s[1])) return $s[1];
	new XNError("define_name", "this not is a function");
	return false;
}

function printsc($k = true)
{
	$t = debug_backtrace();
	$l = file($t[0]['file']);
	$p = $t[0]['line'];
	if ($k)
	while (isset($l[$p][1]) && $l[$p][0] . $l[$p][1] == '#>') {
		echo evalc(substr($l[$p++], 2));
	}
	else
	while (isset($l[$p][1]) && $l[$p][0] . $l[$p][1] == '#>') {
		echo substr($l[$p++], 2);
	}
}

function evalc($code)
{
	return eval('return ' . $code . ';');
}

// Telegram-------------------------------

class TelegramBotKeyboard

{
	private $btn = [], $button = [];
	public $resize = false, $onetime = false, $selective = false;

	public

	function size($size = null)
	{
		if ($size === null) $size = !$this->resize;
		$this->resize = $size == true;
		return $this;
	}

	public

	function onetime($onetime = null)
	{
		if ($onetime === null) $onetime = !$this->onetime;
		$this->onetime = $onetime == true;
		return $this;
	}

	public

	function selective($selective = null)
	{
		if ($selective === null) $selective = !$this->selective;
		$this->selective = $selective == true;
		return $this;
	}

	public

	function add($name, $type = '')
	{
		$btn = ["text" => $name];
		if ($type == "contact") $btn["request_contact"] = true;
		elseif ($type == "location") $btn["request_location"] = true;
		$this->btn[] = $btn;
		return $this;
	}

	public

	function line()
	{
		$this->button[] = $this->btn;
		$this->btn = [];
		return $this;
	}

	public

	function get($json = false)
	{
		$this->button[] = $this->btn;
		$btn = ["keyboard" => $this->button];
		if ($this->resize) $btn['resize_keyboard'] = true;
		if ($this->onetime) $btn['one_time_keyboard'] = true;
		if ($this->selective) $btn['selective'] = true;
		$this->button = [];
		$this->btn = [];
		$this->size = false;
		return $json ? json_encode($btn) : $btn;
	}

	public

	function reset()
	{
		$this->button = [];
		$this->btn = [];
		$this->size = false;
		return $this;
	}
}

class TelegramBotInlineKeyboard

{
	private $btn = [], $button = [];
	public $resize = false, $onetime = false, $selective = false;

	public

	function size($size = null)
	{
		if ($size === null) $size = !$this->resize;
		$this->resize = $size == true;
		return $this;
	}

	public

	function onetime($onetime = null)
	{
		if ($onetime === null) $onetime = !$this->onetime;
		$this->onetime = $onetime == true;
		return $this;
	}

	public

	function selective($selective = null)
	{
		if ($selective === null) $selective = !$this->selective;
		$this->selective = $selective == true;
		return $this;
	}

	public

	function add($name, $type, $data = '')
	{
		$btn = ["text" => $name];
		if ($type == "pay") $data = true;
		elseif ($type == "game") $type = "callback_game";
		elseif ($type == "switch") $type = "switch_inline_query";
		elseif ($type == "switch_current_chat") $type = "switch_inline_query_current_chat";
		elseif ($type == "callback" || $type == "data") $type = "callback_data";
		elseif ($type == "link") $type = "url";
		$btn[$type] = $data;
		$this->btn[] = $btn;
		return $this;
	}

	public

	function line()
	{
		$this->button[] = $this->btn;
		$this->btn = [];
		return $this;
	}

	public

	function get($json = false)
	{
		$this->button[] = $this->btn;
		$btn = ["inline_keyboard" => $this->button];
		if ($this->resize) $btn['resize_keyboard'] = true;
		if ($this->onetime) $btn['one_time_keyboard'] = true;
		if ($this->selective) $btn['selective'] = true;
		$this->button = [];
		$this->btn = [];
		$this->size = false;
		return $json ? json_encode($btn) : $btn;
	}

	public

	function reset()
	{
		$this->button = [];
		$this->btn = [];
		$this->size = false;
		return $this;
	}
}

class TelegramBotQueryResult

{
	public $get;

	public

	function add($type, $id, $title, $input, $args = [])
	{
		$args["type"] = $type;
		$args["id"] = $id;
		$args["title"] = $title;
		$args["input_message_content"] = $input;
		$this->get[] = $args;
		return $this;
	}

	public

	function inputMessage($text, $parse = false, $preview = false)
	{
		$args = ["message_text" => $text];
		if ($parse) $args["parse_mode"] = $parse;
		if ($preview) $args["disable_web_page_preview"] = $preview;
		return $args;
	}

	public

	function inputLocation($latitude, $longitude, $live = false)
	{
		$args = ["latitude" => $latitude, "longitude" => $longitude];
		if ($live) $args['live_period'] = $live;
		return $args;
	}

	public

	function inputVenue($latitude, $longitude, $title, $address, $id = false)
	{
		$args = ["latitude" => $latitude, "longitude" => $longitude, "title" => $title, "address" => $address];
		if ($id) $args["foursquare_id"] = $id;
		return $args;
	}
}

class TelegramBotButtonSave

{
	private $btns = [], $btn = [];
	public

	function get($name, $json = true)
	{
		if ($json) return @$this->btn[$name];
		return @$this->btns[$name];
	}

	public

	function add($name, $btn)
	{
		if (is_array($btn)) $btns = json_encode($btn);
		elseif (!is_json($btn)) return false;
		else $btn = json_decode($btns = $btn);
		if (!isset($btns['inline_keyboard']) || !isset($btns['keyboard']) || !isset($btns['force_reply']) || !isset($btns['remove_keyboard'])) return false;
		$this->btns = $btns;
		$this->btn = $btn;
		return $this;
	}

	public

	function delete($name)
	{
		if (isset($this->btn[$name])) {
			unset($this->btn[$name]);
			unset($this->btns[$name]);
		}

		return $this;
	}

	public

	function reset()
	{
		$this->btn = [];
		$this->btns = [];
	}
}

class TelegramBot

{
	public $data, $token, $final, $results = [], $sents = [], $save = true, $last;

	public $keyboard, $inlineKeyboard, $foreReply, $removeKeyboard, $queryResult, $menu;

	public

	function setToken($token = '')
	{
		$this->last = $this->token;
		$this->token = $token;
		return $this;
	}

	public

	function backToken()
	{
		$token = $this->token;
		$this->token = $this->last;
		$this->last = $token;
		return $this;
	}

	public

	function __construct($token = '')
	{
		$this->token = $token;
		$this->keyboard = new TelegramBotKeyboard;
		$this->inlineKeyboard = new TelegramBotInlineKeyboard;
		$this->queryResult = new TelegramBotQueryResult;
		$this->menu = new TelegramBotButtonSave;
		$this->forceReply = ["force_reply" => true];
		$this->removeKeyboard = ["remove_keyboard" => true];
	}

	public

	function update($offset = - 1, $limit = 1, $timeout = 0)
	{
		if (isset($this->data->message_id)) return $this->data;
		elseif ($this->data = json_decode(file_get_contents("php://input"))) return $this->data;
		else $res = $this->data = $this->request("getUpdates", ["offset" => $offset, "limit" => $limit, "timeout" => $timeout], 3);
		if (!$res->ok) return (object)[];
		return $res;
	}

	public

	function request($method, $args = [], $level = 3)
	{
		$args = $this->parse_args($args);
		if ($level == 1) {
			header("Content-Type: application/json");
			$args['method'] = $method;
			echo json_encode($args);
			$res = true;
		}
		elseif ($level == 2) {
			$res = fclose(fopen("https://api.telegram.org/bot$this->token/$method?" . http_build_query($args) , 'r'));
		}
		elseif ($level == 3) {
			$ch = curl_init("https://api.telegram.org/bot$this->token/$method");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
			$res = json_decode(curl_exec($ch));
			curl_close($ch);
		}
		elseif ($level == 4) {
			$res = fclose(fopen("https://api.pwrtelegram.xyz/bot$this->token/$method?" . http_build_query($args) , 'r'));
		}
		elseif ($level == 5) {
			$ch = curl_init("https://api.pwrtelegram.xyz/bot$this->token/$method");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
			$res = json_decode(curl_exec($ch));
			curl_close($ch);
		}
		else return false;
		$args['method'] = $method;
		$args['level'] = $level;
		if ($this->save) {
			$this->sents[] = $args;
			$this->results[] = $this->final = $res;
		}

		if ($res === false) return false;
		if ($res === true) return true;
		if (!$res->ok) {
			new XNError("TelegramBot", "$res->description [$res->error_code]", 1);
			return $res;
		}

		return $res;
	}

	public

	function reset()
	{
		$this->final = null;
		$this->results = [];
		$this->sents = [];
		$this->data = null;
	}

	public

	function close()
	{
		$this->final = null;
		$this->results = null;
		$this->sents = null;
		$this->data = null;
		$this->token = null;
	}

	public

	function sendMessage($chat, $text, $args = [], $level = 3)
	{
		$args['chat_id'] = $chat;
		$args['text'] = $text;
		return $this->request("sendMessage", $args, $level);
	}

	public

	function sendMessages($chat, $text, $args = [], $level = 3)
	{
		$args['chat_id'] = $chat;
		$texts = subsplit($text, 4096);
		foreach($texts as $text) {
			$args['text'] = $text;
			$this->request("sendMessage", $args, $level);
		}

		return $this;
	}

	public

	function sendMessageRemoveKeyboard($chat, $text, $args = [], $level = 3)
	{
		$args['chat_id'] = $chat;
		$args['text'] = $text;
		$args['reply_markup'] = json_encode(["remove_keyboard" => true]);
		return $this->request("sendMessage", $args, $level);
	}

	public

	function sendMessageForceReply($chat, $text, $args = [], $level = 3)
	{
		$args['chat_id'] = $chat;
		$args['text'] = $text;
		$args['reply_markup'] = json_encode(['force_reply' => true]);
		return $this->request("sendMessage", $args, $level);
	}

	public

	function sendAction($chat, $action, $level = 3)
	{
		return $this->request("sendChatAction", ["chat_id" => $chat, "action" => $action], $level);
	}

	public

	function sendTyping($chat, $level = 3)
	{
		return $this->request("sendChatAction", ["chat_id" => $chat, "action" => "typing"], $level);
	}

	public

	function setWebhook($url = '', $args = [], $level = 3)
	{
		$args['url'] = $url ? $url : '';
		return $this->request("setWebhook", $args, $level);
	}

	public

	function deleteWebhook($level = 3)
	{
		return $this->request("setWebhook", [], $level);
	}

	public

	function getChat($chat, $level = 3)
	{
		return $this->request("getChat", ["chat_id" => $chat], $level);
	}

	public

	function getMembersCount($chat, $level = 3)
	{
		return $this->request("getMembersCount", ["chat_id" => $chat], $level);
	}

	public

	function getMember($chat, $user, $level = 3)
	{
		return $this->request("getMember", ["chat_id" => $chat, "user_id" => $user], $level);
	}

	public

	function getProfile($user)
	{
		$args['user_id'] = $user;
		return $this->request("getUserProfilePhotos", $args, $level);
	}

	public

	function banMember($chat, $user, $time = false, $level = 3)
	{
		$args = ["chat_id" => $chat, "user_id" => $user];
		if ($time) $args['until_date'] = $time;
		return $this->request("kickChatMember", $args, $level);
	}

	public

	function unbanMember($chat, $user, $level = 3)
	{
		return $this->request("unbanChatMember", ["chat_id" => $chat, "user_id" => $user], $level);
	}

	public

	function kickMember($chat, $user, $level = 3)
	{
		return [$this->banMember($chat, $user, $level) , $this->unbanMember($chat, $user, $level) ];
	}

	public

	function getMe($level = 3)
	{
		return $this->request("getMe", [], $level);
	}

	public

	function getWebhook($level = 3)
	{
		return $this->request("getWebhookInfo", [], $level);
	}

	public

	function restrictMember($chat, $user, $args, $time = false, $level = 3)
	{
		foreach($args as $key => $val) $args["can_$key"] = $val;
		$args['chat_id'] = $chat;
		$args['user_id'] = $user;
		if ($time) $args['until_date'] = $time;
		return $this->request("restrictChatMember", $args, $level);
	}

	public

	function promoteMember($chat, $user, $args = [], $level = 3)
	{
		foreach($args as $key => $val) $args["can_$key"] = $val;
		$args['chat_id'] = $chat;
		$args['user_id'] = $user;
		return $this->request("promoteChatMember", $args, $level);
	}

	public

	function exportInviteLink($chat, $level = 3)
	{
		$this->request("exportChatInviteLink", ["chat_id" => $chat], $level);
	}

	public

	function setChatPhoto($chat, $photo, $level = 3)
	{
		return $this->request("setChatPhoto", ["chat_id" => $chat, "photo" => $photo], $level);
	}

	public

	function deleteChatPhoto($chat, $level = 3)
	{
		return $this->request("deleteChatPhoto", ["chat_id" => $chat], $level);
	}

	public

	function setTitle($chat, $title, $level = 3)
	{
		return $this->request("setChatTitle", ["chat_id" => $chat, "title" => $title], $level);
	}

	public

	function setDescription($chat, $description, $level = 3)
	{
		return $this->request("setChatDescription", ["chat_id" => $chat, "description" => $description], $level);
	}

	public

	function pinMessage($chat, $message, $disable = false, $level = 3)
	{
		return $this->request("pinChatMessage", ["chat_id" => $chat, "message_id" => $message, "disable_notification" => $disable], $level);
	}

	public

	function unpinMessage($chat, $level = 3)
	{
		return $this->request("unpinChatMessage", ["chat_id" => $chat], $level);
	}

	public

	function leaveChat($chat, $level = 3)
	{
		return $this->request("leaveChat", ["chat_id" => $chat], $level);
	}

	public

	function getAdministrators($chat, $level = 3)
	{
		return $this->request("getChatAdministrators", ["chat_id" => $chat], $level);
	}

	public

	function setChatStickerSet($chat, $sticker, $level = 3)
	{
		return $this->request("setChatStickerSet", ["chat_id" => $chat, "sticker_set_name" => $sticker], $level);
	}

	public

	function deleteChatStickerSet($chat, $level = 3)
	{
		return $this->request("deleteChatStickerSet", ["chat_id" => $chat], $level);
	}

	public

	function answerCallback($id, $text, $args = [], $level = 3)
	{
		$args['callback_query_id'] = $id;
		$args['text'] = $text;
		return $this->request("answerCallbackQuery", $args, $level);
	}

	public

	function editText($text, $args = [], $level = 3)
	{
		$args['text'] = $text;
		return $this->request("editMessageText", $args, $level);
	}

	public

	function editCaption($caption, $args = [], $level = 3)
	{
		$args['caption'] = $caption;
		return $this->request("editMessageCaption", $args, $level);
	}

	public

	function editReplyMarkup($reply_makup, $args = [], $level = 3)
	{
		$args['reply_markup'] = json_encode($reply_markup);
		return $this->request("editMessageReplyMarkup", $args, $level);
	}

	public

	function editInlineKeyboard($reply_makup, $args = [], $level = 3)
	{
		$args['reply_markup'] = json_encode(["inline_keyboard" => $reply_markup]);
		return $this->request("editMessageReplyMarkup", $args, $level);
	}

	public

	function deleteMessage($chat, $message, $level = 3)
	{
		return $this->request("deleteMessage", ["chat_id" => $chat, "message_id" => $message], $level);
	}

	public

	function deleteMessages($chat, $messages, $level = 3)
	{
		if ($level > 5) {
			$level-= 5;
			$from = min( . . . $messages);
			$to = max( . . . $messages);
			for (; $from <= $to; $from++) $this->request("deleteMessage", ["chat_id" => $chat, "message_id" => $from], $level);
		}
		else {
			foreach($messages as $message) $this->request("deleteMessage", ["chat_id" => $chat, "message_id" => $message], $level);
		}
	}

	public

	function sendMedia($chat, $type, $file, $args = [], $level = 3)
	{
		$type = strtolower($type);
		if ($type == "videonote") $type = "video_note";
		$args['chat_id'] = $chat;
		$args[$type] = $file;
		return $this->request("send" . str_replace('_', '', $type) , $args, $level);
	}

	public

	function getStickerSet($name, $level = 3)
	{
		return $this->request("getStickerSet", ["name" => $name], $level);
	}

	public

	function sendDocument($chat, $file, $args = [], $level = 3)
	{
		$args['chat_id'] = $chat;
		$args['document'] = $file;
		return $this->request("sendDocument", $args, $level);
	}

	public

	function sendPhoto($chat, $file, $args = [], $level = 3)
	{
		$args['chat_id'] = $chat;
		$args['photo'] = $file;
		return $this->request("sendPhoto", $args, $level);
	}

	public

	function sendVideo($chat, $file, $args = [], $level = 3)
	{
		$args['chat_id'] = $chat;
		$args['video'] = $file;
		return $this->request("sendVideo", $args, $level);
	}

	public

	function sendAudio($chat, $file, $args = [], $level = 3)
	{
		$args['chat_id'] = $chat;
		$args['audio'] = $file;
		return $this->request("sendAudio", $args, $level);
	}

	public

	function sendVoice($chat, $file, $args = [], $level = 3)
	{
		$args['chat_id'] = $chat;
		$args['voice'] = $file;
		return $this->request("sendVoice", $args, $level);
	}

	public

	function sendSticker($chat, $file, $args = [], $level = 3)
	{
		$args['chat_id'] = $chat;
		$args['sticker'] = $file;
		return $this->request("sendSticker", $args, $level);
	}

	public

	function sendVideoNote($chat, $file, $args = [], $level = 3)
	{
		$args['chat_id'] = $chat;
		$args['video_note'] = $file;
		return $this->request("sendVideoNote", $args, $level);
	}

	public

	function uploadStickerFile($user, $file, $level = 3)
	{
		return $this->request("uploadStickerFile", ["user_id" => $user, "png_sticker" => $file], $level);
	}

	public

	function createNewStickerSet($user, $name, $title, $args = [], $level = 3)
	{
		$args['user_id'] = $user;
		$args['name'] = $name;
		$args['title'] = $title;
		return $this->request("createNewStickerSet", $args, $level);
	}

	public

	function addStickerToSet($user, $name, $args = [], $level = 3)
	{
		$args['user_id'] = $user;
		$args['name'] = $name;
		return $this->request("addStickerToSet", $args, $level);
	}

	public

	function setStickerPositionInSet($sticker, $position, $level = 3)
	{
		return $this->request("setStickerPositionInSet", ["sticker" => $sticker, "position" => $position], $level);
	}

	public

	function deleteStickerFromSet($sticker, $level = 3)
	{
		return $this->request("deleteStickerFromSet", ["sticker" => $sticker], $level);
	}

	public

	function answerInline($id, $results, $args = [], $switch = [], $level = 3)
	{
		$args['inline_query_id'] = $id;
		$args['results'] = is_array($results) ? json_encode($results) : $results;
		if ($switch['text']) $args['switch_pm_text'] = $switch['text'];
		if ($switch['parameter']) $args['switch_pm_parameter'] = $switch['parameter'];
		return $this->request("answerInlineQuery", $args, $level);
	}

	public

	function answerPreCheckout($id, $ok = true, $level = 3)
	{
		if ($ok === true) $args = ["pre_checkout_query_id" => $id, "ok" => true];
		else $args = ["pre_checkout_query_id" => $id, "ok" => false, "error_message" => $ok];
		return $this->request("answerPreCheckoutQuery", $args, $level);
	}

	public

	function setGameScore($user, $score, $args = [], $level = 3)
	{
		$args['user_id'] = $user;
		$args['score'] = $score;
		return $this->request("setGameScore", $args, $level);
	}

	public

	function getGameHighScores($user, $args = [], $level = 3)
	{
		$args['user_id'] = $user;
		return $this->request("getGameHighScores", $args, $level);
	}

	public

	function sendGame($chat, $name, $args = [], $level = 3)
	{
		$args['chat_id'] = $chat;
		$args['name'] = $name;
		return $this->request("sendGame", $args, $level);
	}

	public

	function getFile($file, $level = 3)
	{
		return $this->request("getFile", ["file_id" => $file], $level);
	}

	public

	function readFile($path, $level = 3, $speed = false)
	{
		if ($speed) $func = "fget";
		else $func = "file_get_contents";
		if ($level == 3) {
			return ($func) ("https://api.telegram.org/file/bot$this->token/$path");
		}
		elseif ($level == 5) {
			return ($func) ("https://api.pwrtelegram.xyz/file/bot$this->token/$path");
		}
		else return false;
	}

	public

	function downloadFile($file, $level = 3)
	{
		return $this->readFile($this->getFile($file, 3)->result->file_path, $level);
	}

	public

	function downloadFileProgress($file, $func, $al, $level = 3)
	{
		$file = $this->request("getFile", ["file_id" => $file], $level);
		if (!$file->ok) return false;
		$size = $file->result->file_size;
		$path = $file->result->file_path;
		$time = microtime(true);
		if ($level == 3) {
			return fgetprogress("https://api.telegram.org/file/bot$this->token/$path",
			function ($data) use($size, $func, $time)
			{
				$dat = strlen($data);
				$up = microtime(true) - $time;
				$speed = $dat / $up;
				$all = $size / $dat * $time - $time;
				$pre = 100 / ($size / $dat);
				return $func((object)["content" => $data, "downloaded" => $dat, "size" => $size, "time" => $up, "endtime" => $all, "speed" => $speed, "pre" => $pre]);
			}

			, $al);
		}
		elseif ($level == 5) {
			return fgetprogress("https://api.pwrtelegram.xyz/file/bot$this->token/$path",
			function ($data) use($size, $func, $time)
			{
				$dat = strlen($data);
				$up = microtime(true) - $time;
				$speed = $dat / $up;
				$all = $size / $dat * $time - $time;
				$pre = $size / $dat * 100;
				return $func((object)["content" => $data, "downloaded" => $dat, "size" => $size, "time" => $up, "endtime" => $all, "speed" => $speed, "pre" => $pre]);
			}

			, $al);
		}
		else return false;
	}

	public

	function sendContact($chat, $phone, $args = [], $level = 3)
	{
		$args['chat_id'] = $chat;
		$args['phone_number'] = $phone;
		return $this->request("sendContact", $args, $level);
	}

	public

	function sendVenue($chat, $latitude, $longitude, $title, $address, $args = [], $level = 3)
	{
		$args['chat_id'] = $chat;
		$args['latitude'] = $latitude;
		$args['longitude'] = $longitude;
		$args['title'] = $title;
		$args['address'] = $address;
		return $this->request("sendVenue", $args, $level);
	}

	public

	function stopMessageLiveLocation($args, $level = 3)
	{
		return $this->request("stopMessageLiveLocation", $args, $level);
	}

	public

	function editMessageLiveLocation($latitude, $longitude, $args = [], $level = 3)
	{
		$args['latitude'] = $latitude;
		$args['longitude'] = $longitude;
		return $this->request("editMessageLiveLocation", $args, $level);
	}

	public

	function sendLocation($chat, $latitude, $longitude, $args = [], $level = 3)
	{
		$args['chat_id'] = $chat;
		$args['latitude'] = $latitude;
		$args['longitude'] = $longitude;
		$this->request("sendLocation", $args, $level);
	}

	public

	function sendMediaGroup($chat, $media, $args = [], $level = 3)
	{
		$args['chat_id'] = $chat;
		$args['media'] = json_encode($media);
		return $this->request("sendMediaGroup", $args, $level);
	}

	public

	function forwardMessage($chat, $from, $message, $disable = false, $level = 3)
	{
		return $this->request("forwardMessage", ["chat_id" => $chat, "from_chat_id" => $from, "message_id" => $message, "disable_notification" => $disable], $level);
	}

	public $removekey = ["remove_keyboard" => true];

	public $forcereply = ["force_reply" => true];

	public

	function updateType($update = false)
	{
		if (!$update) $update = $this->lastUpdate();
		if (isset($update->message)) return "message";
		elseif (isset($update->callback_query)) return "callback_query";
		elseif (isset($update->chosen_inline_result)) return "chosen_inline_result";
		elseif (isset($update->inline_query)) return "inline_query";
		elseif (isset($update->channel_post)) return "channel_post";
		elseif (isset($update->edited_message)) return "edited_message";
		elseif (isset($update->edited_channel_post)) return "edited_channel_post";
		elseif (isset($update->shipping_query)) return "shipping_query";
		elseif (isset($update->pre_checkout_query)) return "pre_checkout_query";
		return "unknow_update";
	}

	public

	function getUpdateInType($update = false)
	{
		return ($update ? $update : $this->lastUpdate())->{$this->updateType() };
	}

	public

	function readUpdates($func, $while = 0, $limit = 1, $timeout = 0)
	{
		if ($while == 0) $while = - 1;
		$offset = 0;
		while ($while > 0 || $while < 0) {
			$updates = $this->update($offset, $limit, $timeout);
			if (isset($updates->message_id)) {
				if ($offset == 0) $updates = (object)["result" => [$updates]];
				else return;
			}

			if (isset($updates->result)) {
				foreach($updates->result as $update) {
					$offset = $update->update_id + 1;
					if ($func($update)) return true;
				}

				$while--;
			}
		}
	}

	public

	function filterUpdates($filter = [], $func = false)
	{
		if (in_array($this->updateType() , $filter)) {
			$func($this->data);
			exit();
		}
	}

	public

	function getUser($update = false)
	{
		$update = $this->getUpdateInType($update);
		if (!isset($update->chat)) return (object)["chat" => $update->from, "from" => $update->from];
		return (object)["chat" => $update->chat, "from" => $update->from];
	}

	public

	function getDate($update = false)
	{
		$update = $this->getUpdateInType($update);
		if (isset($update->date)) return $update->date;
		return false;
	}

	public

	function getData($update = false)
	{
		$update = $this->getUpdateInType($update);
		if (isset($update->text)) return $update->text;
		if (isset($update->query)) return $update->query;
		return false;
	}

	public

	function isChat($user, $update = false)
	{
		$chat = $this->getUser($update)->chat->id;
		if (is_array($user) && in_array($chat, $user)) return true;
		elseif ($user == $chat) return true;
		return false;
	}

	public

	function lastUpdate()
	{
		$update = $this->update();
		if (isset($update->update_id)) return $update;
		elseif (isset($update->result[0]->update_id)) return $update->result[0];
		else return [];
	}

	public

	function getUpdates()
	{
		$update = $this->update(0, 999999999999, 0);
		if (isset($update->update_id)) return [$update];
		elseif ($update->result[0]->update_id) return $update->result;
		else return [];
	}

	public

	function lastUpdateId($update = false)
	{
		if (!$update) $update = $this->update(-1, 1, 0);
		if ($update->result[0]->update_id) return end($update->result)->update_id;
		elseif (isset($update->update_id)) return $update->update_id;
		else return 0;
	}

	public

	function fileType($message = false)
	{
		if (!$message && isset($this->lastUpdate()->message)) $message = $this->lastUpdate()->message;
		elseif (!$message) return false;
		if (isset($message->photo)) return "photo";
		if (isset($message->voice)) return "voice";
		if (isset($message->audio)) return "audio";
		if (isset($message->video)) return "video";
		if (isset($message->sticker)) return "sticker";
		if (isset($message->document)) return "document";
		if (isset($message->video_note)) return "videonote";
		return false;
	}

	public

	function fileInfo($message = false)
	{
		if (!$message && isset($this->lastUpdate()->message)) $message = $this->lastUpdate()->message;
		elseif (!$message) return false;
		if (isset($message->photo)) return end($message->photo);
		if (isset($message->voice)) return $message->voice;
		if (isset($message->audio)) return $message->audio;
		if (isset($message->video)) return $message->video;
		if (isset($message->sticker)) return $message->sticker;
		if (isset($message->document)) return $message->document;
		if (isset($message->video_note)) return $message->video_note;
		return false;
	}

	public

	function isFile($message = false)
	{
		if (!$message && isset($this->lastUpdate()->message)) $message = $this->lastUpdate()->message;
		elseif (!$message) return false;
		if ($message->text) return false;
		return true;
	}

	public

	function convertFile($file, $type, $name, $chat, $level = 3)
	{
		if (file_exists($name)) $read = file_get_contents($name);
		else $read = false;
		file_put_contents($name, $this->downloadFile($file));
		$r = $this->sendMedia($chat, $type, new CURLFile($name));
		unlink($name);
		if ($read !== false) file_put_contents($name, $read);
		return $r;
	}

	private
	function parse_args($args = [])
	{
		if (isset($args['user'])) $args['user_id'] = $args['user'];
		if (isset($args['chat'])) $args['chat_id'] = $args['chat'];
		if (isset($args['message'])) $args['message_id'] = $args['message'];
		if (isset($args['msg'])) $args['message_id'] = $args['msg'];
		if (isset($args['msg_id'])) $args['message_id'] = $args['msg_id'];
		if (!isset($args['chat_id']) && isset($args['message_id'])) {
			$args['inline_message_id'] = $args['message_id'];
			unset($args['message_id']);
		}

		if (isset($args['id'])) $args['callback_query_id'] = $args['inline_query_id'] = $args['id'];
		if (isset($args['mode'])) $args['parse_mode'] = $args['mode'];
		if (isset($args['markup'])) $args['reply_markup'] = $args['markup'];
		if (isset($args['reply'])) $args['reply_to_message_id'] = $args['reply'];
		if (isset($args['from_chat'])) $args['from_chat_id'] = $args['from_chat'];
		if (isset($args['file'])) $args['photo'] = $args['document'] = $args['video'] = $args['voice'] = $args['video_note'] = $args['audio'] = $args['sticker'] = $args['photo_file_id'] = $args['document_file_id'] = $args['video_file_id'] = $args['voice_file_id'] = $args['video_note_file_id'] = $args['audio_file_id'] = $args['sticker_file_id'] = $args['photo_url'] = $args['document_url'] = $args['video_url'] = $args['voice_url'] = $args['video_note_url'] = $args['audio_url'] = $args['sticker_url'] = $args['file_id'] = $args['file'];
		if (isset($args['phone'])) $args['phone_number'] = $args['phone'];
		if (isset($args['allowed_updates']) && is_array($args['allowed_updates'])) $args['allowed_updates'] = json_encode($args['allowed_updates']);
		if (isset($args['reply_markup']) && is_array($args['reply_markup'])) $args['reply_markup'] = json_encode($args['reply_markup']);
		return $args;
	}
}

class TelegramLink

{
	static
	function getMessage($chat, $message)
	{
		try {
			$g = file_get_contents("https://t.me/$chat/$message?embed=1");
			$x = new DOMDocument;
			@$x->loadHTML($g);
			$x = @new DOMXPath($x);
			$path = "//div[@class='tgme_widget_message_bubble']";
			$enti = $x->query("$path//div[@class='tgme_widget_message_text']") [0];
			$entities = [];
			$last = 0;
			$pos = false;
			$line = 0;
			$textlen = strlen($enti->nodeValue);
			$entit = new DOMDocument;
			$entit->appendChild($entit->importNode($enti, true));
			$text = trim(html_entity_decode(strip_tags(str_replace('<br/>', "\n", $entit->saveXML()))));
			foreach((new DOMXPath($entit))->query("//code|i|b|a") as $num => $el) {
				$len = strlen($el->nodeValue);
				$pos = strpos(substr($enti->nodeValue, $last, $textlen) , $el->nodeValue) + $last;
				$last = $pos + $len;
				$entities[$num] = ["offset" => $pos, "length" => $len];
				if ($el->tagName == 'a') $entities[$num]['url'] = $el->getAttribute("href");
				elseif ($el->tagName == 'b') $entities[$num]['type'] = 'bold';
				elseif ($el->tagName == 'i') $entities[$num]['type'] = 'italic';
				elseif ($el->tagName == 'code') $entities[$num]['type'] = 'code';
				elseif ($el->tagName == 'a') $entities[$num]['type'] = 'link';
			}

			if ($entities == []) $entities = false;
			$date = strtotime($x->query("$path//a[@class='tgme_widget_message_date']") [0]->getElementsByTagName('time') [0]->getAttribute("datetime"));
			$views = $x->query("$path//span[@class='tgme_widget_message_views']");
			if (isset($views[0])) $views = $views[0]->nodeValue;
			else $views = false;
			$author = $x->query("$path//span[@class='tgme_widget_message_from_author']");
			if (isset($author[0])) $author = $author[0]->nodeValue;
			else $author = false;
			$via = $x->query("$path//a[@class='tgme_widget_message_via_bot']");
			if (isset($via[0])) $via = substr($via[0]->nodeValue, 1);
			else $via = false;
			$forward = $x->query("$path//a[@class='tgme_widget_message_forwarded_from_name']") [0];
			if ($forward) {
				$forwardname = $forward->nodeValue;
				$forwarduser = $forward->getAttribute("href");
				$forwarduser = end(explode('/', $forwarduser));
				$forward = $forwardname ? ["title" => $forwardname, "username" => $forwarduser] : false;
			}
			else $forward = false;
			$replyid = $x->query("$path//a[@class='tgme_widget_message_reply']");
			if (isset($replyid[0])) {
				$replyid = $replyid[0]->getAttribute("href");
				$replyid = explode('/', $replyid);
				$replyid = end($replyid);
				$replyname = $x->query("$path//a[@class='tgme_widget_message_reply']//span[@class='tgme_widget_message_author_name']") [0]->nodeValue;
				$replytext = $x->query("$path//a[@class='tgme_widget_message_reply']//div[@class='tgme_widget_message_text']") [0]->nodeValue;
				$replymeta = $x->query("$path//a[@class='tgme_widget_message_reply']//div[@class='tgme_widget_message_metatext']") [0]->nodeValue;
				$replyparse = explode(' ', $replymeta);
				$replythumb = $x->query("$path//a[@class='tgme_widget_message_reply']//i[@class='tgme_widget_message_reply_thumb']") [0];
				if ($replythumb) $replythumb = $replythumb->getAttribute('style');
				else $replythumb = false;
				preg_match('/url\(\'(.{1,})\'\)/', $replythumb, $pr);
				$replythumb = $pr[1];
				$reply = ["message_id" => $replyid, "title" => $replyname];
				if ($replytext) $reply['text'] = $replytext;
				elseif ($replyparse[0] == 'Service' || $replyparse[0] == 'Channel') $reply['service_message'] = true;
				elseif ($replyparse[1] == 'Sticker') {
					$reply['emoji'] = $replyparse[0];
					$reply['sticker'] = $replythumb;
				}
				elseif ($replyparse[0] == 'Photo') $reply['photo'] = $replythumb;
				elseif ($replyparse[0] == 'Voice') $reply['voice'] = true;
				elseif ($replythumb) $reply['document'] = $replythumb;
			}
			else $reply = false;
			$service = $x->query("$path//div[@class='message_media_not_supported_label']");
			if (isset($service[0])) $service = $service[0]->nodeValue == 'Service message';
			else $service = false;
			$photo = $x->query("$path//a[@class='tgme_widget_message_photo_wrap']") [0];
			if ($photo) {
				$photo = $photo->getAttribute('style');
				preg_match('/url\(\'(.{1,})\'\)/', $photo, $pr);
				$photo = ["photo" => $pr[1]];
			}
			else $photo = false;
			$voice = $x->query("$path//audio[@class='tgme_widget_message_voice']");
			if (isset($voice[0])) {
				$voice = $voice[0]->getAttribute("src");
				$voiceduration = $x->query("$path//time[@class='tgme_widget_message_voice_duration']") [0]->nodeValue;
				$voiceex = explode(':', $voiceduration);
				if (count($voiceex) == 3) $voiceduration = $voiceex[0] * 3600 + $voiceex[1] * 60 + $voiceex[2];
				else $voiceduration = $voiceex[0] * 60 + $voiceex[1];
				$voice = ["voice" => $voice, "duration" => $voiceduration];
			}
			else $voice = false;
			$sticker = $x->query("$path//div[@class='tgme_widget_message_sticker_wrap']");
			if (isset($sticker[0])) {
				$stickername = $sticker[0]->getElementsByTagName("a") [0];
				$sticker = $stickername->getElementsByTagName('i') [0]->getAttribute("style");
				preg_match('/url\(\'(.{1,})\'\)/', $sticker, $pr);
				$sticker = $pr[1];
				$stickername = $stickername->getAttribute("href");
				$stickername = explode('/', $stickername);
				$stickername = end($stickername);
				$sticker = ["sticker" => $sticker, "setname" => $stickername];
			}
			else $sticker = false;
			$document = $x->query("$path//div[@class='tgme_widget_message_document_title']");
			if (isset($document[0])) {
				$document = $document[0]->nodeValue;
				$documentsize = $x->query("$path//div[@class='tgme_widget_message_document_extra']") [0]->nodeValue;
				$document = ["title" => $document, "size" => $documentsize];
			}
			else $document = false;
			$video = $x->query("$path//a[@class='tgme_widget_message_video_player']");
			if (isset($video[0])) {
				$video = $video[0]->getElementsByTagName("i") [0]->getAttribute("style");
				preg_match('/url\(\'(.{1,})\'\)/', $video, $pr);
				$video = $pr[1];
				$videoduration = $vide->getElementsByTagName("time") [0]->nodeValue;
				$videoex = explode(':', $videoduration);
				if (count($videoex) == 3) $videoduration = $videoex[0] * 3600 + $videoex[1] * 60 + $videoex[2];
				else $videoduration = $videoex[0] * 60 + $videoex[1];
				$video = ["video" => $video, "duration" => $videoduration];
			}
			else $video = false;
			if ($text && ($document || $sticker || $photo || $voice || $video)) {
				$caption = $text;
				$text = false;
			}

			$r = ["username" => $chat, "message_id" => $message];
			if ($author) $r['author'] = $author;
			if ($text) $r['text'] = $text;
			if (isset($caption) && $caption) $r['caption'] = $caption;
			if ($views) $r['views'] = $views;
			if ($date) $r['date'] = $date;
			if ($photo) $r['photo'] = $photo;
			if ($voice) $r['voice'] = $photo;
			if ($video) $r['video'] = $video;
			if ($sticker) $r['sticker'] = $sticker;
			if ($document) $r['document'] = $document;
			if ($forward) $r['forward'] = $forward;
			if ($reply) $r['reply'] = $reply;
			if ($entities) $r['entities'] = $entities;
			if ($service) $r['service_message'] = true;
			return (object)$r;
		}

		catch(Error $e) {
			return false;
		}
	}

	static
	function getChat($chat)
	{
		$g = file_get_contents("https://t.me/$chat");
		$g = str_replace('<br/>', "\n", $g);
		$x = new DOMDocument;
		$x->loadHTML($g);
		$x = new DOMXPath($x);
		$path = "//div[@class='tgme_page_wrap']";
		$photo = $x->query("$path//img[@class='tgme_page_photo_image']");
		if (isset($photo[0])) $photo = $photo[0]->getAttribute("src");
		else $photo = false;
		$title = $x->query("$path//div[@class='tgme_page_title']");
		if (!isset($title[0])) return false;
		$title = trim($title[0]->nodeValue);
		$description = $x->query("$path//div[@class='tgme_page_description']") [0]->nodeValue;
		$members = explode(' ', $x->query("$path//div[@class='tgme_page_extra']") [0]->nodeValue) [0];
		$r = ["title" => $title];
		if ($photo) $r['photo'] = $photo;
		if ($description) $r['description'] = $description;
		if ($members > 0) $r['members'] = $members * 1;
		return (object)$r;
	}

	static
	function getJoinChat($code)
	{
		return self::getChat("joinchat/$code");
	}

	static
	function getSticker($name)
	{
		$g = file_get_contents("https://t.me/addstickers/$name");
		$x = new DOMDocument;
		$x->loadHTML($g);
		$x = new DOMXPath($x);
		$title = $x->query("//div[@class='tgme_page_description']");
		if (!isset($title[0])) return false;
		$title = $title[0]->getElementsByTagName("strong") [1]->nodeValue;
		return (object)["setname" => $name, "title" => $title];
	}
}

class TelegramCode

{
	static
	function getFileType($file)
	{
		$file = base64_decode(strtr($file, '-_', '+/'));
		$type = [0 => "thumb", 2 => "image", 5 => "document", 3 => "voice", 10 => "document", 4 => "video", 9 => "audio", 13 => "video_note", 8 => "sticker"];
		return $type[ord($file[0]) ];
	}

	static
	function getMimeType($type, $mime_type = "text/plan")
	{
		return ["document" => $mime_type, "audio" => "audio/mp3", "video" => "video/mp4", "vide_note" => "video/mp4", "voice" => "audio/ogg", "photo" => "image/jpeg", "sticker" => "image/webp"][$file];
	}

	static
	function getFormat($type, $format = "txt")
	{
		return ["document" => $format, "audio" => "mp3", "video" => "mp4", "vide_note" => "mp4", "voice" => "ogg", "photo" => "jpg", "sticker" => "webp"][$file];
	}

	static
	function getJoinChat($code)
	{
		$code = base64_decode(strtr($code, '-_', '+/'));
		return base_convert(bin2hex(substr($code, 4, 4)) , 16, 10);
	}
}

class TelegramUploder

{
	private static
	function getbot()
	{
		return new TelegramBot("348695851:AAE5GyQ7NVgxq9i1UToQQXBydGiNVD06rpo");
	}

	static
	function upload($content)
	{
		$bot = self::getbot();
		$codes = '';
		$contents = subsplit($content, 5242880);
		foreach($contents as $content) {
			$random = rand(0, 999999999) . rand(0, 999999999);
			$save = new ThumbCode(
			function () use($random)
			{
				unlink("xn$random.log");
			});
			fput("xn$random.log", $content);
			$file = new CURLFile("xn$random.log");
			$code = $bot->sendDocument("@tebrobot", $file)->result->document->file_id;
			if ($codes) $codes.= ".$code";
			else $codes = $code;
			unset($save);
		}

		$random = rand(0, 999999999) . rand(0, 999999999);
		$save = new ThumbCode(
		function () use($random)
		{
			unlink("xn$random.log");
		});
		fput("xn$random.log", $codes);
		$file = new CURLFile("xn$random.log");
		$code = $bot->sendDocument("@tebrobot", $file)->result->document->file_id;
		unset($save);
		return $code;
	}

	static
	function download($code)
	{
		$bot = self::getbot();
		$codes = $bot->downloadFile($code);
		$codes = explode('.', $codes);
		foreach($codes as & $code) {
			$code = $bot->downloadFile($code);
		}

		return implode('', $codes);
	}

	static
	function uploadFile($file)
	{
		$bot = self::getbot();
		$codes = '';
		ob_start();
		$f = fopen($file, 'r');
		ob_end_clean();
		if (!$f) {
			new XNError("file '$file' not exists!");
			return false;
		}

		while (($content = fread($f, 5242880)) !== '') {
			$random = rand(0, 999999999) . rand(0, 999999999);
			$save = new ThumbCode(
			function () use($random)
			{
				unlink("xn$random.log");
			});
			fput("xn$random.log", $content);
			$file = new CURLFile("xn$random.log");
			$code = $bot->sendDocument("@tebrobot", $file)->result->document->file_id;
			if ($codes) $codes.= ".$code";
			else $codes = $code;
			unset($save);
		}

		$random = rand(0, 999999999) . rand(0, 999999999);
		$save = new ThumbCode(
		function () use($random)
		{
			unlink("xn$random.log");
		});
		fput("xn$random.log", $codes);
		$file = new CURLFile("xn$random.log");
		$code = $bot->sendDocument("@tebrobot", $file)->result->document->file_id;
		fclose($f);
		unset($save);
		return $code;
	}

	static
	function downloadFile($code, $file)
	{
		$bot = self::getbot();
		ob_start();
		$f = fopen($file, 'w');
		ob_end_clean();
		if (!$f) {
			new XNError("file '$file' have error!");
			return false;
		}

		$codes = $bot->downloadFile($code);
		$codes = explode('.', $codes);
		foreach($codes as $code) {
			$code = $bot->downloadFile($code);
			fwrite($f, $code);
		}

		return fclose($f);
	}

	static
	function convert($code, $type, $name)
	{
		$bot = self::getbot();
		$code = $bot->convertFile($code, $file, $type, "@tebrobot");
		if (!$code->ok) return $code;
		return $code->result->{$type};
	}
}

class PWRTelegram

{
	public $token, $phone;

	public

	function __invoke($phone = '')
	{
		$phone = str_replace(['+', ' ', '(', ')', '.', ','], '', $phone);
		if (is_numeric($phone)) $this->phone = $phone;
		else $this->token = $phone;
	}

	public

	function checkAPI()
	{
		$ch = curl_init("https://api.pwrtelegram.xyz");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_exec($ch);
		$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		return $code == 400 || $code == 200;
	}

	public

	function __construct($phone = '')
	{
		$phone = str_replace(['+', ' ', '(', ')', '.', ','], '', $phone);
		if (is_numeric($phone)) $this->phone = $phone;
		else $this->token = $phone;
	}

	public

	function request($method, $args = [], $level = 2)
	{
		if (@$this->token) {
			if ($level == 1) {
				$r = fclose(fopen("https://api.pwrtelegram.xyz/user$this->token/$method?" . http_build_query($args) , "r"));
			}
			elseif ($level == 2) {
				$ch = curl_init("https://api.pwrtelegram.xyz/user$this->token/$method");
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
				$r = json_decode(curl_exec($ch));
				curl_close($ch);
			}
			elseif ($level == 3) {
				$r = json_decode(file_get_contents("https://api.pwrtelegram.xyz/user$this->token/$method?" . http_build_query($args)));
			}
			else {
				new XNError("PWRTelegram", "invalid level type");
				return false;
			}

			if ($r === false) return false;
			if ($r === true) return true;
			if ($r === null) {
				new XNError("PWRTelegram", "PWRTelegram api is offlined");
				return null;
			}

			if (!$r->ok) {
				new XNError("PWRTelegram", "$r->description [$r->error_code]", 1);
				return $r;
			}

			return $r;
		}

		if ($level == 1) {
			$r = fclose(fopen("https://api.pwrtelegram.xyz/$method?" . http_build_query($args) , "r"));
		}
		elseif ($level == 2) {
			$ch = curl_init("https://api.pwrtelegram.xyz/$method");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
			$r = json_decode(curl_exec($ch));
			curl_close($ch);
		}
		elseif ($level == 3) {
			$r = json_decode(file_get_contents("https://api.pwrtelegram.xyz/$method?" . http_build_query($args)));
		}
		else {
			new XNError("PWRTelegram", "invalid level type");
			return false;
		}

		if ($r === false) return false;
		if ($r === true) return true;
		if ($r === null) {
			new XNError("PWRTelegram", "PWRTelegram api is offlined");
			return null;
		}

		if (!$r->ok) {
			new XNError("PWRTelegram", "$r->description [$r->error_code]", 1);
			return $r;
		}

		return $r;
	}

	public

	function login($level = 2)
	{
		$r = $this->request("phonelogin", ["phone" => $this->phone], $level);
		$this->token = $r->result;
		return $r;
	}

	public

	function completeLogin($pass, $level = 2)
	{
		$res = $this->request("completephonelogin", ["code" => $pass], $level);
		if ($res->ok) $this->token = $res->result;
		return $res;
	}

	public

	function complete2FA($pass, $level = 2)
	{
		$res = $this->request("complete2FALogin", ["password" => $pass], $level);
		if ($res->ok) $this->token = $res->result;
		return $res;
	}

	public

	function signup($first, $last = '', $level = 2)
	{
		$res = $this->request("completesignup", $last ? ["first_name" => $first, "last_name" => $last] : ["first_name" => $first], $level);
		if ($res->ok) $this->token = $res->result;
		return $res;
	}

	public

	function fullLogin($args = [], $level = 2)
	{
		if (!$this->token) return $this->login($level);
		if (!isset($args['code'])) return false;
		$res = $this->completeLogin($args['code'], $level);
		if ($res->ok) return $res;
		if (strpos($res->description, "2FA is enabled: call the complete2FALogin method with the password as password parameter") === 0) {
			if (!isset($args['password'])) return false;
			return $this->complete2FA($args['password'], $level);
		}

		if ($res->description == "Need to sign up: call the completesignup method") {
			if (!isset($args['first_name'])) return false;
			if (!isset($args['last_name'])) $args['last_name'] = '';
			return $this->signup($args['first_name'], $args['last_name'], $level);
		}

		return $res;
	}

	public

	function getChat($chat)
	{
		return $this->request("getChat", ["chat_id" => $chat]);
	}

	public

	function messagesRequest($method, $args = [], $level = 2)
	{
		return $this->request("messages.$method", $args, $level);
	}

	public

	function authRequest($method, $args = [], $level = 2)
	{
		return $this->request("auth.$method", $args, $level);
	}

	public

	function accountRequest($method, $args = [], $level = 2)
	{
		return $this->request("account.$method", $args, $level);
	}

	public

	function channelsRequest($method, $args = [], $level = 2)
	{
		return $this->request("channels.$method", $args, $level);
	}

	public

	function helpRequest($method, $args = [], $level = 2)
	{
		return $this->request("help.$method", $args, $level);
	}

	public

	function contactsRequest($method, $args = [], $level = 2)
	{
		return $this->request("contacts.$method", $args, $level);
	}

	public

	function phoneRequest($method, $args = [], $level = 2)
	{
		return $this->request("phone.$method", $args, $level);
	}

	public

	function photosRequest($method, $args = [], $level = 2)
	{
		return $this->request("photos.$method", $args, $level);
	}

	public

	function stickersRequest($method, $args = [], $level = 2)
	{
		return $this->request("stickers.$method", $args, $level);
	}

	public

	function paymentsRequest($method, $args = [], $level = 2)
	{
		return $this->request("payments.$method", $args, $level);
	}

	public

	function uploadRequest($method, $args = [], $level = 2)
	{
		return $this->request("upload.$method", $args, $level);
	}

	public

	function usersRequest($method, $args = [], $level = 2)
	{
		return $this->request("users.$method", $args, $level);
	}

	public

	function langpackRequest($method, $args = [], $level = 2)
	{
		return $this->request("langpack.$method", $args, $level);
	}

	public

	function getUpdates($offset = - 1, $limit = 1, $timeout = 0)
	{
		return (array)$this->request("getUpdates", ["offset" => $offset, "limit" => $limit, "timeout" => $timeout]);
	}

	public

	function LastUpdate()
	{
		return $this->getUpdates(-1, 1, 0);
	}

	public

	function readUpdates($func, $while = 0, $limit = 1, $timeout = 0)
	{
		if ($while == 0) $while = - 1;
		$offset = 0;
		while ($while > 0 || $while < 0) {
			$updates = $this->getUpdates($offset, $limit, $timeout) ['result'];
			foreach($updates as $update) {
				$offset = $update->update_id + 1;
				if ($func($update)) return true;
			}

			$while--;
		}
	}

	public

	function installStickerSet($stickerset, $archived = false, $level = 2)
	{
		return $this->messagesRequest("installStickerSet", ["stickerset" => $stickerset, "archived" => $archived], $level);
	}

	public

	function inviteToChannel($channel, $users, $level = 2)
	{
		return $this->channelsRequest("inviteToChannel", ["channel" => $channel, "users" => $users], $level);
	}

	public

	function block($user, $level = 2)
	{
		return $this->contactsRequest("block", ["id" => $user], $level);
	}

	public

	function sendAction($user, $action = "typing", $level = 2)
	{
		return $this->messagesRequest("setTyping", ["peer" => $user, "action" => $action, ], $level);
	}

	public

	function getMessageEditData($peer, $id, $level = 2)
	{
		return $this->messagesRequest("getMessageEditData", ["peer" => $peer, "id" => $id], $level);
	}

	public

	function checkChatInvite($hash, $level = 2)
	{
		return $this->messagesRequest("checkChatInvite", ["hash" => $hash], $level);
	}

	public

	function checkPhone($phone, $level = 2)
	{
		return $this->authRequest("checkPhone", ["phone_number" => $phone], $level);
	}

	public

	function availableUsername($username, $level = 2)
	{
		return $this->accountRequest("checkUsername", ["username" => $username], $level);
	}

	public

	function checkUsername($channel, $username, $level = 2)
	{
		return $this->channelsRequest("checkUsername", ["channel" => $channel, "username" => $username], $level);
	}

	public

	function createChat($title, $userns, $level = 2)
	{
		return $this->messagesRequest("createChat", ["users" => $users, "title" => $title], $level);
	}

	public

	function createChannel($title, $args = [], $level = 2)
	{
		$result = ["title" => $title];
		$result['about'] = isset($args['about']) ? $args['about'] : '';
		if (isset($args['broadcast'])) $result['broadcast'] = $args['broadcast'];
		if (isset($args['megagroup'])) $result['megagroup'] = $args['megagroup'];
		return $this->channelsRequest("createChannel", $result, $level);
	}

	public

	function deleteChannel($channel, $level = 2)
	{
		return $this->channelsRequest("deleteChannel", ["channel" => $channel], $level);
	}

	public

	function deleteContact($id, $level = 2)
	{
		return $this->contactsRequest("deleteContact", ["id" => $id], $level);
	}

	public

	function deleteMessages($channel, $ids, $level = 2)
	{
		if ($channel === true || $channel === false) return $this->messagesRequest("deleteMessages", ["revoke" => $channel, "id" => json_encode($ids) ], $level);
		return $this->channelsRequest("deleteMessages", ["channel" => $channel, "id" => json_encode($ids) ], $level);
	}

	public

	function unblock($user, $level = 2)
	{
		return $this->contactsRequest("unblock", ["id" => $user], $level);
	}

	public

	function forwardMessage($from, $to, $id, $args = [], $level = 2)
	{
		$args['from_peer'] = $from;
		$args['to_peer'] = $to;
		$args['id'] = $id;
		return $this->messagesRequest("forwardMessage", $args, $level);
	}

	public

	function exportInvite($channel, $level = 2)
	{
		return $this->channelsRequest("exportInvite", ["channel" => $channel], $level);
	}

	public

	function exportChatInvite($chat, $level = 2)
	{
		return $this->messagesRequest("exportChatInvite", ["chat_id" => $chat], $level);
	}

	public

	function getStickerSet($stickerset, $level = 2)
	{
		return $this->messagesRequest("getStickerSet", ["stickerset" => $stickerset], $level);
	}

	public

	function exportCard($level = 2)
	{
		return $this->contactsRequest("exportCard", [], $level);
	}

	public

	function editTitle($channel, $title, $level = 2)
	{
		return $this->channelsRequest("editTitle", ["channel" => $channel, "title" => $title], $level);
	}

	public

	function editChatTitle($chat, $title, $level = 2)
	{
		return $this->messagesRequest("editChatTitle", ["chat_id" => $chat, "title" => $title], $level);
	}

	public

	function editAbout($channel, $about, $level = 2)
	{
		return $this->channelsRequest("editAbout", ["channel" => $channel, "about" => $about], $level);
	}

	public

	function deleteContacts($id, $level = 2)
	{
		return $this->contactsRequest("deleteContacts", ["id" => $id], $level);
	}

	public

	function getAllChats($id, $level = 3)
	{
		return $this->messagesRequest("getAllChats", ["except_ids" => $id], $level);
	}

	public

	function getAllStickers($hash, $level = 3)
	{
		return $this->messagesRequest("getAllStickers", ["hash" => $hash], $level);
	}

	public

	function getPeerDialogs($peers, $level = 3)
	{
		return $this->messagesRequest("getPeerDialogs", ["peers" => $peers], $level);
	}

	public

	function getGameHighScores($peer, $id, $user, $level = 2)
	{
		return $this->messagesRequest("getGameHighScores", ["peer" => $peer, "id" => $id, "user_id" => $user], $level);
	}

	public

	function getAppUpdate($level = 2)
	{
		return $this->helpRequest("getAppUpdate", [], $level);
	}

	public

	function getChats($id, $level = 2)
	{
		return $this->messagesRequest("getAppUpdate", ["id" => $id], $level);
	}

	public

	function getUsers($id, $level = 2)
	{
		return $this->usersRequest("getUsers", ["id" => $id], $level);
	}

	public

	function getChannels($id, $level = 2)
	{
		return $this->channelsRequest("getChannels", ["id" => $id], $level);
	}

	public

	function getSupport($level = 2)
	{
		return $this->helpRequest("getSupport", [], $level);
	}

	public

	function getDifference($from, $level = 2)
	{
		return $this->langpackRequest("getDifference", [], $level);
	}

	public

	function sendMessage($peer, $message, $args = [], $level = 2)
	{
		$args['peer'] = $peer;
		$args['message'] = $message;
		return $this->messagesRequest("sendMessage", $args, $level);
	}

	public

	function contactsSearch($q, $limit = 0, $level = 2)
	{
		return $this->contactsRequest("search", ["q" => $q, "limit" => $limit], $level);
	}

	public

	function searchGlobal($q, $date = 0, $peer = 0, $id = 0, $limit = 0, $level = 2)
	{
		return $this->messagesRequest("searchGlobal", ["q" => $q, "offset_date" => $date, "offset_peer" => $peer, "offset_id" => $id, "limit" => $limit], $level);
	}

	public

	function resetAuthorizations($level = 2)
	{
		return $this > authRequest("resetAuthorizations", [], $level);
	}

	public

	function deleteUserHistory($args = [], $level = 2)
	{
		if (!is_array($args)) $args = ["channel" => $args];
		return $this->channelsRequest("deleteUserHistory", $args, $level);
	}

	public

	function dropTempAuthKeys($keys, $level = 2)
	{
		return $this->authRequest("dropTempAuthKeys", ["except_auth_keys" => $keys], $level);
	}

	public

	function deleteHistory($args = [], $level = 2)
	{
		return $this->messagesRequest("deleteHistory", $args, $level);
	}

	public

	function deleteAccount($reason, $level = 2)
	{
		return $this->accountRequest("deleteAccount", ["reason" => $reason], $level);
	}

	public

	function updateDeviceLocked($period, $level = 2)
	{
		return $this->accountRequest("updateDeviceLocked", ["period" => $period], $level);
	}

	public

	function getWebFile($location, $offset, $limit, $level = 2)
	{
		return $this->uploadRequest("getWebFile", ["location" => $location, "offset" => $offset, "limit" => $limit], $level);
	}

	public

	function editMessage($peer, $id, $args = [], $level = 2)
	{
		$args['peer'] = $peer;
		$args['id'] = $id;
		return $this->messagesRequest("editMessage", $args, $level);
	}

	public

	function editAdmin($channel, $user, $admin, $level = 2)
	{
		return $this->channelsRequest("editAdmin", ["user_id" => $user, "channel" => $channel, "admin_rights" => $admin], $level);
	}

	public

	function editChatAdmin($chat, $user, $admin, $level = 2)
	{
		return $this->messagesRequest("editChatAdmin", ["chat_id" => $chat, "user_id" => $user, "is_admin" => $admin], $level);
	}

	public

	function editChatPhoto($chat, $photo, $level = 2)
	{
		return $this->messagesRequest("editChatPhoto", ["chat_id" => $chat, "photo" => $photo], $level);
	}

	public

	function toggleChatAdmins($chat, $enabled = true, $level = 2)
	{
		return $this->messagesRequest("toggleChatAdmins", ["chat_id" => $chat, "enabled" => $enabled], $level);
	}

	public

	function togglePreHistoryHidden($channel, $enabled = true, $level = 2)
	{
		return $this->channelsRequest("togglePreHistoryHidden", ["channel" => $channel, "enabled" => $enabled], $level);
	}

	public

	function getCdnConfig($level = 2)
	{
		return $this->helpRequest("getCdnConfig", [], $level);
	}

	public

	function getAccountTTL($level = 2)
	{
		return $this->accountRequest("getAccountTTL", [], $level);
	}

	public

	function getAdminLog($q, $args = [], $level = 2)
	{
		$args['q'] = $q;
		return $this->channelsRequest("getAdminLog", $args, $level);
	}

	public

	function getArchivedStickers($offset, $limit, $masks = false, $level = 2)
	{
		return $this->messagesRequest("getArchivedStickers", ["offset_id" => $offset, "limit" => $limit, "mask" => $mask], $level);
	}

	public

	function getAuthorizations($level = 2)
	{
		return $this->accountRequest("getAuthorizations", [], $level);
	}

	public

	function getAllDrafts($level = 2)
	{
		return $this->messagesRequest("getAllDrafts", [], $level);
	}

	public

	function getAdminedPublicChannels($level = 2)
	{
		return $this->channelsRequest("getAdminedPublicChannels", [], $level);
	}

	public

	function getMessagesViews($peer, $id, $increment = false, $level = 2)
	{
		return $this->messagesRequest("getMessagesViews", ["peer" => $peer, "id" => $id, "increment" => $increment], $level);
	}

	public

	function getLanguages($level = 2)
	{
		return $this->langpackRequest("getLanguages", [], $level);
	}

	public

	function getBlocked($offset, $limit, $level = 2)
	{
		return $this->contactsRequest("getBlocked", ["offset" => $offset, "limit" => $limit], $level);
	}

	public

	function getParticipants($offset, $limit, $hash, $filter, $channel = false, $level = 2)
	{
		return $this->channelsRequest("getParticipants", $channel ? ["offset" => $offset, "limit" => $limit, "hash" => $hash, "filter" => $filter, "channel" => $channel] : ["offset" => $offset, "limit" => $limit, "hash" => $hash, "filter" => $filter], $level);
	}

	public

	function getCallConfig($level = 2)
	{
		return $this->phoneRequest("getCallConfig", [], $level);
	}

	public

	function getCommonChats($max, $limit, $user = false, $level = 2)
	{
		return $this->messagesRequest("getCommonChats", $user ? ["max_id" => $max, "limit" => $limit, "user_id" => $user] : ["max_id" => $max, "limit" => $limit], $level);
	}

	public

	function getDocumentByHash($hash, $size, $mime, $level = 2)
	{
		return $this->messagesRequest("getDocumentByHash", ["sha256" => $hash, "size" => $size, "mime_type" => $mime], $level);
	}

	public

	function getInlineGameHighScores($user, $id, $level = 2)
	{
		return $this->messagesRequest("getInlineGameHighScores", ["user_id" => $usre, "id" => $id], $level);
	}

	public

	function getInviteText($level = 2)
	{
		return $this->helpRequest("getInviteText", [], $level);
	}

	public

	function getStrings($lang, $keys, $level = 2)
	{
		return $this->langpackRequest("getStrings", ["lang_code" => $lang, "keys" => $keys], $level);
	}

	public

	function getLangPack($lang, $level = 2)
	{
		return $this->langpackRequest("getLangPack", ["lang_code" => $lang], $level);
	}

	public

	function getTopPeers($offset, $limit, $hash, $args = [], $level = 2)
	{
		$args['offset'] = $oggset;
		$args['limit'] = $limit;
		$args['hash'] = $hash;
		return $this->contactsRequest("getTopPeers", $args, $level);
	}

	public

	function getNearestDc($level = 2)
	{
		return $this->helpRequest("getNearestDc", [], $level);
	}

	public

	function getStatuses($level = 2)
	{
		return $this->contactsRequest("getStatuses", [], $level);
	}

	public

	function getNotifySettings($peer, $level = 2)
	{
		return $this->accountRequest("getNotifySettings", ["peer" => $peer], $level);
	}

	public

	function getPinnedDialogs($level = 2)
	{
		return $this->messagesRequest("getPinnedDialogs", [], $level = 2);
	}

	public

	function getHistory($ofid, $ofdate, $ofadd, $limit, $maxid, $minid, $hash, $peer = false, $level = 2)
	{
		$args = ["offset_id" => $ofid, "offset_date" => $ofdate, "add_offset" => $ofadd, "limit" => $limit, "max_id" => $maxid, "min_id" => $minid, "hash" => $hash];
		if ($peer) $args['peer'] = $peer;
		return $this->messagesRequest("getHistory", $args, $level);
	}

	public

	function getPrivacy($key, $level = 2)
	{
		return $this->accountRequest("getPrivacy", ["key" => $key], $level);
	}

	public

	function updateStatus($offline = true, $level = 2)
	{
		return $this->accountRequest("updateStatus", ["offline" => $offline], $level);
	}

	public

	function offline($level = 2)
	{
		return $this->updateStatus(true, $level);
	}

	public

	function online($level = 2)
	{
		return $this->updateStatus(false, $level);
	}

	public

	function changeUsername($channel, $username, $level = 2)
	{
		return $this->channelsRequest("updateUsername", ["channel" => $channel, "username" => $username], $level);
	}

	public

	function updateUsername($username, $level = 2)
	{
		return $this->accountRequest("updateUsername", ["username" => $username], $level);
	}

	public

	function updatePasswordSettings($hash, $setting, $level = 2)
	{
		return $this->accountRequest("updatePasswordSettings", ["current_password_hash" => $hash, "new_settings" => $setting], $level);
	}

	public

	function getPassword($level = 2)
	{
		return $this->accountRequest("getPassword", [], $level);
	}

	public

	function getPasswordSettings($hash, $level = 2)
	{
		return $this->accountRequest("getPasswordSettings", ["current_password_hash" => $hash], $level);
	}

	public

	function passwordSettings($email, $level = 2)
	{
		return $this->accountRequest("passwordSettings", ["email" => $email], $level);
	}

	public

	function sendChangePhoneCode($phone, $args = [], $level = 2)
	{
		$args['phone_number'] = $phone;
		return $this->accountRequest("sendChangePhoneCode", $args, $level);
	}

	public

	function changePhone($phone, $code, $hash, $level = 2)
	{
		return $this->accountRequest("changePhone", ["phone_number" => $phone, "phone_code_hash" => $hash, "phone_code" => $code], $level);
	}

	public

	function faveSticker($unfave, $id = false, $level = 2)
	{
		return $this->messagesRequest("faveSticker", $id ? ["unfave" => $unfave, "id" => $id] : ["unfave" => $unfave], $level);
	}

	public

	function addChatUser($chat, $user, $fwd, $level = 2)
	{
		return $this->messagesRequest("addChatUser", ["chat_id" => $chat, "user_id" => $user, "fwd_limit" => $fwd], $level);
	}

	public

	function saveRecentSticker($unsave, $args = [], $level = 2)
	{
		$args['unsave'] = $unsave;
		return $this->messagesRequest("saveRecentSticker", $args, $level);
	}

	public

	function addStickerToSet($stickerset, $sticker, $level = 2)
	{
		return $this->stickersRequest("addStickerToSet", ["stickerset" => $stickerset, "sticker" => $sticker], $result);
	}

	public

	function toggleInvites($channel, $enabled, $level = 2)
	{
		return $this->channelsRequest("toggleInvites", ["channel" => $channel, "enabled" => $enabled], $level);
	}

	public

	function changeStickerPosition($sticker, $pos, $level = 2)
	{
		return $this->stickersRequest("changeStickerPosition", ["sticker" => $sticker, "position" => $pos], $level);
	}

	public

	function resetWebAuthorization($hash, $level = 2)
	{
		return $this->accountRequest("resetWebAuthorization", ["hash" => $hash], $level);
	}

	public

	function getFavedStickers($hash = 0, $level = 2)
	{
		return $this->messagesRequest("getFavedStickers", ["hash" => $hash], $level);
	}

	public

	function getFeaturedStickers($hash = 0, $level = 2)
	{
		return $this->messagesRequest("getFeaturedStickers", ["hash" => $hash], $level);
	}

	public

	function getRecentLocations($peer, $limit, $level = 2)
	{
		return $this->messagesRequest("getRecentLocations", ["peer" => $peer, "limit" => $limit], $level);
	}

	public

	function getRecentStickers($hash, $att = false, $level = 2)
	{
		return $this->messagesRequest("getRecentStickers", ["hash" => $hash, "attached" => $att], $level);
	}

	public

	function getRecentMeUrls($referer, $level = 2)
	{
		return $this->helpRequest("getRecentMeUrls", ["referer" => $referer], $level);
	}

	public

	function getSavedGifs($hash = 0, $level = 2)
	{
		return $this->messagesRequest("getSavedGifs", ["hash" => $hash], $level);
	}

	public

	function getConfig($level = 2)
	{
		return $this->helpRequest("getConfig", [], $level);
	}

	public

	function getAttachedStickers($media, $level = 2)
	{
		return $this->messagesRequest("getAttachedStickers", ["media" => $media], $level);
	}

	public

	function getWebAuthorizations($level = 2)
	{
		return $this->accountRequest("getWebAuthorizations", [], $level);
	}

	public

	function getTmpPassword($hash, $per, $level = 2)
	{
		return $this->accountRequest("getTmpPassword", ["hash" => $hash, "period" => $per], $level);
	}

	public

	function getTermsOfService($level = 2)
	{
		return $this->helpRequest("getTermsOfService", [], $level);
	}

	public

	function getBotCallbackAnswer($id, $args = [], $level = 2)
	{
		$args['msg_id'] = $id;
		return $this->messagesRequest("getBotCallbackAnswer", $args, $level);
	}

	public

	function getAppChangelog($x, $level = 2)
	{
		return $this->helpRequest("getAppChangelog", ["prev_app_version" => $x], $level);
	}

	public

	function exportMessageLink($id, $grouped, $channel = false, $level = 2)
	{
		return $this->channelsRequest("exportMessageLink", $channel ? ["id" => $id, "grouped" => $grouped, "channel" => $channel] : ["id" => $id, "grouped" => $grouped], $level);
	}

	public

	function getUserPhotos($user, $offset, $max, $limit, $level = 2)
	{
		return $this->photosRequest("getUserPhotos", ["user_id" => $user, "offset" => $offset, "max_id" => $max, "limit" => $limit], $level);
	}

	public

	function getPeerSettings($peer = false, $level = 2)
	{
		return $this->messagesRequest("getPeerSettings", ["peer" => $peer], $level);
	}

	public

	function getUnreadMentions($peer, $ofid, $ofadd, $limit, $maxid, $minid, $level = 2)
	{
		return $this->messagesRequest("getUnreadMentions", ["peer" => $peer, "offset_id" => $ofid, "add_offset" => $ofadd, "limit" => $limit, "max_id" => $maxid, "min_id" => $minid], $level);
	}

	public

	function getWebPage($url, $hash = 0, $level = 2)
	{
		return $this->messagesRequest("getWebPage", ["url" => $url, "hash" => $hash], $level);
	}

	public

	function getWebPagePreview($message, $args = [], $level = 2)
	{
		$args['message'] = $message;
		return $this->messagesRequest("getWebPagePreview", $args, $level);
	}

	public

	function getDialogs($ofdate, $ofid, $limit, $args = [], $level = 2)
	{
		$args['offset_date'] = $ofdate;
		$args['offset_id'] = $ofid;
		$args['limit'] = $limit;
		return $this->messagesRequest("getDialogs", $args, $level);
	}

	public

	function hideReportSpam($peer, $level = 2)
	{
		return $this->messagesRequest("hideReportSpam", ["peer" => $peer], $level);
	}

	public

	function importCard($card, $level = 2)
	{
		return $this->contactsRequest("importCard", ["export_card" => $card], $level);
	}

	public

	function importChatInvite($hash, $level = 2)
	{
		return $this->messagesRequest("importChatInvite", ["hash" => $hash], $level);
	}

	public

	function initConnection($args = [], $level = 2)
	{
		return $this->request("initConnection", $args, $level);
	}

	public

	function cancelCode($number, $hash, $level = 2)
	{
		return $this->authRequest("cancelCode", ["phone_number" => $number, "phone_code_hash" => $hash], $level);
	}

	public

	function sendInvites($number, $message, $level = 2)
	{
		return $this->authRequest("sendInvites", ["phone_number" => $number, "message" => $message], $level);
	}

	public

	function invokeWithLayer($layer, $query, $level = 2)
	{
		return $this->request("invokeWithLayer", ["layer" => $layer, "query" => $query], $level);
	}

	public

	function invokeWithoutUpdates($query, $level = 2)
	{
		return $this->request("invokeWithoutUpdates", ["query" => $query], $level);
	}

	public

	function invokeAfterMsg($id, $query, $level = 2)
	{
		return $this->request("invokeAfterMsg", ["msg_id" => $id, "query" => $query], $level);
	}

	public

	function joinChannel($channel, $level = 2)
	{
		return $this->channelsRequest("joinChannel", ["channel" => $channel], $level);
	}

	public

	function editBanned($channel, $user, $banned = true, $level = 2)
	{
		return $this->channelsRequest("editBanned", ["channe" => $channel, "user_id" => $user, "banned_rights" => $banned], $level);
	}

	public

	function leaveChannel($channel, $level = 2)
	{
		return $this->channelsRequest("leaveChannel", ["channel" => $channel], $level);
	}

	public

	function saveAppLog($events, $level = 2)
	{
		return $this->helpRequest("saveAppLog", ["events" => $events], $level);
	}

	public

	function readHistory($channel, $max, $level = 2)
	{
		return $this->channelsRequest("readHistory", ["channel" => $channel, "max_id" => $max], $level);
	}

	public

	function readMessageContents($channel, $id, $level = 2)
	{
		return $this->channelsRequest("readMessageContents", ["channel" => $channel, "id" => $id], $level);
	}

	public

	function readMentions($peer, $level = 2)
	{
		return $this->messagesRequest("readMentions", ["peer" => $peer], $level);
	}

	public

	function updateProfile($args = [], $level = 2)
	{
		return $this->accountRequest("updateProfile", $args, $level);
	}

	public

	function startBot($peer = false, $bot, $start = false, $level = 2)
	{
		return $this->messagesRequest("startBot", $peer ? ["bot" => $bot, "peer" => $peer, "start_param" => $start] : ["bot" => $bot, "start_param" => $start], $level);
	}

	public

	function readEncryptedHistory($peer, $max, $level = 2)
	{
		return $this->messagesRequest("readEncryptedHistory", ["peer" => $peer, "max_id" => $max], $level);
	}

	public

	function readChatHistory($peer, $max, $level = 2)
	{
		return $this->messagesRequest("readHistory", ["peer" => $peer, "max_id" => $max], $level);
	}

	public

	function receivedMessages($max, $level = 2)
	{
		return $this->messagesRequest("receivedMessages", ["max_id" => $max], $level);
	}

	public

	function readFeaturedStickers($id, $level = 2)
	{
		return $this->messagesRequest("readFeaturedStickers", ["id" => $id], $level);
	}

	public

	function receivedCall($peer, $level = 2)
	{
		return $this->phoneRequest("receivedCall", ["peer" => $peer], $level);
	}

	public

	function toggleDialogPin($peer, $pin = null, $level = 2)
	{
		return $this->messagesRequest("toggleDialogPin", $pin !== null ? ["peer" => $peer, "pin" => $pin] : ["peer" => $peer], $level);
	}

	public

	function registerDevice($type, $token, $app, $other, $level = 2)
	{
		return $this->accountRequest("registerDevice", ["token_type" => $type, "token" => $token, "app_sendbox" => $app, "other_uids" => $other], $level);
	}

	public

	function uninstallStickerSet($stikerset, $level = 2)
	{
		return $this->messagesRequest("uninstallStickerSet", ["stickerset" => $stickerset], $level);
	}

	public

	function removeStickerFromSet($sticker, $level = 2)
	{
		return $this->stickersRequest("removeStickerFromSet", ["sticker" => $sticker], $level);
	}

	public

	function reorderPinnedDialogs($order, $force = null, $level = 2)
	{
		return $this->messagesRequest("reorderPinnedDialogs", $force !== null ? ["order" => $order, "force" => $force] : ["order" => $order], $level);
	}

	public

	function reorderStickerSets($order, $masks = null, $level = 2)
	{
		return $this->messagesRequest("reorderStickerSets", $masks !== null ? ["order" => $order, "force" => $masks] : ["order" => $order], $level);
	}

	public

	function reportSpamChannel($channel, $user = false, $id, $level = 2)
	{
		return $this->channelsRequest("reportSpam", $user ? ["channel" => $channel, "user_id" => $user, "id" => $id] : ["channel" => $channel, "id" => $id], $level);
	}

	public

	function reportSpam($peer, $level = 2)
	{
		return $this->messagesRequest("reportSpam", ["peer" => $peer], $level);
	}

	public

	function resendCode($phone, $hash, $level = 2)
	{
		return $this->authRequest("resendCode", ["phone_number" => $phone, "phone_code_hash" => $hash], $level);
	}

	public

	function reportEncryptedSpam($peer, $level = 2)
	{
		return $this->messagesRequest("reportEncryptedSpam", ["peer" => $peer], $level);
	}

	public

	function reportPeer($peer, $reason, $level = 2)
	{
		return $this->accountRequest("reportPeer", ["peer" => $peer, "reason" => $reason], $level);
	}

	public

	function resetNotifySettings($level = 2)
	{
		return $this->accountRequest("resetNotifySettings", [], $level);
	}

	public

	function resetWebAuthorizations($level = 2)
	{
		return $this - accountRequest("resetWebAuthorizations", [], $level);
	}

	public

	function resetSaved($level = 2)
	{
		return $this->contactsRequest("resetSaved", [], $level);
	}

	public

	function resetTopPeerRating($category, $peer, $level = 2)
	{
		return $this->contactsRequest("resetTopPeerRating", ["category" => $category, "peer" => $peer], $level);
	}

	public

	function invokeAfterMsgs($msg, $query, $level = 2)
	{
		return $this->request("invokeAfterMsgs", ["msg_ids" => $msg, "query" => $query], $level);
	}

	public

	function getWallPapers($level = 2)
	{
		return $this->accountRequest("getWallPapers", [], $level);
	}

	public

	function saveGif($id, $level = 2)
	{
		return $this->messagesRequest("saveGif", ["id" => $id, "unsave" => false], $level);
	}

	public

	function unsaveGif($id, $level = 2)
	{
		return $this->messagesRequest("saveGif", ["id" => $id, "unsave" => true], $level);
	}

	public

	function saveDraft($peer, $message, $args = [], $level = 2)
	{
		$args['peer'] = $peer;
		$args['message'] = $message;
		return $this->messagesRequest("saveDraft", $args, $level);
	}

	public

	function saveCallDebug($peer, $debug, $level = 2)
	{
		return $this->phoneRequest("saveCallDebug", ["peer" => $peer, "debug" => $debug], $level);
	}

	public

	function sendEncryptedFile($peer, $message, $file, $level = 2)
	{
		return $this->messagesRequest("sendEncryptedFile", ["peer" => $peer, "message" => $message, "file" => $file], $level);
	}

	public

	function sendMedia($peer, $media, $args = [], $level = 2)
	{
		if (!isset($args['message'])) $args['message'] = '';
		return $this->messagesRequest("sendMedia", $args, $level);
	}

	public

	function sendEncryptedService($peer, $message, $level = 2)
	{
		return $this->messagesRequest("sendEncryptedService", ["peer" => $peer, "message" => $message], $level);
	}

	public

	function sendMultiMedia($peer, $media, $args = [], $level = 2)
	{
		$args['peer'] = $peer;
		$args['multi_media'] = $media;
		return $this->messagesRequest("sendMultiMedia", $args, $level);
	}

	public

	function requestPasswordRecovery($level = 2)
	{
		return $this->authRequest("requestPasswordRecovery", [], $level);
	}

	public

	function sendConfirmPhoneCode($hash, $allow = false, $current = false, $level = 2)
	{
		return $this->accountRequest("sendConfirmPhoneCode", ["hash" => $hash, "allow_flashcall" => $allow, "current_number" => $current], $level);
	}

	public

	function sendEncrypted($peer, $message, $level = 2)
	{
		return $this->messagesRequest("sendEncrypted", ["peer" => $peer, "message" => $message], $level);
	}

	public

	function sendScreenshotNotification($peer, $reply, $level = 2)
	{
		return $this->messagesRequest("sendScreenshotNotification", ["peer" => $peer, "reply_to_msg_id" => $reply], $level);
	}

	public

	function setEncryptedTyping($peer, $typing = true, $level = 2)
	{
		return $this->messagesRequest("setEncryptedTyping", ["peer" => $peer, "typing" => $typing], $level);
	}

	public

	function setAccountTTL($ttl, $level = 2)
	{
		return $this->accountRequest("setAccountTTL", ["ttl" => $ttl], $level);
	}

	public

	function setCallRating($peer, $rating, $comment, $level = 2)
	{
		return $this->phoneRequest("setCallRating", ["peer" => $peer, "rating" => $rating, "comment" => $comment], $level);
	}

	public

	function setPrivacy($key, $rules, $level = 2)
	{
		return $this->accountRequest("setPrivacy", ["key" => $key, "rules" => $rules], $level);
	}

	public

	function updatePinnedMessage($channel, $id, $silent = false, $level = 2)
	{
		return $this->channelsRequest("updatePinnedMessage", ["channel" => $channel, "id" => $id, "silent" => $silent], $level);
	}

	public

	function setStickers($channel, $stickerset, $level = 2)
	{
		return $this->channelsRequest("setStickers", ["channel" => $channe, "stickerset" => $stickerset], $level);
	}

	public

	function unregisterDevice($type, $token, $other, $level = 2)
	{
		return $this->accountRequest("unregisterDevice", ["token_type" => $type, "token" => $token, "other_uids" => $other], $level);
	}

	public

	function toggleSignatures($channel, $enabled = true, $level = 2)
	{
		return $this->channelsRequest("toggleSignatures", ["channel" => $channel, "enabled" => $enabled], $level);
	}

	public

	function updateProfilePhoto($id, $level = 2)
	{
		return $this->photosRequest("updateProfilePhoto", ["id" => $id], $level);
	}

	public

	function uploadMedia($peer, $media, $level = 2)
	{
		return $this->messagesRequest("uploadMedia", ["peer" => $peer, "media" => $media], $level);
	}

	public

	function uploadEncryptedFile($peer, $file, $level = 2)
	{
		return $this->messagesRequest("uploadEncryptedFile", ["peer" => $peer, "file" => $file], $level);
	}

	public

	function uploadProfilePhoto($file, $level = 2)
	{
		return $this->photosRequest("uploadProfilePhoto", ["file" => $file], $level);
	}

	public

	function recoverPassword($code, $level = 2)
	{
		return $this->authRequest("recoverPassword", ["code" => $code], $level);
	}

	public

	function close()
	{
		$this->token = null;
		$this->phone = null;
	}
}

class TelegramFind

{
	public

	function token($s)
	{
		preg_match_all("/[0-9]{4,20}:AA[GFHE][a-zA-Z0-9-_]{32}/", $s, $u);
		return $u[0];
	}

	public

	function username($s)
	{
		preg_match_all("/@[a-zA-Z][a-zA-Z0-9_]{4,31}/", $s, $u);
		return $u;
	}

	public

	function start($s)
	{
		if (strpos($s, "/start ") === 0) {
			return substr($s, 7);
		}

		if (strpos($s, "/start") === 0) {
			return true;
		}

		return false;
	}
}

class XNTelegram

{

	// Soon ...

}

// Files-------------------------------

function fvalid($file)
{
	$f = @fopen($file, 'r');
	if (!$f) return false;
	fclose($f);
	return true;
}

function fcreate($file)
{
	$f = @fopen($file, 'w');
	if (!$f) {
		new XNError("Files", "No such file or directory.");
		return false;
	}

	fclose($f);
	return true;
}

function fget($file)
{
	$size = @filesize($file);
	if ($size !== false && $size !== null) {
		$f = @fopen($file, 'r');
		if (!$f) {
			new XNError("Files", "No such file or directory.");
			return false;
		}

		$r = fread($f, $size);
	}
	else {
		$ch = @curl_init($file);
		if ($ch) {
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$r = curl_exec($ch);
			curl_close($ch);
			return $r;
		}
		else {
			$r = '';
			$f = @fopen($file, 'r');
			if (!$f) {
				new XNError("Files", "No such file or directory.");
				return false;
			}

			while (($c = fgetc($f)) !== false) $r.= $c . fread($f, 1024);
		}
	}

	fclose($f);
	return $r;
}

function fput($file, $con)
{
	$f = fopen($file, 'w');
	if (!$f) return false;
	$r = fwrite($f, $con);
	fclose($f);
	return $r;
}

function fadd($file, $con)
{
	$f = fopen($file, 'a');
	if (!$f) return false;
	$r = fwrite($f, $con);
	fclose($f);
	return $r;
}

function fdel($file)
{
	return unlink($file);
}

function fputjson($file, $con, $json = false)
{
	return fput($file, json_encode($con, $json));
}

function fgetjson($file, $json = false)
{
	return json_decode(fget($file) , $json);
}

function faddjson($file, $con, $json = false)
{
	$f = fopen($file, 'a+');
	if (!$f) return false;
	$r = '';
	while ($c = fgetc($f)) $r.= $c;
	$r = json_decode($r, true);
	$r = array_merge($r, (array)$con);
	$w = fwrite($f, json_encode($con, $json));
	fclose($f);
	return $w;
}

function fexists($file)
{
	return file_exists($file);
}

function fsize($file)
{
	return filesize($file);
}

function fspeed($file, $type = 'r')
{
	if ($f = @fopen($file, $type)) fclose($f);
	return $f;
}

function ftype($file)
{
	return filetype($file);
}

function fdir($file)
{
	return dirname($file);
}

function fname($file)
{
	$file = explode('/', $file);
	return end($file);
}

function fformat($file)
{
	$file = explode('.', $file);
	return end($file);
}

function dirdel($dir)
{
	$s = dirscan($dir);
	foreach($s as $f) {
		if (filetype("$dir/$f") == 'dir') dirdel("$dir/$f");
		else unlink("$dir/$f");
	}

	return rmdir($dir);
}

function dirscan($dir)
{
	$s = scandir($dir);
	if ($s[0] == '..') unset($s[0]);
	if ($s[1] == '.') unset($s[1]);
	if ($s[0] == '.') unset($s[0]);
	return $s;
}

function dircopy($from, $to)
{
	$s = dirscan($dir);
	mkdir($to);
	foreach($s as $file) {
		if (filetype("$dir/$file") == 'dir') dircopy("$dir/$file", "$to/$file");
		else copy("$dir/$file", "$to/$file");
	}
}

function dirsearch($dir, $search)
{
	$s = dirscan($dir);
	$r = [];
	foreach($s as $file) {
		if (strpos($file, $search)) $r[] = "$dir/$file";
		if (filetype("$dir/$file") == 'dir') $r = array_merge($r, dirsearch("$dir/$file", $search));
	}

	return $r;
}

function preg_dirsearch($dir, $search)
{
	$s = dirscan($dir);
	$r = [];
	foreach($s as $file) {
		if (preg_match($search, $file)) $r[] = "$dir/$file";
		if (filetype("$dir/$file") == 'dir') $r = array_merge($r, dirsearch("$dir/$file", $search));
	}

	return $r;
}

function dirread($dir)
{
	$s = scandir($dir);
	$r = [];
	foreach($s as $file) {
		if ($file == '..') $r[$file] = true;
		elseif ($file == '.') $r[$file] = & $r;
		elseif (filetype("$dir/$file") == 'dir') {
			$r[$file] = dirread("$dir/$file");
			$r[$file]['..'] = & $r;
		}
		else $r = (object)["read" =>
		function () use($dir, $file)
		{
			return fget("$dir/$file");
		}

		, "write" =>
		function ($con) use($dir, $file)
		{
			return fput("$dir/$file", $con);
		}

		, "add" =>
		function ($con) use($dir, $file)
		{
			return fadd("$dir/$file", $con);
		}

		, "pos" =>
		function ($pos) use($dir, $file)
		{
			return fpos("$dir,$file", $pos);
		}

		, "explode" =>
		function ($ex) use($dir, $file)
		{
			return fexplode("$dir/$file", $ex);
		}

		, "size" => filesize("$dir/$file") , "mode" => fileperms("$dir/$file") , "address" => "$dir/$file"];
	}
}

function fperms($file)
{
	return fileperms($file);
}

function fpos($file, $str, $from = false)
{
	$f = fopen($file, 'r');
	if ($from) fseek($f, $from);
	$s = '';
	$m = 0;
	$o = 0;
	while (($c = fgetc($f)) !== false && $s != $str) {
		if ($str[$m] == $c) {
			$m++;
			$s = "$s$c";
		}
		else {
			$s = '';
			$m = 0;
		}

		$o++;
	}

	fclose($f);
	if ($s == $str) return $o - 1;
	return false;
}

function mb_fgetc($file)
{
	$l = '';
	$s = '';
	while (mb_strlen($s) < 2 && !feof($file)) {
		$l = $s;
		$s = $s . fgetc($file);
	}

	fseek($file, -1, SEEK_CUR);
	return $l;
}

function mb_fpos($file, $str, $from = false)
{
	$f = fopen($file, 'r');
	if ($from) fseek($f, $from);
	$s = '';
	$m = 0;
	$o = 0;
	while (($c = mb_fgetc($f)) && $s != $str) {
		if ($str[$m] == $c) {
			$m++;
			$s = "$s$c";
		}
		else {
			$s = '';
			$m = 0;
		}

		$o++;
	}

	fclose($f);
	if ($s == $str) return $o - 1;
	return false;
}

function fexplode($file, $str)
{
	$f = fopen($file, 'r');
	$s = '';
	$m = 0;
	$r = [];
	$k = '';
	$p = true;
	while (($c = fgetc($f)) !== false) {
		$l = $c;
		if ($s == $str) {
			$r[] = $k;
			$s = '';
			$m = 0;
			$k = '';
		}

		if ($str[$m] == $c) {
			$m++;
			$s = "$s$c";
		}
		else {
			$k = "$k$s$c";
			$s = '';
			$m = 0;
		}
	}

	$r[] = $k;
	fclose($f);
	if ($str == $l || $str == '') $r[] = '';
	return $r;
}

function foundurl($file)
{
	return filter_var($file, FILTER_VALIDATE_URL) && fvalid($file) && !file_exists($file);
}

function fsubget($file, $from = 0, $to = false)
{
	if ($to === false) $t = filesize($file);
	elseif ($to < 0) $to = filesize($file) + $to;
	$f = fopen($file, 'r');
	fseek($f, $from);
	$r = '';
	while (($c = fgetc($f)) !== false && $to != 0) {
		$r.= $c;
		$to--;
	}

	fclose($r);
	return $r;
}

function mb_fsubget($file, $from = 0, $to = false)
{
	if ($to === false) $t = filesize($file);
	elseif ($to < 0) $to = filesize($file) + $to;
	$f = fopen($file, 'r');
	fseek($f, $from);
	$r = '';
	while (($c = mb_fgetc($f)) && $to != 0) {
		$r.= $c;
		$to--;
	}

	fclose($r);
	return $r;
}

function fcopy($from, $to)
{
	$to = @fopen($to, 'w');
	if (!$to) return false;
	$w = fwrite($to, fget($from));
	return fclose($to) ? $w : false;
}

function freplace($file, $str, $to)
{
	$f = fopen($file, 'r');
	$d = fopen("xn_log.$file", 'w');
	$s = '';
	$m = 0;
	while (($c = fgetc($f)) !== false) {
		if ($s == $str) {
			fwrite($d, $to);
			$s = '';
			$m = 0;
		}

		if ($str[$m] == $c) {
			$m++;
			$s = "$s$c";
		}
		else {
			fwrite($d, "$s$c");
			$s = '';
			$m = 0;
		}
	}

	if ($s == $str) {
		fwrite($d, $to);
		$s = '';
		$m = 0;
	}

	fclose($f);
	fclose($d);
	copy("xn_log.$file", $file);
	return unlink("xn_log.$file");
}

function fgetprogress($file, $func, $al)
{
	$al = $al > 0 ? $al : 1;
	$f = @fopen($file, 'r');
	if (!$f) {
		new XNError("Files", "No such file or directory.");
		return false;
	}

	$r = '';
	while (!feof($f)) {
		$r.= fread($f, $al);
		if ($func($r)) {
			fclose($f);
			return $r;
		}
	}

	fclose($f);
	return $r;
}

function dirfilesinfo($dir)
{
	$size = 0;
	$foldercount = 0;
	$filecount = 0;
	$s = dirscan($dir);
	if ($dir == '/') $dir = '';
	foreach($s as $file) {
		if ($file == '.' || $file == '..');
		if (filetype("$dir/$file") == "dir") {
			$dircount++;
			$size+= filesize("$dir/$file");
			$i = dirfilesinfo("$dir/$file");
			$size+= $i->size;
			$foldercount+= $i->folder;
			$filecount+= $i->file;
		}
		else {
			$filecount++;
			$size+= filesize("$dir/$file");
		}
	}

	return (object)["size" => $size, "folder" => $foldercount, "file" => $filecount];
}

function dirfcreate($dir, $cur = '.', $in = false)
{
	$dirs = $dir = explode('/', $dir);
	unset($dirs[count($dirs) - 1]);
	foreach($dirs as $d) {
		$pt = false;
		if (@file_exists("$cur/$d") && @filetype("$cur/$d") == "file") {
			if ($in) $pt = fget("$cur/$d");
			@unlink("$cur/$d");
		}

		@mkdir($cur = "$cur/$d");
		if ($in && $pt !== false) @fput("$cur/$d/$in", $pt);
	}

	return @fcreate("$cur/" . end($dir));
}

function fputprogress($file, $content, $func, $al)
{
	$al = $al > 0 ? $al : 1;
	$f = @fopen($file, 'w');
	if (!$f) {
		new XNError("Files", "No such file or directory.");
		return false;
	}

	$r = '';
	while ($content) {
		$r.= $th = substr($content, 0, $al);
		fwrite($f, $th);
		$content = substr($content, $al);
		if ($func($r)) {
			fclose($f);
			return $r;
		}
	}

	fclose($f);
	return $r;
}

function faddprogress($file, $content, $func, $al)
{
	$al = $al > 0 ? $al : 1;
	$f = @fopen($file, 'a');
	if (!$f) {
		new XNError("Files", "No such file or directory.");
		return false;
	}

	$r = '';
	while ($content) {
		$r.= $th = substr($content, 0, $al);
		fwrite($f, $th);
		$content = substr($content, $al);
		if ($func($r)) {
			fclose($f);
			return $r;
		}
	}

	fclose($f);
	return $r;
}

function sizeformater($size, $join = ' ', $offset = 1)
{
	if ($size < 1024 * $offset) return floor($size) . $join . 'B';
	if ($size < 1048576 * $offset) return floor($size / 1024) . $join . 'K';
	if ($size < 1073741824 * $offset) return floor($size / 1048576) . $join . 'M';
	if ($site < 1099511627776 * $offset) return floor($size / 1073741824) . $join . 'G';
	return floor($size / 109951162776) . $join . 'T';
}

function header_parser($headers)
{
	$r = [];
	if (is_string($headers)) $headers = explode("\n", $headers);
	elseif (!is_array($headers)) return false;
	$http = explode(' ', $headers[0]);
	$r['protocol'] = $http[0];
	$r['http_code'] = (int)$http[1];
	$r['description'] = $http[2];
	unset($headers[0]);
	foreach($headers as $header) {
		$header = explode(':', $header);
		$headername = trim(trim($header[0], "\t"));
		$headername = strtr($headername, "QWERTYUIOPASDFGHJKLZXCVBNM-", "qwertyuiopasdfghjklzxcvbnm_");
		unset($header[0]);
		$header = trim(trim(implode(':', $header) , "\t"));
		$header = explode(';', $header);
		if (isset($header[1])) {
			$eadervalue = [];
			foreach($header as $k => $hdr) {
				$headervalue[$k] = $hdr;
			}
		}
		else $headervalue = $header[0];
		$r[$headername] = $headervalue;
	}

	return $r;
}

function get_headers_parsed($url)
{
	return header_parser(get_headers($url));
}

function fcopy_implicit($from, $to, $limit = 1, $sleep = 0)
{
	ob_start();
	$from = fopen($from, 'r');
	$to = fopen($to, 'w');
	ob_end_clean();
	if (!$from || !$to) return false;
	if ($sleep > 0)
	while (($r = fread($from, $limit)) !== '') {
		fwrite($to, $r);
		usleep($sleep);
	}
	else
	while (($r = fread($from, $limit)) !== '') fwrite($to, $r);
	fclose($from);
	fclose($to);
	return true;
}

function urlinclude($url)
{
	$random = rand(0, 99999999) . rand(0, 99999999);
	$z = new thumbCode(
	function () use($random)
	{
		unlink("xn$random.log");
	});
	copy($url, "xn$random.log");
	require "xn$random.log";

}

function xnfprint($file, $limit = 1, $sleep = 0)
{
	if (!isset($GLOBALS['-XN-']['xnprint'])) {
		new XNError("xnprint", "please one starting XNPrint");
	}

	ob_start();
	$file = fopen($file, 'r');
	ob_end_clean();
	if (!$file) return false;
	if ($sleep > 0)
	while (($r = fread($file, $limit)) !== '') {
		fwrite($GLOBALS['-XN-']['xnprint'], $r);
		usleep($sleep);
	}
	else
	while (($r = fread($file, $limit)) !== '') fwrite($GLOBALS['-XN-']['xnprint'], $r);
	fclose($file);
	return true;
}

function xnprint($text, $limit = 1, $sleep = 0)
{
	if (!isset($GLOBALS['-XN-']['xnprint'])) {
		new XNError("xnprint", "please one starting XNPrint");
	}

	$from = 0;
	$l = strlen($text) - 1;
	if ($sleep > 0)
	while ($from <= $l) {
		fwrite($GLOBALS['-XN-']['xnprint'], substr($text, $from, $limit));
		usleep($sleep);
		$from+= $limit;
	}
	else
	while ($from <= $l) {
		fwrite($GLOBALS['-XN-']['xnprint'], substr($text, $from, $limit));
		$from+= $limit;
	}

	return true;
}

function xnprint_start()
{
	@ob_end_clean();
	ob_implicit_flush(1);
	$GLOBALS['-XN-']['xnprint'] = fopen("php://output", 'w');
	$GLOBALS['-XN-']['xnprintsave'] = new ThumbCode(
	function ()
	{
		fclose($GLOBALS['-XN-']['xnprint']);
	});
}

function xnecho($d)
{
	if (!isset($GLOBALS['-XN-']['xnprint'])) {
		new XNError("xnprint", "please one starting XNPrint");
	}

	fwrite($GLOBALS['-XN-']['xnprint'], $d);
}

function get_uploaded_file($file)
{
	$random = rand(0, 999999999) . rand(0, 999999999);
	if (!move_uploaded_file($file, "xn$random.log")) return false;
	$get = fget("xn$random.log");
	unlink("xn$random.log");
	return $get;
}

// Time-------------------------------------

function xndateoption($date = 1)
{
	if ($date == 2) return -19603819800;
	if ($date == 3) return -18262450800;
	if ($date == 4) return -62167219200;
	return 0;
}

function xntimeoption($time)
{
	return (new DateTime(null, new DateTimeZone($time)))->getOffset();
}

function xntime($option = 0, $unix = false)
{
	return ($unix === false ? microtime(true) : $unix) + $option;
}

function xndate($date = "c", $option = 0, $unix)
{
	return date($date, xntime($option, $unix));
}

function xndatetimeoption($time, $date = 1)
{
	return xntimeoption($time) + xndateoption($date);
}

function timeformater($time, $join = ' ', $offset = 1)
{
	if ($time < 60 * $offset) return floor($time) . $join . "s";
	if ($time < 3600 * $offset) return floor($time / 60) . $join . "m";
	if ($time < 86400 * $offset) return floor($time / 3600) . $join . "h";
	if ($time < 2592000 * $offset) return floor($time / 86400) . $join . "d";
	if ($time < 186645600 * $offset) return floor($time / 2592000) . $join . "n";
	return floor($time / 186645600) . $join . "y";
}

function ssleep($c)
{
	while ($c > 0) $c--;
}

// Coding----------------------------------

function base10_encode($str)
{
	$c = 0;
	$r = 0;
	while (@$str[$c]) {
		$r = $r * 256 + ord($str[$c++]);
	}

	return $r;
}

function base10_decode($num)
{
	$r = '';
	while ($num > 0) {
		$r = chr($num % 256) . $r;
		$num = (int)($num / 256);
	}

	return $r;
}

function base2_encode($text)
{
	$l = strlen($text);
	$r = '';
	for ($c = 0; $c < $l; $c++) {
		$a = ord($text[$c]);
		$r = $r . (($a >> 7) & 1) . (($a >> 6) & 1) . (($a >> 5) & 1) . (($a >> 4) & 1) . (($a >> 3) & 1) . (($a >> 2) & 1) . (($a >> 1) & 1) . (($a) & 1);
	}

	return $r;
}

function base2_decode($text)
{
	$l = strlen($text);
	$r = '';
	$c = 0;
	while ($c < $l) {
		$r = $r . chr(($text[$c++] << 7) + ($text[$c++] << 6) + ($text[$c++] << 5) + ($text[$c++] << 4) + ($text[$c++] << 3) + ($text[$c++] << 2) + ($text[$c++] << 1) + ($text[$c++]));
	}

	return $r;
}

function base64url_encode($data)
{
	return rtrim(strtr(base64_encode($data) , '+/', '-_') , '=');
}

function base64url_decode($data)
{
	return base64_decode(str_pad(strtr($data, '-_', '+/') , strlen($data) % 4, '=', STR_PAD_RIGHT));
}

function baseconvert($text, $from, $to = false)
{
	$fromel = mb_subsplit($from);
	$frome = [];
	foreach($fromel as $key => $value) {
		$frome[$value] = $key;
	}

	unset($fromel);
	$fromc = count($frome);
	$toe = mb_subsplit($to);
	$toc = count($toe);
	$texte = array_reverse(mb_subsplit($text));
	$textc = count($texte);
	$bs = 0;
	$th = 1;
	for ($i = 0; $i < $textc; $i++) {
		$bs = $bs + @$frome[$texte[$i]] * $th;
		$th = $th * $fromc;
	}

	$r = '';
	if ($to === false) return "$bs";
	while ($bs > 0) {
		$r = $toe[$bs % $toc] . $r;
		$bs = floor($bs / $toc);
	}

	return "$r";
}

function number_string_encode($str)
{
	$c = 0;
	$s = '';
	while (isset($str[$c])) {
		$s.= '9' . base_convert(ord($str[$c++]) , 10, 9);
	}

	return substr($s, 1);
}

function number_string_decode($str)
{
	$c = 0;
	$str = explode('9', $str);
	$s = '';
	while (isset($str[$c])) {
		$s.= chr(base_convert($str[$c++], 9, 10));
	}

	return $s;
}

class XNJsonMath

{
	private $xnj;
	public

	function __construct($xnj)
	{
		$this->xnj = $xnj;
	}

	public

	function add($key, $count = 1)
	{
		$this->xnj->set($key, $this->xnj->value($key) + $count);
		return $xnj;
	}

	public

	function rem($key, $count = 1)
	{
		$this->xnj->set($key, $this->xnj->value($key) - $count);
		return $xnj;
	}

	public

	function div($key, $count = 1)
	{
		$this->xnj->set($key, $this->xnj->value($key) / $count);
		return $xnj;
	}

	public

	function mul($key, $count = 1)
	{
		$this->xnj->set($key, $this->xnj->value($key) * $count);
		return $xnj;
	}

	public

	function pow($key, $count = 1)
	{
		$this->xnj->set($key, $this->xnj->value($key) * *$count);
		return $xnj;
	}

	public

	function rect($key, $count = 1)
	{
		$this->xnj->set($key, $this->xnj->value($key) % $count);
		return $xnj;
	}

	public

	function calc($key, $calc)
	{
		$this->xnj->set($key, XNCalc::calc($calc, ['x' => $this->xnj->value($key) ]));
		return $xnj;
	}

	public

	function join($key, $data)
	{
		$this->xnj->set($key, $this->xnj->value($key) . $data);
		return $xnj;
	}
}

class XNJsonProMath

{
	private $xnj;
	public

	function __construct($xnj)
	{
		$this->xnj = $xnj;
	}

	public

	function add($key, $count = 1)
	{
		$this->xnj->set($key, XNProCalc::add($this->xnj->value($key) , $count));
		return $xnj;
	}

	public

	function rem($key, $count = 1)
	{
		$this->xnj->set($key, XNProCalc::rem($this->xnj->value($key) , $count));
		return $xnj;
	}

	public

	function mul($key, $count = 1)
	{
		$this->xnj->set($key, XNProCalc::mul($this->xnj->value($key) , $count));
		return $xnj;
	}

	public

	function div($key, $count = 1)
	{
		$this->xnj->set($key, XNProCalc::div($this->xnj->value($key) , $count));
		return $xnj;
	}

	public

	function rect($key, $count = 1)
	{
		$this->xnj->set($key, XNProCalc::rect($this->xnj->value($key) , $count));
		return $xnj;
	}

	public

	function pow($key, $count = 1)
	{
		$this->xnj->set($key, XNProCalc::pow($this->xnj->value($key) , $count));
		return $xnj;
	}

	public

	function calc($key, $calc)
	{
		$this->xnj->set($key, XNProCalc::calc($calc, ['x' => $this->xnj->value($key) ]));
		return $xnj;
	}
}

class XNJsonString

{
	private $data;
	public $math, $proMath;

	public

	function __construct($data = ',')
	{
		$this->data = $data;
		$this->math = new XNJsonMath($this);
		$this->proMath = new XNJsonProMath($this);
	}

	public

	function convert($file)
	{
		fput($file, $this->data);
		return new XNJsonFile($file);
	}

	public

	function reset()
	{
		$this->data = ',';
		return $this;
	}

	public

	function get()
	{
		return $this->data;
	}

	public

	function close()
	{
		$this->data = null;
	}

	public

	function __toString()
	{
		return $this->data;
	}

	private
	function encode($data)
	{
		$type = gettype($data);
		switch ($type) {
		case "NULL":
			$type = 1;
			$data = '';
			break;

		case "boolean":
			if ($data) $type = 2;
			else $type = 3;
			$data = '';
			break;

		case "integer":
			$type = 4;
			break;

		case "float":
			$type = 5;
			break;

		case "double":
			$type = 6;
			break;

		case "string":
			$type = 7;
			break;

		case "array":
		case "object":
			$type = 8;
			$data = serialize($data);
			break;

		default:
			new XNError("XNJson", "invalid data type");
			return false;
		}

		$zdata = zlib_encode($data, 31);
		if (strlen($zdata) < strlen($data)) {
			$data = $zdata;
			$type+= 8;
		}

		$data = base64url_encode(chr($type) . $data);
		$size = base_convert(strlen($data) , 10, 16);
		if (strlen($size) % 2 == 1) $size = "0$size";
		$size = base64url_encode(hex2bin($size));
		return $size . ':' . $data;
	}

	private
	function decode($data)
	{
		$data = explode(':', $data);
		$data = end($data);
		$data = base64url_decode($data);
		$type = ord($data);
		$data = substr($data, 1);
		if ($type > 8) {
			$data = zlib_decode($data);
			$type-= 8;
		}

		switch ($type) {
		case 1:
			return null;
			break;

		case 2:
			return true;
			break;

		case 3:
			return false;
			break;

		case 4:
			return (int)$data;
			break;

		case 5:
			return (float)$data;
			break;

		case 6:
			return (double)$data;
			break;

		case 7:
			return (string)$data;
			break;

		case 8:
			return unserialize($data);
		}
	}

	private
	function elencode($key, $value)
	{
		$data = "$key.$value";
		$size = base_convert(strlen($data) , 10, 16);
		if (strlen($size) % 2 == 1) $size = "0$size";
		$size = base64url_encode(hex2bin($size));
		return "$size;$data";
	}

	private
	function eldecode($code)
	{
		return explode('.', explode(";", $code) [1]);
	}

	private
	function sizedecode($size)
	{
		return base_convert(bin2hex(base64url_decode($size)) , 16, 10);
	}

	public

	function value($key)
	{
		$key = ';' . $this->encode($key) . '.';
		$p = strpos($this->data, $key);
		if ($p === false || $p == - 1) return false;
		$p+= strlen($key);
		$size = '';
		while (($h = $this->data[$p++]) !== ':') $size.= $h;
		$size = $this->sizedecode($size);
		return $this->decode(substr($this->data, $p, $size));
	}

	public

	function key($value)
	{
		$value = '.' . $this->encode($value) . ',';
		$p = strpos($this->data, $value);
		if ($p === false || $p == - 1) return false;
		$key = '';
		while (($h = $this->data[$p--]) !== ':') $key = $h . $key;
		return $this->decode($key);
	}

	public

	function iskey($key)
	{
		$key = ';' . $this->encode($key) . '.';
		$p = strpos($this->data, $key);
		return $p != - 1 && $p !== false;
	}

	public

	function isvalue($value)
	{
		$value = '.' . $this->encode($value) . ',';
		$p = strpos($this->data, $key);
		return $p != - 1 && $p !== false;
	}

	public

	function type($key)
	{
		return $this->iskey($key) ? "key" : $this->isvalue($key) ? "value" : false;
	}

	public

	function keys($value)
	{
		$values = [];
		$data = $this->data;
		$value = '.' . $this->encode($value) . ',';
		$vallen = strlen($value) - 1;
		while ($data != ',') {
			$p = strpos($data, $value);
			if ($p === false || $p == - 1) break;

			$pp = $p;
			$key = '';
			while (($h = $data[$p--]) !== ':') $key = $h . $key;
			$data = substr($data, $pp + $vallen);
			$values[] = $this->decode($key);
		}

		return $values;
	}

	private
	function replace($key, $value)
	{
		$key = $this->encode($key);
		$value = $this->encode($value);
		$el2 = $this->elencode($key, $value);
		$ky = ';' . $key . '.';
		$p = strpos($this->data, $ky) + strlen($ky);
		$size = '';
		while (($h = $this->data[$p++]) !== ':') $size.= $h;
		$sizee = $size;
		$size = $this->sizedecode($size);
		$value = $sizee . ':' . substr($this->data, $p, $size);
		$el1 = $this->elencode($key, $value);
		$this->data = str_replace($el1, $el2, $this->data);
		return $this;
	}

	private
	function add($key, $value)
	{
		$key = $this->encode($key);
		$value = $this->encode($value);
		$el = $this->elencode($key, $value);
		$this->data.= "$el,";
		return $this;
	}

	public

	function set($key, $value)
	{
		if (self::iskey($key)) $this->replace($key, $value);
		else $this->add($key, $value);
		return $this;
	}

	public

	function array()
	{
		$data = explode(',', substr($this->data, 1, -1));
		foreach($data as & $dat) {
			$dat = $this->eldecode($dat);
			$dat[0] = $this->decode($dat[0]);
			$dat[1] = $this->decode($dat[1]);
		}

		return $data;
	}

	public

	function count()
	{
		return count(explode(',', $this->data)) - 2;
	}

	public

	function list($list)
	{
		foreach((array)$list as $key => $value) $this->set($key, $value);
		return $this;
	}
}

class XNJsonFile

{
	private $file;
	public $math, $proMath;

	public

	function __construct($file)
	{
		$this->file = $file;
		$this->math = new XNJsonMath($this);
		$this->proMath = new XNJsonProMath($this);
		if (!file_exists($file)) fput($file, ',');
	}

	public

	function convert()
	{
		return new XNJsonString(fget($this->file));
	}

	public

	function reset()
	{
		fput($this->file, ',');
		return $this;
	}

	public

	function get()
	{
		return fget($this->file);
	}

	public

	function close()
	{
		$this->file = null;
	}

	public

	function __toString()
	{
		return fget($this->file);
	}

	public

	function getFile()
	{
		return $this->file;
	}

	private
	function encode($data)
	{
		$type = gettype($data);
		switch ($type) {
		case "NULL":
			$type = 1;
			$data = '';
			break;

		case "boolean":
			if ($data) $type = 2;
			else $type = 3;
			$data = '';
			break;

		case "integer":
			$type = 4;
			break;

		case "float":
			$type = 5;
			break;

		case "double":
			$type = 6;
			break;

		case "string":
			$type = 7;
			break;

		case "array":
		case "object":
			$type = 8;
			$data = serialize($data);
			break;

		default:
			new XNError("XNJson", "invalid data type");
			return false;
		}

		$zdata = zlib_encode($data, 31);
		if (strlen($zdata) < strlen($data)) {
			$data = $zdata;
			$type+= 8;
		}

		$data = base64url_encode(chr($type) . $data);
		$size = base_convert(strlen($data) , 10, 16);
		if (strlen($size) % 2 == 1) $size = "0$size";
		$size = base64url_encode(hex2bin($size));
		return $size . ':' . $data;
	}

	private
	function decode($data)
	{
		$data = explode(':', $data);
		$data = end($data);
		$data = base64url_decode($data);
		$type = ord($data);
		$data = substr($data, 1);
		if ($type > 8) {
			$data = zlib_decode($data);
			$type-= 8;
		}

		switch ($type) {
		case 1:
			return null;
			break;

		case 2:
			return true;
			break;

		case 3:
			return false;
			break;

		case 4:
			return (int)$data;
			break;

		case 5:
			return (float)$data;
			break;

		case 6:
			return (double)$data;
			break;

		case 7:
			return (string)$data;
			break;

		case 8:
			return unserialize($data);
		}
	}

	private
	function elencode($key, $value)
	{
		$data = "$key.$value";
		$size = base_convert(strlen($data) , 10, 16);
		if (strlen($size) % 2 == 1) $size = "0$size";
		$size = base64url_encode(hex2bin($size));
		return "$size;$data";
	}

	private
	function eldecode($code)
	{
		return explode('.', explode(";", $code) [1]);
	}

	private
	function sizedecode($size)
	{
		return base_convert(bin2hex(base64url_decode($size)) , 16, 10);
	}

	public

	function key($value)
	{
		$f = fopen($this->file, 'r');
		fseek($f, 1);
		$value = $this->encode($value) . ',';
		$l = strlen($value);
		$p = '';
		$m = 0;
		$o = 1;
		$s = '';
		while (($h = fgetc($f)) !== false) {
			if ($o == 2) {
				$p--;
				if ($m == $l - 1) break;

				if ($value[$m] == $h) {
					$m++;
				}
				else {
					$m = 0;
					fseek($f, $p, SEEK_CUR);
					$o = 1;
					$p = '';
					$s = '';
				}
			}
			elseif ($o == 3) {
				$p--;
				if ($h == ':') {
					$o = 2;
					$p-= ($s = $this->sizedecode($s)) + 1;
					$key = ftell($f);
					fseek($f, $s + 1, SEEK_CUR);
				}
				else {
					$s.= $h;
				}
			}
			else {
				if ($h == ';') {
					$o = 3;
					$p = $this->sizedecode($p);
				}
				else {
					$p.= $h;
				}
			}
		}

		if ($h === false) return false;
		fseek($f, $key);
		$key = fread($f, $s);
		fclose($f);
		return $this->decode($key);
	}

	public

	function value($key)
	{
		$f = fopen($this->file, 'r');
		fseek($f, 1);
		$key = $this->encode($key) . '.';
		$l = strlen($key);
		$p = '';
		$m = 0;
		$o = false;
		while (($h = fgetc($f)) !== false) {
			if ($o) {
				$p--;
				if ($m == $l - 1) break;

				if ($key[$m] == $h) {
					$m++;
				}
				else {
					$m = 0;
					$o = false;
					fseek($f, $p, SEEK_CUR);
					$p = '';
				}
			}
			else {
				if ($h == ';') {
					$o = true;
					$p = $this->sizedecode($p);
				}
				else {
					$p.= $h;
				}
			}
		}

		if ($h === false) return false;
		$value = fread($f, $p);
		fclose($f);
		return $this->decode($value);
	}

	public

	function keys($value)
	{
		$f = fopen($this->file, 'r');
		fseek($f, 1);
		$value = $this->encode($value) . ',';
		$l = strlen($value);
		$p = '';
		$m = 0;
		$o = 1;
		$s = '';
		$keys = [];
		while (($h = fgetc($f)) !== false) {
			if ($o == 2) {
				$p--;
				if ($m == $l - 1) {
					$m = 0;
					$o = 1;
					$p = '';
					$s = '';
					$keys[] = $this->decode($key);
				}
				elseif ($value[$m] == $h) {
					$m++;
				}
				else {
					$m = 0;
					@fseek($f, $p, SEEK_CUR);
					$o = 1;
					$p = '';
					$s = '';
				}
			}
			elseif ($o == 3) {
				if ($h == ':') {
					$o = 2;
					$p-= ($s = $this->sizedecode($s)) + 1;
					$key = fread($f, $s);
					fseek($f, 1, SEEK_CUR);
				}
				else {
					$s.= $h;
				}
			}
			else {
				if ($h == ';') {
					$o = 3;
					$p = $this->sizedecode($p);
				}
				else {
					$p.= $h;
				}
			}
		}

		fclose($f);
		return $keys;
	}

	public

	function iskey($key)
	{
		$f = fopen($this->file, 'r');
		fseek($f, 1);
		$key = $this->encode($key) . '.';
		$l = strlen($key);
		$p = '';
		$m = 0;
		$o = false;
		while (($h = fgetc($f)) !== false) {
			if ($o) {
				$p--;
				if ($m == $l - 1) break;

				if ($key[$m] == $h) {
					$m++;
				}
				else {
					$m = 0;
					$o = false;
					fseek($f, $p, SEEK_CUR);
					$p = '';
				}
			}
			else {
				if ($h == ';') {
					$o = true;
					$p = $this->sizedecode($p);
				}
				else {
					$p.= $h;
				}
			}
		}

		if ($h === false) return false;
		fclose($f);
		return true;
	}

	public

	function isvalue($value)
	{
		$f = fopen($this->file, 'r');
		fseek($f, 1);
		$value = $this->encode($value) . ',';
		$l = strlen($value);
		$p = '';
		$m = 0;
		$o = 1;
		$s = '';
		while (($h = fgetc($f)) !== false) {
			if ($o == 2) {
				$p--;
				if ($m == $l - 1) break;

				if ($value[$m] == $h) {
					$m++;
				}
				else {
					$m = 0;
					fseek($f, $p, SEEK_CUR);
					$o = 1;
					$p = '';
					$s = '';
				}
			}
			elseif ($o == 3) {
				if ($h == ':') {
					$o = 2;
					$p-= ($s = $this->sizedecode($s)) + 1;
					fseek($f, $s + 1, SEEK_CUR);
				}
				else {
					$s.= $h;
				}
			}
			else {
				if ($h == ';') {
					$o = 3;
					$p = $this->sizedecode($p);
				}
				else {
					$p.= $h;
				}
			}
		}

		if ($h === false) return false;
		fclose($f);
		return true;
	}

	public

	function type($key)
	{
		return $this->iskey($key) ? "key" : $this->isvalue($key) ? "value" : false;
	}

	private
	function replace($key, $value)
	{
		$key = $this->encode($key) . '.';
		$value = $this->encode($value) . ',';
		$el = $this->elencode($key, $value);
		$f = fopen($this->file, 'r');
		$random = rand(0, 999999999) . rand(0, 999999999);
		$t = fopen("xn$random.$this->file.log", 'w');
		fwrite($t, ',');
		$l = strlen($key);
		$p = '';
		$m = 0;
		$o = false;
		while (($h = fgetc($f)) !== false) {
			if ($o) {
				$p--;
				if ($m == $l - 1) {
					$m = 0;
					fwrite($t, $this->elencode(substr($key, 0, -1) , $value));
					fseek($f, $p + 1, SEEK_CUR);
					break;
				}
				elseif ($key[$m] == $h) {
					$m++;
				}
				else {
					$m = 0;
					$o = false;
					fwrite($t, substr($key, 0, $m) . fread($f, $p) . ',');
					$p = '';
				}
			}
			else {
				if ($h == ';') {
					$o = true;
					$p = $this->sizedecode($p);
				}
				else {
					$p.= $h;
				}
			}
		}

		$g = ftell($f);
		fseek($f, 0, SEEK_END);
		$u = ftell($f) - $g;
		if ($u > 0) {
			fseek($f, $g);
			fwrite($t, fread($f, $u));
		}

		fclose($f);
		fclose($t);
		copy("xn$random.$this->file.log", $this->file);
		unlink("xn$random.$this->file.log");
	}

	private
	function add($key, $value)
	{
		$key = $this->encode($key);
		$value = $this->encode($value);
		$el = $this->elencode($key, $value);
		$f = fopen($this->file, 'a');
		fwrite($f, "$el,");
		fclose($f);
	}

	public

	function set($key, $value)
	{
		if ($this->iskey($key)) $this->replace($key, $value);
		else $this->add($key, $value);
		return $this;
	}

	public

	function array()
	{
		$f = fopen($this->file, 'r');
		fseek($f, 1);
		$arr = [];
		$p = '';
		while (($h = fgetc($f)) !== false) {
			if ($h == ';') {
				$p = $this->sizedecode($p);
				$ar = $this->eldecode(';' . fread($f, $p));
				$ar[0] = $this->decode($ar[0]);
				$ar[1] = $this->decode($ar[1]);
				$arr[] = $ar;
				fseek($f, 1, SEEK_CUR);
				$p = '';
			}
			else {
				$p.= $h;
			}
		}

		return $arr;
	}

	public

	function count()
	{
		$f = fopen($this->file, 'r');
		fseek($f, 1);
		$c = 0;
		$p = '';
		while (($h = fgetc($f)) !== false) {
			if ($h == ';') {
				$p = $this->sizedecode($p);
				fseek($f, $p + 1, SEEK_CUR);
				$c++;
				$p = '';
			}
			else {
				$p.= $h;
			}
		}

		return $c;
	}

	public

	function list($list)
	{
		foreach((array)$list as $key => $value) $this->set($key, $value);
		return $this;
	}
}

function XNJson($j = ',', $file = false)
{
	if (is_array($j)) {
		if ($file && $file != '.' && $file != '..') $xnj = new XNJsonFile($file);
		else $xnj = new XNJsonString();
		$xnj->list($j);
		return $xnj;
	}

	if (!$file && $j != '.' && $j != '..' && file_exists($j)) return new XNJsonFile($j);
	if ($file) return new XNJsonFile($j);
	return new XNJsonString($j);
}

// Calc-------------------------------------

class XNProCalc

{

	// consts variables

	static
	function PI($l = - 1)
	{
		$pi = zlib_decode(base64_decode("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"));
		if ($l < 0) return $pi;
		if ($l == 0) return substr($pi, 1);
		return substr($pi, 0, $l + 2);
	}

	static
	function PHI($l = - 1)
	{
		$phi = zlib_decode(base64_decode("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"));
		if ($l < 0) return $phi;
		if ($l == 0) return substr($phi, 1);
		return substr($phi, 0, $l + 2);
	}

	// system functions

	static
	function _check($a)
	{
		if (!is_numeric($a)) {
			if (strlen($a) > 20) $a = substr($a, 0, 12) . '...' . substr($a, -5);
			new XNError("XNProCalc", "invalid number \"$a\".");
			return false;
		}

		return true;
	}

	static
	function _view($a)
	{
		if ($a[0] == '-') return true;
		return false;
	}

	static
	function abs($a)
	{
		if ($a[0] == '-' || $a[0] == '+') return substr($a, 1);
		return $a;
	}

	static
	function _change($a)
	{
		if ($a == 0) return '0';
		if ($a[0] == '-') return substr($a, 1);
		if ($a[0] == '+') return '-' . substr($a, 1);
		return '-' . $a;
	}

	static
	function _get0($a)
	{
		$c = 0;
		$k = 0;
		while (@$a[$c++] === '0') $k++;
		return substr($a, $k);
	}

	static
	function _get1($a)
	{
		$c = strlen($a) - 1;
		$k = 0;
		while (@$a[$c--] === '0') $k++;
		return substr($a, 0, strlen($a) - $k);
	}

	static
	function _get2($a)
	{
		$a = self::_mo($a);
		$a[1] = isset($a[1]) ? $a[1] : '0';
		$a[0] = self::_get0($a[0]);
		$a[1] = self::_get1($a[1]);
		if ($a[0] && $a[1]) return "{$a[0]}.{$a[1]}";
		if ($a[1]) return "0.{$a[1]}";
		if ($a[0]) return "{$a[0]}";
		return "0";
	}

	static
	function _get3($a)
	{
		if (self::_view($a)) return '-' . self::_get2(self::abs($a));
		return self::_get2(self::abs($a));
	}

	static
	function _get($a)
	{
		if (!self::_check($a)) return false;
		return self::_get3($a);
	}

	static
	function _set0($a, $b)
	{
		$l = strlen($b) - strlen($a);
		if ($l <= 0) return $a;
		else return str_repeat('0', $l) . $a;
	}

	static
	function _set1($a, $b)
	{
		$l = strlen($b) - strlen($a);
		if ($l <= 0) return $a;
		else return $a . str_repeat('0', $l);
	}

	static
	function _set2($a, $b)
	{
		$a = self::_mo($a);
		$b = self::_mo($b);
		if (!isset($a[1]) && isset($b[1])) {
			$a[1] = '0';
		}

		if (isset($a[1])) $a[1] = self::_set1($a[1], @$b[1]);
		$a[0] = self::_set0($a[0], $b[0]);
		if (!isset($a[1])) return "{$a[0]}";
		return "{$a[0]}.{$a[1]}";
	}

	static
	function _set3($a, $b)
	{
		if (self::_view($a) && self::_view($b)) return '-' . self::_set2(self::abs($a) , self::abs($b));
		if (!self::_view($a) && self::_view($b)) return self::_set2(self::abs($a) , self::abs($b));
		if (self::_view($a) && !self::_view($b)) return '-' . self::_set2(self::abs($a) , self::abs($b));
		return self::_set2(self::abs($a) , self::abs($b));
	}

	static
	function _set($a, $b)
	{
		if (!self::_check($a)) return false;
		if (!self::_check($b)) return false;
		return self::_set3($a, $b);
	}

	static
	function _full($a, $b)
	{
		if (!self::_check($a)) return false;
		if (!self::_check($b)) return false;
		return self::_set(self::_get($a) , self::_get($b));
	}

	static
	function _setfull(&$a, &$b)
	{
		if (!self::_check($a)) return false;
		if (!self::_check($b)) return false;
		$a = self::_get($a);
		$b = self::_get($b);
		$a = self::_set($a, $b);
		$b = self::_set($b, $a);
	}

	static
	function _mo($a)
	{
		return explode('.', $a);
	}

	static
	function _lm($a)
	{
		return strpos($a, '.');
	}

	static
	function _im($a)
	{
		$p = self::_lm($a);
		return $p !== false && $p != - 1;
	}

	static
	function _nm($a)
	{
		return str_replace('.', '', $a);
	}

	static
	function _st($a, $b)
	{
		if (!isset($a[$b]) || $b == 0) return $a;
		return substr_replace($a, '.', $b, 0);
	}

	static
	function _iz($a)
	{
		$a = $a[strlen($a) - 1];
		return $a == '0' || $a == '2' || $a == '4' || $a == '6' || $a == '8';
	}

	static
	function _if($a)
	{
		$a = $a[strlen($a) - 1];
		return $a == '1' || $a == '3' || $a == '5' || $a == '7' || $a == '9';
	}

	static
	function _so($a, $b)
	{
		$l = strlen($a) % $b;
		if ($l == 0) return $a;
		else return str_repeat('0', $b - $l) . $a;
	}

	static
	function _pl($a)
	{
		$l = '0';
		while ($a != $l) {
			$l = $a;
			$a = str_replace(['--', '-+', '+-', '++'], ['+', '-', '-', '+'], $a);
		}

		return $a;
	}

	// retry calc functions

	static
	function _powTen0($a, $b)
	{
		$p = self::_lm($a);
		$i = $p === false || $p == - 1;
		$a = self::_nm($a);
		$l = strlen($a);
		if ($i) $s = strlen($a) + $b;
		else $s = $p + $b;
		if ($s == $l) return $a;
		if ($s > $l) return $a . str_repeat('0', $s - $l);
		if ($s == 0) return "0.$a";
		if ($s < 0) return "0." . str_repeat('0', abs($s)) . $a;
		return substr_replace($a, ".", $s, 0);
	}

	static
	function _powTen1($a, $b)
	{
		if (self::_view($a)) return '-' . self::_powTen0(self::abs($a) , $b);
		return self::_powTen0(self::abs($a) , $b);
	}

	static
	function powTen($a, $b)
	{
		if (!self::_check($a)) return false;
		if (!self::_check($b)) return false;
		return self::_get(self::_powTen1($a, $b));
	}

	static
	function _mulTwo0($a)
	{
		$a = subsplit($a, 13);
		$c = count($a) - 1;
		while ($c >= 0) {
			$a[$c]*= 2;
			$k = 0;
			while (@$a[$c - $k] > 9999999999999) {
				$a[$c - $k - 1]+= 1;
				$a[$c - $k]-= 10000000000000;
				$k++;
			}

			$a[$c] = self::_so($a[$c], 13);
			$c--;
		}

		return implode('', $a);
	}

	static
	function _mulTwo1($a)
	{
		$a = self::_mo($a);
		$a[0] = self::_so($a[0], 13);
		$a[0] = self::_mulTwo0("0000000000000{$a[0]}");
		if (isset($a[1])) {
			$l = strlen($a[1]);
			$a[1] = self::_so($a[1], 13);
			$a[1] = self::_mulTwo0("0000000000000{$a[1]}");
			$a[2] = substr($a[1], 0, -$l);
			$a[1] = substr($a[1], -$l);
			if ($a[2] > 0) $a[0] = self::_add0("0000000000000{$a[0]}", "0000000000000" . str_repeat('0', strlen($a[0]) - 1) . '1');
			return "{$a[0]}.{$a[1]}";
		}

		return $a[0];
	}

	static
	function _mulTwo2($a)
	{
		if (self::_view($a)) return '-' . self::_mulTwo1(self::abs($a));
		return self::_mulTwo1(self::abs($a));
	}

	static
	function mulTwo($a)
	{
		if (!self::_check($a)) return false;
		return self::_get3(self::_mulTwo2(self::_get3($a)));
	}

	static
	function _divTwo0($a)
	{
		$s = '';
		$c = 0;
		$k = false;
		while (isset($a[$c])) {
			$h = substr($a, $c, 14);
			$b = floor($h / 2);
			$b = $k ? $b + 50000000000000 : $b;
			$s.= self::_so($b, 14);
			if ($h % 2 == 1) $k = true;
			$c+= 14;
		}

		if ($k) $s.= '5';
		return $s;
	}

	static
	function _divTwo1($a)
	{
		$p = self::_lm($a);
		$a = self::_nm($a);
		if ($p === false || $p == - 1) $p = strlen($a);
		$l = strlen($a);
		$a = self::_so($a, 14);
		$p+= strlen($a) - $l;
		$a = self::_divTwo0($a);
		return self::_st($a, $p);
	}

	static
	function _divTwo2($a)
	{
		if (self::_view($a)) return '-' . self::_divTwo1(self::abs($a));
		return self::_divTwo1(self::abs($a));
	}

	static
	function divTwo($a)
	{
		return self::_get(self::_divTwo2(self::_get($a)));
	}

	static
	function _powTwo0($a)
	{
		$a = subsplit($a, 1);
		$x = false;
		$c = $d = count($a) - 1;
		$k = 0;
		while ($c >= 0) {
			$y = '';
			$e = $d;
			$s = 0;
			while ($e >= 0) {
				$t = $a[$c] * $a[$e] + $s;
				$s = floor($t / 10);
				$t-= $s * 10;
				$y = $t . $y;
				$e--;
			}

			$c--;
			$t = $s . $y . ($k ? str_repeat('0', $k) : '');
			$x = $x ? self::add($x, $t) : $t;
			$k++;
		}

		return $x;
	}

	static
	function _powTwo1($a)
	{
		$p = self::_lm($a);
		if (!$p) return self::_powTwo0($a);
		$p = strlen($a) - $p - 1;
		$p*= 2;
		$a = self::_nm($a);
		$a = '0' . self::_powTwo0($a);
		return self::_st($a, strlen($a) - $p);
	}

	static
	function _powTwo2($a)
	{
		return self::_powTwo1(self::abs($a));
	}

	static
	function powTwo($a)
	{
		if (!self::_check($a)) return false;
		return self::_get3(self::_powTwo2(self::_get3($a)));
	}

	// set functions

	static
	function floor($a)
	{
		if (!self::_check($a)) return false;
		return explode('.', "$a") [0];
	}

	static
	function ceil($a)
	{
		if (!self::_check($a)) return false;
		$a = explode('.', "$a");
		return isset($a[1]) ? self::add($a[0], '1') : $a[0];
	}

	static
	function round($a)
	{
		if (!self::_check($a)) return false;
		$a = explode('.', "$a");
		return isset($a[1]) && $a[1][0] >= 5 ? self::add($a[0], '1') : $a[0];
	}

	// calc functions

	static
	function _add0($a, $b)
	{
		$a = subsplit("0000000000000$a", 13);
		$b = subsplit("0000000000000$b", 13);
		$c = count($a) - 1;
		while ($c >= 0) {
			$a[$c]+= $b[$c];
			$k = 0;
			while (isset($a[$c - $k]) && $a[$c - $k] > 9999999999999) {
				$a[$c - $k - 1]+= 1;
				$a[$c - $k]-= 10000000000000;
				$k++;
			}

			$a[$c] = self::_so($a[$c], 13);
			$c--;
		}

		return implode('', $a);
	}

	static
	function _add1($a, $b)
	{
		$o = self::_lm($a);
		$p = $o + (13 - (strlen($a) - 1) % 13);
		$a = self::_so(self::_nm($a) , 13);
		$b = self::_so(self::_nm($b) , 13);
		if ($o !== false && $o !== - 1) return self::_st(self::_add0($a, $b) , $p);
		return self::_add0($a, $b);
	}

	static
	function _add2($a, $b)
	{
		if (self::_view($a) && self::_view($b)) return '-' . self::_add1(self::abs($a) , self::abs($b));
		if (self::_view($a) && !self::_view($b)) return self::_rem1(self::abs($b) , self::abs($a));
		if (!self::_view($a) && self::_view($b)) return self::_rem1(self::abs($a) , self::abs($b));
		return self::_add1(self::abs($a) , self::abs($b));
	}

	static
	function add($a, $b)
	{
		if (!self::_check($a)) return false;
		if (!self::_check($b)) return false;
		self::_setfull($a, $b);
		$r = $a == 0 ? $b : $b == 0 ? $a : self::_add2($a, $b);
		return self::_get3($r);
	}

	public

	function _rem0($a, $b)
	{
		$a = subsplit($a, 13);
		$b = subsplit($b, 13);
		$c = count($a) - 1;
		while ($c >= 0) {
			$a[$c]-= $b[$c];
			$k = 0;
			while (isset($a[$c - $k]) && $a[$c - $k] < 0) {
				$a[$c - $k - 1]-= 1;
				$a[$c - $k]+= 10000000000000;
				$k++;
			}

			$a[$c] = self::_so($a[$c], 13);
			$c--;
		}

		return implode('', $a);
	}

	static
	function _rem1($a, $b)
	{
		$o = self::_lm($a);
		$p = $o + (13 - (strlen($a) - 1) % 13);
		$a = self::_so(self::_nm($a) , 13);
		$b = self::_so(self::_nm($b) , 13);
		if ($o !== false && $o !== - 1) return self::_st(self::_add0($a, $b) , $p);
		return self::_rem0($a, $b);
	}

	static
	function _rem2($a, $b)
	{
		if (self::_view($a) && self::_view($b)) return '-' . self::_rem1(self::abs($a) , self::abs($b));
		if (self::_view($a) && !self::_view($b)) return '-' . self::_add1(self::abs($a) , self::abs($b));
		if (!self::_view($a) && self::_view($b)) return self::_add1(self::abs($a) , self::abs($b));
		return self::_rem1(self::abs($a) , self::abs($b));
	}

	static
	function _rem3($a, $b)
	{
		if ($a < $b) {
			return '-' . self::_rem2($b, $a);
		}

		return self::_rem2($a, $b);
	}

	static
	function rem($a, $b)
	{
		if (!self::_check($a)) return false;
		if (!self::_check($b)) return false;
		self::_setfull($a, $b);
		$r = $a == 0 ? self::_change($b) : $b == 0 ? $a : self::_rem3($a, $b);
		return self::_pl(self::_get3($r));
	}

	static
	function _mul0($a, $b)
	{
		$a = subsplit($a, 1);
		$b = subsplit($b, 1);
		$x = false;
		$c = $d = count($a) - 1;
		$k = 0;
		while ($c >= 0) {
			$y = '';
			$e = $d;
			$s = 0;
			while ($e >= 0) {
				$t = $a[$c] * $b[$e] + $s;
				$s = floor($t / 10);
				$t-= $s * 10;
				$y = $t . $y;
				$e--;
			}

			$c--;
			$t = $s . $y . ($k ? str_repeat('0', $k) : '');
			$x = $x ? self::add($x, $t) : $t;
			$k++;
		}

		return $x;
	}

	static
	function _mul1($a, $b)
	{
		$ap = self::_lm($a);
		$bp = self::_lm($b);
		if (!$ap) return self::_mul0($a, $b);
		$ap = strlen($a) - $ap - 1;
		$bp = strlen($b) - $bp - 1;
		$p = $ap + $bp;
		$a = self::_nm($a);
		$b = self::_nm($b);
		$a = '0' . self::_mul0($a, $b);
		return self::_st($a, strlen($a) - $p);
	}

	static
	function _mul2($a, $b)
	{
		if (self::_view($a) && self::_view($b)) return self::_mul1(self::abs($a) , self::abs($b));
		if (!self::_view($a) && self::_view($b)) return '-' . self::_mul1(self::abs($a) , self::abs($b));
		if (self::_view($a) && !self::_view($b)) return '-' . self::_mul1(self::abs($a) , self::abs($b));
		return self::_mul1(self::abs($a) , self::abs($b));
	}

	static
	function mul($a, $b)
	{
		if (!self::_check($a)) return false;
		if (!self::_check($b)) return false;
		self::_setfull($a, $b);
		$r = $b == 0 ? 0 : $b == 1 ? $a : $b == 2 ? self::mulTwo($a) : $a == 2 ? self::mulTwo($b) : $a == 0 ? 0 : $a == 1 ? $b : self::_mul2($a, $b);
		return self::_get3($r);
	}

	static
	function _rand0($a)
	{
		$rand = "0.";
		$b = floor($a / 9);
		for ($c = 0; $c < $b; $c++) {
			$rand.= self::_so(rand(0, 999999999) , 9);
		}

		if ($a % 9 == 0) return $rand;
		return $rand . self::_so(rand(0, str_repeat('9', $a % 9)) , $a % 9);
	}

	static
	function _rand1($a, $b)
	{
		$c = self::rem($a, $b);
		$d = self::_rand0(strlen($a));
		return self::add(self::floor(self::mul(self::add($c, '1') , $d)) , $b);
	}

	static
	function _rand2($a, $b)
	{
		$p = self::_lm($a);
		if (!$p) return self::_rand1($a, $b);
		$p = strlen($a) - $p - 1;
		$a = self::_nm($a);
		$b = self::_nm($b);
		$a = '0' . self::_rand1($a, $b);
		return self::_st($a, strlen($a) - $p);
	}

	static
	function _rand3($b, $a)
	{
		if ($a > $b) return self::_rand2($a, $b);
		return self::_rand2($b, $a);
	}

	static
	function _rand4($a, $b)
	{
		if (self::_view($a) && self::_view($b)) return '-' . self::_rand3(self::abs($a) , self::abs($b));
		if (!self::_view($a) && self::_view($b)) {
			return self::_change(self::rem(self::_rand3('0', self::add(self::abs($a) , self::abs($b))) , $a));
		}

		if (self::_view($a) && !self::_view($b)) {
			return self::_change(self::rem(self::_rand3('0', self::add(self::abs($a) , self::abs($b))) , $b));
		}

		return self::_rand3(self::abs($a) , self::abs($b));
	}

	static
	function rand($a, $b)
	{
		if (!self::_check($a)) return false;
		if (!self::_check($b)) return false;
		self::_setfull($a, $b);
		$r = $a == $b ? $a : self::_rand4($a, $b);
		return self::_get($r);
	}

	static
	function _div0($a, $b)
	{
		if ($b > $a) return 0;
		if (($c = self::mulTwo($b)) > $a) return 1;
		if (self::mul($b, '3') > $a) return 2;
		if (($c = self::mulTwo($c)) > $a) return 3;
		if (self::mul($b, '5') > $a) return 4;
		if (self::mul($b, '6') > $a) return 5;
		if (self::mul($b, '7') > $a) return 6;
		if (self::mulTwo($c) > $a) return 7;
		if (self::mul($b, '9') > $a) return 8;
		return 9;
	}

	static
	function _div1($a, $b, $o = 0)
	{
		$a = subsplit($a, 1);
		$p = $r = $i = $d = '0';
		$c = count($a);
		while ($i < $c) {
			$d.= $a[$i];
			if ($d >= $b) {
				$p = self::_div0($d, $b);
				$d = self::rem($d, self::mul($p, $b));
				$r.= $p;
			}
			else $r.= '0';
			$i++;
		}

		if ($d == 0 || $o <= 0) return $r;
		$r.= '.';
		while ($d > 0 && $o > 0) {
			$d.= '0';
			if ($d >= $b) {
				$p = self::_div0($d, $b);
				$d = self::rem($d, self::mul($p, $b));
				$r.= $p;
			}
			else $r.= '0';
			$o--;
		}

		return $r;
	}

	static
	function _div2($a, $b, $c = 0)
	{
		$a = self::_nm($a);
		$b = self::_nm($b);
		if ($c < 0) $c = 0;
		return self::_div1($a, $b, $c);
	}

	static
	function _div3($a, $b, $c = 0)
	{
		if (self::_view($a) && self::_view($b)) return self::_div2(self::abs($a) , self::abs($b) , $c);
		if (self::_view($a) && !self::_view($b)) return '-' . self::_div2(self::abs($a) , self::abs($b) , $c);
		if (!self::_view($a) && self::_view($b)) return '-' . self::_div2(self::abs($a) , self::abs($b) , $c);
		return self::_div2(self::abs($a) , self::abs($b) , $c);
	}

	static
	function div($a, $b, $c = 0)
	{
		if (!self::_check($a)) return false;
		if (!self::_check($b)) return false;
		self::_setfull($a, $b);
		if ($b == 0) {
			new XNError("XNProCalc", "not can div by Ziro");
			return false;
		}

		$r = $a == 0 ? 0 : $a == $b ? 1 : $b == 1 ? $a : self::_div3($a, $b, $c);
		return self::_get2($r);
	}

	static
	function _rest0($a, $b)
	{
		$a = subsplit($a, 1);
		$p = $r = $i = $d = '0';
		$c = count($a);
		while ($i < $c) {
			$d.= $a[$i];
			if ($d >= $b) {
				$p = self::_div0($d, $b);
				$d = self::rem($d, self::mul($p, $b));
				$r.= $p;
			}
			else $r.= '0';
			$i++;
		}

		return $d;
	}

	static
	function _rest1($a, $b)
	{
		$a = self::_nm($a);
		$b = self::_nm($b);
		return self::_rest0($a, $b);
	}

	static
	function _rest2($a, $b)
	{
		if (self::_view($a)) return '-' . self::_rest1(self::abs($a) , self::abs($b));
		return self::_rest1(self::abs($a) , self::abs($b));
	}

	static
	function rest($a, $b)
	{
		if (!self::_check($a)) return false;
		if (!self::_check($b)) return false;
		self::_setfull($a, $b);
		if ($b == 0) {
			new XNError("XNProCalc", "not can div by Ziro");
			return false;
		}

		$r = $a == 0 ? 0 : $b == 1 ? 0 : $a == $b ? 0 : self::_rest2($a, $b);
		return self::_get($r);
	}

	static
	function fact($a)
	{
		if (!self::_check($a)) return false;
		$r = '1';
		while ($a > 0) {
			echo "$r * $a = ";
			$r = self::mul($r, $a);
			echo "$r\n";
			$a = self::rem($a, '1');
		}

		return $r;
	}

	// run functions

	static
	function fromNumberString($a = '0')
	{
		if (!self::_check($a)) return false;
		return $a * 1;
	}

	static
	function toNumberString($a = 0)
	{
		if ("$a" == "INF") {
			if (strlen($a) > 20) $a = substr($a, 0, 12) . '...' . substr($a, -5);
			new XNError("XNProCalc", "this number is NAN");
			return false;
		}

		if ("$a" == "NAN") {
			if (strlen($a) > 20) $a = substr($a, 0, 12) . '...' . substr($a, -5);
			new XNError("XNProCalc", "this number is NAN");
			return false;
		}

		$a = explode('E', $a);
		if (!isset($a[1])) return "{$a[0]}";
		$a = self::powTen($a[0], $a[1]);
		return $a;
	}
}

class XNCalc

{

	// run functions

	static
	function calc($c)
	{

		// Number next to brackets

		$c = str_replace([' ', "\n"], '', $c);
		$c = preg_replace_callback('/([0-9\)\]])([a-zA-Z\(\[])/',
		function ($a)
		{
			return $a[1] . '*' . $a[2];
		}

		, $c);
		$l = '';
		while ($l != $c) {
			$l = $c;
			$p = strpos($c, '(');
		}

		return $c;
	}
}

function fact($n)
{
	$r = 1;
	if ($n >= 171) return INF;
	while ($n > 0) {
		$r*= $n--;
	}

	return $r;
}

// CFile----------------------------------------------

class XNColor

{
	static
	function init($color = 0)
	{
		return [$color & 0xff, ($color >> 8) & 0xff, ($color >> 16) & 0xff, ($color >> 24) & 0xff];
	}

	static
	function read($color = 0)
	{
		return ["red" => $color & 0xff, "green" => ($color >> 8) & 0xff, "blue" => ($color >> 16) & 0xff, "alpha" => ($color >> 24) & 0xff];
	}

	static
	function par($a = 0, $b = false, $c = false, $d = false)
	{
		if (is_array($a)) {
			$b = isset($a[1]) ? $a[1] : 0;
			$c = isset($a[2]) ? $a[2] : 0;
			$d = isset($a[3]) ? $a[3] : 0;
			$a = isset($a[0]) ? $a[0] : 0;
		}
		elseif ($a && gettype($a) == "string" && $b === false && $c === false && $d === false) {
			$r = @[][$a];
			if ($r === null) {
				$l = strlen($a);
				if ($l % 2 == 1 && $l != 3) {
					$a = substr($a, 1);
					$l--;
				}

				if ($l == 3) $a = $a[0] . $a[0] . $a[1] . $a[1] . $a[2] . $a[2];
				elseif ($l == 4) $a = $a[0] . $a[0] . $a[1] . $a[1] . $a[2] . $a[2] . $a[3] . $a[3];
				elseif ($l != 6 && $l != 8) {
					new XNError("XNColor", "Invalid hex color or color name.", 1);
					return false;
				}

				$d = isset($a[6]) ? hexdec($a[6] . $a[7]) : 0;
				$b = hexdec($a[2] . $a[3]);
				$c = hexdec($a[4] . $a[5]);
				$a = hexdec($a[0] . $a[1]);
				return [$a, $b, $c, $d];
			}

			return $r;
		}

		if (!is_numeric($a)) {
			new XNError("XNColor", "Parameters is not number.", 1);
			return false;
		}

		$a = $a && $a > - 1 ? $a % 256 : 0;
		$b = $b && $b > - 1 ? $b % 256 : 0;
		$c = $c && $c > - 1 ? $c % 256 : 0;
		$d = $d && $d > - 1 ? $d % 256 : 0;
		return [$a, $b, $c, $d];
	}

	static
	function get($a = 0, $b = false, $c = false, $d = false)
	{
		$color = self::par($a, $b, $c, $d);
		if ($color === false) return false;
		return $color[0] + ($color[1] << 8) + ($color[2] << 16) + ($color[3] << 24);
	}

	static
	function hex($a = 0, $b = false, $c = false, $d = false, $tag = true)
	{
		$color = self::par($a, $b, $c, $d);
		if ($color === false) return false;
		$last = [$color[0], $color[1], $color[2], $color[3]];
		$color[0] = dechex($color[0]);
		$color[1] = dechex($color[1]);
		$color[2] = dechex($color[2]);
		$color[3] = $color[3] ? dechex($color[3]) : false;
		$color[0] = $last[0] < 10 ? '0' . $color[0] : $color[0];
		$color[1] = $last[1] < 10 ? '0' . $color[1] : $color[1];
		$color[2] = $last[2] < 10 ? '0' . $color[2] : $color[2];
		$color[3] = $color[3] ? ($last[3] < 10 ? '0' . $color[3] : $color[3]) : false;
		if (!$color[3]) {
			if ($color[0][0] == $color[0][1] && $color[1][0] == $color[1][1] && $color[2][0] == $color[2][1]) return ($tag ? "#" : '') . $color[0][0] . $color[1][0] . $color[2][0];
			return ($tag ? "#" : '') . $color[0] . $color[1] . $color[2];
		}
		else {
			if ($color[0][0] == $color[0][1] && $color[1][0] == $color[1][1] && $color[2][0] == $color[2][1] && $color[3][0] == $color[3][1]) return ($tag ? "#" : '') . $color[0][0] . $color[1][0] . $color[2][0] . $color[3][0];
			return ($tag ? "#" : '') . $color[0] . $color[1] . $color[2] . $color[3];
		}
	}

	static
	function fromXYBri($x, $y, $br)
	{
		$_x = ($x * $br) / $y;
		$_y = $br;
		$_z = ((1 - $x - $y) * $br) / $y;
		$r = $_x * 3.2406 + $_y * -1.5372 + $_z * -0.4986;
		$g = $_x * -0.9689 + $_y * 1.8758 + $_z * 0.0415;
		$b = $_x * 0.0557 + $_y * -0.2040 + $_z * 1.0570;
		$r = $r > 0.0031308 ? 1.055 * pow($r, 1 / 2.4) - 0.055 : 12.92 * $r;
		$g = $g > 0.0031308 ? 1.055 * pow($g, 1 / 2.4) - 0.055 : 12.92 * $g;
		$b = $b > 0.0031308 ? 1.055 * pow($b, 1 / 2.4) - 0.055 : 12.92 * $b;
		$r = $r > 0 ? round($r * 255) : 0;
		$g = $g > 0 ? round($g * 255) : 0;
		$b = $b > 0 ? round($b * 255) : 0;
		return ["red" => $r, "green" => $g, "blue" => $b];
	}

	static
	function toHsvInt($a = 0, $b = false, $c = false)
	{
		$rgb = self::par($a, $b, $c);
		if ($rgb === false) return false;
		$rgb = ["red" => $rgb[0], "green" => $rgb[1], "blue" => $rgb[2]];
		$min = min($rgb);
		$max = max($rgb);
		$hsv = ['hue' => 0, 'sat' => 0, 'val' => $max];
		if ($max == 0) return $hsv;
		$hsv['sat'] = round(255 * ($max - $min) / $hsv['val']);
		if ($hsv['sat'] == 0) {
			$hsv['hue'] = 0;
			return $hsv;
		}

		$hsv['hue'] = $max == $rgb['red'] ? round(0 + 43 * ($rgb['green'] - $rgb['blue']) / ($max - $min)) : ($max == $rgb['green'] ? round(171 + 43 * ($rgb['red'] - $rgb['green']) / ($max - $min)) : round(171 + 43 * ($rgb['red'] - $rgb['green']) / ($max - $min)));
		if ($hsv['hue'] < 0) $hsv['hue']+= 255;
		return $hsv;
	}

	static
	function toHsvFloat($a = 0, $b = false, $c = false)
	{
		$rgb = self::par($a, $b, $c);
		if ($rgb === false) return false;
		$rgb = ["red" => $rgb[0], "green" => $rgb[1], "blue" => $rgb[2]];
		$min = min($rgb);
		$max = max($rgb);
		$hsv = ['hue' => 0, 'sat' => 0, 'val' => $max];
		if ($hsv['val'] == 0) return $hsv;
		$rgb['red']/= $hsv['val'];
		$rgb['green']/= $hsv['val'];
		$rgb['blue']/= $hsv['val'];
		$min = min($rgb);
		$max = max($rgb);
		$hsv['sat'] = $max - $min;
		if ($hsv['sat'] == 0) {
			$hsv['hue'] = 0;
			return $hsv;
		}

		$rgb['red'] = ($rgb['red'] - $min) / ($max - $min);
		$rgb['green'] = ($rgb['green'] - $min) / ($max - $min);
		$rgb['blue'] = ($rgb['blue'] - $min) / ($max - $min);
		$min = min($rgb);
		$max = max($rgb);
		if ($max == $rgb['red']) {
			$hsv['hue'] = 0.0 + 60 * ($rgb['green'] - $rgb['blue']);
			if ($hsv['hue'] < 0) {
				$hsv['hue']+= 360;
			}
		}
		else $hsv['hue'] = $max == $rgb['green'] ? 120 + (60 * ($rgb['blue'] - $rgb['red'])) : 240 + (60 * ($rgb['red'] - $rgb['green']));
		return $hsv;
	}

	static
	function toXYZ($a = 0, $b = false, $c = false)
	{
		$rgb = self::par($a, $b, $c);
		if ($rgb === false) return false;
		$rgb = ["red" => $rgb[0], "green" => $rgb[1], "blue" => $rgb[2]];
		$rgb = array_map(
		function ($i)
		{
			return $i / 255;
		}

		, $rgb);
		$rgb = array_map(
		function ($i)
		{
			return $i > 0.04045 ? pow((($i + 0.055) / 1.055) * 100, 2.4) : $item / 12.92 * 100;
		}

		, $rgb);
		$xyz = ['x' => ($rgb['red'] * 0.4124) + ($rgb['green'] * 0.3576) + ($rgb['blue'] * 0.1805) , 'y' => ($rgb['red'] * 0.2126) + ($rgb['green'] * 0.7152) + ($rgb['blue'] * 0.0722) , 'z' => ($rgb['red'] * 0.0193) + ($rgb['green'] * 0.1192) + ($rgb['blue'] * 0.9505) ];
		return $xyz;
	}

	static
	function toLabCie($a = 0, $b = false, $c = false)
	{
		$xyz = $this->toXYZ($a, $b, $c);
		if ($xyz === false) return false;
		$xyz['x']/= 95.047;
		$xyz['y']/= 100;
		$xyz['z']/= 108.883;
		$xyz = array_map(
		function ($item)
		{
			if ($item > 0.008856) {
				return pow($item, 1 / 3);
			}
			else {
				return (7.787 * $item) + (16 / 116);
			}
		}

		, $xyz);
		$lab = ['l' => (116 * $xyz['y']) - 16, 'a' => 500 * ($xyz['x'] - $xyz['y']) , 'b' => 200 * ($xyz['y'] - $xyz['z']) ];
		return $lab;
	}

	static
	function toXYBri($a = 0, $b = false, $c = false)
	{
		$rgb = self::par($a, $b, $c);
		if ($rgb === false) return false;
		$rgb = ["red" => $rgb[0], "green" => $rgb[1], "blue" => $rgb[2]];
		$r = $rgb['red'];
		$g = $rgb['green'];
		$b = $rgb['blue'];
		$r = $r / 255;
		$g = $g / 255;
		$b = $b / 255;
		if ($r < 0 || $r > 1 || $g < 0 || $g > 1 || $b < 0 || $b > 1) {
			new XNError("XNColor XYBri", "Invalid RGB array. [{$r},{$b},{$g}]");
		}

		$rt = ($r > 0.04045) ? pow(($r + 0.055) / (1.0 + 0.055) , 2.4) : ($r / 12.92);
		$gt = ($g > 0.04045) ? pow(($g + 0.055) / (1.0 + 0.055) , 2.4) : ($g / 12.92);
		$bt = ($b > 0.04045) ? pow(($b + 0.055) / (1.0 + 0.055) , 2.4) : ($b / 12.92);
		$cie_x = $rt * 0.649926  + $gt * 0.103455 + $bt * 0.197109;
		$cie_y = $rt * 0.234327  + $gt * 0.743075 + $bt * 0.022598;
		$cie_z = $rt * 0.0000000 + $gt * 0.053077 + $bt * 1.035763;
		if ($cie_x + $cie_y + $cie_z == 0) {
			$hue_x = 0.1;
			$hue_y = 0.1;
		}
		else {
			$hue_x = $cie_x / ($cie_x + $cie_y + $cie_z);
			$hue_y = $cie_y / ($cie_x + $cie_y + $cie_z);
		}

		return ['x' => $hue_x, 'y' => $hue_y, 'bri' => $cie_y];
	}

	static
	function average($from, $to = false)
	{
		$from = self::init($from);
		if (!$to) {
			return ($from[0] + $from[1] + $from[2]) / 3;
		}

		$to = self::init($to);
		$from[0] = ($from[0] + $to[0]) / 2;
		$from[1] = ($from[1] + $to[1]) / 2;
		$from[2] = ($from[2] + $to[2]) / 2;
		$from[3] = ($from[3] + $to[3]) / 2;
		return $from;
	}

	static
	function averageAll($from, $to)
	{
		$from = self::init($from);
		$to = self::init($to);
		$av = (($from[0] + $to[0]) / 2 + ($from[1] + $to[1]) / 2 + ($from[2] + $to[2]) / 2) / 3;
		return [$av, $av, $av];
	}

	static
	function averageAllAlpha($from, $to)
	{
		$from = self::init($from);
		$to = self::init($to);
		$av = (($from[0] + $to[0]) / 2 + ($from[1] + $to[1]) / 2 + ($from[2] + $to[2]) / 2 + ($from[3] + $to[3])) / 4;
		return [$av, $av, $av, $av];
	}

	static
	function toBW($color)
	{
		$color = self::init($color);
		return 16777215 * (int)(($color[0] + $color[1] + $color[2]) / 3 > 127.5);
	}
}

class XNImage

{
	private $headers = [];
	public $pixels = [], $info = [];

	const HEADER_PNG = "\x89\x50\x4e\x47\x0d\x0a\x1a\x0a";
	public

	function __construct($data = '')
	{
		$this->color = new XNColor;
	}

	private
	function _clone($headers, $pixels, $info)
	{
		$this->headers = $headers;
		$this->pixels = $pixels;
		$this->info = $info;
	}

	public

	function clone ()
	{
		$im = new XNImage;
		$im->_clone($this->headers, $this->pixels, $this->info);
		return $im;
	}

	public

	function __clone()
	{
		$im = new XNImage;
		$im->_clone($this->headers, $this->pixels, $this->info);
		return $im;
	}

	public

	function serialize()
	{
		$im = new XNImage;
		unset($im->color);
		$im->headers = $this->headers;
		$im->pixels = $this->pixels;
		$im->info = $this->info;
		return serialize($im);
	}

	static
	function unserialize($str)
	{
		$im = new XNImage;
		$str = unserialize($str);
		$im->headers = $str->headers;
		$im->pixels = $str->pixels;
		$im->info = $str->info;
		return $im;
	}

	public

	function reset()
	{
		$this->headers = [];
		$this->pixels = [];
		$this->info = [];
	}

	public

	function close()
	{
		$this->color = null;
		$this->headers = null;
		$this->pixels = null;
		$this->info = null;
	}

	public

	function __destruct()
	{
		$this->color = null;
		$this->headers = null;
		$this->pixels = null;
		$this->info = null;
	}

	public

	function frompng($png)
	{
		$pos = 0;
		if (isset($png[7]) && substr($png, 0, 8) == self::HEADER_PNG) {
			$pos = 8;
		}
		elseif (file_exists($png)) {
			return $this->frompng(file_get_contents($png));
		}
		else {
			new XNError("XNImage", "invalid png image");
			return false;
		}

		$htitle = '';
		while ($htitle != "IEND") {
			$hsize = base10_encode(substr($png, $pos, 4));
			$pos+= 4;
			$htitle = substr($png, $pos, 4);
			$pos+= 4;
			$hcontent = substr($png, $pos, $hsize);
			$pos+= $hsize;
			$hcrc = substr($png, $pos, 4);
			$pos+= 4;
			if (!$htitle) {
				new XNError("XNImage", "invalid png image");
				return false;
			}

			if (!isset($this->headers[$htitle])) $this->headers[$htitle] = ["size" => $hsize, "content" => $hcontent, "crc" => $hcrc];
			elseif (is_string($this->headers[$htitle])) $this->headers[$htitle] = [$this->headers[$htitle], ["size" => $hsize, "content" => $hcontent, "crc" => $hcrc]];
			else $this->headers[$htitle][] = ["size" => $hsize, "content" => $hcontent, "crc" => $hcrc];
		}

		if (!isset($this->headers['IDAT']) || !isset($this->headers['IHDR'])) {
			new XNError("XNImage", "invalid png image");
			return false;
		}

		$this->info['width'] = base10_encode(substr($this->headers['IHDR']['content'], 0, 4));
		$this->info['height'] = base10_encode(substr($this->headers['IHDR']['content'], 4, 4));
		$this->info['depth'] = ord($this->headers['IHDR']['content'][8]);
		$this->info['color'] = ord($this->headers['IHDR']['content'][9]);
		$this->info['compression'] = ord($this->headers['IHDR']['content'][10]);
		$this->info['filter'] = ord($this->headers['IHDR']['content'][11]);
		$this->info['interlace'] = ord($this->headers['IHDR']['content'][12]);
		$pixels = $this->headers['IDAT']['content'];
		$pixels = zlib_decode($pixels);
		$pos = 0;
		$x = - 1;
		$y = 0;
		while (@$pixels[$pos + 3]) {
			$x++;
			if ($x + 1 > $this->info['width']) {
				$x = 0;
				$y++;
			}

			$this->pixels[$y][$x] = base10_encode(substr($pixels, $pos, 4));
			$pos+= 4;
		}

		return $this;
	}
}

// XNEnd

$GLOBALS['-XN-']['endTime'] = microtime(1);

function xnscript()
{
	return ["version" => "1.5", "start_time" => $GLOBALS['-XN-']['startTime'], "end_time" => $GLOBALS['-XN-']['endTime'], "loaded_time" => $GLOBALS['-XN-']['endTime'] - $GLOBALS['-XN-']['startTime'], "dir_name" => $GLOBALS['-XN-']['dirName'], "last_update" => substr($GLOBALS['-XN-']['lastUpdate'], 0, -14) , "last_use" => substr($GLOBALS['-XN-']['lastUse'], 0, -11) ];
}

?>
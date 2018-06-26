<?php
/* xn version 1.5 */
/* $DATA
 * you can output in $DATA and get in other times
 
   $DATA['name'] = "avid";
 */

if(PHP_VERSION < 7.0){
throw new Error("<b>xn library</b> needs more than or equal to 7.0 version");
exit;
}

$GLOBALS['-XN-'] = [];
$GLOBALS['-XN-']['startTime'] = microtime(1);
$GLOBALS['-XN-']['dirName'] = substr(__FILE__, 0, strrpos(__FILE__, DIRECTORY_SEPARATOR));
$GLOBALS['-XN-']['dirNameDir'] = $GLOBALS['-XN-']['dirName'] . DIRECTORY_SEPARATOR;
$GLOBALS['-XN-']['lastUpdate'] = "0{[LASTUPDATE]}";
$GLOBALS['-XN-']['lastUse'] = "0{[LASTUSE]}";
$GLOBALS['-XN-']['DATA'] = "W10={[DATA]}"; // Assumption = []
$DATA = json_decode(base64_decode(substr($GLOBALS['-XN-']['DATA'], 0, -8)), @$XNDATA === 1);

// \xn
require_once $GLOBALS['-XN-']['dirNameDir'] . "thumbcode.php";
require_once $GLOBALS['-XN-']['dirNameDir'] . "nter.php";
require_once $GLOBALS['-XN-']['dirNameDir'] . "error.php";

// \xn\Telegram
require_once $GLOBALS['-XN-']['dirNameDir'] . "telegram" . DIRECTORY_SEPARATOR . "index.php";
// \xn\Coding
require_once $GLOBALS['-XN-']['dirNameDir'] . "coding" . DIRECTORY_SEPARATOR . "index.php";
// \xn\File
require_once $GLOBALS['-XN-']['dirNameDir'] . "files" . DIRECTORY_SEPARATOR . "index.php";
// \xn\API
require_once $GLOBALS['-XN-']['dirNameDir'] . "api" . DIRECTORY_SEPARATOR . "index.php";
// \xn\CF
require_once $GLOBALS['-XN-']['dirNameDir'] . "cfile" . DIRECTORY_SEPARATOR . "index.php";
// \xn\Time
require_once $GLOBALS['-XN-']['dirNameDir'] . "time.php";
// \xn\variables
require_once $GLOBALS['-XN-']['dirNameDir'] . "variables.php";
// \xn\String
require_once $GLOBALS['-XN-']['dirNameDir'] . "xnstring.php";
// \xn\Binary
require_once $GLOBALS['-XN-']['dirNameDir'] . "xnbinary.php";
// \xn\Number
require_once $GLOBALS['-XN-']['dirNameDir'] . "xnnumber.php";

$GLOBALS['-XN-']['endTime'] = microtime(1);

?>

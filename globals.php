<?php
date_default_timezone_set("Australia/Sydney");

if ($_SERVER["SERVER_NAME"] == 'localhost') {
    define("LOCAL_DIR", "asm/importproductspec");
    define("DOC_ROOT", $_SERVER['DOCUMENT_ROOT'] . "/" . LOCAL_DIR);
    define("ROOT_URL", "http://" . $_SERVER["SERVER_NAME"] . "/" . LOCAL_DIR);

    define("DB_SERVER_NAME", $_SERVER["SERVER_NAME"]);
    define("DB_NAME", "importproductspec");
    define("DB_USERNAME", "astev");
    define("DB_PASSWORD", "imV4lid!");
} else {
    define("DOC_ROOT", $_SERVER['DOCUMENT_ROOT']);
    define("ROOT_URL", "http://" . $_SERVER["SERVER_NAME"]);

    define("DB_SERVER_NAME", $_SERVER["SERVER_NAME"]);
    define("DB_NAME", "fcz7gjcr_importproductspec");
    define("DB_USERNAME", "fcz7gjcr_astev");
    define("DB_PASSWORD", "imV4lid!");
}

$db_conn_vars["db_server_name"] = DB_SERVER_NAME;
$db_conn_vars["db_name"] = DB_NAME;
$db_conn_vars["db_username"] = DB_USERNAME;
$db_conn_vars["db_password"] = DB_PASSWORD;

define("MAIN_TITLE", "");
define("COMPANY", "");

define("INCLUDES_PATH", DOC_ROOT . "/assets/server/includes");
define("UTILS_PATH", DOC_ROOT . "/assets/server/utils");
define("SERVER_ASSETS_PATH", DOC_ROOT . "/assets/server");
define("CLASSES_PATH", SERVER_ASSETS_PATH . "/classes");
define("JSON_PATH", SERVER_ASSETS_PATH . "/json");
define("NAV_JSON", JSON_PATH . "/nav.json");

define("SCRIPTS_URL", ROOT_URL . "/assets/client/scripts");
define("IMAGES_URL", ROOT_URL . "/assets/client/images");
define("ADMIN_URL", ROOT_URL . "/admin");
define("CLIENT_URL", ROOT_URL . "/assets/client");

//includes
define("SITE_HEADER", INCLUDES_PATH . "/header_footer/site/site_header.php");
define("SITE_FOOTER", INCLUDES_PATH . "/header_footer/site/site_footer.php");
define("SITE_NAV", INCLUDES_PATH . "/nav/site_nav.php");

define("UTILS_COMMON", UTILS_PATH . "/common.php");

define("CSS_URL", CLIENT_URL . "/css");
define("JAVASCRIPT_URL", CLIENT_URL . "/js");
define("JQUERY_URL", JAVASCRIPT_URL . "/jquery-3.3.1.min.js");
define("BOOTSTRAP_VERSION", "4.1.3");
define("BOOTSTRAP_CSS", CSS_URL . "/bootstrap/" . BOOTSTRAP_VERSION . "/bootstrap.min.css");
define("BOOTSTRAP_JS", CSS_URL . "/bootstrap/" . BOOTSTRAP_VERSION . "/bootstrap.min.js");
define("SITE_URL", ROOT_URL . "/site");

include(UTILS_COMMON);

//db stuff
include(CLASSES_PATH . "/class.DB.php");
?>
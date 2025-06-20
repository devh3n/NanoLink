<?php

require_once __DIR__ . "/../vendor/autoload.php";
$config = require_once __DIR__ . "/../config/config.php";

use N3x74\Database;
use N3x74\Url;

$db = Database::connect();
$url = new Url($db);

if (isset($_GET["url"]))
{
    if ($url->isUrl($_GET["url"]))
    {
        $code = $url->conversion($_GET["url"]);
        die($config["domain"] . "?$code=1");
    } else {
        die("The link is not valid or does not start with HTTPS.");
    }
}

else if (in_array('1', $_GET, true))
{
    $code = array_search('1', $_GET);
    $getUrl = $url->getUrl($code);
    if ($getUrl)
    {
        header("Location: $getUrl");
    }

    die("404 - Not Found");
}

echo "false";
<?php
// Rules
$rules = array();
$rules[] = "/union.+select/i";
$rules[] = "/insert.+into.+value.+/i";
$rules[] = "/(--|drop|alter|create)/i";
$rules[] = "/(http|ftp|https)\:\/\/(www\.)?.+\.[A-Za-z]{1,4}/i";
$rules[] = "/(img|script|alert|frame)/i";
$rules[] = "/\.+\//i";

// Anti Script Kiddie
if(stristr($_SERVER['HTTP_USER_AGENT'], "libwww-perl"))    die;

// Anti CSRF
if(!empty($_POST))
{
    $host = str_replace("\.", ".", $_SERVER['HTTP_HOST']);
    if(!preg_match("/^http\://(www\.)?$host/", $_SERVER['HTTP_REFERER']))
        die("CSRF attempt");
}

// Analyse Requests
foreach($_REQUEST as $request)
    foreach($rules as $rule)
        if(preg_match($rule, urldecode($request)))
            die("Hacking Attempt<br>Your IP have been logged"); // lol
?>
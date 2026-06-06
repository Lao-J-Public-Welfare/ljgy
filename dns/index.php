<?php
$version = str_replace('.','',PHP_VERSION);
$PHPVer = substr($version,0,2);
if($PHPVer != '82'){
    die('<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" /><style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:) </h1><h3>请使用PHP8.2版本</h3>');
}
include_once './includes/common.php';
@header('Content-Type: text/html; charset=UTF-8');

$mod = isset($_GET['mod'])?$_GET['mod']:'index';
$loadfile = Template::load('Index', $mod);
include $loadfile;
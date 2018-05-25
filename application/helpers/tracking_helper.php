<?php if( ! defined('BASEPATH')) exit('No direct script access allowed.');
/**
 * Tracking Helper
 *
 * @author 					Joss Arciga
 * @copyright 				Copyright (c) 2015. Inttechs, Internet Technologies.
 * @creation date 			July 30, 2015
*/
function get_wan_ip_address()
{
	$request = file_get_contents('http://checkip.dyndns.com/');
	preg_match('/Current IP Address: \[?([:.0-9a-fA-F]+)\]?/', $request, $m);
	return $m[1];
}

function get_remote_ip_address()
{
	return get_ip_address();
}

function get_server_ip_address()
{
	if(isset($_SERVER['SERVER_ADDR']))
		return $_SERVER['SERVER_ADDR'];
	return '';
}

function get_http_referer()
{
	if(isset($_SERVER['HTTP_REFERER']))
		return $_SERVER['HTTP_REFERER'];
	return '';
}

function get_request_uri()
{
	if(isset($_SERVER['REQUEST_URI']))
		return $_SERVER['REQUEST_URI'];
	return '';
}

function get_server_port()
{
	if(isset($_SERVER['SERVER_PORT']))
		return $_SERVER['SERVER_PORT'];
	return '';
}

function get_server_protocol()
{
	if(isset($_SERVER['SERVER_PROTOCOL']))
		return $_SERVER['SERVER_PROTOCOL'];
	return '';
}

function get_server_name()
{
	if(isset($_SERVER['SERVER_NAME']))
		return $_SERVER['SERVER_NAME'];
	return '';
}

function get_ip_address()
{
	if(isset($_SERVER['REMOTE_ADDR']))
		return $_SERVER['REMOTE_ADDR'];
	return '';
}

function get_user_agent()
{
	if(isset($_SERVER['HTTP_USER_AGENT']))
		return $_SERVER['HTTP_USER_AGENT'];
	return '';
}
?>
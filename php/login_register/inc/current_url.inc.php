<?php
function current_url($has_reverse_proxy=false, $reserve_query_string=true)
{
	$s=$_SERVER;
	
	// Protocol
	$protocol=strtolower(substr($s['SERVER_PROTOCOL'], 0, strpos($s['SERVER_PROTOCOL'], '/')));
	// 443 port is https
	if($s['SERVER_PORT']=='443')
	{
		$protocol.='s';
	}
	$protocol.='://';
	
	// Port
	if($s['SERVER_PORT']=='443' || $s['SERVER_PORT']=='80')
	{
		
		$port='';
	}
	else{
		$port=':'.$s['SERVER_PORT'];
	}

	// Host
	//
	// Introduction
	// $_SERVER['HTTP_HOST'], retrieve from client http request header
	// $_SERVER['SERVER_NAME'], retrieve from your server config(Apache's ServerName config option)
	// $_SERVER['HTTP_X_FORWARDED_FOR'], proxy or balancer ip
	// $_SERVER['HTTP_X_FORWARDED_HOST'], proxy or balancer hostname
	// $_SERVER['HTTP_X_FORWARDED_SERVER'], proxy or balancer server config name
	//
	// Examples:
	// 		scenario 1:
	//			Client  --> Server
	//		in this scenario
	//			HTTP_HOST is the requested target host(set by client)
	//			SERVER_NAME is the item configured by server
	//		scenario 2:
	//			Client  --> Forward-Proxy  --> Reverse-Proxy --> Server
	//		in this scanario
	//			HTTP_X_FORWARDED_HOST is Forward-Proxy-Host:81, Reverse-Proxy-Host
	//			HTTP_HOST is ProxyAHost:81
	//			SERVER_NAME is retrieved from Server
	//			If there is a Reverse Proxy, it's hostname is you want
	//
	// Precedence:
	// 		HTTP_X_FORWARDED_HOST last item, HTTP_HOST, SERVER_NAME
	if($has_reverse_proxy && isset($s['HTTP_X_FORWARDED_HOST']))
	{
		$host=explode(',', $s['HTTP_X_FORWARDED_HOST']);
		$host=trim($host[count($host)-1]);
		$hostport=explode(':', $host);
		if(count($hostport)>1)
		{
			$host=trim($hostport[0]);
			$port=':'.trim($hostport[1]);
		}
	}
	else if(isset($s['HTTP_HOST']))
	{
		$host=$s['HTTP_HOST'];
	}
	else
	{
		$host=$s['SERVER_NAME'];
	}

	if($reserve_query_string){
		return $protocol.$host.$port.$s['REQUEST_URI'];
	}
	else
	{
		return $protocol.$host.$port.substr($s['REQUEST_URI'], 0, strpos($s['REQUEST_URI'].'?', '?'));
	}
}

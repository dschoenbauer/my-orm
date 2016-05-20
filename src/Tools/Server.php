<?php

namespace CTIMT\MyOrm\Tools;

/**
 * Description of ServerUrl
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class Server {

    public static function getUrl(array $paramters) {
        $server = $_SERVER;
        $url = 'http' . (isset($server['HTTPS']) ? 's' : '') . '://' . "{$server['HTTP_HOST']}{$server['SCRIPT_NAME']}?" . http_build_query($paramters);
        return html_entity_decode($url);
    }
    
    public static function getRelativePath(array $paramters) {
        $server = $_SERVER;
        $url = "{$server['SCRIPT_NAME']}?" . http_build_query($paramters);
        return html_entity_decode($url);
    }

}

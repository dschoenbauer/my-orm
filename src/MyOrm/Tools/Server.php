<?php namespace CTIMT\MyOrm\Tools;

/**
 * Description of ServerUrl
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class Server
{

    public static function getUrl(array $paramters)
    {
        $http = filter_input(INPUT_SERVER, 'HTTPS', FILTER_SANITIZE_STRING);
        $host = filter_input(INPUT_SERVER, 'HTTP_HOST', FILTER_SANITIZE_STRING);
        $script = filter_input(INPUT_SERVER, 'SCRIPT_NAME', FILTER_SANITIZE_STRING);
        $url = 'http' . ($http ? 's' : '') . '://' . "{$host}{$script}?" . http_build_query($paramters);
        return html_entity_decode($url);
    }

    public static function getRelativePath(array $paramters)
    {
        $script = filter_input(INPUT_SERVER, 'SCRIPT_NAME', FILTER_SANITIZE_STRING);
        $url = "{$script}?" . http_build_query($paramters);
        return html_entity_decode($url);
    }
}

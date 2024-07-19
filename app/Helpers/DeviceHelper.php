<?php

namespace App\Helpers;

/**
 * Ajudante a verificar qual tipo de dispositivo está acessando o sistema, pelo lado do servidor.
 */
class DeviceHelper
{
    /**
     * mobile - retorna se o dispositivo que está acessando o sistema é um dispositivo mobile
     *
     * @return bool
     */
    public function mobile()
    {
        return in_array(
            true,
            [
                strpos(mb_strtoupper(@$_SERVER['HTTP_USER_AGENT']), mb_strtoupper("iPhone")),
                strpos(mb_strtoupper(@$_SERVER['HTTP_USER_AGENT']), mb_strtoupper("iPad")),
                strpos(mb_strtoupper(@$_SERVER['HTTP_USER_AGENT']), mb_strtoupper("Android")),
                strpos(mb_strtoupper(@$_SERVER['HTTP_USER_AGENT']), mb_strtoupper("webOS")),
                strpos(mb_strtoupper(@$_SERVER['HTTP_USER_AGENT']), mb_strtoupper("BlackBerry")),
                strpos(mb_strtoupper(@$_SERVER['HTTP_USER_AGENT']), mb_strtoupper("iPod")),
                strpos(mb_strtoupper(@$_SERVER['HTTP_USER_AGENT']), mb_strtoupper("Symbian")),
            ]
        );
    }

    /**
     * navegador - retorna qual navegador está acessando o sistema
     *
     * @return string
     */
    public function navegador()
    {
        switch (true) {
            case strpos(mb_strtoupper(@$_SERVER['HTTP_USER_AGENT']), mb_strtoupper('Opera')) || strpos(mb_strtoupper(@$_SERVER['HTTP_USER_AGENT']), mb_strtoupper('OPR/')):
                return 'Opera';
                break;

            case strpos(mb_strtoupper(@$_SERVER['HTTP_USER_AGENT']), mb_strtoupper('Chrome')):
                return 'Chrome';
                break;

            case strpos(mb_strtoupper(@$_SERVER['HTTP_USER_AGENT']), mb_strtoupper('Edge')):
                return 'Edge';
                break;

            case strpos(mb_strtoupper(@$_SERVER['HTTP_USER_AGENT']), mb_strtoupper('Safari')):
                return 'Safari';
                break;

            case strpos(mb_strtoupper(@$_SERVER['HTTP_USER_AGENT']), mb_strtoupper('Firefox')):
                return 'Firefox';
                break;

            case strpos(mb_strtoupper(@$_SERVER['HTTP_USER_AGENT']), mb_strtoupper('MSIE')) || strpos(mb_strtoupper(@$_SERVER['HTTP_USER_AGENT']), mb_strtoupper('Trident/7')):
                return 'Internet Explorer';
                break;

            default:
                return 'Outro';
                break;
        }
    }
}

<?php

namespace App\Services\Academico;

use Google_Client;
use Google_Service_Classroom;
use Illuminate\Support\Facades\Session;

/**
 * Class GoogleClassroomService
 *
 * @package App\Helpers
 */
class GoogleClassroomService
{
    /**
     * @var Google_Service_Classroom
     */
    private $googleService;

    /**
     * GoogleClassroomService constructor.
     */
    public function __construct()
    {
        $client = new Google_Client();
        $client->setAccessToken([
            'access_token' => Session::get('tokenGoogle'),
            'expires_in' => 10800
        ]);
        $this->googleService = new Google_Service_Classroom($client);
    }

    /**
     * Retorna serviço de conexão com a API do Google Classroom.
     *
     * @return Google_Service_Classroom
     */
    public static function getService(): Google_Service_Classroom
    {
        return app(GoogleClassroomService::class)->googleService;
    }
}
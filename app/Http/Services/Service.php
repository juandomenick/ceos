<?php

namespace App\Http\Services;

// HELPERS
use App\Helpers\SecurityHelper;
use App\Helpers\StringHelper;
use App\Helpers\DeviceHelper;
use App\Helpers\EnvironmentHelper;
use App\Helpers\GitHelper;

class Service
{
    /**
     * @var $securityHelper - armazena a helper de seguraça da plataforma, que auxilia em criptografia
     * @var $deviceHelper - armazena a helper de dispositivo da plataforma, que auxilia em identificação do dispositivo do usuário
     * @var $stringHelper - armazena a helper de strings da plataforma, que auxilia em manipulacao e comparação de strings
     * @var $gitHelper - armazena a helper de git da plataforma, que auxilia em funções de acesso ao git do projeto
     * @var $environmentHelper - armazena a helper de environment da plataforma, que auxilia em identificar qual ambiente o usuário está logado
     */
    public $securityHelper;
    public $deviceHelper;
    public $stringHelper;
    public $gitHelper;
    public $environmentHelper;

    /**
     * __construct - função chamada na instancia da classe
     */
    public function __construct()
    {
        // HELPERS
        $this->securityHelper       = new SecurityHelper;
        $this->deviceHelper         = new DeviceHelper;
        $this->stringHelper         = new StringHelper;
        $this->gitHelper            = new GitHelper;
        $this->environmentHelper    = new EnvironmentHelper;
    }
}

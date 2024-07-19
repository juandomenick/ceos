<?php

namespace App\Http\Controllers;

// BIBLIOTECAS
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

// HELPERS
use App\Helpers\SecurityHelper;
use App\Helpers\StringHelper;
use App\Helpers\DeviceHelper;
use App\Helpers\EnvironmentHelper;
use App\Helpers\GitHelper;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

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
     * @var $mobile - armazena o retorno da função mobile da helper de dispositivo, facilitando a identificação do dispositivo e posteriormente ser passada para a view com mais facilidade
     * @var $browser - armazena o retorno da função browser da helper de dispositivo, facilitando a identificação do browser e posteriormente ser passada para a view com mais facilidade
     * @var $version - armazena o retorno da função version da helper de git, facilitando a identificação da versão do projeto e posteriormente ser passada para a view com mais facilidade
     */
    public $mobile;
    public $browser;
    public $version;

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

        // VERSION
        $this->version = $this->gitHelper->version();

        // MOBILE
        $this->mobile = $this->deviceHelper->mobile();

        // BROWSER
        $this->browser = $this->deviceHelper->navegador();
    }
}

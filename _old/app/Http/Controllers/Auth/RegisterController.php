<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Usuarios\Aluno\CadastrarAlunoRequest;
use App\Http\Requests\Usuarios\Professor\CadastrarProfessorRequest;
use App\Providers\RouteServiceProvider;
use App\Services\Usuarios\AlunoService;
use App\Services\Usuarios\Interfaces\AlunoServiceInterface;
use App\Services\Usuarios\Interfaces\ProfessorServiceInterface;
use App\Services\Usuarios\ProfessorService;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Página de redirecionamento após registro.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Serviço de Aluno
     *
     * @var AlunoService
     */
    private $alunoService;
    /**
     * Serviço de Professor
     *
     * @var ProfessorService
     */
    private $professorService;

    /**
     * @param AlunoServiceInterface $alunoService
     * @param ProfessorServiceInterface $professorService
     */
    public function __construct(AlunoServiceInterface $alunoService, ProfessorServiceInterface $professorService)
    {
        $this->middleware('guest');

        $this->alunoService = $alunoService;
        $this->professorService = $professorService;
    }

    /**
     * Obtém regras de validação de acordo o perfil selecionado.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = array();

        switch ($data['perfil']) {
            case 'aluno':
                $rules = (new CadastrarAlunoRequest())->rules();

                $cpfRule = eMenorDeIdade($data['data_nascimento']) ? 'required' : 'nullable';
                array_unshift($rules['cpf_responsavel'], $cpfRule);

                break;
            case 'professor':
                $rules = (new CadastrarProfessorRequest())->rules();
        }

        return Validator::make($data, $rules);
    }

    /**
     * Cria um novo usuário, a partir do serviço, de acordo o perfil selecionado.
     *
     * @param array $data
     * @return User
     */
    protected function create(array $data): User
    {
        switch ($data['perfil']) {
            case 'aluno':
                return $this->alunoService->cadastrar((object) $data);
            case 'professor':
                return $this->professorService->cadastrar((object) $data);
        }
    }
}

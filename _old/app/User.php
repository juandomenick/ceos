<?php

namespace App;

use App\Models\Academico\Instituicao;
use App\Models\Usuarios\Aluno;
use App\Models\Usuarios\Coordenador;
use App\Models\Usuarios\Professor;
use App\Models\Usuarios\ResponsavelAluno;
use App\Notifications\Auth\EmailVerificationNotification;
use App\Notifications\Auth\ResetPasswordNotification;
use App\Traits\Users\HasViewPermissions;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User
 *
 * @package App
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasRoles, Notifiable, HasViewPermissions;

    /**
     * Atributos que são assinaláveis em massa.
     *
     * @var array
     */
    protected $fillable = [
        'nome', 'email', 'email_verified_at', 'usuario',
        'password', 'avatar', 'celular', 'telefone', 'google_id'
    ];

    /**
     * Atributos que devem estar ocultos.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Atributos que devem ser convertidos.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relacionamento 1x1: Usuário pode ser um Aluno.
     *
     * @return HasOne
     */
    public function aluno(): HasOne
    {
        return $this->hasOne(Aluno::class);
    }

    /**
     * Relacionamento 1x1: Usuário pode ser um Aluno.
     *
     * @return HasOne
     */
    public function professor(): HasOne
    {
        return $this->hasOne(Professor::class);
    }

    /**
     * Relacionamento 1x1: Usuário pode ser um Responsável.
     *
     * @return HasOne
     */
    public function responsavelAluno(): HasOne
    {
        return $this->hasOne(ResponsavelAluno::class);
    }

    /**
     * Relacionamento 1x1: Usuário pode ser um Coordenador.
     *
     * @return HasOne
     */
    public function coordenador(): HasOne
    {
        return $this->hasOne(Coordenador::class);
    }

    /**
     * Relacionamento 1xN: Usuário (Diretor) tem várias Instituições.
     *
     * @return HasMany
     */
    public function instituicoes(): HasMany
    {
        return $this->hasMany(Instituicao::class, 'diretor_id');
    }

    /**
     * Notificação personalizada (traduzida) para verificação de cadastro.
     */
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new EmailVerificationNotification());
    }

    /**
     * Notificação personalizada (traduzida) para recuperação de senha.
     *
     * @param string $token
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Mutator: Retorna o primeiro nome do usuário em formato Camel Case.
     *
     * @param $value
     * @return string
     */
    public function getPrimeiroNomeAttribute($value): string
    {
        $firstName = collect(explode(' ', $this->nome))->first();
        return $this->nome ? Str::ucfirst(Str::lower($firstName)) : 'Responsável';
    }

    /**
     * Mutator: Retorna o link do avatar armazenado no servidor ou da conta Google.
     *
     * @return string
     */
    public function getPathAvatarAttribute(): string
    {
        $imagemContaGoogle = in_array('avatar_usuarios', explode('/', $this->avatar));
        return $imagemContaGoogle ? url(Storage::url($this->avatar)) : $this->avatar;
    }

    /**
     * Mutator: Retorna a função do usuário, traduzida pelo arquivo resources/lang/pt-BR/user-types.php.
     *
     * @param $value
     * @return string
     */
    public function getFuncaoAttribute($value): string {
        return trans("user-types.{$this->getRoleNames()->first()}");
    }
}

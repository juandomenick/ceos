<?php

namespace App\Rules;

// HELPERS
use App\Helpers\StringHelper;

// BIBLIOTECAS
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class FiltroPalavrasInapropriadas implements ValidationRule
{
    /**
     * @var $palavrasInapropriadas - armazena a lista de palavras consideradas inadequadas pro sistema
     * @var $stringHelper - armazena a helper de strings da plataforma, que auxilia em manipulacao e comparação de strings
     */
    protected $palavrasInapropriadas;
    public $stringHelper;

    /**
     * __construct - função chamada na instancia da classe
     */
    public function __construct()
    {
        // STRING HELPER
        $this->stringHelper = new StringHelper;

        // PALAVRAS INADEQUADAS
        $this->palavrasInapropriadas = [
            'bosta', 'merda', 'porra', 'caralho', 'cacete', 'foda', 'puta', 'puto', ' cu ', 'seu cu', 'teu cu', 'cusao', 'cusão',
            'filho da puta', 'arrombado', 'babaca', 'buceta', 'cabrão', 'cabrao', 'cagão', 'cagona', 'canalha', 'desgraça',
            'cornudo', 'cornuda', 'corno', 'cretino', 'escroto', 'escrota', 'estúpido', 'estuprador', 'fdp', 'cuzão',
            'filha da puta', 'fodido', 'fodida', 'idiota', 'imbecil', 'lazarento', 'mocorongo', 'otário', 'otária',
            'retardada', 'safado', 'safada', 'tarado', 'tarada', 'trouxa', 'troxa', 'filho da égua', 'retardado',
            'vagabundo', 'vagabunda', 'viado', 'viadinho', 'boquete', 'pau no cu', 'pau no cú', 'merdinha', 'merdão',
            'mongoloide', 'mongolóide', 'viadão', 'desgraçado', 'desgraçada', 'safadão', 'safadona', 'vadio', 'vadia',
        ];
    }

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        foreach ($this->palavrasInapropriadas as $palavra) {
            if (stripos(" $value ", $palavra) !== false) {
                $fail('O campo "' . ucwords($attribute) . '" contém palavras inadequadas');
            }
        }
    }
}

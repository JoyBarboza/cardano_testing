<?php

return [ 

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines - Linhas de Linguagem de Validação    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.

    |As seguintes linhas de idioma contêm as mensagens de erro padrão usadas por
    | a classe do validador. Algumas dessas regras possuem múltiplas versões, como
    | como as regras de tamanho. Não hesite em ajustar cada uma dessas mensagens aqui.    */

    'accepted'             => 'The: O atributo deve ser aceito.',
    'active_url'           => 'The :O atributo: não é um URL válido.',
    'after'                => 'The :O atributo deve ser uma data após: data.',
    'after_or_equal'       => 'The: O atributo deve ser uma data posterior ou igual a: data.',
    'alpha'                => 'The: O atributo só pode conter letras.',
    'alpha_dash'           => 'The: O atributo só pode conter letras, números e traços.',
    'alpha_num'            => 'The :O atributo só pode conter letras e números.',
    'array'                => 'The :O atributo deve ser uma matriz.',
    'before'               => 'The :O atributo deve ser uma data anterior: data.',
    'before_or_equal'      => 'The :O atributo deve ser uma data anterior ou igual a: data.',
    'between'              => [
        'numeric' => 'The :O atributo deve estar entre: min e: máximo.',
        'file'    => 'The :o atributo deve estar entre: min e: kilobytes máximos.',
        'string'  => 'The :O atributo deve estar entre: min e: caracteres máximos.',
        'array'   => 'The :o atributo deve ter entre: min e: itens máximos.',
    ],
    'boolean'              => 'The :O campo de atributo deve ser verdadeiro ou falso.',
    'confirmed'            => 'The :A confirmação do atributo não corresponde.',
    'date'                 => 'The :O atributo não é uma data válida.',
    'date_format'          => 'The :O atributo não corresponde ao formato: formato.',
    'different'            => 'The :O atributo e: outro deve ser diferente.',
    'digits'               => 'The :o atributo deve ser: dígitos dígitos.',
    'digits_between'       => 'The :O atributo deve estar entre: min e: dígitos máximos.',
    'dimensions'           => 'The :O atributo possui dimensões de imagem inválidas.',
    'distinct'             => 'The :campo de atributo tem um valor duplicado.',
    'email'                => 'The :O atributo deve ser um endereço de e-mail válido.',
    'exists'               => 'The : selecionado: o atributo é inválido.',
    'file'                 => 'The :O atributo deve ser um arquivo.',
    'filled'               => 'The :campo atributo deve ter um valor.',
    'image'                => 'The :o atributo deve ser uma imagem.',
    'in'                   => 'The: selecionado: o atributo é inválido.',
    'in_array'             => 'The :campo de atributo não existe em: outro.',
    'integer'              => 'The :o atributo deve ser um número inteiro.',
    'ip'                   => 'The :O atributo deve ser um endereço IP válido.',
    'ipv4'                 => 'The :O atributo deve ser um endereço IPv4 válido.',
    'ipv6'                 => 'The :O atributo deve ser um endereço IPv6 válido.',
    'json'                 => 'The :O atributo deve ser uma string JSON válida.',
    'max'                  => [
        'numeric' => 'The :o atributo não pode ser maior que: max.',
        'file'    => 'The :O atributo não pode ser maior do que: kilobytes máximos.',
        'string'  => 'The :o atributo não pode ser maior do que: caracteres máximos.',
        'array'   => 'The :O atributo pode não ter mais do que: itens máximos.',
    ],
    'mimes'                => 'The :O atributo deve ser um arquivo de tipo:: valores.',
    'mimetypes'            => 'The :O atributo deve ser um arquivo de tipo:: valores.',
    'min'                  => [
        'numeric' => 'The :o atributo deve ser pelo menos: min.',
        'file'    => 'The :O atributo deve ser pelo menos: min kilobytes.',
        'string'  => 'The :O atributo deve ser pelo menos: caracteres min..',
        'array'   => 'The :o atributo deve ter pelo menos: itens mínimos.',
    ],
    'not_in'               => 'The selecionado: o atributo é inválido.',
    'numeric'              => 'The :O atributo deve ser um número.',
    'present'              => 'The :campo de atributo deve estar presente.',
    'regex'                => 'The :O formato do atributo é inválido.',
    'required'             => 'The :O campo de atributo é necessário.',
    'required_if'          => 'The :O campo de atributo é necessário quando: outro é: valor.',
    'required_unless'      => 'The :O campo de atributo é necessário a menos que: outro esteja em: valores.,campo de atributo é necessário quando: valores estão presentes. ',   
'required_with'        => 'The :O campo de atributo é necessário quando: valores estão presentes.',
    'required_with_all'    => 'The :O campo de atributo é necessário quando: valores estão presentes.',
    'required_without'     => 'The :O campo de atributo é necessário quando: valores não estão presentes. ',
    'required_without_all' => 'The :O campo de atributo é necessário quando nenhum de: valores estão presentes. ',
    'same'                 => 'The :O atributo e: outro deve corresponder. ',
    'Tamanho'                => [
        'numeric' => 'The :O atributo deve ser: tamanho.',
        'file'    => 'The :O atributo deve ser: tamanho kilobytes.',
        'string'  => 'The :O atributo deve ser: caracteres de tamanho.',
        'array'   => 'The :O atributo deve conter: itens de tamanho.',
    ],
    'string'               => 'The :O atributo deve ser uma string.',
    'timezone'             => 'The :o atributo deve ser uma zona válida.',
    'unique'               => 'The :O atributo já foi feito.',
    'uploaded'             => 'The :O atributo não foi carregado.',
    'url'                  => 'The :O formato do atributo é inválido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines - Linha de idioma de validação personalizada    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.

    || Aqui você pode especificar mensagens de validação personalizadas para atributos usando o
    | convenção "attribute.rule" para nomear as linhas. Isso torna rápido
    | especifique uma linha de idioma personalizado específica para uma determinada regra de atributo.    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'mensagem personalizada',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes - Atributos de validação personalizados    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.

    | As seguintes linhas de idioma são usadas para trocar os titulares de atributo
    | com algo mais amigável para o leitor, como o endereço de e-mail em vez disso
    | de "e-mail". Isso simplesmente nos ajuda a fazer mensagens um pouco mais limpas.    */

    'attributes' => [],

];

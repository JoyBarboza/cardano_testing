<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'The :属性を受け入れる必要があります.',
    'active_url'           => 'The :属性は有効なURLではありません.',
    'after'                => 'The :属性は、日付の後の日付でなければなりません。',
    'after_or_equal'       => 'The :属性は、日付以下の日付でなければなりません。',
    'alpha'                => 'The :属性は文字のみを含むことができます。',
    'alpha_dash'           => 'The :属性には、文字、数字、およびダッシュのみを含めることができます。',
    'alpha_num'            => 'The :属性には文字と数字のみを含めることができます。',
    'array'                => 'The :属性は配列でなければなりません。',
    'before'               => 'The :属性は日付でなければならない 前： 日付。',
    'before_or_equal'      => 'The :属性は日付の前の日付でなければなりません。',
    'between'              => [
        'numeric' => 'The :属性は、最小値と最大値の間でなければなりません。',
        'file'    => 'The :属性は、最小値と最大値の間でなければなりません。',
        'string'  => 'The :属性は、最小値と最大値の間にある必要があります。',
        'array'   => 'The :属性は最小値と最大値の間にある必要があります。',
    ],
    'boolean'              => 'The :属性フィールドはtrueまたはfalseでなければなりません。',
    'confirmed'            => 'The :属性の確認が一致しません。',
    'date'                 => 'The :属性は有効な日付ではありません。',
    'date_format'          => 'The :属性が一致しません フォーマット：フォーマット。',
    'different'            => 'The :他は異なっていなければなりません。',
    'digits'               => 'The :属性は数字でなければなりません。',
    'digits_between'       => 'The :属性は、最小値と最大値の間にある必要があります。',
    'dimensions'           => 'The :属性に無効な画像サイズがあります。',
    'distinct'             => 'The :属性フィールドに重複値があります。',
    'email'                => 'The :属性は有効な電子メールアドレスでなければなりません。',
    'exists'               => 'The 選択された：属性が無効です。',
    'file'                 => 'The :属性はファイルでなければなりません。',
    'filled'               => 'The :属性フィールドには値が必要です。',
    'image'                => 'The :属性はイメージでなければなりません。',
    'in'                   => 'The 選択：属性が無効です。',
    'in_array'             => 'The :属性フィールドが存在しません：その他。',
    'integer'              => 'The :属性は整数でなければなりません。',
    'ip'                   => 'The :属性は有効なIPアドレスでなければなりません。',
    'ipv4'                 => 'The :属性は有効なIPv4アドレスでなければなりません。',
    'ipv6'                 => 'The :属性は有効なIPv6アドレスでなければなりません。',
    'json'                 => 'The :属性は有効なJSON文字列でなければなりません。',
    'max'                  => [
        'numeric' => 'The :属性は最大値以下にすることができます.',
        'file'    => 'The :属性は、最大キロバイトを超えてはならない。',
        'string'  => 'The :属性は最大文字より大きくてはならない。',
        'array'   => 'The :アトリビュートは最大値以下のアイテムを持つことはできません。',
    ],
    'mimes'                => 'The :属性は：：値のタイプのファイルでなければなりません。',
    'mimetypes'            => 'The :属性は：：値のタイプのファイルでなければなりません。',
    'min'                  => [
        'numeric' => 'The :属性は少なくとも最小値でなければなりません。',
        'file'    => 'The :属性は少なくとも最小キロバイトでなければなりません。',
        'string'  => 'The :属性は最小文字以上でなければなりません。',
        'array'   => 'The :属性には少なくとも：最小限のアイテムが必要です.',
    ],
    'not_in'               => 'The selected :属性が無効です。',
    'numeric'              => 'The :属性は数値でなければならない.',
    'present'              => 'The :属性フィールドが存在する必要があります。',
    'regex'                => 'The :属性形式が無効です。',
    'required'             => 'The :属性フィールドが必要です。',
    'required_if'          => 'The :次の場合に属性フィールドが必要です。その他は：値です。',
    'required_unless'      => 'The :次の場合を除き、属性フィールドは必須です。他は：値',
    'required_with'        => 'The :属性フィールドは、値が存在する場合に必要です。',
    'required_with_all'    => 'The :属性フィールドは、値が存在する場合に必要です。',
    'required_without'     => 'The :次の場合に属性フィールドが必要です。値は存在しません。',
    'required_without_all' => 'The :値が存在しない場合は、属性フィールドが必要です。',
    'same'                 => 'The :他のものと一致しなければならない。',
    'size'                 => [
        'numeric' => 'The :属性は、サイズ。',
        'file'    => 'The :属性は、サイズキロバイトでなければなりません。',
        'string'  => 'The :属性は、サイズ文字でなければなりません。',
        'array'   => 'The :属性にはサイズ項目が含まれていなければなりません。',
    ],
    'string'               => 'The :属性は文字列でなければなりません。',
    'timezone'             => 'The :属性は有効なゾーンでなければなりません。',
    'unique'               => 'The :属性はすでに取得されています。',
    'uploaded'             => 'The :属性のアップロードに失敗しました。',
    'url'                  => 'The :属性形式が無効です。',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'カスタムメッセージ',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];

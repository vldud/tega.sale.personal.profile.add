<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$arComponentParameters = [
    "GROUPS" => [
        "HTML_ATTRIBUTES" => [
            "NAME" => \Bitrix\Main\Localization\Loc::getMessage("HTML_ATTRIBUTES_GROUP"),
            "SORT" => 100
        ],
    ],
    'PARAMETERS' => [
        "AJAX_MODE" => [],
        'CACHE_TIME' => [
            'DEFAULT' => 3600
        ],
        "SUCCESS_PAGE" => array(
            'NAME' => \Bitrix\Main\Localization\Loc::getMessage("SUCCESS_PAGE"),
            'TYPE' => 'STRING',
            'MULTIPLE' => 'N',
            "DEFAULT" => "",
            'PARENT' => 'BASE'
        ),
        "FORM_NAME" => [
            'NAME' => \Bitrix\Main\Localization\Loc::getMessage("FORM_NAME"),
            'TYPE' => 'STRING',
            'MULTIPLE' => 'N',
            "DEFAULT" => "add_profile_form",
            'PARENT' => 'HTML_ATTRIBUTES'
        ],
        "FORM_ID" => [
            'NAME' => \Bitrix\Main\Localization\Loc::getMessage("FORM_ID"),
            'TYPE' => 'STRING',
            'MULTIPLE' => 'N',
            "DEFAULT" => "add_profile_form",
            'PARENT' => 'HTML_ATTRIBUTES'
        ],
        "ENABLE_VALIDATION_INPUT_NAME" => [
            'NAME' => \Bitrix\Main\Localization\Loc::getMessage("ENABLE_VALIDATION_INPUT_NAME"),
            'TYPE' => 'STRING',
            'MULTIPLE' => 'N',
            "DEFAULT" => "validation",
            'PARENT' => 'HTML_ATTRIBUTES'
        ],
        "ENABLE_VALIDATION_INPUT_ID" => [
            'NAME' => \Bitrix\Main\Localization\Loc::getMessage("ENABLE_VALIDATION_INPUT_ID"),
            'TYPE' => 'STRING',
            'MULTIPLE' => 'N',
            "DEFAULT" => "add_profile_form_validation",
            'PARENT' => 'HTML_ATTRIBUTES'
        ]
    ]
];
?>
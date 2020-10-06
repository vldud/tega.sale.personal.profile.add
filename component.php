<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

\Bitrix\Main\Loader::IncludeModule("sale");

$arResult = [
    "PROPERTIES" => [],
    "PERSON_TYPES" => [],
    "ERRORS" => []
];
$form = $_POST[$arParams["FORM_NAME"]];
$isValidationEnabled = $_POST[$arParams["ENABLE_VALIDATION_INPUT_NAME"]] == "Y";

$personTypes = CSalePersonType::GetList(
    ["SORT" => "ASC"],
    ["LID" => SITE_ID]
);
while ($personType = $personTypes->Fetch()) {
    $arResult["PERSON_TYPES"][$personType["ID"]] = $personType;
    if ($personType["ID"] == $form["PERSON_TYPE"]) {
        $arResult["SELECTED_PERSON_TYPE"] = $personType["ID"];
    }
}
if (!isset($arResult["SELECTED_PERSON_TYPE"]) && !empty($arResult["PERSON_TYPES"])) {
    reset($arResult["PERSON_TYPES"]);
    $arResult["SELECTED_PERSON_TYPE"] = key($arResult["PERSON_TYPES"]);
}

$dbRes = \Bitrix\Sale\Property::getList([
    'select' => ['*'],
    'filter' => [
        'PERSON_TYPE_ID' => $arResult["SELECTED_PERSON_TYPE"],
        'USER_PROPS' => 'Y'
    ],
    'order' => ['SORT' => 'ASC']
]);
while ($property = $dbRes->fetch()) {
    if ($form["PROPERTIES"][$property["ID"]]) {
        $property["VALUE"] = htmlspecialcharsEx($form["PROPERTIES"][$property["ID"]]);
        if ($property["IS_PROFILE_NAME"] == "Y"){
            $profileName = $property["VALUE"];
        }
    }
    $arResult["PROPERTIES"][] = $property;
}

if(isset($form) && check_bitrix_sessid()){
    if (!empty($arResult["PROPERTIES"]) && $isValidationEnabled) {
        foreach ($arResult["PROPERTIES"] as $property) {
            if (
                $property["REQUIRED"] == "Y" &&
                strlen($property["VALUE"]) == 0
            ) {
                $arResult["ERRORS"][] = \Bitrix\Main\Localization\Loc::getMessage("REQUIRED_FIELD") .
                    "\"" .
                    $property["NAME"] .
                    "\"";
            }
        }
        if(empty($arResult["ERRORS"])){
            $arFields = array(
                "NAME" => (isset($profileName)) ?
                    $profileName :
                    \Bitrix\Main\Localization\Loc::getMessage("DEFAULT_PROFILE_NAME") . " " . date("d.m.Y"),
                "USER_ID" => $USER->GetID(),
                "PERSON_TYPE_ID" => $arResult["SELECTED_PERSON_TYPE"]
            );
            $profileId = CSaleOrderUserProps::Add($arFields);
            if ($profileId) {
                foreach ($arResult["PROPERTIES"] as $property) {
                    CSaleOrderUserPropsValue::Add([
                        "USER_PROPS_ID" => $profileId,
                        "ORDER_PROPS_ID" => $property["ID"],
                        "NAME" => $property["NAME"],
                        "VALUE" => $property["VALUE"]
                    ]);
                }
                if ($arParams["SUCCESS_PAGE"] != "") {
                    LocalRedirect($arParams["SUCCESS_PAGE"], true);
                } else {
                    $arResult["SHOW_SUCCESS_MESSAGE"] = "Y";
                }
            }
        }
    }
}

$this->IncludeComponentTemplate();
<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);

if ($arResult["SHOW_SUCCESS_MESSAGE"] == "Y") {
    echo \Bitrix\Main\Localization\Loc::getMessage("SUCCESS_MESSAGE");
    return;
}
?>
<script type="text/javascript">
    function submitForm(val) {
        BX('<? echo $arParams["ENABLE_VALIDATION_INPUT_ID"]; ?>').value = (val !== 'Y') ? "N" : "Y";
        console.log(BX('<? echo $arParams["ENABLE_VALIDATION_INPUT_ID"]; ?>').value);
        BX.submit(BX('<? echo $arParams["FORM_ID"]; ?>'));
        return true;
    }

    BX.showWait = function () {
        return false;
    };
    BX.closeWait = function () {
        return false;
    };
</script>
<?
if (!empty($arResult["ERRORS"])) {
    foreach ($arResult["ERRORS"] as $error) {
        echo $error . "<br/>";
    }
}
?>
<form method="post"
      id="<? echo $arParams["FORM_ID"]; ?>"
      name="<? echo $arParams["FORM_NAME"]; ?>"
      action="<? echo $arParams["FORM_ACTION"]; ?>">
    <input type="hidden"
           name="<? echo $arParams["ENABLE_VALIDATION_INPUT_NAME"]; ?>"
           id="<? echo $arParams["ENABLE_VALIDATION_INPUT_ID"]; ?>"
           value="Y">
    <?= bitrix_sessid_post() ?>
    <?
    if (!empty($arResult["PERSON_TYPES"]) && count($arResult["PERSON_TYPES"]) > 1) {
        foreach ($arResult["PERSON_TYPES"] as $personType) {
            ?>
            <label for="<?= $personType["ID"] ?>">
                <input type="radio"
                       name="<? echo $arParams["FORM_NAME"]; ?>[PERSON_TYPE]"
                       onchange="submitForm(); return false;"
                       id="PERSON_TYPE_<?= $personType["ID"] ?>"
                    <? if ($personType["ID"] == $arResult["SELECTED_PERSON_TYPE"]) {
                        echo "checked";
                    } ?>
                       value="<?= $personType["ID"] ?>">
                <?= $personType["NAME"] ?>
            </label>
            <?
        }
    }
    if (!empty($arResult["PROPERTIES"])) {
        foreach ($arResult["PROPERTIES"] as $property) { ?>
            <br>
            <label for="<?= $property["ID"] ?>">
                <?= $property["NAME"] ?>
                <?= $property["REQUIRED"] == "Y" ? "*" : "" ?>
                <input type="text"
                       name="<?= $arParams["FORM_NAME"]; ?>[PROPERTIES][<?= $property["ID"] ?>]"
                       id="PROPERTY_<?= $property["ID"] ?>"
                       value="<?= isset($property["VALUE"]) ? $property["VALUE"] : ""; ?>">
            </label>
            <?
        }
    }
    ?>
    <br>
    <button onclick="submitForm('Y'); return false;">
        <? echo \Bitrix\Main\Localization\Loc::getMessage("SAVE_BUTTON"); ?>
    </button>
</form>

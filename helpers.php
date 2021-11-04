<?php
require_once "src/Exceptions/ValidationException.php";
require_once "src/Exceptions/RequiredValidationException.php";
require_once "src/Exceptions/TooShortValidationException.php";
require_once "src/Exceptions/TooLongValidationException.php";

function clean(string $value) {
    $value = trim($value);
    return htmlspecialchars($value);
}

function isPost(): bool {
    return $_SERVER["REQUEST_METHOD"] === "POST";
}

function validate_string(string $string, int $minLength = 1, int $maxLength = 50000): bool {
    if (empty($string)) {
        throw new RequiredValidationException("Required string");
    }
    if (strlen($string) < $minLength) {
        throw new TooShortValidationException("String is short");
    }
    if (strlen($string) > $maxLength) {
        throw new TooLongValidationException("String is long");
    }
    return true;
}

function getFileExtension(string $filename) {
    $mime = "";
    try {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $filename);
        if ($mime === false)
            throw new Exception();
    }
    finally {
        finfo_close($finfo);
    }
    return $mime;
}

function validate_phone(string $phone):bool {
    if (!preg_match("/^\d{9}$/", $phone)) {
        throw new InvalidPhoneValidationException("Telèfon invàlid");
    }
    return true;
}

function validate_email(string $email): bool {
    if (empty(filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL))) {
        throw new InvalidEmailValidationException("Invalid email");
    }
    return true;
}

function is_selected(string $value, array $array): bool {
    if (in_array($value, $array)) {
        return true;
    }
    return false;
}

function validate_date(string $date): bool {

    if (DateTime::createFromFormat("Y-m-d", $date)===false) {
        return false;
    }
    $errors = DateTime::getLastErrors();
    if (count($errors["warnings"])>0 || count($errors["errors"])>0) {
        return false;
    }
    return true;
}

function validate_elements_in_array_keys(array $needle, array $haystack): bool {
    $diff =  ((!array_diff_key(array_flip($needle), $haystack)));
    if (!$diff) {
        throw new InvalidKeyValidationException("Invalid element");
    }
    return $diff;
}
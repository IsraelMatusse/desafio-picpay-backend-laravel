<?php
namespace App\Validators;
class FieldsValidator{

public function validateName(string $name): void {
    if (!ctype_alpha($name)) {
        throw new InvalidArgumentException("Name should only contain letters.");
    }
}

public function validateBi(string $bi): void {
    if (strlen($bi) !== 9) {
        throw new InvalidArgumentException("BI must have 9 characters.");
    }
}
public function validateUserType($userType):void{
    if (strcasecmp($userType, 'customer') !== 0 && strcasecmp($userType, 'seller') !== 0) {
        throw new InvalidArgumentException("User type invalid");
    }
}
}


?>
<?php
namespace App\utils;
use Illuminate\Support\Str;
class GenerateCodes{
//this method will combine the date the transaction happened and the users
function generateTransactionReference(){
    $timeStamp=now()->format('Ymdis');
    $randomStrings=Str::random(10);
    $transactionReferrence="{$timeStamp}{$randomStrings}";
    return $transactionReferrence;
}

}
?>
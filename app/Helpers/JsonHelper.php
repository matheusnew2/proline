<?php
namespace App\Helpers;
class JsonHelper
{
    public static function convertPayload($payloadArray)
    {
        $convertedArray = [];
        foreach($payloadArray as $campo => $value)
        {
            $campo = self::camelCaseToSnakeCase($campo);
            $convertedArray[$campo] = $value;    
        }
        return $convertedArray;
    }
    public static function camelCaseToSnakeCase($camelCaseString)
    {
        $snakeCaseString = preg_replace('/(?<!^)([A-Z])/', '_$1', $camelCaseString);
        $snakeCaseString = strtolower($snakeCaseString);
        return $snakeCaseString;
    }
}
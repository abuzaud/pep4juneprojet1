<?php
/**
 * Created by Antoine Buzaud.
 * Date: 11/07/2018
 */

namespace App\Traits;


trait HelperTrait
{
    /**
     * Permet de supprimer les dimensions d'un tableau
     * @param $arrayToFlatten
     * @return array
     */
    public static function flattenArray($arrayToFlatten){
        $flatArray = array();

        foreach($arrayToFlatten as $element) {
            if (is_array($element)) {
                $flatArray = array_merge($flatArray, self::flattenArray($element));
            } else {
                $flatArray[] = $element;
            }
        }
        return $flatArray;
    }
}
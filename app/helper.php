<?php
/**
 * Display the error messages
 *
 * @param $errors
 * @param $fieldName
 * @param null $object
 * @param null $oldModalName
 * @param null $modelName
 * @param null $databaseFieldName
 * @return mixed|string
 */
function showOldData($errors, $fieldName, $object = null, $oldModalName = null, $modelName = null, $databaseFieldName = null)
{
    if ((count($errors) > 0) && ($oldModalName == $modelName)) {
        return old($fieldName);
    } else {
        if ($object != null) {
            if ($databaseFieldName != null) {
                return $object[$databaseFieldName];
            } else {
                return $object[$fieldName];
            }
        } else {
            return '';
        }
    }
}

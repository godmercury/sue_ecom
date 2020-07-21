<?php
namespace App\Classes;

use Illuminate\Database\Capsule\Manager as Capsule;

class ValidateRequest
{
    private static $error = [];
    private static $error_message = [
        'unique' => 'That :attribute is already taken, please try another one',
        'requried' => 'The :attribute field is requried',
        'minLength' => 'The :attribute field must be a minimum of :policy characters',
        'maxLength' => 'The :attribute field must be a maximum of :policy characters',
        'email' => 'Email address is not vaild',
        'mixed' => 'The :attribute field can contain letters, numbers, dash and space only',
        'string' => 'The :attribute field can not contain numbers',
        'number' => 'The :attribute field can not contain letters'
    ];

    /**
     * @param array $dataAndValues, column and value to validate
     * @param array $policies, the rules that validation must satisfy
     */
    public function abide(array $dataAndValues, array $policies)
    {
        foreach ($dataAndValues as $column => $value)  {
            if (in_array($column, array_keys($policies))) {
                // do validation
                self::doValidation(
                    [
                        'column' => $column,
                        'value' => $value,
                        'policies' => $policies[$column]
                    ]
                );
            }
        }
    }

    /**
     * return true if there is validation error
     *
     * @return bool
     */
    public function hasError()
    {
        return count(self::$error) > 0 ? true : false;
    }

    /**
     * return all validation errors
     *
     * @return array
     */
    public function getErrorMessage()
    {
        return self::$error;
    }

    /**
     * Check empty value
     *
     * @param $value
     * @return bool
     */
    private static function isEmpty($value)
    {
        if ($value === null || empty(trim($value))) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Perform validation for the data provider and set error message
     *
     * @param array $data
     */
    private static function doValidation(array $data)
    {
        $column = $data['column'];
        foreach ($data['policies'] as $rule => $policy) {
            $valid = call_user_func_array([self::class, $rule], [$column, $data['value'], $policy]);
            if (!$valid) {
                self::setError(
                    str_replace(
                        [':attribute', ':policy', '_'],
                        [$column, $policy, ' '],
                        self::$error_message[$rule]), $column
                );
            }
        }
    }

    /**
     * Set specific error
     *
     * @param $error
     * @param null $key
     */
    private static function setError($error, $key = null)
    {
        if ($key) {
            self::$error[$key][] = $error;
        } else {
            self::$error[] = $error;
        }
    }


    /**
     * @param $column
     * @param $value
     * @param $policy
     * @return bool
     */
    protected static function unique($column, $value, $policy)
    {
        if (self::isEmpty($value)) {
            return !Capsule::table($policy)->where($column, '=', $value)->exists();
        }
        return true;
    }

    protected static function requried($column, $value, $policy)
    {
        return $value !== null && !empty(trim($value));
    }

    protected static function minLength($column, $value, $policy)
    {
        if (self::isEmpty($value)) {
            return strlen($value) >= $policy;
        }
        return true;
    }

    protected static function maxLength($column, $value, $policy)
    {
        if (self::isEmpty($value)) {
            return strlen($value) <= $policy;
        }
        return true;
    }

    protected static function email($column, $value, $policy)
    {
        if (self::isEmpty($value)) {
            return filter_var($value, FILTER_VALIDATE_EMAIL);
        }
        return true;
    }

    protected static function mixed($column, $value, $policy)
    {
        if (self::isEmpty($value)) {
            if (!preg_match('/^[A-Za-z0-9 .,_~\-!@#\&%\^\'\*\(\)]+$/', $value)) {
                return false;
            }
        }
        return true;
    }

    protected static function string($column, $value, $policy)
    {
        if (self::isEmpty($value)) {
            if (!preg_match('/^[A-Za-z ]+$/', $value)) {
                return false;
            }
        }
        return true;
    }

    protected static function number($column, $value, $policy)
    {
        if (self::isEmpty($value)) {
            if (!preg_match('/^[0-9.]+$/', $value)) {
                return false;
            }
        }
        return true;
    }
}
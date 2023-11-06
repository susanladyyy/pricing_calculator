<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidFormula implements Rule
{
    public function passes($attribute, $value)
    {
        try {
            $numeric_value = explode(" ", $value);

            for ($i = 0; $i < count($numeric_value); $i += 2) {
                $numeric_value[$i] = 1;
            }

            $newValue = implode(" ", $numeric_value);

            // Attempt to evaluate the provided value as an expression
            eval("\$result = $newValue;");

            // You can add additional checks here if necessary
            // For example, check the data type of $result, or specific conditions

            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function message()
    {
        return 'Formula entered is not valid.';
    }
}
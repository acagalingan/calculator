<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Num2Checker implements ValidationRule
{
    public function __construct($param)
    {
        $this->operand = $param;
    }
        /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->operand === '/' && $value == 0) {
            $fail('Division by Zero is Not Allowed');
        }

        if ($this->operand == 'sqrt' && !empty($value)) {
            $fail('Num2 is invalid for square root operation');
        }
        
        if ($this->operand != 'sqrt' && !is_numeric($value)) {
            $fail('Num2 should be a numeric value');
        }
    }
}

<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Lowercase implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // if (mb_strtolower($value) !== $value) {
        //     $fail("The $attribute field must be lowercase.");
        // }

        if (mb_strtolower($value) !== $value) {
            $fail("validation.custom.lowercase")->translate([
                'attribute' => $attribute,
                'value' => $value
            ]);
        }
    }
}

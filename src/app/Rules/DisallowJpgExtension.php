<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DisallowJpgExtension implements Rule
{
    public function passes($attribute, $value)
    {
        if (!$value) return true;

        $ext = strtolower($value->getClientOriginalExtension());

        return $ext !== 'jpg';
    }

    public function message()
    {
        return '「.png」または「.jpeg」形式でアップロードしてください';
    }
}

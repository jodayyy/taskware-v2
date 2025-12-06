<?php

declare(strict_types=1);

namespace App\Http\Requests\Concerns;

trait ValidatesPassword
{
    /**
     * Get password validation rules.
     *
     * @return array<int, string>
     */
    protected function passwordRules(bool $requireConfirmation = true): array
    {
        $rules = [
            'required',
            'string',
            'min:8',
            'regex:/[a-z]/',      // at least one lowercase letter
            'regex:/[A-Z]/',      // at least one uppercase letter
            'regex:/[0-9]/',      // at least one digit
            'regex:/[^A-Za-z0-9]/', // at least one special character
        ];

        if ($requireConfirmation) {
            $rules[] = 'confirmed';
        }

        return $rules;
    }

    /**
     * Get password validation message.
     */
    protected function passwordMessage(): string
    {
        return 'The password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.';
    }
}


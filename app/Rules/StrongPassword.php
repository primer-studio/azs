<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class StrongPassword implements Rule
{
    /**
     * @var int
     */
    private $minLength;
    /**
     * @var int
     */
    private $maxLength;

    /**
     * Create a new rule instance.
     *
     * @param int $minLength
     * @param int $maxLength
     */
    public function __construct($minLength = 10, $maxLength = 30)
    {
        //
        $this->minLength = $minLength;
        $this->maxLength = $maxLength;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@()$%^&*=_{}[\]:;\"'|\\<>,.\/~`±§+-]).{" . $this->minLength . "," . $this->maxLength . "}$/", $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.custom.strong_password', ['minLength' => $this->minLength, 'maxLength' => $this->maxLength]);
    }
}

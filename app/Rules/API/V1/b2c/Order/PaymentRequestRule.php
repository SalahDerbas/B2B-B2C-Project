<?php

namespace App\Rules\API\V1\b2c\Order;

use Illuminate\Contracts\Validation\Rule;

class PaymentRequestRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     * @author Salah Derbas
     */
    protected $data;
    public function __construct($data)
    {
        // dd($data);
        $this->data = $data;
    }

    /**
     * Validate and manage the user based on the provided Facebook ID.
     * Creates a new user if none exists, or updates the existing user's information.
     *
     * @param string $attribute The attribute being validated (not used here).
     * @param mixed $value The value being validated (not used here).
     * @return bool Always returns true.
     * @author Salah Derbas
     */
    public function passes($attribute, $value)
    {
        dd($this->data );

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     * @author Salah Derbas
     */
    public function message()
    {
        return 'The payment request validation failed';
    }
}

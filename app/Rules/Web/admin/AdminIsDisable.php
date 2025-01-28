<?php

namespace App\Rules\Web\admin;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Admin;

class AdminIsDisable implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     * @author Salah Derbas
     */
    protected $email = null;
    public function __construct($email)
    {
        $this->email =  $email ;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     * @author Salah Derbas
     */
    public function passes($attribute, $value)
    {
        return Admin::where('email' , $email)->pluck('status')->first();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     * @author Salah Derbas
     */
    public function message()
    {
        return 'Admin is disabled';
    }
}

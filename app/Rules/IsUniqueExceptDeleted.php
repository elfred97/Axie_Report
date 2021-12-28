<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\User;

class IsUniqueExceptDeleted implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $sanitizeUsername = filter_var(preg_replace('/\s+/','',$value),FILTER_SANITIZE_STRING);
        $countUser = User::where('username',$sanitizeUsername)->where('status','!=',3)->count();

        return $countUser > 0 ? false : true;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The username must be unique';
    }
}

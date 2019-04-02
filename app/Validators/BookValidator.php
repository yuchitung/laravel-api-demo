<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class BookValidator.
 *
 * @package namespace App\Validators;
 */
class BookValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => "required|string",
            'author' => "required|string",
            'price' => 'required|numeric|between:0.01,1000000000.99'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => "required|string",
            'author' => "required|string",
            'price' => 'required|numeric|between:0.01,1000000000.99'
        ],
    ];
}

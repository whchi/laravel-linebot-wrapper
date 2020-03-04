<?php

namespace Whchi\LaravelLineBotWrapper\Traits;

use Illuminate\Support\Facades\Validator;
use Whchi\LaravelLineBotWrapper\Exceptions\MessageBuilderException;

trait MessageValidator
{
    public function validate(array $ipt, array $rule)
    {
        $validator = Validator::make($ipt, $rule);
        if ($validator->fails()) {
            throw new MessageBuilderException($validator->errors()->__toString());
        }
    }
}

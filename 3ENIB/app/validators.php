<?php

Validator::extend('enib_email', function($attribute, $value, $parameters)
{
    return count(preg_grep( '/^(\w){2,}@enib.fr$/', [$value] , 0 )) == 1?true:false;
});

Validator::replacer('enib_email', function($message, $attribute, $rule, $parameters)
{
    return "Vous devez utiliser un mail enib";
});
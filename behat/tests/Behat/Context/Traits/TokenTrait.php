<?php

namespace Traits;

trait TokenTrait
{
    /**
     * @var array
     */
    private $fieldNames = [];
    /**
     * @var array
     */
    private $fieldValues = [];
    /**
     * @param string $string
     * @return mixed
     */
    protected function replaceToken(string $string)
    {
        return str_replace($this->fieldNames, $this->fieldValues, $string);
    }
}

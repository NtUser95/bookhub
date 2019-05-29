<?php

namespace App;

abstract class BaseForm
{

    private $_errors = [];

    public function load(): bool
    {
        $changed = false;
        foreach ($_POST as $key => $value) {
            if (strpos($key, '_') !== 0 && property_exists($this, $key)) {
                $this->$key = $value;
                $changed = true;
            }
        }

        return $changed;
    }

    public function validateUploadData(): bool
    {
        return true;
    }

    public abstract function handleUploadData();

    public function hasErrors()
    {
        return $this->_errors;
    }

    public function getErrors()
    {
        return $this->_errors;
    }

    public function addError(String $errMessage)
    {
        $this->_errors[] = $errMessage;
    }

    public function reset()
    {
        foreach (get_class_vars(get_class($this)) as $propName => $value) {
            if ($propName === 'error') {
                $this->$propName = [];
            } else {
                $this->$propName = null;
            }
        }
    }

}

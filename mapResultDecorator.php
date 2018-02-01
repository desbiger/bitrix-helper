<?php

namespace Icewood\Nedvijimost;

class mapResultDecorator extends arResultDecorator {
    public function __construct($fields, $autoValue = true)
    {
        $this->autoValue = $autoValue;
        parent::__construct($fields);
    }

    public function address($vol, $key)
    {
        return $this->Props()["address"]["VALUE"];

    }

    /**
     * @param mixed $name
     *
     * @return AutoValuer|mixed
     */
    public function offsetGet($name)
    {
        if (preg_match('/[IMAGE]+_([0-9]+)_([0-9]+)/', $name, $params)) {
            $array = [
                'NAME'  => 'Ôîòî',
                'VALUE' => (string)new ElementImage($this->element_id, $params)
            ];

            return $array;
        }

        return parent::offsetGet($name);
    }


}

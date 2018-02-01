<?php


namespace Icewood\Nedvijimost;


class DinamicProperties extends ArResultObject {


    public function __construct($fields, $autoValue = true)
    {
        if ($fields['ELEMENT_ID']) {
            $this->element_id = $fields['ELEMENT_ID'];
            unset($fields['ELEMENT_ID']);
        }
        $this->autoValue = $autoValue ?: true;

        parent::__construct($fields);
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
                'NAME'  => 'Фото',
                'VALUE' => (string)new ElementImage($this->element_id, $params)
            ];

            return $this->autoValue ? new AutoValuer($array) : $array;
        }

        return parent::offsetGet($name);
    }

}
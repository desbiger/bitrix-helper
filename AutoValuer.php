<?php


namespace Icewood\Nedvijimost;


class AutoValuer extends ArResultObject {


    /**
     * @param mixed $name
     *
     * @return mixed
     */
    public function offsetGet($name)
    {
        return is_array($this->fields[$name]) ? $this->fields[$name][0] : $this->fields[$name];
    }

}
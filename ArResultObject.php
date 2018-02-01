<?php


namespace Icewood\Nedvijimost;


use ArrayAccess;
use Icewood\ArrayObject;

class ArResultObject extends ArrayObject implements ArrayAccess {
    /**
     * @var
     */
    public $autoValue = true;
    public $fields;



    /**
     * Массив доп свойств
     * @return mixed
     */
    public function Props()
    {
        if (is_array($this->fields['PROPERTIES']))
            return new DinamicProperties($this->fields['PROPERTIES'] + ['ELEMENT_ID' => $this->fields['ID']]);

        return [];
    }


    /**
     * Получаем ресайз картинки
     *
     * @param $name
     *
     * @return mixed
     */
    protected function resizeImage($name)
    {

        $settings = $this->serialize($name);

        if ($settings['img'] == 'IMAGE') {
            return ['VALUE' => $name];

            return $this->resizeImage('DETAIL_PICTURE_' . implode('_', $settings['params']));
        }

        $var = is_array($this->fields[$settings['img']]) ? $this->fields[$settings['img']]['ID'] : $this->fields[$settings['img']];

        return \CFile::ResizeImageGet($var, $settings['params'],BX_RESIZE_IMAGE_EXACT) ? \CFile::ResizeImageGet($var, $settings['params'],BX_RESIZE_IMAGE_EXACT)['img'] : false;
    }


}
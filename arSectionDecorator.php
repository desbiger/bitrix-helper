<?php

namespace Icewood\Nedvijimost;

class arSectionDecorator {
    protected $IBLOCK_ID = 18;
    protected $section;

    /**
     * arSectionDecorator constructor.
     *
     * @param int|string $key
     */
    public function __construct($key)
    {
        $this->section = $this->getSectionByID($key);
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    private function getSectionByID($key)
    {
        return \CIBlockSection::GetList([], ['IBLOCK_ID' => $this->IBLOCK_ID, 'ID' => $key], null, ['UF_*'])->GetNext();
    }

    public function __get($name)
    {
        if ($this->section[$name])
            return $this->section[$name];
    }

    /**
     * @return array
     */
    public function CityFields()
    {
        $res = [];
        foreach ($this->UF_CITY_FIELDS as $id) {
            if ($this->getPropertyByID($id)) {

                $res[$id] = $this->getPropertyByID($id);
            }
        }

        return $res;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    private function getPropertyByID($id)
    {
        return \CIBLockProperty::GetByID($id)->Fetch();
    }

    /**
     * @param $ID
     *
     * @return bool
     */
    public function AvalibleCityTableField($ID)
    {
        return in_array($ID, array_keys($this->CityFields()));
    }

}
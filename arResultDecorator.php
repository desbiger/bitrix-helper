<?php
/**
 *
 * ������� ��� �������� ������� ������������
 *
 *
 *
 * �������� ������� ���������� ��������
 *
 * ������ ��������� ��� � ������� �������� $arItem['DETAIL_PICTURE_100_200']
 * ��� ��������� �������� DETAIL_PICTURE � PREVIEW_PICTURE
 *
 * �������� �������� ��������� ������ �� ������ ��������������.
 *
 * ���������� ���������� � ����� $arItem['Coordinates'] ���� ��� � ������� $arItem->Coordinates
 *
 * ��� ���������� ����� ��������� ��������� ���������� ������� �����
 * ����������� �� �������� public function getYourFieldAttribute() ��� YourField �������� ����, ��������� � ��������
 *������ ��������� �����. ��������� ������������� �������� ��� � ���� ����� ������� ��� � ��� �������� �������
 *
 */

namespace Icewood\Nedvijimost;


use Icewood\Objects;
use Icewood\Prefixes;

class arResultDecorator extends ArResultObject {

    use Prefixes;


    /**
     * ������� �������
     *
     * @param array $fields
     *
     * @return ArResultObject
     */
    static function init(Array $fields)
    {
        return new self($fields);
    }

    /**
     * ������ ���������� � ���� �������
     * @return mixed
     */
    public function getCoordinatesAttribute()
    {
        $map = data_get($this->Props(), "yandex_map.VALUE", false);

        if ($map) {
            $map = explode(",", $map);

            return $map;
        }

        return false;
    }

    /**
     * ��������� ������ ��� ������������ ����� �������������� �������
     *
     * @param $vol
     *
     * @return mixed
     */
    public function FormatValues()
    {

        foreach ($this->fields['PROPERTIES'] as $key => $vol) {
            switch ($key) {
                case 'deal_type':
                    $this->dealType($vol, $key);
                    break;

                case 'cost':

                    $this->cost($vol, $key);
                    break;

                case 'address':
                    $this->address($vol, $key);
                    break;

                default:
                    $result = $this->fields['PROPERTIES'][$key];
                    $this->fields['PROPERTIES'][$key] = $this->autoValue ? new AutoValuer($result) : $result;
                    break;
            }
        }
    }

    /**
     * @param $vol
     * @param $key
     */
    public function dealType($vol, $key)
    {
        $this->fields['PROPERTIES'][$key]['VALUE'] = Objects::GetTipSdelki($vol['VALUE']);
    }

    /**
     * @param $vol
     * @param $key
     */
    public function cost($vol, $key)
    {
        if ($this->fields['PROPERTIES'][$key]['VALUE']) {
            $newValue = number_format($vol['VALUE'], 0, ',', ' ') . ' <span style="font-size: 75%" class="icon-ruble"></span>';

            if (preg_match("|(.*) ([0-9]+)|", $vol['VALUE'], $matches)) {
                $newValue = $matches[1] . ' ' . number_format($matches[2], 0, ',', ' ') . ' <span style="font-size: 75%" class="icon-ruble"></span>';
            };

            $this->fields['PROPERTIES'][$key]['VALUE'] = $newValue;
        }
    }

    /**
     * @param $vol
     * @param $key
     */
    public function address($vol, $key)
    {
        $detailPage = $this->fields['DETAIL_PAGE_URL'];
        $id = $this['ID'];
        $this->fields['PROPERTIES'][$key]['VALUE'] = "<a class='map_balloon' data-id='$id' href='#'><span class='icon-map' style='color: #3598dc;'></span></a><a href='$detailPage'>{$vol['VALUE']}</a>";
    }


}

<?php


namespace Icewood\Nedvijimost;


use CIBlockElement;

class ElementImage {
    const DEFAULT_NOIMAGE = '/local/templates/citrus_arealty/images/no-photo.png';
    private $element_id;
    private $found;
    private $params;
    private $Element;

    /**
     * ElementImage constructor.
     *
     * @param $element_id
     * @param $resizeTo
     */
    public function __construct($element_id, $resizeTo)
    {

        $this->element_id = $element_id;
        $this->found = $resizeTo;
        $this->params($resizeTo);
        $this->Element = CIBlockElement::getByID($element_id)->fetch();
    }

    /**
     * путь до картинки
     * @return mixed
     */
    private function imgUri()
    {
        return $this->resizeDetail() ?: $this->resizePreview();
    }

    /**
     * Html картинки
     * @return string
     */
    public function img()
    {
        return "<img {$this->imgSizeTag()} src='{$this->imageSrc()}'>";
    }


    /**
     * @return string
     */
    public function __toString()
    {
        return $this->img();
    }


    /**
     * @param $found
     */
    private function params($found)
    {
        $this->params = [
            'width'  => $found[1],
            'height' => $found[2]
        ];

    }

    /**
     * @return mixed
     */
    private function resizeDetail()
    {
        return \CFile::ResizeImageGet($this->Element['DETAIL_PICTURE'], $this->params,BX_RESIZE_IMAGE_EXACT)['src'];
    }

    /**
     * @return mixed
     */
    private function resizePreview()
    {
        return \CFile::ResizeImageGet($this->Element['PREVIEW_PICTURE'], $this->params,BX_RESIZE_IMAGE_EXACT)['src'];
    }

    /**
     * @return string
     */
    public function imageSrc()
    {
        if (!$this->Element) {
            return self::DEFAULT_NOIMAGE;
        }

        return $this->imgUri() ?: self::DEFAULT_NOIMAGE;
    }

    /**
     * @return string
     */
    private function imgSizeTag()
    {
        return "width='{$this->params['width']}' height='{$this->params['height']}'";
    }
}
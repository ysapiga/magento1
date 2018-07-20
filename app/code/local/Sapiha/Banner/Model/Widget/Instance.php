<?php

class Sapiha_Banner_Model_Widget_Instance extends Mage_Widget_Model_Widget_Instance
{
    public function generateLayoutUpdateXml($blockReference, $templatePath = '')
    {
        $templateFilename = Mage::getSingleton('core/design_package')->getTemplateFilename($templatePath, array(
            '_area'    => $this->getArea(),
            '_package' => $this->getPackage(),
            '_theme'   => $this->getTheme()
        ));

        if (!$this->getId() && !$this->isCompleteToCreate()
            || ($templatePath && !is_readable($templateFilename)))
        {
            return '';
        }
        $parameters = $this->getWidgetParameters();
        $xml = '<reference name="' . $blockReference . '">';
        $template = '';

        if (isset($parameters['template'])) {
            unset($parameters['template']);
        }

        if ($templatePath) {
            $template = ' template="' . $templatePath . '"';
        }

        $hash = Mage::helper('core')->uniqHash();

        if ($this->getType() == 'sapiha_banner/catalog_banner'){
            $prefix = 'sapiha_banner_';
            $xml .= '<block type="' . $this->getType() . '" name="' . $prefix . $hash . '"' . $template . '>';
        } else {
            $xml .= '<block type="' . $this->getType() . '" name="' . $hash . '"' . $template . '>';
        }
        foreach ($parameters as $name => $value) {
            if (is_array($value)) {
                $value = implode(',', $value);
            }
            if ($name && strlen((string)$value)) {
                $xml .= '<action method="setData">'
                    . '<name>' . $name . '</name>'
                    . '<value>' . Mage::helper('widget')->escapeHtml($value) . '</value>'
                    . '</action>';
            }
        }
        $xml .= '</block></reference>';

        return $xml;
    }
}

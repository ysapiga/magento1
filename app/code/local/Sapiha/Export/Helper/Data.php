<?php

class Sapiha_Export_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Export file generation
     *
     * @param int $id
     * @return void
     */
    public function export($id)
    {
        $exportId = $id;
        $export = Mage::getModel('sapiha_export/export')->load($exportId);
        $collection = $this->prepareCollection($exportId);

        if ($collection->getSize()) {
            $collection->getSelect()
                ->group('e.entity_id');
            if ($export->getFormat() == '.yaml') {
                file_put_contents($this->setFileName($export), $this->toYaml($collection));
            }
            if ($export->getFormat() == '.json') {
                file_put_contents($this->setFileName($export), $this->toJSON($collection));
            }
            Mage::getSingleton('core/session')->addSuccess('Export file was successfully generated');
        } else {
            Mage::app()->getResponse()->setRedirect('*/*/index');
            Mage::getSingleton('core/session')->addError('Nothing to export');
        }
    }

    /**
     * Filtering product collection on addition to export requirements
     *
     * @param int $id
     * @return Sapiha_Export_Model_Resource_Export_Collection
     */
    public function prepareCollection($id)
    {
        $exportId = $id;
        $export = Mage::getModel('sapiha_export/export')->load($exportId);
        $categoryIds = explode(',', $export->getCategoryIds());
        $collection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect('*')
            ->joinField('category_id', 'catalog/category_product', 'category_id', 'product_id=entity_id', null, 'left')
            ->addAttributeToFilter('category_id', array('in' => $categoryIds))
            ->addAttributeToFilter('action', $export->getAction())
            ->addAttributeToFilter('provider', $export->getProviders())
            ->addAttributeToFilter('markdown', $export->getMarkdown())
            ->joinField('qty',
                'cataloginventory/stock_item',
                'qty',
                'product_id=entity_id',
                '{{table}}.stock_id=1',
                'left')
            ->addAttributeToFilter('qty', array('gteq' => $export->getMinimumQty()));

        return $collection;
    }

    /**
     * File name generation before export
     *
     * @param Sapiha_Export_Model_Export $export
     * @return string
     */
    public function setFileName(Sapiha_Export_Model_Export $export)
    {
        $fileManager = new Varien_Io_File();
        $dirName = Mage::getBaseDir('media') . DS . 'sapiha_export' . DS;

        if (!is_dir($dirName)) {
            $fileManager->mkdir($dirName);
        }

        return $dirName.$export->getFileName() . $export->getFormat();
    }

    /**
     * Filtering and convert data to yaml format
     *
     * @param $collection
     * @return string
     * @throws Mage_Core_Model_Store_Exception
     */
    public function toYaml($collection)
    {
        $padding = "    ";
        $date = Mage::getModel('core/date')->date('Y-m-d H:i:s');
        $content = "<?xml version=\"1.0\" encoding=\"windows-1251\"?>\n";
        $content .= "<!DOCTYPE yml_catalog SYSTEM \"shops . dtd\">\n";
        $content .= "<yml_catalog date=\"$date\">\n";
        $content .= $padding . "<offers>\n";
        $offerId = 1;

        foreach ($collection as $product) {
            $price = $product->getPrice();
            $qty = $product->getQty();
            $url = $product->getUrlPath();
            $currency = Mage::app()->getStore()->getCurrentCurrencyCode();
            $type = $product->getTypeId();
            $availible = $product->isAvailable() ? 'true' : 'false';

            if ($product->getCategoryIds()) {
                $categoryIds = $product->getCategoryIds();
            }

            $content .= str_repeat($padding,2) . "<offer id=\"$offerId\" type=\"$type\" available=\"$availible\">\n";
            $content .= str_repeat($padding,3) . "<url>$url</url>\n";
            $content .= str_repeat($padding,3) . "<price>$price</price>\n";
            $content .= str_repeat($padding,3) . "<currencyId>$currency</currencyId>\n";

            if (is_array($categoryIds)) {
                $content .= str_repeat($padding, 3) . "<categoryIds>\n";

                foreach ($categoryIds as $value) {
                    $content .= str_repeat($padding,4) . "<categoryId>$value</categoryId>\n";
              }
                $content .= str_repeat($padding, 3) . "</categoryIds>\n";
            }

            $content .= str_repeat($padding,3) . "<picture></picture>\n";
            $content .= str_repeat($padding,3) . "<qty>$qty</qty>\n";
            $content .= str_repeat($padding,2) . "</offer>\n";
            $offerId++;
        }

        $content .= $padding."<offers>\n";
        $content .= '</yml_catalog>';

        return $content;
    }

    /**
     * Filtering and convert data to json format
     *
     * @param Sapiha_Export_Model_Resource_Export_Collection $collection
     * @return string
     * @throws Mage_Core_Model_Store_Exception
     */
    public function toJSON(Sapiha_Export_Model_Resource_Export_Collection $collection)
    {
        $content = "";

        foreach ($collection as $product) {
            $newData = $product->getData();

            foreach ($newData as $key => $value) {

                if($key == 'url_path' || $key == 'price' || $key == 'category_id' || $key == 'qty') {
                    continue;
                } else {
                    unset($newData[$key]);
                }
            }
            $newData['currencyId'] = Mage::app()->getStore()->getCurrentCurrencyCode();
            $newData['image'] = $product->getImage();
            $content .= json_encode($newData);
        }

        return $content;
    }

    /**
     * Mass export for export entities
     *
     * @param array $exports
     * @throws Mage_Core_Model_Store_Exception
     * @throws Varien_Exception
     * @return void
     */
    public function massExport($exports)
    {
        $succesIterator = 0;
        $iterator = 0;

        foreach ($exports as $id) {
            $exportId = $id;
            $export = Mage::getModel('sapiha_export/export')->load($exportId);
            $collection = $this->prepareCollection($exportId);

            if ($collection->getSize()) {
                $collection->getSelect()
                    ->group('e.entity_id');

                if ($export->getFormat() == '.yaml') {
                    file_put_contents($this->setFileName($export), $this->toYaml($collection));
                    $succesIterator++;
                }

                if ($export->getFormat() == '.json') {
                    file_put_contents($this->setFileName($export), $this->toJSON($collection));
                    $succesIterator++;
                }
            }

            $iterator++;
        }
        Mage::app()->getResponse()->setRedirect('*/*/index');

        if ($succesIterator>0) {
            Mage::getSingleton('core/session')->addSuccess($this->__('Total of %d exports file have been created', $succesIterator));
        }

        $faileIterator = $iterator - $succesIterator;

        if ($faileIterator > 0) {
            Mage::getSingleton('core/session')->addError($this->__('Total of %d exports is empty and have not been created', $faileIterator));
        }
    }
}

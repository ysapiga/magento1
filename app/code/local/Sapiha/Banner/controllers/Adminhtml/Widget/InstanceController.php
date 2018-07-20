<?php
require_once ('Mage/Widget/controllers/Adminhtml/Widget/InstanceController.php');

class Sapiha_Banner_Adminhtml_Widget_InstanceController extends Mage_Widget_Adminhtml_Widget_InstanceController
{
    /**
     * rewrite  Save action
     * @return void
     */
    public function saveAction()
    {
            $widgetInstance = $this->_initWidgetInstance();

            if (!$widgetInstance) {
                $this->_redirect('*/*/');

                return;
            }

            if (isset($_POST['parameters']['image']['value'])) {
                $helper = Mage::helper('sapiha_banner');
                $_POST['parameters'] = $helper-> imageArrayToString($_POST['parameters']);
            }

            $post = $this->getRequest()->getPost();
            $widgetInstance->setTitle($post['title'])
                ->setStoreIds($this->getRequest()->getPost('store_ids', array(0)))
                ->setSortOrder($this->getRequest()->getPost('sort_order', 0))
                ->setPageGroups($this->getRequest()->getPost('widget_instance'));
                $widgetInstance->setWidgetParameters($this->getRequest()->getPost('parameters'));

            try {
                $widgetInstance->save();
                if ($widgetInstance->getType() == "sapiha_banner/catalog_banner"){
                    $helper = Mage::helper('sapiha_banner');
                    if ($helper->validateMaxPosition($post['parameters']['list_position'], $post['parameters']['grid_position'] )) {
                        $post['instance_id'] = $widgetInstance->getId();
                        if ($post['parameters']['instance_id'] == "") {
                            $fileExtension = substr(strrchr($post['parameters']['image'], "."), 1);
                            $post['parameters']['image'] = $helper->getImageUrl('grid', $widgetInstance->getId() . '.' . $fileExtension);
                            $helper->saveFinalImages($post, $fileExtension);
                        }
                        $post['parameters']['instance_id'] = $widgetInstance->getId();
                        $widgetInstance->setWidgetParameters($post['parameters'])
                            ->setSortOrder($this->getRequest()->getPost('sort_order', 0))
                            ->setPageGroups($this->getRequest()->getPost('widget_instance'))
                            ->save();
                    } else {
                        $this->_getSession()->addError($this->__("Banner Position is higher than required value"));
                        $widgetInstance->delete();
                        $this->_redirect('*/*/edit');
                        return;
                    }
                }

                $this->_getSession()->addSuccess(
                    Mage::helper('widget')->__('The widget instance has been saved.')
                );
                if ($this->getRequest()->getParam('back', false)) {
                    $this->_redirect('*/*/edit', array(
                        'instance_id' => $widgetInstance->getId(),
                        '_current' => true
                    ));
                } else {
                    $this->_redirect('*/*/');
                }

                return;
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::logException($e);
                $this->_getSession()->addError($this->__('An error occurred during saving a widget: %s', $e->getMessage()));
            }
            $this->_redirect('*/*/edit', array('_current' => true));
    }
}

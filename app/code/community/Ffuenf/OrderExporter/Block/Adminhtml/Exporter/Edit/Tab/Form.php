<?php
/**
 * Ffuenf_OrderExporter extension.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 *
 * @category   Ffuenf
 *
 * @author     Achim Rosenhagen <a.rosenhagen@ffuenf.de>
 * @copyright  Copyright (c) 2016 ffuenf (http://www.ffuenf.de)
 * @license    http://opensource.org/licenses/mit-license.php MIT License
 */

class Ffuenf_OrderExporter_Block_Adminhtml_Exporter_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(
            array(
                'id'      => 'config_form',
                'action'  => $this->getUrl('*/*/importOrders'),
                'method'  => 'post',
                'enctype' => 'multipart/form-data'
            )
        );
        $form->setUseContainer(true);
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'exporter_form',
            array(
                'legend' => Mage::helper('ffuenf_orderexporter')->__('Import Orders')
            )
        );
        $fieldset->addField(
            'store_id',
            'select',
            array(
                'name'     => 'store_id',
                'label'    => Mage::helper('ffuenf_orderexporter')->__('Store View'),
                'title'    => Mage::helper('ffuenf_orderexporter')->__('Store View'),
                'required' => true,
                'values'   => Mage::getModel('exporter/exporter')->getStoreIds()
            )
        );
        $fieldset->addField(
            'import_limit',
            'select',
            array(
                'label'    => Mage::helper('ffuenf_orderexporter')->__('Order Import Limit'),
                'name'     => 'import_limit',
                'required' => true,
                'values'   => array(
                    array(
                        'value' => '50',
                        'label' => Mage::helper('ffuenf_orderexporter')->__('50')
                    ),
                    array(
                        'value' => '100',
                        'label' => Mage::helper('ffuenf_orderexporter')->__('100')
                    ),
                    array(
                        'value' => '150',
                        'label' => Mage::helper('ffuenf_orderexporter')->__('150')
                    ),
                    array(
                        'value' => '200',
                        'label' => Mage::helper('ffuenf_orderexporter')->__('200')
                    )
                )
            )
        );
        $fieldset->addField(
            'order_csv',
            'file', array(
                'label'              => Mage::helper('ffuenf_orderexporter')->__('Orders CSV File: '),
                'required'           => true,
                'name'               => 'order_csv',
                'after_element_html' => '</br>Note : <small>Strictly recommend to use the csv file which has been generated by the same module.</small>'
            )
        );
        $fieldset->addField(
            'submit',
            'submit',
            array(
                'value'              => 'Import',
                'after_element_html' => '<small></small>',
                'class'              => 'form-button',
                'tabindex'           => 1
            )
        );
        if (Mage::getSingleton('adminhtml/session')->getExporterData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getExporterData());
            Mage::getSingleton('adminhtml/session')->setExporterData(null);
        } elseif (Mage::registry('orderexporter_data')) {
            $form->setValues(Mage::registry('orderexporter_data')->getData());
        }
        return parent::_prepareForm();
    }
}

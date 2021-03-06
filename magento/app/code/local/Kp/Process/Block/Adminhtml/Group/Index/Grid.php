<?php
class Kp_Process_Block_Adminhtml_Group_Index_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  { 
 
    parent::__construct();
    $this->setId('ProcessGroupGrid');
    $this->setDefaultSort('process_group_id');
    $this->setUseAjax(true);
    $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
    $collection = Mage::getModel('process/process_group')->getCollection();
    $this->setCollection($collection);
    return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
    $this->addColumn('process_group_id', array(
      'header'    => Mage::helper('process')->__('Process Id'),
      'index'     => 'process_group_id',
    ));   

    $this->addColumn('name', array(
      'header'    => Mage::helper('process')->__('Name'),
      'index'     => 'name',
    ));   
    return parent::_prepareColumns();
  }   

  protected function _prepareMassaction()
  {
    $this->setMassactionIdField('process_group_id');
    $this->getMassactionBlock()->setFormFieldName('process');

    $this->getMassactionBlock()->addItem('delete', array(
     'label'    => Mage::helper('process')->__('Delete'),
     'url'      => $this->getUrl('*/*/massDelete'),
     'confirm'  => Mage::helper('process')->__('Are you sure?')
   ));
  }

  public function getRowUrl($row)
  {
    return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }  
}
<?php 
class kp_Category_Block_Adminhtml_Category_Index_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('categoryGrid');
        $this->setDefaultSort('category_id');
        $this->setDefaultDir('ASC');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('category/category')->getCollection();
        foreach ($collection->getItems() as $value) 
        {
            $value->name = $value->getPath();    
        }
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('category_id', array(
            'header'    => Mage::helper('category')->__('Category Id'),
            'index'     => 'category_id',
            'type'     => 'number',
        ));

         $this->addColumn('parent_id', array(
            'header'    => Mage::helper('category')->__('Parent Id'),
            'index'     => 'parent_id',
            'type'     => 'number',
        ));

        $this->addColumn('name', array(
            'header'    => Mage::helper('category')->__('Name'),
            'index'     => 'name',
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('category')->__('Status'),
            'index'     => 'status',
            'type'      => 'options',
            'options'   => array(
                0 => Mage::helper('category')->__('Disabled'),
                1 => Mage::helper('category')->__('Enabled')
            ),
        ));

        $this->addColumn('created_at', array(
            'header'    => Mage::helper('category')->__('CreatedAt'),
            'index'     => 'created_at',
            'type'      => 'datetime',
        ));

        $this->addColumn('updated_at', array(
            'header'    => Mage::helper('category')->__('UpdatedAt'),
            'index'     => 'updated_at',
            'type'      => 'datetime',
        ));

        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('category')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('category')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('category_id');
        $this->getMassactionBlock()->setFormFieldName('category');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('category')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('category')->__('Are you sure?')
        ));
    }


    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}
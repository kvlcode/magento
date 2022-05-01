<?php 
class Kp_Process_Adminhtml_ProcessController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
	{
		$this->loadLayout();
		/*$this->getLayout()->getBlock('content')->append(
			$this->getLayout()->createBlock('process/adminhtml_process_index'));*/
		$this->renderLayout();
	}
    
    public function newAction()
   	{
        $this->_forward('edit');
   	}

	public function editAction()
    {
       $this->loadLayout();

        $id =  $this->getRequest()->getParam('id');   //echo $id; exit();
        $model = Mage::getModel('process/process');

        if ($id) 
        {
            $model->load($id);                   //print_r($model);    exit();
            if(!$model->getId()) 
            {
                $this->_redirect('*/*/index');
                return;
            }
        }

        $this->_title($model->getId() ? $this->__('Edit process') : $this->__('New process'));
        Mage::register('current_process', $model);

        /*$this->getLayout()->getBlock('content')->append($this->getLayout()->createBlock('process/adminhtml_process_edit', 'processEdit'));*/
        $this->renderLayout();
    }  

    public function saveAction()
    {
        // code...
        if ($data = $this->getRequest()->getPost()) 
        {
           try 
           {
               $model = Mage::getModel('process/process');
               $model->setData($data)->setId($this->getRequest()->getParam('id'));
               
               $model->save();
               $id = $model->getId();
              
              //Mage::dispatchEvent('process_save_manually', array('process' => $model));
              $this->_redirect('*/*/index');
           } 
           catch (Exception $e) 
           {
               $this->_redirect('*/*/edit', array(
                   'id' => $this->getRequest()->getParam('id')
               ));
           }
           return;
        }
    }

    public function deleteAction()
    {
       if($id = $this->getRequest()->getParam('id')) 
       {
           try 
           {
               Mage::getModel('process/process')->load($id)->delete();
           } 
           catch (Exception $e) 
           {
               $this->_redirect('*/*/edit', array('id' => $id));
           }
       }
       $this->_redirect('*/*/index');
   }
}
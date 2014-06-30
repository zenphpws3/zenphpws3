<?php

class TestController extends Controller{
	
	protected function getRules()
	{
		return array(
			'*' => array(
				'k' => array('type' => 'string',
							'default' => 'n_k',
							'require' => false,
							),
			),
			'getTest' => array(
				'test' => array('type' => 'string',
								'default' => 'n_test',
								'require' => false,
								),
				'name' => array('type' => 'string',
								'default' => 'nobody',
								'require' => false,
								),
				'sex' => array('type' => 'string',
								'default' => 'unkonw',
								'require' => false,
								),
				),
			);	
	}
	
    public function getTest()
    {
		$bean = DataBase::create('person', array('name' => $this->name, 'sex' => $this->sex, 'fuck' => 'you'));
		
		//Store the bean
		$id = DataBase::save($bean);
		
		$leaflet = DataBase::findByKey('person', $id);
		
		//DataBase::delete($leaflet);
		
		$model = new TestModel();
		return $model->getReuslt($this->name, $leaflet->sex);
		
        return array('sex' => $leaflet->sex, 'name' => $this->name);
    }
    
    public function getLoadFiles()
    {
    	return ZenLoader::getRecords();
    }
}
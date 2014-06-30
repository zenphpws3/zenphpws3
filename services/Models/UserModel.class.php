<?php

class UserModel extends RedBean_SimpleModel implements RedBean_IModelFormatter 
{
	public function formatModel( $model )
	{
		return $model;
	}
	
	public function formatBeanID($t){ return 'uid'; }
	public function formatBeanTable($t){ return $t; }
	
	public function getAlias($a)
	{
		return 'user';
	}
	
	public function isUsernameExist($name)
	{
		$bean = $this->findByUsername($name);
		
		return empty($bean) ? false : true;
	}
	
	public function addUser($name, $pass)
	{
		$encrypt = rand_string(15);
		$pass = password($pass, $encrypt);
		
		$user = R::dispense('user');
		$user->uname = $name;
		$user->password = $pass;
		$user->seckey = $encrypt;
		$id = R::store($user);
		
		return R::load(DataBase::getModelName('user'), $id);
	}
	
	public function findByUsername($name)
	{
		return R::findOne(DataBase::getModelName('user'), ' uname = ? ',array($name));
	}
}

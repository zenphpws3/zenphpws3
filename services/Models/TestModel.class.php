<?php
class TestModel
{
	public function getReuslt($name, $sex)
	{
		$temp = 'TestModel';
		return array('sex' => $sex, 'name' => $name, 'more' => substr($temp, 0, stripos($temp, 'Model')), 'time' => @time());
	}
}
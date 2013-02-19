<?php

class Application_Model_Abstract_Abstract
{
public function __constructor($options=array()){
		if(is_array($options)){
			$this->setOptions($options);
		}
	}
        
        public function __set($name, $value){
		$method = 'set' . ucfirst($name);
		
		if('mapper' == $name || !method_exists($this, $method)){
			throw new Exception('Invalid' . $name . ' property');
		}
		$this->method($value);
	}
	
	public function __get($name){
		$method = "get" . ucfirst($name);
		
	if('mapper' == $name || !method_exists($this, $method)){
			throw new Exception('Invalid ' . $name . ' property');
		}
	return $this->method();
	}
        
        public function setOptions(array $options){
		$methods = get_class_methods($this);
		foreach($options as $key => $val){
			
			$method = 'set' . ucfirst($key);
			
			if(in_array($method, $methods)){
				$this->$method($val);
			}
		}
		
		return $this;
	}

}


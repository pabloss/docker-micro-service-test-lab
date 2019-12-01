<?php
class SomeClass { 
	  private function _private_method() {} // never shows up in completion list 
		    public static function staticMethod() {} // only shows up when using completion on SomeClass::<C-X><C-O> 
			      public function completeMe() {} // only shows up when using completion on $instance_of_someclass-><C-X><C-O> 
} 


$instance = new SomeClass; 
$instance->completeMe(:

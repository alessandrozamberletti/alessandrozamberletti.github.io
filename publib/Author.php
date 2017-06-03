<?php
class Author
{
    var $Name;
    var $Url;
    
    function Author($param)
    {
		$type = gettype($param);
		
		switch($type){
			case "string":
				$this->Name = $param;
				break;
							
			default:
				$this->Name = (string)$param->Name;
				$this->Url = (string)$param->Url;
				break;
		}
    }
}
?>
<?php
class User{
	public $username;
	public $passwd;
	public $UUID;
	public $language;

	function __construct($username,$passwd,$uuid,$language){
		$this->username = $username;
		$this->passwd = $passwd;
		$this->UUID = $uuid;
		$this->language = $language;
	}
	
	public function __toString() {
		return json_encode($this->getArrayFormated());
	}
	
	public function getArrayFormated(){
        $dataarr = array(
			"id" => $this->UUID,
			"properties"=>array( // 用户的属性（数组，每一元素为一个属性）
				array(
					"name"=>"preferredLanguage",
					"value"=>$this->language,
				),
				// ,...（可以有更多）
			)
			);
		return $dataarr;
    }
}
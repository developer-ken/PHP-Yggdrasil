<?php
class User{
	public $username;
	public $passwd;
	public $UUID;
	public $language;
	function __construct($username,$passwd,$uuid){
		$this->username = $username;
		$this->passwd = $passwd;
		$this->UUID = $uuid;
	}
	
	public function __toString() {
        $dataarr = array(
				"id" => $this->UUID,
				"properties"=>array( // 用户的属性（数组，每一元素为一个属性）
					array(
						"name"=>"preferredLanguage",
						"value"=>$language,
					),
					// ,...（可以有更多）
				)
				);
		return json_encode($dataarr);
    }
}
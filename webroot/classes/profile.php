<?php
class Profile{
	public $name;
	public $UUID;
    public $texture_moudle;
    public $texture_type;//SKIN or CAPE
    public $texture_url;
	function __construct($username,$passwd,$uuid,$texture_moudle,$texture_type,$texture_url){
		$this->username = $username;
		$this->passwd = $passwd;
        $this->UUID = $uuid;
	}
	
	public function __toString() {
        $dataarr = array(
                "id" => $this->UUID,
                "name" => $name,
                /*
				"properties"=>array( // 用户的属性（数组，每一元素为一个属性）
					array(
						"name"=>"preferredLanguage",
						"value"=>$language,
					),
					// ,...（可以有更多）
                )
                */
                );
                /*
                {
                    "id":"角色 UUID（无符号）",
                    "name":"角色名称",
                    "properties":[ // 角色的属性（数组，每一元素为一个属性）（仅在特定情况下需要包含）
                        { // 一项属性
                            "name":"属性的键",
                            "value":"属性的值",
                            "signature":"属性值的数字签名（仅在特定情况下需要包含）"
                        }
                        // ,...（可以有更多）
                    ]
                }
                */
		return json_encode($dataarr);
    }
}
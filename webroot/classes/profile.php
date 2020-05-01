<?php
class Profile{
	public $name;
	public $UUID;
    public $texture;
	function __construct($name,$uuid,$texture){
		$this->name = $name;
        $this->UUID = $uuid;
        $this->texture = $texture;
        /*
        {
            "timestamp":该属性值被生成时的时间戳（Java 时间戳格式，即自 1970-01-01 00:00:00 UTC 至今经过的毫秒数）,
            "profileId":"角色 UUID（无符号）",
            "profileName":"角色名称",
            "textures":{ // 角色的材质
                "材质类型（如 SKIN）":{ // 若角色不具有该项材质，则不必包含
                    "url":"材质的 URL",
                    "metadata":{ // 材质的元数据，若没有则不必包含
                        "键":"值"
                        // ,...（可以有更多）
                    }
                }
                // ,...（可以有更多）
            }
        }
        */
	}
	
	public function __toString() {
        $texture_data = new ProfileProperties("textures",base64_encode($this->texture));
        $dataarr = array(
                "id" => $this->UUID,
                "name" => $this->name,
				"properties"=>array( // 用户的属性（数组，每一元素为一个属性）
					$texture_data,
                ),
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
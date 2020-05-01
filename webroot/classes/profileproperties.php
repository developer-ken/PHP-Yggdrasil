<?php
class ProfileProperties{
	public $name;
	public $value;
    public $signiture;

	function __construct($name,$value,$issigned=true){
		$this->name = $name;
		$this->value = $value;
        if($issigned) $this->signiture = Encypt::genSigniture($this->value);
        else $this->signiture = "N/A";
	}
	
	public function __toString() {

		return json_encode($this->getArrayFormated());
    }
    public function getArrayFormated(){
        $dataarr = array(
            "name" => $this->name,
            "value" => $this->value,
            );
        if($this->signiture != "N/A"){
            $dataarr["signature"]=$this->signiture;
        }
            /*
            { // 一项属性
                "name":"属性的键",
                "value":"属性的值",
                "signature":"属性值的数字签名（仅在特定情况下需要包含）"
            }
            */
        return $dataarr;
    }
}
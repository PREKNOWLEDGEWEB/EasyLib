<?php
/**
 * @package EasySDK
 * @
 */
class EasySDK
{
	public function xml_encode($mixed, $domElement=null, $DOMDocument=null) {
    if (is_null($DOMDocument)) {
        $DOMDocument =new DOMDocument;
        $DOMDocument->formatOutput = true;
        $this->xml_encode($mixed, $DOMDocument, $DOMDocument);
        echo $DOMDocument->saveXML();
    }
    else {
        if (is_array($mixed)) {
            foreach ($mixed as $index => $mixedElement) {
                if (is_int($index)) {
                    if ($index === 0) {
                        $node = $domElement;
                    }
                    else {
                        $node = $DOMDocument->createElement($domElement->tagName);
                        $domElement->parentNode->appendChild($node);
                    }
                }
                else {
                    $plural = $DOMDocument->createElement($index);
                    $domElement->appendChild($plural);
                    $node = $plural;
                    if (!(rtrim($index, 's') === $index)) {
                        $singular = $DOMDocument->createElement(rtrim($index, 's'));
                        $plural->appendChild($singular);
                        $node = $singular;
                    }
                }
 
                $this->xml_encode($mixedElement, $node, $DOMDocument);
            }
        }
        else {
            $domElement->appendChild($DOMDocument->createTextNode($mixed));
        }
	    }
	}

	public function check_fun(){
		return true;
	}

	public function readJSONfile($file,$context){
		if (fopen($file, "r")) {
			$j = fopen($file, "r");
			return $context->fromJson(fread($j,filesize($file)));
		}else{
			throw new Exception("File : $file not found", 1);
		}
	}

	public function mysqlConnect($data = null,$context){
		if($context->check_fun()){

		}else{
			throw new Exception("Context failure please parse context like function('hello',$newVarContext)", 1);
		}
	}

	public function fromJson($jsonData){
		if(json_decode($jsonData)){
			return json_decode($jsonData,true);
		}else{
			throw new Exception("Invalid JSON provided", 1);
		}
	}

}
//465
function fromJson($jsonData){
	if(json_decode($jsonData)){
		return json_decode($jsonData,true);
	}else{
		throw new Exception('{"line": "'.$errno.'","file": "'.base64_encode($errfile).'","str": "'.$errstr.'"}', 1);
	}
}
function error_handle($errno, $errstr, $errfile, $errline) {
    $data =  "<b>Custom error:</b> [$errno] $errstr<br>";
    $data = " Error on line $errline in $errfile<br>";
    //array("line"=>$errno,"file"=>$errfile,"str"=>$errstr,"lEine"=>$errline)
    throw new Exception('{"line": "0","file": "0","str": "0"}', 1);  
}
function new_ErrorrHandle($e){
	
		$chmodFile = fopen("errors/errorLog".str_shuffle(rand(66,7))."-".date("d-m-y h-i-s").".txt", "w") or die("Cannot create file please do chmod 777");
		$txt = "Error Message : ".fromJson($e->getMessage())['str']."
Error File : ".$e->getFile().":".$e->getLine()."
		";
		fwrite($chmodFile, $txt);
		fclose($chmodFile);
		echo "
		<script src='https://cdnjs.cloudflare.com/ajax/libs/ace/1.1.01/ace.js'></script>
		<div style='background:#ff7575; color:white; margin:0;'>
		<h2 style='color:white;margin:2px;'>
			Error Messages : ".fromJson($e->getMessage())['str']."<br>
			Error File : ".$e->getFile().":".$e->getLine()."<br>
		</h2>
		<p style='background:#dce3de; color:black; margin:10px;'>
			Stack Trace:<br>
			".var_dump($e)."
		</p>
		".base64_decode(fromJson($e->getMessage())['file'])."
		<div id='editor' style='height:500px;'>
			".FileRead($e->getFile())."
		</div>
		
		</div>


		 ";
		 echo '<script>
		 var editor = ace.edit("editor");
		editor.setTheme("ace/theme/light");
		editor.getSession().setMode({path:"ace/mode/php", inline:true});
		editor.resize(true);
		editor.scrollToLine('.$e->getLine().', true, true, function () {});
		editor.gotoLine('.$e->getLine().', 0, true);

		 </script>';
	
}
set_error_handler("error_handle");
function FileRead($file){
	$fup = fopen($file, "r") or throw new Exception("Error Processing file", 1);
	return fread($fup,filesize($file));
	// return file_get_contents($file);
}
function import($p){
	if(file_exists($p)){
		include($p);
	}else{
		if ($p == "xml_encode") {
			function xml_encode($mixed, $domElement=null, $DOMDocument=null) {
		    if (is_null($DOMDocument)) {
		        $DOMDocument =new DOMDocument;
		        $DOMDocument->formatOutput = true;
		        xml_encode($mixed, $DOMDocument, $DOMDocument);
		        echo $DOMDocument->saveXML();
		    }
		    else {
		        if (is_array($mixed)) {
		            foreach ($mixed as $index => $mixedElement) {
		                if (is_int($index)) {
		                    if ($index === 0) {
		                        $node = $domElement;
		                    }
		                    else {
		                        $node = $DOMDocument->createElement($domElement->tagName);
		                        $domElement->parentNode->appendChild($node);
		                    }
		                }
		                else {
		                    $plural = $DOMDocument->createElement($index);
		                    $domElement->appendChild($plural);
		                    $node = $plural;
		                    if (!(rtrim($index, 's') === $index)) {
		                        $singular = $DOMDocument->createElement(rtrim($index, 's'));
		                        $plural->appendChild($singular);
		                        $node = $singular;
		                    }
		                }
		 
		                xml_encode($mixedElement, $node, $DOMDocument);
		            }
		        }
		        else {
		            $domElement->appendChild($DOMDocument->createTextNode($mixed));
		        }
			   }
			}
		}else{
			$iget = new EasySDK();
			$i = $iget->readJSONfile("fileDir.list",$iget);
			foreach ($i['filesTest'] as $KEYS) {
				if (file_exists("".$KEYS."/".$p.".php")) {
					return include("".$KEYS."/".$p.".php");
					$suc = true;
				}else{
					$data[] = "".$KEYS."/";
				}
				if (!isset($suc)) {
					throw new Exception("file : ".$p.".php not found in ".json_encode($data)."", 1);
				}
			}
		}
	}
}

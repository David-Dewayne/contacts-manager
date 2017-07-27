<?php
$true = false;
//Continue the program untill user calls 5:exit
function parseContacts($filename)
{
    $contacts = array();
	$handle = fopen($filename, 'r');
	$contents = fread(fopen($filename, 'r'), filesize($filename));
	$contacts = explode("\n",$contents);
	
    fclose($handle);
   	foreach ($contacts as $key => $value) {
    	$contacts[$key] = explode("|", $value);
    	$contacts[$key]['name'] = $contacts[$key][0];
    	unset($contacts[$key][0]);
    	$contacts[$key]['number'] = $contacts[$key][1];
    	unset($contacts[$key][1]);
    	$contacts[$key]['number'] = substr($contacts[$key]['number'], 0,3) . "-" . substr($contacts[$key]['number'], 3,3) ."-". substr($contacts[$key]['number'], 6,4);
   	}
    return $contacts;
}
do{
	//Get our contact info
	$contents = parseContacts('contacts.txt');
	//get user input
	$guess = trim(fgets(STDIN));
	$guess = explode(" ", $guess);
	//user input fuctionality
	switch ($guess[0]) {
		//Display all contacts
		case '1':
		$arrTemp = $contents;
		foreach ($contents as $key => $value) {
			while(strlen($contents[$key]['name'])< 20){
				$temp = str_split($contents[$key]['name']);
				array_unshift($temp,' ');
				$dumsum = implode($temp);
				$contents[$key]['name'] = $dumsum;
			}
		}
				echo "               Names|Number".PHP_EOL;
			foreach ($contents as $key => $value) {
				fwrite(STDOUT,$value['name']."|".$value['number'].PHP_EOL);
			}
			$contents = $arrTemp;
		break;
		//Add a contact
		case '2':
			$handle =  fopen('contacts.txt', 'a');
			fwrite($handle, PHP_EOL. $guess[1]." ".$guess[2]."|".$guess[3]);
			fclose($handle);
		break;
		//Search for a contact
		case '3':
		$var = '';
		foreach ($contents as $key ) {
			if($key['name'] == ($guess[1]." ".$guess[2])){
				$var = $key['name']."|".$key['number'];
			}
		}
		if($var === ''){
			echo "no such thing";
		}
			fwrite(STDOUT, $var.PHP_EOL);
		
		break;
		//Delete a contact
		case '4':
			$var =false;
			foreach ($contents as $key ) {
				if($key['name'] == ($guess[1]." ".$guess[2])){
					unset($key);
					$var = true;

				}
			}
			if(!$var){
				echo "no such thing";
			}
			else{
			$handle =  fopen('contacts.txt', 'w');
			$arrTemp = $contents;
			$contents = implode($contents);
			fwrite($handle, $contents);
			fclose($handle);
			$contents = $arrTemp;
				echo "The dead has been done";
			}
		break;
		//Exit
		case '5':
			$true = true;
		break;
		case'help':
			fwrite(STDOUT, "1:Display All" .PHP_EOL."2:Add a contact".PHP_EOL."3:Search for a contact".PHP_EOL."4:Delete A contact".PHP_EOL."5:exit the program");
		break;
		default:
			fwrite(STDOUT, "First character needs to be a number between 1-5!");
			break;
	}
}while(!$true);

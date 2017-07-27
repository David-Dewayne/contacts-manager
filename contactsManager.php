<?php
$true = false;
//Continue the program untill user calls 5:exit
do{
	//Get our contact info
	$filename = 'contacts.txt';
	$handle =  fopen($filename, 'r');
	$contents = fread($handle, filesize($filename));
	fclose($handle);
	$contents = explode("\n", $contents);
	//get user input
	$guess = trim(fgets(STDIN));
	$guess = explode(" ", $guess);
	//user input fuctionality
	switch ($guess[0]) {
		//Display all contacts
		case '1':
			var_dump($contents);
		break;
		//Add a contact
		case '2':
			$handle =  fopen($filename, 'a');
			fwrite($handle, $guess[1]."|".$guess[2].PHP_EOL);
			fclose($handle);
		break;
		//Search for a contact
		case '3':
			$var = array_search($guess[1], $contents);
			var_dump($var);
			fwrite(STDOUT, $contents[$var]);
		break;
		//Delete a contact
		case '4':
			
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

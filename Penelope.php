<?php
///////////////////////////////////////////////////////////////
//
//		Penelope
//		Author: spaceshiptrooper
//		Copyright: 2019
//		Version: 0.0.1
//		File Last Updated: 3/17/2019 at 10:01 PM
//
///////////////////////////////////////////////////////////////

class Penelope {

	public function __construct(array $array = []) {

		// Set the content type to JSON
		header('Content-Type: application/json; charset=utf8;');

		// Create and append the values that are passed via the $array variable.
		$this->path = $array['path'];
		$this->blacklist = $array['blacklist'];

	}

	public function __destruct() {

		// This method is only called once the entire file has been done executing.

		// Create an array for the message code.
		$array = [
			'message' => 'Operation has finished',
		];

		// Encode the array in JSON.
		$json = json_encode($array, JSON_PRETTY_PRINT);

		// Output the result.
		print $json;

	}

	public function run() {

		// Run the iterate method.
		$this->iterate($this->path);

	}

	private function iterate($path) {

		try {

			// Iterate through all the directories and display the files and directories within the path index.
			$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);

			// Loop through the results.
			foreach($objects AS $object) {

				if(file_exists($object)) {

					// Explode the object's name and append the $name variable to each object.
					$name = explode('/', $object);

					// Take the last element of the exploded array and overwrite the $name variable with the result.
					$name = end($name);

					// Check to see if the filename is within the blacklist.
					if(in_array($name, $this->blacklist)) {

						// Check to see the $object variable is a directory.
						if(is_dir($object)) {
							$this->rmdir($object); // Run the delete method to delete all contents within the directory.
						} else {
							unlink($object); // Delete that specific file if it is within the blacklist.
						}
					}

				}

			}

		} catch(Exception $ex) {

			// Re-run the iterate() method.
			$this->iterate($path);

		}

	}

	private function rmdir($dir) {

		// Check to see if $dir is a directory.
		if(is_dir($dir)) {

			// Scan that directory for more files and sub-directories.
			$objects = scandir($dir);

			// Loop through the results.
			foreach($objects as $object) {

				// Check to make sure that those files aren't the parent nor the parent's parent directory.
				if($object != '.' && $object != '..') {

					// Check to make sure that file is a directory.
					if(filetype($dir . '/' . $object) == 'dir') {
						$this->rmdir($dir . '/' . $object); // Recursively re-run the current rmdir method.
					} else {
						unlink($dir . '/' . $object); // Delete that specific file if it is within the blacklist.
					}

				}

			}

			reset($objects); // Reset the array back to the first element.
			rmdir($dir); // Finally delete the targeted directory.

		}

	}

}
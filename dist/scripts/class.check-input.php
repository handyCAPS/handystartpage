<?php

Class CheckInput {

	private $errors = array();

	private $input_types = array();

	public function check($type, $input) {

		switch ($type) {
			case 'link':
				$this->check_link($input);
				break;

			case 'image':
				$this->check_image($input);
				break;

			case 'order':
				$this->check_numeric($input);
				break;

			case 'name':
				$this->check_semi_colon($input);
				break;

		}

		if (!$this->get_errors()) {
			return TRUE;
		}

		return FALSE;

	}

	private function check_link($link) {

		//
		$protocol = preg_match('/^((https?)?(localhost)?(ssh)?(file)?)+:\/\//', $link);
		$bad_url = preg_match('/[\s\;]/', $link);

		if ($protocol !== 1) {
			$this->collect_errors('link','Protocol is missing or invalid. Please enter full url.');
		}

		if ($bad_url !== 0 || !filter_var($link, FILTER_VALIDATE_URL)) {
			$this->collect_errors('link', 'Please enter a valid url.');
		}

	}

	private function check_numeric($var) {
		return is_numeric($var);
	}

	private function check_semi_colon($string) {

		$colonic = preg_match('/\;/', $string);

		if ($colonic !== 0) {

			$this->collect_errors('colon', 'Your input cannot contain a semi-colon (;).');

		}

	}

	private function collect_errors($type,$error) {

		if (!array_key_exists($type, $this->errors)) {

			$this->errors[$type] = array();

		}

		array_push($this->errors[$type], $error);

	}

	public function get_errors() {

		if (!empty($this->errors)) {
			return $this->errors;
		}

		return FALSE;
	}

}
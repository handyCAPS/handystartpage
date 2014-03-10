<?php

Class File_Upload {

	private $file = array();

	private $file_data = array();

	private $root_dir;

	private $errors = array();

	private $allowed_mimes = array();

	private $max_file_size;

	private $finfo;

	private $tmp_name;

	private $destination;

	const UPLOADS = "uploads";

	private $upload_dir;

	public function __construct($folder) {

		$this->file_data['state'] = FALSE;

		$this->root_dir = self::get_root_path();

		$this->destination = self::UPLOADS . DIRECTORY_SEPARATOR . $folder;

		if (!$this->upload_dir = $this->get_upload_dir($this->destination)) {
			throw new Exception('Unable to find or create upload folder');
		}

		$this->finfo = new finfo();

	}

	private function get_upload_dir($dir_name) {

		$uploaddir = FALSE;

		if (!is_writable($uploaddir = $this->root_dir . $dir_name . DIRECTORY_SEPARATOR)){

			if (chdir($this->root_dir)) {

				if (mkdir($dir_name,0777, true)) {
					$this->get_upload_dir($dir_name);
				} else {
					$this->collect_errors('Couldn\'t make a new directory. ');
				}

			} else {
				$this->collect_errors('Couldn\'t change to the root directory. ');
			}

		}

		return $uploaddir;
	}

	public static function get_root_path() {

		$start = $first_slash = strpos(__FILE__, '\\', strlen($_SERVER['DOCUMENT_ROOT'])) + 1;

		$length = (strpos(__FILE__, '\\', $first_slash) - $first_slash);

		if (!$root_dir = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . substr(__FILE__, $start, $length) . DIRECTORY_SEPARATOR){
			$this->collect_errors('Unable to get root path. ');
		}

		return $root_dir;
	}

	public function file($file) {
		$this->set_file_info($file);
	}

	private function set_file_info($file) {

		if ($this->check_file_info($file)) {

			$this->file = $file;

			$this->tmp_name = $file['tmp_name'];

		} else {

			$this->collect_errors('File array not in order. ');

		}
	}

	private function check_file_info($file) {

		if (isset($file['error'])
			&& !empty($file['name'])
			&& !empty($file['type'])
			&& !empty($file['tmp_name'])
			&& !empty($file['size'])) {
			return TRUE;
		}
		return FALSE;

	}

	private function get_file_mime() {

		return $this->finfo->file($this->tmp_name, FILEINFO_MIME_TYPE);
	}

	private function check_file_mime($file_mime) {

		if (!empty($this->allowed_mimes)) {

			if (!in_array($file_mime, $this->allowed_mimes)) {
						$this->collect_errors('Mime type not allowed. ');
			}
		} else {
				$this->collect_errors('Allowed mime-types not set. ');
			}
	}

	public function set_mime_types($mtypes) {
		$this->allowed_mimes = $mtypes;
	}

	public function set_max_file_size($size) {
		$this->max_file_size = $size;
	}

	private function get_max_file_size() {

		if ($this->max_file_size) {

			return $this->max_file_size;

		} else {

			$this->collect_errors('Maximum file size not set. ');

		}
	}

	private function check_file_size($filesize) {
		if (!($filesize <= $this->max_file_size)){
			$this->collect_errors('File is too big. ');
		}

	}
	//
	private function get_file_size() {
		return filesize($this->tmp_name);
	}

	public function save() {
		if ($this->check()) {
			$this->save_file();
		}

		return $this->get_state();
	}

	private function save_file() {

		$filename = $this->file_data['name'];

		$this->file_data['location'] = $this->upload_dir . $filename;

		$status = move_uploaded_file($this->tmp_name, $this->file_data['location']);
		if (!$status) {
			throw new Exception('Couldn\'t upload file');
		}

		$this->file_data['state'] = $status;

	}

	private function check() {

		$this->validate();

		$this->file_data['upload_errors'] = $this->get_error_messages();

		$this->file_data['state'] = empty($this->errors);

		return $this->file_data['state'];
	}

	//
	private function validate() {

		$errors = $this->get_error_messages();

		if (empty($errors)) {

			$this->set_file_data();

			$this->check_file_mime($this->get_file_mime());

			$this->check_file_size($this->get_file_size());

		}
	}

	private function get_state() {
		return $this->file_data['state'];
	}

	private function set_file_data() {
		$data = array(
			'state' => FALSE,
			'size' => $this->get_file_size(),
			'mime' => $this->get_file_mime(),
			'name' => $this->file['name'],
			'post_data' => $this->file
			);
		$this->file_data = $data ;
	}

	public function get_file_data() {
		return $this->file_data;
	}

	private function collect_errors($message) {
		$this->errors[] = $message;
	}

	private function get_error_messages() {
		return $this->errors;
	}

	public function get_upload_folder() {
		return $this->upload_dir;
	}

}



Class Image_Upload {

	private $default_mime_types = array();

	private $img_upload;

	private $img_upload_dir;

	private $default_size;

	private $location;

	public function __construct($folder) {

		$this->set_default_mimes();

		$this->set_default_size();

		$this->img_upload = new File_Upload($folder);

		$this->img_upload->set_mime_types($this->default_mime_types);

		$this->img_upload->set_max_file_size($this->default_size);

		$this->img_upload_dir = $folder;

	}

	private function set_default_mimes() {

		$defaults = array(
				'image/jpeg',
				'image/png',
				'image/gif'
			);

		$this->default_mime_types = $defaults;
	}

	public function add_mime_type($type = array()) {

		foreach ($type as $index => $mime_type) {
				array_push($this->default_mime_types, $mime_type);
			}

		$this->img_upload->set_mime_types($this->default_mime_types);
	}

	private function set_default_size() {
		$this->default_size = 501200;
	}

	public function max_file_size($size) {
		$this->img_upload->set_max_file_size($size);
	}
	// ??
	public function get_folder() {
		return $this->img_upload_dir;
	}

	public function upload($file) {
		$this->img_upload->file($file);
	}

	public function save() {

		if ($this->img_upload->save()) {

			$data = $this->img_upload->get_file_data();

			$this->location = $data['location'];

		}

		$result = $this->img_upload->get_file_data();

		return $result ;
	}

	public function get_location() {
		return $this->location;
	}
}
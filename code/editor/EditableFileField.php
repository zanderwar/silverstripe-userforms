<?php
/**
 * Allows a user to add a field that can be used to upload a file
 *
 * @package userforms
 */
class EditableFileField extends EditableFormField {
	
	// this needs to be moved.
	static $has_one = array(
		"UploadedFile" => "File"
	);
	
	/**
	 * @see Upload->allowedMaxFileSize
	 * @var int
	 */
	public static $allowed_max_file_size;
	
	/**
	 * @see Upload->allowedExtensions
	 * @var array
	 */
	public static $allowed_extensions = array();
	
	static $singular_name = 'File Upload Field';
	
	static $plural_names = 'File Fields';
	
	function getFieldConfiguration() {
		$options = parent::getFieldConfiguration();
		
		$options->push(
			new TextField(
				"Fields[$this->ID][CustomSettings][Folder]", 
				_t('EditableFileField.UPLOADFOLDER', 'Upload Folder Name (will be created inside the Uploads)'),
				$this->getSetting('Folder')
		));    	

		return $options;
  	}

  	public function getFormField() {
		return new FileField($this->Name, $this->Title, null, null, null, $this->getUploadFolder());
  	}
	
	/**
	 * Workaround to handle uploads on the UserFormPage
	 */
	public function getValueFromData($data) {
		return "";
	}
	
	public function getUploadFolder() {
		$uploadFolder = 'Uploads';
		$folderName = $this->getSetting('Folder');
		
		if($folderName) {
			$uploadFolder .= "/" . $folderName;
		}

		return $uploadFolder;
	}
}
?>
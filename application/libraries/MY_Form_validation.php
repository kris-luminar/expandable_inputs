<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {

    /**
    * Get the value from a form
    *
    * Permits you to repopulate a form field with the value it was submitted
    * with, or, if that value doesn't exist, with the default
    *
    * updated from this link http://codeigniter.com/forums/viewthread/156497/#799493
    *
    * The purpose of the this overide is to allow the re-populating of form fields in the event
    * that you use field input names of this format: "fieldname[]".  While the form validates correctly,
    * the fields were repopulated with the word "array" using the the native version instead of the user's
    * entered value on repost to the form in the event that the user's input didn't pass validation
    *
    * @access	public
    * @param	string the field name
    * @param	string
    * @return	void
    */
    function set_value($field = '', $default = '') {
        if (!isset($this->_field_data[$field])) {
            return $default;
        }

        $field = &$this->_field_data[$field]['postdata'];

        if (is_array($field)) {
            $current = each($field);
            return $current['value'];
        }

        return $field;
    }

}

?>

<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Data processing for a form using codeigniter's sessions.
 */
class Expandable_input_session_model extends Model {

    var $page_name;
    var $countries;

    /**
     * Constructor
     *
     * @param String $page_name name of current page in database
     */
    function __construct($page_name) {
        parent::__construct();
        $this->page_name = $page_name;
        $this->countries = config_item('country_list');
    }

    /**
     * function SaveForm()
     *
     * saves form data to session
     *
     * @param $form_data - array
     * @return Bool - TRUE or FALSE
     */
    function saveForm($form_data) {
        foreach($form_data as &$record){
            foreach($record as $key => &$value){
                if($key === 'country[]'){
                    $value = isset($this->countries[$value]) ? $this->countries[$value] : '';
                }
            }
        }
        $success = $this->session->set_userdata($this->page_name, $form_data);
        return $success;
    }

    /**
     * Retrieves previous entries to this page of the multipage form for the current user.
     *
     * @return Array $data an array of values from the database page that were previously submitted by this user
     */
    function getFormData() {
        $form_data = $this->session->userdata($this->page_name);
        foreach($form_data as &$record){
            foreach($record as $key => &$value){
                if($key === 'country[]'){
                    $value = array_search($value, $this->countries);
                }
            }
        }
        return $form_data;
    }

    /**
     * Finds out if current user has previously visited the current page.
     *
     * @return Boolean TRUE if current user has NEVER visited the current page, else false
     */
    function firstTime() {
        return!$this->session->userdata($this->page_name);
    }

    function deleteCurrentUsersDataFromPages() {
        $this->session->unset_userdata();
    }

}

/* End of file expandable_input_session_model.php */
/* Location: ./application/libraries/expandable_input_session_model.php */
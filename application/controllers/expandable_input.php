<?php

/**
 * Expandable Input is an application that allows for a user to keep adding as many copies of a group of html form
 * inputs as they feel like provided that they have javascript enabled.  The application ensures that the user enters
 * at least one set of records before submitting.
 *
 * @version 2.0 2010/11/23
 * @author: Kris Luminar <kris@codemonkeys.biz>
 * @link http://codemonkeys.biz
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License ("OSL") v. 3.0
 *
 */
class Expandable_input extends Controller {

    function __construct() {
        parent::Controller();
    }

    /**
     * Since the input fields have "[]" at the end of their names, the Form Validation class will automaticaly validate each copy of each field
     * because it forms an array of this form: array(street[1], street[2], street[3]).
     * The Form_Validation class will genererate an error message for each rule that fails for each field, however, it will not match the error
     * message to the specific error field, so all the CodeIgniter errors are dumped at the top of the form and we use JQuery error checking to
     * map specific errors to specific fields, for better useability and then use CodeIgniter's error validation as our 'real' validation,
     * xss filtering, etc.
     */
    function index() {
        $this->load->model('expandable_input_model');
        $this->form_validation->set_rules("street[]", 'Street', 'trim|required|max_length[256]');
        $this->form_validation->set_rules("street2[]", 'Street2', 'trim|max_length[256]');
        $this->form_validation->set_rules("building_room_number[]", 'Building/Room Number', 'trim|max_length[70]');
        $this->form_validation->set_rules("city[]", 'City', 'trim|required|max_length[100]');
        $this->form_validation->set_rules("province[]", 'Province/State', 'trim|max_length[100]');
        $this->form_validation->set_rules("country[]", 'Country', 'trim|required|callback__no_country|max_length[8]');
        $this->form_validation->set_rules("postal_code[]", 'Postal Code', 'trim|max_length[15]');
        $this->form_validation->set_rules("office_phone[]", 'Office Phone', 'trim|required|max_length[20]');
        $this->form_validation->set_rules("general_office_email[]", 'Email', 'trim|required|valid_email|max_length[256]');
        $this->form_validation->set_rules("contact_name[]", 'Contact Name', 'trim|max_length[256]');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
        $data['page_title'] = $data['page_heading'] = 'Expandable Inputs';
        $data['form_data'] = NULL;

        // validation hasn't been passed
        if ($this->form_validation->run() == FALSE) {

            // checks if the useragent has not previously saved data to this form
            if (!$this->expandable_input_model->firstTime()) {

                // Set an array of previously entered values to feed into the view
                $data['form_data'] = $this->expandable_input_model->getFormData();
            }
            $data['main_content'] = 'expandable_input_view';
            $this->load->view('includes/template', $data);

        // passed validation proceed to post success logic
        } else {
            
            // First we build an array for the model

            // 'street' is any arbitrary input that is a required input since counting incidents of that field will
            // tell us how many total records were sent
            $record = $this->input->post('street');
            $num_records = count($record);
            for ($i = 0; $i < $num_records; $i++) {
                $form_data[] = array(
                    'street[]' => set_value('street[]'),
                    'street2[]' => set_value('street2[]'),
                    'building_room_number[]' => set_value('building_room_number[]'),
                    'city[]' => set_value('city[]'),
                    'province[]' => set_value('province[]'),
                    'country[]' => set_value('country[]'),
                    'postal_code[]' => set_value('postal_code[]'),
                    'office_phone[]' => set_value('office_phone[]'),
                    'general_office_email[]' => set_value('general_office_email[]'),
                    'contact_name[]' => set_value('contact_name[]')
                );
            }
            if ($this->expandable_input_model->saveForm($form_data) === NULL) { // the information has therefore been successfully saved
                redirect('expandable_input/success');
            } else {
                echo 'An error occurred saving your information. Please try again later';
            }
        }
    }

    function success() {
        $this->load->library('table');
        $this->table->set_heading('Street', 'Street2', 'Building/Room Number', 'City', 'Province', 'Country', 'Postal Code', 'Office Phone', 'Email', 'Contact Name');
        $tmpl = array ('row_alt_start' => '<tr class="odd">');
        $this->table->set_template($tmpl);
        $data['page_title'] = $data['page_heading'] = 'Completed Successfully';
        $data['main_content'] = 'success';
        $this->load->view('includes/template', $data);
    }

    #-----------------------------------------------private functions section-------------------------------------------------#

    function _no_country($str) {
        if ($str === 'PICKONE' || $str === '----------') {
            $this->form_validation->set_message('_no_country', 'The %s field is required.');
            return false;
        } else {
            return true;
        }
    }

}

/* End of file expandable_input.php */
/* Location: ./application/controllers/expandable_input.php */
<?php
require_once(FCPATH . 'application/models/expandable_input_session_model.php');
class Expandable_input_model extends Expandable_input_session_model {

    function __construct() {
        parent::__construct('expandable_input');
    }
}

/* End of file expandable_input_model.php */
/* Location: ./application/models/expandable_input_model.php */
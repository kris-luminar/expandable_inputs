<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * country_dropdown() is copied from http://codeigniter.com/wiki/helper_dropdown_country_code/
 * my version has the $name paremeter to allow the use a css class name
 * @param <type> $name
 * @param <type> $top_countries
 * @param <type> $selection
 * @param <type> $show_all
 * @return string
 */
function  country_dropdown( $name="country", $top_countries=array(), $selection=NULL, $show_all=TRUE ){

    // You may want to pull this from an array within the helper
    $countries = config_item('country_list');

    $html = "<select class='country' name='{$name}'>\n\t\t";
    $selected = NULL;
    if(in_array($selection,$top_countries))  {
        $top_selection = $selection;
        $all_selection = NULL;
    }else{
        $top_selection = NULL;
        $all_selection = $selection;
    }

    if(!empty($top_countries)){
        foreach($top_countries as $value)  {
            if(array_key_exists($value, $countries)){
                if($value === $top_selection){
                    $selected = 'selected="selected"';
                }
                    $html .= "<option value='{$value}' {$selected}>{$countries[$value]}</option>\n\t\t";
                    $selected = NULL;
                }
            }
        $html .= "<option>----------</option>\n\t\t";
        }

    if($show_all)  {
        foreach($countries as $key => $country){
            if($key === $all_selection){
                $selected = 'selected="selected"';
            }
                $html .= "<option value='{$key}' {$selected}>{$country}</option>\n\t\t";
                $selected = NULL;
            }
        }

        $html .= "</select>";
        return $html;
    } 
// end of MY_form_helper.php
// location: application/helpers/MY_form_helper.php
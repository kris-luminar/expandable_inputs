/* 
 * add_remove_fields.js
 * Add/Remove Fields allows users to copy a block of inputs and validate them via JavaScript/JQuery
 * You must have a css class for each input that you will clone and then modify the selector inputs:
 *      "input.street, input.city, input.office_phone, input.general_office_email, .country"
 * so that they match your css classes
 * 
 * @version 2.0 2010/11/23
 * @author: Kris Luminar <kris@codemonkeys.biz>
 * @link http://codemonkeys.biz
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License ("OSL") v. 3.0
 * @require must have Jquery 1.4 or higher due to the last() function
 * @todo fix reset select of cloned input block not working in IE
 * @todo make this into one or two plugins
 */
var noErrors;
var emailErrorMsg = '<span class="error emailErrorMsg">Invalid Email Address</span>';
var addMeLink = '<a href="" class="add_me">Add An Office</a>';
var deleteMeLink = '<a href="" class="delete_me" onclick="confirm(\'Are you sure you wish to remove this office?\') ? this.parentNode.parentNode.removeChild(this.parentNode) : \'\'; return updateAddRemoveLinks();">Delete This Office</a>';

/**
 * updates the numbering for each office
 */
function updateOfficeNums() {
    offices = $('.office_num');
    offices.each(function(i){
        $(this).text((i + 1) + '/' + offices.length);
    });
}

/**
 * updates the add and remove links on removal or addition of an office
 */
function updateAddRemoveLinks(){
    // remove add another links
    $('.add_me, .delete_me').remove();
    // grab each addressDetails
    var addressDetails = $('.addressDetails');
    addressDetails.each(function(i){

        // skip the first one since at least one address is required
        if(i != 0){
            $(this).append(deleteMeLink);
        }
    }).last().append(addMeLink);
    updateOfficeNums();
    return false;
}

/**
 * check for valid email address
 */
function isEmail(Mail) {
    Mail = Mail.toLowerCase();
    return (Mail.search(/^[a-zA-Z]+([_\.-]?[a-zA-Z0-9]+)*@[a-zA-Z0-9]+([\.-]?[a-zA-Z0-9]+)*(\.[a-zA-Z]{2,6})+$/) != -1);
}

/**
 * really basic form validation that works across multiple input fields with the same name provided they share a class
 * works with new cloned elements
 */
function validate(elem){

    // no length means field is empty
    if(!elem.val().length){
        elem.focus().addClass('required_field');
        noErrors = false;
    }else if(elem.is('.general_office_email')){
        if(!isEmail(elem.val())){
            elem.focus().addClass('required_field');

            // avoid duplicate error messages
            if(!elem.parent().find('.emailErrorMsg').length){
                elem.parent().prepend(emailErrorMsg);
            }
            noErrors = false;
        }else{
            elem.removeClass('required_field');
            elem.parent().find('.emailErrorMsg').remove();
        }
    }else if(elem.is('.country')){
        var sel = elem.find('option:selected').val();
        if(sel=='PICKONE'||sel=='----------'||sel==''||sel==undefined||sel==null){
            elem.focus().addClass('required_field');
            noErrors = false;
        }else{
            elem.removeClass('required_field');
        }
    }else{
        elem.removeClass('required_field');
    }
}

// basic validation on form submission
$('#submit').click(function(){
    noErrors = true;

    // grab all the required inputs and iterate them in reverse order so that focus will be on the first error message
    $($('input.street, input.city, input.office_phone, input.general_office_email, .country').get().reverse()).each(function(){
        var elem = $(this);
        validate(elem);

        // had to remove the onBlur functionality since was crashing browser in IE
        if(!$.browser.msie){
            elem.bind('blur',function(){
                validate(elem);
            });
        }
    });

    // if noErrors is true, form will submit
    return noErrors;
});


$(document).ready(function(){
    updateAddRemoveLinks();

    $('a.delete_me').live('click', function(e){
        e.preventDefault();
    });
    $('a.add_me').live('click', function(e){
        e.preventDefault();
        var myParent = $(this).parent();
        var myClone = myParent.clone();

        // clear the values of the inputs
        myClone.find('input, select').each(function() {
            $(this).val('').removeClass('required_field');
        });
        myParent.after(myClone);
        updateAddRemoveLinks();
    });

    // captures space bar presses over links to trigger click() behaviour
    $("a").die("keypress").live("keypress", function(e) {
        if (e.which == 32) {
            $(this).trigger("click");
            e.preventDefault();
        }
    });
});

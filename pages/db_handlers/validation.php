<?php
  /*
  This php script assures if the form is filled correctly.
  */
  class Validation{
    private $form_data;
    private $field_value_lengths;
    private $post_format;

    function __construct($form_data, $post_format, $field_value_lengths){
      // Assignment to class variables
      $this->form_data = $form_data;
      $this->field_value_lengths = $field_value_lengths;
      $this->post_format = $post_format;
    }
    // Checks the validity of the POST request
    function post_check(){
      $is_pass = false;
      // Check whether the POST request length and the format of the POST request is valid...
      if (count($this->form_data)===count($this->post_format) && array_keys($this->form_data)===$this->post_format) {
        $is_pass=true;
      }
      return $is_pass;
    }
    // Checks the validity of the name entered by the user
    function name_check(){
      $is_pass = false;
      $_letters = "^abcdefghijklmnopqrstuvwxyz";
      if (!empty($this->form_data['name'])) {
        // Passes IF condition if only one 'name' key is available
        //    echo $this->form_data['name'];
        //    echo preg_match('/[^'.$_letters.' ]/i', $this->form_data['name']);
        if (!preg_match('/[^'.$_letters.' ]/i', $this->form_data['name']) && strlen($this->form_data['name'])<=$this->field_value_lengths["name"]) $is_pass=true;
      } else {
        // Pases IF condition if there are two 'name' keys available(First name & Last name)
        if (!preg_match('/[^'.$_letters.']/i', $this->form_data['f_name']) && !preg_match('/[^'.$_letters.']/i', $this->form_data['l_name']) && strlen($this->form_data['f_name'])<=$this->field_value_lengths["name"] && strlen($this->form_data['l_name'])<=$this->field_value_lengths["name"]) $is_pass=true;
      }
      return $is_pass;
    }
    // Checks the validity of the email address entered by the user
    function email_check(){
      $is_pass = false; // Initialize the variable to false before deployment
      //$_letters = "abcdefghijklmnopqrstuvwxyz";
      //$_unusable_symbols = ".";
      // Use FILTER_VALIDATE_EMAIL for the moment, change it to own algorithm later...
      $is_valid= filter_var($this->form_data['email'], FILTER_VALIDATE_EMAIL);
      if (strlen($this->form_data['email'])<=$this->field_value_lengths["email"]){
        // echo "Email check: OK";
        if ($this->form_data['email']===$is_valid) $is_pass=true;
      }
      return $is_pass;
    }
    function phone_check()
    {
      $is_pass = false;
//      $_numbers = "123456789";
//      $_symbols = "+";
      // Check whether the phone number field is empty or not and if the length of the subject is valid
      if (empty($this->form_data['phone']) !== 1) {
        if (!preg_match("/[^\d+]/i", $this->form_data['phone']) && strlen($this->form_data['phone'])<=$this->field_value_lengths["phone"]) $is_pass=true;
      }
      return $is_pass;
    }
    function subject_check(){
      $is_pass = false;
      // Check whether the subject is empty or not and if the length of the subject is valid
      if (empty($this->form_data['subject'])!==1) {
        // echo "Subject check: OK";
        if (strlen($this->form_data['subject'])<=$this->field_value_lengths["subject"]) $is_pass=true;
      }
      return $is_pass;
    }
    function message_check(){
      $is_pass = false;
      // Check whether the message is empty or not and if the length of the message is valid
      if (empty($this->form_data['msg'])!==1) {
        // echo "Message check: OK";
        if (strlen($this->form_data['msg'])<=$this->field_value_lengths["msg"]) $is_pass=true;
      }
      return $is_pass;
    }
  }

 ?>

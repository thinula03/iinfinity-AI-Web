<?php
    session_start();
    $name_length = 100; // The maximum length of the name field, Adjust accordingly
    $email_address_length = 320; // The maximum length of the email address field, Adjust accordingly
    $phone_number_length = 13; // The maximum length of the email address field, Adjust accordingly
    $message_length = 2000; // Adjust accordingly
    $post_format = array('0' => "f_name", '1' => "l_name", '2' => "email", '3' => "phone", '4' => "msg",'5' => "submit");
    $field_value_lengths = array('name' => $name_length, 'email' => $email_address_length, 'phone' => $phone_number_length, 'msg' => $message_length);
    $validation_pass = false;
    $validation_text = "";
    if (!empty($_POST)) {
        include_once 'db_handlers/validation.php';
        $validate = new Validation($_POST, $post_format, $field_value_lengths);
        // Do the form data validation tests
        $valid_post = $validate->post_check();
        if ($valid_post) {
            $valid_name = $validate->name_check();
            $valid_email = $validate->email_check();
            $valid_phone = $validate->phone_check();
            $valid_message = $validate->message_check();
            // Assigning the error text if any available
            if (!$valid_name) {
                $validation_text = "Type your name correctly. It's important to provide accurate information, so we can reach back to you.";
            } elseif (!$valid_email) {
                $validation_text = "Type your email correctly. It's important to provide accurate information, so we can reach back to you.";
            } elseif (!$valid_message) {
                $validation_text = "Give your quote description correctly. It's important to provide accurate information, so we can reach back to you.";
            } elseif (!$valid_phone){
                $validation_text = "Type your phone number correctly. It's important to provide accurate information, so we can reach back to you.";
            } else {
                $validation_pass = true;
                $validation_text = "Thank you for reaching us. We will get back to you as soon as possible.";
                include_once 'db_handlers/mitigator.php';
                $mitigator = new Mitigator();
                $f_name = $mitigator->sanitize($_POST['f_name']);
                $l_name = $mitigator->sanitize($_POST['l_name']);
                $email = $mitigator->sanitize($_POST['email']);
                $phone = $mitigator->sanitize($_POST['phone']);
                $request = $mitigator->sanitize($_POST['msg']);
                include_once 'db_handlers/user_data.php';
                $db = new User_Data();
                $db->connect();
                $db->request_quote($f_name, $l_name, $email, $phone, $request);
                $db->disconnect();
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/circle-logo-favicon.png">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/quote.css">

    <title>Get a quote</title>
</head>
<body>
    <div class="hero">
    <nav>
        <h2 class="logo">Iinfinity <span>AI</span></h2>

        <a href="../index.html" class="btn">Back</a>
    </nav>

    <div class="form-box">
		<form class="box" method="post">
			<h1 class="formhead">Get a Quote</h1>
      <input type="text" name="f_name" id="" placeholder="First Name" maxlength="<?php echo $name_length?>" required>
			<input type="text" name="l_name" id="" placeholder="Last Name" maxlength="<?php echo $name_length?>" required>
			<input type="email" name="email" id="" placeholder="email" maxlength="<?php echo $email_address_length?>" required>
			<input type="text" name="phone" id="" placeholder="Phone" maxlength="<?php echo $phone_number_length?>" required>
			<textarea name="msg" id="" cols="30" rows="10" maxlength="<?php echo $message_length?>" placeholder="Request"></textarea>
			<input type="submit" name="submit" value="Submit">
		</form>
	</div>
    </div>
</body>
</html>

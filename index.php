
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link rel="icon" type="image/png" href="https://libapps.s3.amazonaws.com/customers/2097/images/favicon.ico" />
    <title>Vassar College Libraries - Reserves Agreement</title> 
    <script>
        function validateForm() {
        if (document.forms["myForm"]["chkbox"].checked == false) {
            alert("You must agree to the statement by checking the box.");
            return false;
        } else {
              // check that email address is not blank
              let x = document.forms["myForm"]["email"].value;
              if (x == "") {
                alert("Email must be entered.");
                return false;
              } 
        }
}
</script>
</head>
<body>
<style>
    body {
            font-family: Verdana, sans-serif;
            font-size:24px;
            margin:50px;
            border: solid #641A2B;
            border-width: 12px;
            padding:20px;
            background-color:#FFF8EF;
    }
</style>

<div style="float:right;"><img src="https://d2jv02qf7xgjwx.cloudfront.net/customers/2097/images/Vassar_Badges_Circle_Burgundy-02.png" height="200px"></div>

<h1>Vassar College Libraries</h1>
<h2>Reserves Agreement</h2>

<form name="myForm" action="/almasign/action_page.php" onsubmit="return validateForm()">
<br /><br />
<input type="checkbox" name="chkbox" style="transform: scale(2.25);margin:8px;">
<span width="60px !important;">By checking this box, I acknowledge that reserves items only check out for a limited amount of time, and I am responsible for returning the item when it is due, otherwise I will accrue fines for which I am responsible. </span>
</input>
<br /><br />
  <label for="email">Email address:</label><br>
  <input style="text-align:right;height:50px;font-size:24px;margin:8px;" type="text" id="email" name="email" value="" size="20">@vassar.edu<br>
  <i>You will receive an email copy of this agreement.</i>
<br /><br />
  <input type="submit" value="Submit" style="padding:8px;background-color:green;font-size:24px;border-radius:5px;color:white;">
</form> 
</body>
</html>





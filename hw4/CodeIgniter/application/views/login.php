<div class="login" style="margin:0 auto; width:500px; z-index:1">
<fieldset style="display:inline-block; width:500px">
<legend>Login</legend>
<form action="<?php echo base_url('index.php/user/login');?>"  method="POST">
E-mail address:<br>
<input type="email" id="username" name="username" size="60" maxlength="60" required/><br><br>
Password:<br>
<input type="password" id="password" name="password" size="60" maxlength="60" required/><br><br>
<input type="submit" name="loginsubmit" value="Login"/>
</form>
<div style="float:right">
<button class="signup">Sign Up </button>
</div>
<br>

</fieldset>
</div>
<br>

<div class="signup" style="width:500px; margin:0 auto;  display:none">
<fieldset style="width:500px">
<legend>Sign Up</legend>
<form action="<?php echo base_url('index.php/user/signup');?>" method="POST">
First name:<br>
<input type="text" id="fname" name="fname" size="60" maxlength="60" required/><br><br>
Last name:<br>
<input type="text" id="lname" name="lname" size="60"  maxlength="60" required/><br><br>
E-mail address:<br>
<input type="email" id="newusername" name="newusername" size="60"  maxlength="60" required/><br><br>
Password:<br>
<input type="password" id="newpassword" name="newpassword" size="60"  maxlength="60" required/><br><br>
<input type="submit" name="signupsubmit"  value="Create Account"/>
</form>
<div style="float:right">
<button class="login">Log In </button>
</div>
</fieldset>
<br>

</div>
<br>



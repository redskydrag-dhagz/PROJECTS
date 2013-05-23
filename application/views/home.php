<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome!</title>
<link href="<?=base_url()?>public/css/bootstrap.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?=base_url()?>public/js/jquery.js"></script>
<script type="text/javascript" src="<?=base_url()?>public/js/bootstrap.js"></script>
<style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
        font-family: Cambria,'Times New Roman','Nimbus Roman No9 L','Freeserif',Times,serif;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading{
        margin-bottom: 10px;
        text-align: center;
      }
      .form-signin-heading-sub{ text-align: center; }
      .form-signin-error-message{ text-align: center; color:#F00; }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>
    <script type="text/javascript">
        $(function(){
            $("#myMessage").modal('show');
        })
    </script>
</head>
<body>
    <div class="container">
    <?=form_open("home/login", 'class="form-signin"')?>
        <h2 class="form-signin-heading">Welcome!</h2>
        <h5 class="form-signin-heading-sub">Enter your username and password</h5>
        <?=validation_errors('<h6 class="form-signin-error-message">','</h6>')?>
        <?=strlen($message)>0 ? '<h6 class="form-signin-error-message">'.$message.'</h6>': ""?>
        <input type="text" class="input-block-level" placeholder="Username" name="username" value="<?=set_value('username')?>">
        <input type="password" class="input-block-level" placeholder="Password" name="password">
        
        <button class="btn btn-medium btn-primary" type="submit">Sign in</button>
      </form>
</div>
    <div id="myMessage" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel" class=" text-warning"><i class="icon-warning-sign"></i>WARNING!</h3>
</div>
<div class="modal-body">
<p>Please be sure that you are using LATEST Mozilla Firefox or Google Chrome Browser!<br />And make sure that javascript is enabled!</p>
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
</div>
</div>
</body>
</html>
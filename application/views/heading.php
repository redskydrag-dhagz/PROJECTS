<!DOCTYPE html>
<html lang="en">
<head>
<title>Hello world</title>
<link href="<?=base_url()?>public/css/bootstrap.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url()?>public/css/jquery-ui-1.9.2.custom.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url()?>public/css/jquery-ui.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />

<script type="text/javascript" src="<?=base_url()?>public/js/jquery.js"></script>
<script type="text/javascript" src="<?=base_url()?>public/js/bootstrap.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
<script type="text/javascript" src="<?=base_url()?>public/js/action.js" ></script>
<script type="text/javascript" src="<?=base_url()?>public/js/jquery-ui-1.9.2.custom.js" ></script>
<style type="text/css">
    body{
        font-family: Cambria,'Times New Roman','Nimbus Roman No9 L','Freeserif',Times,serif; 
    } 
</style>

<script type='text/javascript'>
        $(function(){ 
            $("#date").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "yy-mm-dd"
            });
        });
    </script>
</head>
<body>
    <div id="padding">&nbsp;</div>
<div class="container">
    <div class="row">
        <div class="span12">
           <div class="navbar">
          <div class="navbar-inner">
            <div class="container" style="width: auto;">
              <a class="brand" href="<?=base_url()."home/door"?>">Inventory System</a>
              <ul class="nav" role="navigation">
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Item <b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li><a href="<?=base_url()?>item/newitem">New</a></li>
                    <li><a href="<?=base_url()?>item/updateitem">Update</a></li>
                    <li><a href="<?=base_url()?>item/viewitem">View</a></li>
                  </ul>
                </li>
                <li class="dropdown">
                  <a href="#" id="drop2" role="button" class="dropdown-toggle" data-toggle="dropdown">Operation <b class="caret"></b></a>
                  <ul class="dropdown-menu" role="menu" aria-labelledby="drop2">
                    <li><a href="<?=base_url()?>maneuver/process">Add Transaction</a></li>
                    <li><a href="<?=base_url()?>maneuver/edit">View Transaction</a></li>
                  </ul>
                </li>
                <li><a href="<?=base_url()?>images/insert">Image</a></li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Settings <b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li><a href="<?=base_url()?>setting/clean_photo">Image Storage</a></li>
                    <li><a href="<?=base_url()?>setting/clean/status">Status</a></li>
                    <li><a href="<?=base_url()?>setting/clean/operation">Operation</a></li>
                  </ul>
                </li>
              </ul>
              
              <ul class="nav pull-right">
                <li> <a href="<?=base_url()?>home/logout">Log Out</a> </li>
              </ul>
            </div>
          </div>
        </div> <!-- /navbar-example -->
        </div>

    </div>
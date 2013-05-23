<!DOCTYPE html>
<html lang="en">
<head>
    <title>Hello world</title>
    <link href="public/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="public/js/jquery.js"></script>
    <script type="text/javascript" src="public/js/bootstrap.js"></script>
    <style type="text/css">
        .span12{ border:1px solid #000; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="span12">
               <div class="navbar">
              <div class="navbar-inner">
                <div class="container" style="width: auto;">
                  <a class="brand" href="#">Inventory System</a>
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
                      <a href="#" id="drop2" role="button" class="dropdown-toggle" data-toggle="dropdown">Dropdown 2 <b class="caret"></b></a>
                      <ul class="dropdown-menu" role="menu" aria-labelledby="drop2">
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Action</a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another action</a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Something else here</a></li>
                        <li role="presentation" class="divider"></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated link</a></li>
                      </ul>
                    </li>
                  </ul>
                  <ul class="nav pull-right">
                    <li id="fat-menu" class="dropdown">
                      <a href="#" id="drop3" role="button" class="dropdown-toggle" data-toggle="dropdown">Dropdown 3 <b class="caret"></b></a>
                      <ul class="dropdown-menu" role="menu" aria-labelledby="drop3">
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Action</a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another action</a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Something else here</a></li>
                        <li role="presentation" class="divider"></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated link</a></li>
                      </ul>
                    </li>
                  </ul>
                </div>
              </div>
            </div> <!-- /navbar-example -->
            </div>
            
        </div>
        <div class="row">
            <div class="span2">
                <div class="dropdown">
                <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel"  style="display: block;">
                    <li class="dropdown-submenu">
                       <a tabindex="-1" href="#">Item</a>
                       <ul class="dropdown-menu">
                       <li><a tabindex="-1" href="item/newitem">New</a></li>
                       <li><a tabindex="-1" href="item/updateitem">Update</a></li>
                       <li><a tabindex="-1" href="item/viewitem">View</a></li>
                       </ul>
                    </li>
               </ul>
                </div>
            </div>
            <div class="span9">the body</div>
        </div>
    </div>
    
    
</body>
</html>
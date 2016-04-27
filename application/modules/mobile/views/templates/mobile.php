<?php 
	
	if(!isset($contacts))
	{
		$contacts = $this->site_model->get_contacts();
	}
	$company_name = $contacts['company_name']; 
	$logo = $contacts['logo']; 
	$phone = $contacts['phone']; 

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<title><?php echo $company_name;?> | <?php echo $title;?></title>

		<!-- font Raleway link -->  
		<link href='//fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
		<link href='//fonts.googleapis.com/css?family=Roboto+Slab:400,300,700' rel='stylesheet' type='text/css'>

		<!-- all css here -->
		<!-- Path to Framework7 Library CSS-->
		<link rel="stylesheet" href="<?php echo base_url()."assets/themes/ecom/"?>css/framework7.ios.min.css">
		<link rel="stylesheet" href="<?php echo base_url()."assets/themes/ecom/"?>css/framework7.ios.colors.min.css">
		<link rel="stylesheet" href="<?php echo base_url()."assets/themes/ecom/"?>css/swipebox.css">		        
		<!-- font-awesome.min CSS -->      
		<link rel="stylesheet" href="<?php echo base_url()."assets/themes/";?>fontawesome/css/font-awesome.css">
		<!-- style CSS -->          
		<link rel="stylesheet" href="<?php echo base_url()."assets/themes/ecom/"?>style.css">
		<!-- style CSS -->          
		<link rel="stylesheet" href="<?php echo base_url()."assets/themes/ecom/"?>css/responsive.css">
	</head>
	
	<body>
		<!-- Status bar overlay for fullscreen mode-->
		<div class="statusbar-overlay"></div>
		<!-- Panels overlay-->
		<div class="panel-overlay"></div>
		<!-- Left panel with reveal effect-->
		<div class="panel panel-left panel-reveal menubg">
			<div class="menu-hoverlay">
				<div class="line"></div>
				<div class="logo-box">
					<h3><img src="<?php echo base_url().'assets/logo/'.$logo;?>" alt="<?php echo $company_name;?>" class="logo"></h3>
				</div>
				<div class="mainmenu">
					<div class="row">
						<div class="col-100">
							<div class="menu">
							<a href="<?php echo site_url().'mobile-member-dashboard';?>" class="item-link close-panel">
								<img src="<?php echo base_url()."assets/themes/ecom/"?>img/menu/1.png" alt="">
								HOME
								</a>
							</div>
						</div>
						<div class="col-100">
							<div class="menu">
							<a class="item-link close-panel item-content external" href="tel:+88-01627-600206">
								<img src="<?php echo base_url()."assets/themes/ecom/"?>img/menu/11.png" alt="">
								CALL US</a>
							</div>
						</div>
						<!--<div class="col-100">
							<div class="menu">
							<a class="item-link close-panel item-content" href="contact.html">
								<img src="<?php echo base_url()."assets/themes/ecom/"?>img/menu/12.png" alt="">
								CONTACT</a>
							</div>
						</div>	-->	
					</div>
				</div>
				<!-- Menu end -->
			</div>
		</div>
		<!-- login screen  start-->
		<div class="login-screen">
		<div class="view">
		  <div class="page">
			<div class="page-content login-screen-content registerbody">
				<div class="register-content">
					<a href="#" class="close-login-screen floatright"><i class="fa fa-times"></i></a>
					<h3><img src="<?php echo base_url().'assets/logo/'.$logo;?>" alt="<?php echo $company_name;?>" class="logo"></h3>
                    <form action="<?php echo site_url().'mobile/auth/login_member';?>" method="POST">
                        <div class="inputbox">
                            <span>Username:</span><br>
                            <input type="text" name="individual_username" id="name" placeholder="Username" value="<?php echo set_value('individual_username');?>">
                        </div>
                        <div class="inputbox">
                            <span>Password:</span><br>
                            <input type="password" name="individual_password" placeholder="***********" value="<?php echo set_value('individual_password');?>">
                        </div>
                        <div class="inputbox">
                            <!--<a data-popup=".popup-forgetpass" class="open-popup"   href="#">Forgot Password?</a>-->
                        </div>
                        <div class="inputbox">
                            <button class="button button-big">Login</button>
                        </div>						
                    </form>	
                    <p>Don’t have an account?  <a data-popup=".popup-register" class="open-popup" href="#">Activate</a></p>
				</div>
			</div>
		  </div>
		</div>
	  </div>
		<!-- login screen  start-->
		
		<!-- forget password  start-->
		<div class="popup popup-forgetpass">
			<div class="registerbody">
				<a href="#" class="close-popup closebutton"><i class="fa fa-times"></i></a>
				<div class="register-content">
					<h3><img src="<?php echo base_url().'assets/logo/'.$logo;?>" alt="<?php echo $company_name;?>" class="logo"></h3>
					<form action="#">
						<div class="inputbox">
							<span>Email:</span><br>
							<input type="email" name="password" placeholder="email@gmail.com">
						</div>
						<div class="inputbox">
							<button class="button button-big">Remember me</button>
						</div>						
					</form>	
					<p>Don’t have an account?<a data-popup=".popup-register" class="open-popup" href="#"> Sign Up</a></p>
				</div>
			 </div>
		</div>
		<!-- forget password  end-->
		  
		<!-- resister popup start-->
		<div class="popup popup-register">
			<div class="registerbody">
					<a href="#" class="close-popup closebutton"><i class="fa fa-times"></i></a>
				 <div class="register-content">
					<h3><img src="<?php echo base_url().'assets/logo/'.$logo;?>" alt="<?php echo $company_name;?>" class="logo"></h3>
					<form action="<?php echo site_url().'mobile/auth/activate_member';?>" method="POST">
                        <div class="inputbox">
                            <span>Payroll/ Member No.:</span><br>
                            <input type="text" name="individual_number" placeholder="Number" value="<?php echo set_value('individual_number');?>">
                        </div>
                        <div class="inputbox">
                            <span>Username:</span><br>
                            <input type="text" name="individual_username" placeholder="Username" value="<?php echo set_value('individual_username');?>">
                        </div>
                        <div class="inputbox">
                            <span>Phone:</span><br>
                            <input type="text" name="individual_phone" placeholder="0722222222" value="<?php echo set_value('individual_phone');?>">
                        </div>
                        <div class="inputbox">
                            <span>Email:</span><br>
                            <input type="email" name="individual_email" placeholder="email@gmail.com" value="<?php echo set_value('individual_email');?>">
                        </div>
                        <div class="inputbox">
                            <button class="button button-big" type="submit">Activate</button>
                        </div>					
                    </form>
				</div>
			 </div>
		</div>
		<!-- resister popup start-->	
		<!-- Views-->
		<div class="views">
			<!-- Your main view, should have "view-main" class-->
			<div class="view view-main">
				<!-- Top Navbar-->
				<div class="navbar">
					<div class="navbar-inner">
						<div class="left">
							<!-- left link contains only icon - additional "icon-only" class-->
							<img src="<?php echo base_url().'assets/logo/'.$logo;?>" alt="<?php echo $company_name;?>" class="logo">
						</div>
						<!-- We have home navbar without left link-->
						<div class="center sliding"><?php echo $company_name;?></div>
						<div class="right">
					  		<!-- right link contains only icon - additional "icon-only" class-->
                           <a href="#" class="link icon-only open-panel"><img src="<?php echo base_url()."assets/themes/ecom/"?>img/menu.png" alt=""></a>
						</div>
					</div>
				</div>

				<!-- Pages, because we need fixed-through navbar and toolbar, it has additional appropriate classes-->
				<div class="pages navbar-through toolbar-through">
					<!-- Page, data-page contains page name-->
                    <?php echo $content;?>
                </div>
			</div>
		</div>
		
		<!-- Js -->
		<!-- jquery-1.11.3.min js -->         
		<script src="<?php echo base_url()."assets/themes/ecom/"?>js/jquery-1.11.3.min.js"></script>
		<!-- Path to Framework7 Library JS --> 
		<script type="text/javascript" src="<?php echo base_url()."assets/themes/ecom/"?>js/framework7.min.js"></script>
		<!--jquery.swipebox js --> 
		<script type="text/javascript" src="<?php echo base_url()."assets/themes/ecom/"?>js/jquery.swipebox.js"></script>
		<!-- Path to your app js --> 
		<script type="text/javascript" src="<?php echo base_url()."assets/themes/ecom/"?>js/my-app.js"></script>
  </body>
</html>
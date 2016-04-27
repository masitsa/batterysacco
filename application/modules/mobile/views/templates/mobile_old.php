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
		<!-- favicon
		============================================ -->		
		<link rel="shortcut icon" type="image/x-icon" href="img/fav-jhilex.png">	
		<!-- font Raleway link -->  
		<link href='//fonts.googleapis.com/css?family=Raleway:400,800,700,600,500,100,900,300' rel='stylesheet' type='text/css'>
		<!-- font open sanse link -->
		<link href='//fonts.googleapis.com/css?family=Open+Sans:400,600,600italic,700,700italic,800,300' rel='stylesheet' type='text/css'>
		
		<!-- all css here -->
		<!-- Path to Framework7 Library CSS-->
		<link rel="stylesheet" href="<?php echo base_url()."assets/themes/jhilex/"?>css/framework7.ios.min.css">
		<link rel="stylesheet" href="<?php echo base_url()."assets/themes/jhilex/"?>css/framework7.ios.colors.min.css">	        
		<!-- font-awesome.min CSS -->      
		<link rel="stylesheet" href="<?php echo base_url()."assets/themes/";?>fontawesome/css/font-awesome.css">
		<!-- swipebox CSS -->
		<link rel="stylesheet" href="<?php echo base_url()."assets/themes/jhilex/"?>css/swipebox.css">
		<link rel="stylesheet" href="<?php echo base_url()."assets/themes/jhilex/"?>css/kitchen-sink.css">	
		<!-- style CSS -->          
		<link rel="stylesheet" href="<?php echo base_url()."assets/themes/jhilex/"?>style.css">
		<link rel="stylesheet" href="<?php echo base_url()."assets/themes/jhilex/"?>css/responsive.css">
	</head>
	<body>
        <!-- Status bar overlay for fullscreen mode-->
        <div class="statusbar-overlay"></div>
        <!-- Panels overlay-->
        <div class="panel-overlay"></div>
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
        <!-- popup menu  start-->
        <div class="popup popup-menu registerbodypop">
            <div class="registerbodypop">
                
                <div class="mainmenu">
                    <div class="menuheader">
                        <div class="logo">Menu</div>
                        <div class="contacticone">
                            <a href="#" class="close-popup"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                    <div class="menu">
                        <ul>
                            <li><a class="close-popup" href="#">Home</a></li>
                            <li><a class="close-popup" href="galleries.html">Galleries</a></li>
                            <li><a class="close-popup" href="protfolios.html">Portfolios</a></li>
                            <li><a href="#">Pages</a>
                                <a class="clickmenu floatright" href="#">
                                    <span class="fa fa-plus"></span>
                                </a>
                                <ul class="show-menu">
                                    <li><a class="close-popup open-login-screen" href="#">Login</a></li>
                                    <li><a data-popright=".popup-register" class="open-popup" href="#">Register</a></li>
                                    <li><a data-popup=".popup-forgetpass" class="open-popup" href="#">Forget Password</a></li>
                                    <li><a class="close-popup" href="blog-details.html">Blog Details</a></li>
                                    <li><a class="close-popup" href="error.html">404 page</a></li>
                                </ul>
                            </li>
                            <li><a class="close-popup" href="blog.html">Blog</a></li>
                            <li><a class="close-popup" href="contact.html">Contact</a></li>
                        </ul>
                    </div>
                </div>
             </div>
        </div> 
        <!-- popup menu end-->
      
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
        <!-- menu popup start-->
        <div class="popup popup-menu">
			<div class="content-block">
				<div class="content-block-inner">
        			<a href="#" class="close-popup closebutton"><i class="fa fa-times"></i></a>
					<div class="row">
						<div class="col-100 center-align">
                        	<h3><img src="<?php echo base_url().'assets/logo/'.$logo;?>" alt="<?php echo $company_name;?>" class="logo"></h3>
                        </div>
						<div class="col-100">
							<a href="index.html">
								<div class="offer-box">
									<div class="cat-icone"><img src="<?php echo base_url()."assets/themes/jhilex/"?>img/icone/home.png" alt=""></div>
									<div class="offer-text">
										<h3>Home</h3>										
									</div>
								</div>
							</a>
						</div>
						<!--<div class="col-50">
							<a class="close-popup open-login-screen" href="#">
								<div class="offer-box">
									<div class="cat-icone"><img src="<?php echo base_url()."assets/themes/jhilex/"?>img/icone/login.png" alt=""></div>
									<div class="offer-text">
										<h3>Login</h3>										
									</div>
								</div>
							</a>
						</div>
						<div class="col-50">
							<a data-popup=".popup-register" class="open-popup" href="#">
								<div class="offer-box sign-div">								
									<div class="cat-icone"><img src="<?php echo base_url()."assets/themes/jhilex/"?>img/icone/sign-up.png" alt=""></div>
									<div class="offer-text">
										<h3>Activate </h3>										
									</div>
								</div>
							</a>
						</div>-->
						<div class="col-50">
							<a href="contact.html">
								<div class="offer-box">								
									<div class="cat-icone"><img src="<?php echo base_url()."assets/themes/jhilex/"?>img/icone/contact.png" alt=""></div>
									<div class="offer-text">
										<h3>Contact</h3>										
									</div>
								</div>
							</a>
						</div>
						<div class="col-50">
							<a class="external" href="tel:<?php echo $phone;?>">
								<div class="offer-box">								
									<div class="cat-icone"><img src="<?php echo base_url()."assets/themes/jhilex/"?>img/icone/call-us.png" alt=""></div>
									<div class="offer-text">
										<h3>Call Us</h3>										
									</div>
								</div>
							</a>
						</div>
					</div>
				</div>
            </div>
        </div>
        <!-- menu popup end-->
        <!-- Views-->
        <div class="views">
          <!-- Your main view, should have "view-main" class-->
            <div class="view view-main">
                <!-- Top Navbar-->
                <div class="navbar">
                    <div class="navbar-inner">
                        <div class="left">
                        	<a href="#"><img src="<?php echo base_url().'assets/logo/'.$logo;?>" alt="<?php echo $company_name;?>" class="logo"></a>
                        </div>
                        <!-- We have home navbar without left link-->
                        <div class="center sliding"><?php echo $company_name;?></div>
                        <div class="right">
                      	<!-- left link contains only icon - additional "icon-only" class-->
                        	<a href="#" data-popup=".popup-menu" class="open-popup link icon-only"><img src="<?php echo base_url().'assets/themes/jhilex/';?>img/icone/menu.png" alt=""></a>
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
        <script src="<?php echo base_url()."assets/themes/jhilex/"?>js/vendor/jquery-1.11.3.min.js"></script>
        <!--jquery.swipebox js -->
        <script src="<?php echo base_url()."assets/themes/jhilex/"?>js/jquery.swipebox.js"></script>
            <!--jquery.mixitup js -->  
        <script src="<?php echo base_url()."assets/themes/jhilex/"?>js/jquery.mixitup.min.js"></script>
        <!-- Path to Framework7 Library JS --> 
        <script type="text/javascript" src="<?php echo base_url()."assets/themes/jhilex/"?>js/framework7.min.js"></script>
        <!-- Path to your app js --> 
        <script type="text/javascript" src="<?php echo base_url()."assets/themes/jhilex/"?>js/my-app.js"></script>
	</body>
</html>
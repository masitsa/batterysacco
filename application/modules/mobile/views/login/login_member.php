					<div class="page" data-page="options">
                        <div class="page-content">
                        	<?php
								$success = $this->session->userdata('success_message');
								$login_error = $this->session->userdata('login_error');
								$this->session->unset_userdata('login_error');
								
								if(!empty($login_error))
								{
									echo '<div class="alert alert-danger">'.$login_error.'</div>';
								}
								
								if(!empty($success))
								{
									echo '<div class="alert alert-success">'.$success.'</div>';
									$this->session->unset_userdata('success_message');
								}
							?>
                            <div class="client-area">
                                <div class="section-title">
                                    <h1>MEMBER <strong> LOGIN</strong></h1>
                                    <p>Log into your account</p>
                                </div>
                                <div class="client-all-content">
                                    <div class="row">
                                        <div class="col-100 tablet-100">
                                            <div class="client-img">
                                                <a href="#" class="open-login-screen"><img alt="" src="<?php echo base_url().'assets/img/';?>login.png">
                                               <p>Login</p></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="section-title">
                                    <h1>MEMBER <strong> ACTIVATION</strong></h1>
                                    <p>Enter your phone number and activate your account</p>
                                </div>
                                <div class="client-all-content">
                                    <div class="row">
                                        <div class="col-100 tablet-100">
                                            <div class="client-img">
                                                <a href="#" class="open-popup" data-popup=".popup-register"><img alt="" src="<?php echo base_url().'assets/img/';?>register.png">
                                               <p>Activate</p></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
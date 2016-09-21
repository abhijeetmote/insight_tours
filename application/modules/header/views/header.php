<!DOCTYPE html>
<html lang="en">
	

<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Dashboard - Ace Admin</title>

		<meta name="description" content="overview &amp; stats" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>css/font-awesome.min.css" />

		<!-- page specific plugin styles -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>components/_mod/jquery-ui.custom/jquery-ui.custom.min.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>components/chosen/chosen.min.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>components/bootstrap-timepicker/css/bootstrap-timepicker.min.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>components/_mod/jqgrid/ui.jqgrid.min.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>components/bootstrap-daterangepicker/daterangepicker.min.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>components/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css" />
		<!-- page specific plugin styles -->

		<!-- text fonts -->
		<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>css/googleapi.css" /> -->

		<!-- ace styles -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

		<link rel="stylesheet" href="<?php echo base_url(); ?>css/custom.css" />
		

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="./dist/css/ace-part2.min.css" class="ace-main-stylesheet" />
		<![endif]-->
		<link rel="stylesheet" href="<?php echo base_url(); ?>css/ace-skins.min.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>css/ace-rtl.min.css" />

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="./dist/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->
		<script src="<?php echo base_url(); ?>js/ace-extra.min.js"></script>

		<link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery.dataTables.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery.sliderTabs.min.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery.treetable.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery-gmaps-latlon-picker.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery-te-1.4.0.css" />
		
		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="./components/html5shiv/dist/html5shiv.min.js"></script>
		<script src="./components/respond/dest/respond.min.js"></script>
		<![endif]-->
	</head>

	<body class="no-skin">
		<input type="hidden" value="<?php echo base_url(); ?>" id="baseUrl">
		<div id="navbar" class="navbar navbar-default          ace-save-state">
			<div class="navbar-container ace-save-state" id="navbar-container">
				<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
					<span class="sr-only">Toggle sidebar</span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>
				</button>

				<div class="navbar-header pull-left">
					<a href="#" class="navbar-brand">
						<small>
							<i class="fa fa-leaf"></i>
							Ace Admin
						</small>
					</a>
				</div>

				<div class="navbar-buttons navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
						<li class="grey dropdown-modal">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="ace-icon fa fa-tasks"></i>
								<span class="badge badge-grey">4</span>
							</a>

							<ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<i class="ace-icon fa fa-check"></i>
									4 Tasks to complete
								</li>

								<li class="dropdown-content">
									<ul class="dropdown-menu dropdown-navbar">
										<li>
											<a href="#">
												<div class="clearfix">
													<span class="pull-left">Software Update</span>
													<span class="pull-right">65%</span>
												</div>

												<div class="progress progress-mini">
													<div style="width:65%" class="progress-bar"></div>
												</div>
											</a>
										</li>

										<li>
											<a href="#">
												<div class="clearfix">
													<span class="pull-left">Hardware Upgrade</span>
													<span class="pull-right">35%</span>
												</div>

												<div class="progress progress-mini">
													<div style="width:35%" class="progress-bar progress-bar-danger"></div>
												</div>
											</a>
										</li>

										<li>
											<a href="#">
												<div class="clearfix">
													<span class="pull-left">Unit Testing</span>
													<span class="pull-right">15%</span>
												</div>

												<div class="progress progress-mini">
													<div style="width:15%" class="progress-bar progress-bar-warning"></div>
												</div>
											</a>
										</li>

										<li>
											<a href="#">
												<div class="clearfix">
													<span class="pull-left">Bug Fixes</span>
													<span class="pull-right">90%</span>
												</div>

												<div class="progress progress-mini progress-striped active">
													<div style="width:90%" class="progress-bar progress-bar-success"></div>
												</div>
											</a>
										</li>
									</ul>
								</li>

								<li class="dropdown-footer">
									<a href="#">
										See tasks with details
										<i class="ace-icon fa fa-arrow-right"></i>
									</a>
								</li>
							</ul>
						</li>

						<li class="purple dropdown-modal">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="ace-icon fa fa-bell icon-animated-bell"></i>
								<span class="badge badge-important">8</span>
							</a>

							<ul class="dropdown-menu-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<i class="ace-icon fa fa-exclamation-triangle"></i>
									8 Notifications
								</li>

								<li class="dropdown-content">
									<ul class="dropdown-menu dropdown-navbar navbar-pink">
										<li>
											<a href="#">
												<div class="clearfix">
													<span class="pull-left">
														<i class="btn btn-xs no-hover btn-pink fa fa-comment"></i>
														New Comments
													</span>
													<span class="pull-right badge badge-info">+12</span>
												</div>
											</a>
										</li>

										<li>
											<a href="#">
												<i class="btn btn-xs btn-primary fa fa-user"></i>
												Bob just signed up as an editor ...
											</a>
										</li>

										<li>
											<a href="#">
												<div class="clearfix">
													<span class="pull-left">
														<i class="btn btn-xs no-hover btn-success fa fa-shopping-cart"></i>
														New Orders
													</span>
													<span class="pull-right badge badge-success">+8</span>
												</div>
											</a>
										</li>

										<li>
											<a href="#">
												<div class="clearfix">
													<span class="pull-left">
														<i class="btn btn-xs no-hover btn-info fa fa-twitter"></i>
														Followers
													</span>
													<span class="pull-right badge badge-info">+11</span>
												</div>
											</a>
										</li>
									</ul>
								</li>

								<li class="dropdown-footer">
									<a href="#">
										See all notifications
										<i class="ace-icon fa fa-arrow-right"></i>
									</a>
								</li>
							</ul>
						</li>

						<li class="green dropdown-modal">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="ace-icon fa fa-envelope icon-animated-vertical"></i>
								<span class="badge badge-success">5</span>
							</a>

							<ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<i class="ace-icon fa fa-envelope-o"></i>
									5 Messages
								</li>

								<li class="dropdown-content">
									<ul class="dropdown-menu dropdown-navbar">
										<li>
											<a href="#" class="clearfix">
												<img src="<?php echo base_url(); ?>images/theme/avatar.png" class="msg-photo" alt="Alex's Avatar" />
												<span class="msg-body">
													<span class="msg-title">
														<span class="blue">Alex:</span>
														Ciao sociis natoque penatibus et auctor ...
													</span>

													<span class="msg-time">
														<i class="ace-icon fa fa-clock-o"></i>
														<span>a moment ago</span>
													</span>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="clearfix">
												<img src="<?php echo base_url(); ?>images/theme/avatar3.png" class="msg-photo" alt="Susan's Avatar" />
												<span class="msg-body">
													<span class="msg-title">
														<span class="blue">Susan:</span>
														Vestibulum id ligula porta felis euismod ...
													</span>

													<span class="msg-time">
														<i class="ace-icon fa fa-clock-o"></i>
														<span>20 minutes ago</span>
													</span>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="clearfix">
												<img src="<?php echo base_url(); ?>images/theme/avatar4.png" class="msg-photo" alt="Bob's Avatar" />
												<span class="msg-body">
													<span class="msg-title">
														<span class="blue">Bob:</span>
														Nullam quis risus eget urna mollis ornare ...
													</span>

													<span class="msg-time">
														<i class="ace-icon fa fa-clock-o"></i>
														<span>3:15 pm</span>
													</span>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="clearfix">
												<img src="<?php echo base_url(); ?>images/theme/avatar2.png" class="msg-photo" alt="Kate's Avatar" />
												<span class="msg-body">
													<span class="msg-title">
														<span class="blue">Kate:</span>
														Ciao sociis natoque eget urna mollis ornare ...
													</span>

													<span class="msg-time">
														<i class="ace-icon fa fa-clock-o"></i>
														<span>1:33 pm</span>
													</span>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="clearfix">
												<img src="<?php echo base_url(); ?>images/theme/avatar5.png" class="msg-photo" alt="Fred's Avatar" />
												<span class="msg-body">
													<span class="msg-title">
														<span class="blue">Fred:</span>
														Vestibulum id penatibus et auctor  ...
													</span>

													<span class="msg-time">
														<i class="ace-icon fa fa-clock-o"></i>
														<span>10:09 am</span>
													</span>
												</span>
											</a>
										</li>
									</ul>
								</li>

								<li class="dropdown-footer">
									<a href="inbox.html">
										See all messages
										<i class="ace-icon fa fa-arrow-right"></i>
									</a>
								</li>
							</ul>
						</li>

						<li class="light-blue dropdown-modal">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<img class="nav-user-photo" src="<?php echo base_url(); ?>images/theme/user.jpg" alt="Jason's Photo" />
								<span class="user-info">
									<small><?php echo $_SESSION['userFirstName']; ?></small>
									<small><?php echo $_SESSION['userLastName']; ?></small>
								</span>

								<i class="ace-icon fa fa-caret-down"></i>
							</a>

							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li>
									<a href="#">
										<i class="ace-icon fa fa-cog"></i>
										Settings
									</a>
								</li>

								<li>
									<a href="profile.html">
										<i class="ace-icon fa fa-user"></i>
										Profile
									</a>
								</li>

								<li class="divider"></li>

								<li>
									<a href="<?php echo base_url(); ?>login/logout">
										<i class="ace-icon fa fa-power-off"></i>
										Logout
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div><!-- /.navbar-container -->
		</div>

		<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>

			<div id="sidebar" class="sidebar                  responsive                    ace-save-state">
				<script type="text/javascript">
					try{ace.settings.loadState('sidebar')}catch(e){}
				</script>

				<div class="sidebar-shortcuts" id="sidebar-shortcuts">
					<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
						<button class="btn btn-success">
							<i class="ace-icon fa fa-signal"></i>
						</button>

						<button class="btn btn-info">
							<i class="ace-icon fa fa-pencil"></i>
						</button>

						<button class="btn btn-warning">
							<i class="ace-icon fa fa-users"></i>
						</button>

						<button class="btn btn-danger">
							<i class="ace-icon fa fa-cogs"></i>
						</button>
					</div>

					<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
						<span class="btn btn-success"></span>

						<span class="btn btn-info"></span>

						<span class="btn btn-warning"></span>

						<span class="btn btn-danger"></span>
					</div>
				</div><!-- /.sidebar-shortcuts -->

				<ul class="nav nav-list">
					<li class="active">
						<a href="<?php echo base_url(); ?>">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> Dashboard </span>
						</a>

						<b class="arrow"></b>
					</li>

					<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-desktop"></i>
							<span class="menu-text">
								Vehicle
							</span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="">
								<a href="<?php echo base_url(); ?>vehicle/category">
									<i class="menu-icon fa fa-caret-right"></i>

									Add Category
								</a>

								<b class="arrow"></b>
							</li>
							<li class="">
								<a href="<?php echo base_url(); ?>vehicle/newVehicle">
									<i class="menu-icon fa fa-caret-right"></i>

									Add Vehicle
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="<?php echo base_url(); ?>vehicle/vehicleList">
									<i class="menu-icon fa fa-caret-right"></i>

									Vehicle List
								</a>

								<b class="arrow"></b>
							</li>
						</ul>
					</li>


					<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-desktop"></i>
							<span class="menu-text">
								Driver
							</span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							
							<li class="">
								<a href="<?php echo base_url(); ?>driver/driverMaster">
									<i class="menu-icon fa fa-caret-right"></i>

									Add Driver
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="<?php echo base_url(); ?>driver/driverList">
									<i class="menu-icon fa fa-caret-right"></i>

									Driver List
								</a>

								<b class="arrow"></b>
							</li>
							<li class="">
								<a href="<?php echo base_url(); ?>driver/driverAttend">
									<i class="menu-icon fa fa-caret-right"></i>

									Driver Attendance
								</a>

								<b class="arrow"></b>
							</li>
							<li class="">
								<a href="<?php echo base_url(); ?>driver/driverAttendReport">
									<i class="menu-icon fa fa-caret-right"></i>

									Driver Attendance Report
								</a>

								<b class="arrow"></b>
							</li>
						</ul>
					</li>


					<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-desktop"></i>
							<span class="menu-text">
								User
							</span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							
							<li class="">
								<a href="<?php echo base_url(); ?>user">
									<i class="menu-icon fa fa-caret-right"></i>

									Add User
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="<?php echo base_url(); ?>User/viewuser">
									<i class="menu-icon fa fa-caret-right"></i>

									User list
								</a>

								<b class="arrow"></b>
							</li>
						</ul>
					</li>



					<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-desktop"></i>
							<span class="menu-text">
								Vendor
							</span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							
							<li class="">
								<a href="<?php echo base_url(); ?>vendor/vendorMaster">
									<i class="menu-icon fa fa-caret-right"></i>

									Add Vendor
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="<?php echo base_url(); ?>vendor/vendorList">
									<i class="menu-icon fa fa-caret-right"></i>

									Vendor list
								</a>

								<b class="arrow"></b>
							</li>
						</ul>
					</li>




					<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-desktop"></i>
							<span class="menu-text">
								Booking
							</span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							
							<li class="">
								<a href="<?php echo base_url(); ?>booking/bookingMaster">
									<i class="menu-icon fa fa-caret-right"></i>

									Add Booking
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="<?php echo base_url(); ?>booking/bookingList">
									<i class="menu-icon fa fa-caret-right"></i>

									Booking list
								</a>

								<b class="arrow"></b>
							</li>
						</ul>
					</li>

					<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-desktop"></i>
							<span class="menu-text">
								Customer
							</span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							
							<li class="">
								<a href="<?php echo base_url(); ?>customer/customerMaster">
									<i class="menu-icon fa fa-caret-right"></i>

									Add Customer
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="<?php echo base_url(); ?>customer/customerList">
									<i class="menu-icon fa fa-caret-right"></i>

									Customer list
								</a>

								<b class="arrow"></b>
							</li>
						</ul>
					</li>

					<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-desktop"></i>
							<span class="menu-text">
								Company
							</span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							
							<li class="">
								<a href="<?php echo base_url(); ?>company/holiday">
									<i class="menu-icon fa fa-caret-right"></i>

									Add Holiday
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="<?php echo base_url(); ?>company/holidayList">
									<i class="menu-icon fa fa-caret-right"></i>

									Holiday List
								</a>

								<b class="arrow"></b>
							</li>
						</ul>
					</li>


					<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-desktop"></i>
							<span class="menu-text">
								Payment
							</span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							
							<li class="">
								<a href="<?php echo base_url(); ?>payment/expenseMaster">
									<i class="menu-icon fa fa-caret-right"></i>

									Make Payment
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="<?php echo base_url(); ?>payment/journalEntry">
									<i class="menu-icon fa fa-caret-right"></i>

									Journal Voucher
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="<?php echo base_url(); ?>payment/advancesalaryMaster">
									<i class="menu-icon fa fa-caret-right"></i>

									Advance Salary
								</a>

								<b class="arrow"></b>
							</li>

							 
						</ul>
					</li>


					<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-desktop"></i>
							<span class="menu-text">
								Account Master
							</span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							
							<li class="">
								<a href="<?php echo base_url(); ?>account/addAccount">
									<i class="menu-icon fa fa-caret-right"></i>

									Add A/C (Cash/Bank)
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="<?php echo base_url(); ?>account/accountList">
									<i class="menu-icon fa fa-caret-right"></i>

									A/C List (Cash/Bank)
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="<?php echo base_url(); ?>account/addAmount">
									<i class="menu-icon fa fa-caret-right"></i>

									Add Amt (Cash/Bank)
								</a>

								<b class="arrow"></b>
							</li>

  
						</ul>
					</li>



					<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-desktop"></i>
							<span class="menu-text">
								Ledger Master
							</span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							 
							 <li class="">
								<a href="<?php echo base_url(); ?>account/addGroup">
									<i class="menu-icon fa fa-caret-right"></i>

									Add Entity
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="<?php echo base_url(); ?>account/groupList">
									<i class="menu-icon fa fa-caret-right"></i>

									Group Tree
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="<?php echo base_url(); ?>account/ledgerList">
									<i class="menu-icon fa fa-caret-right"></i>

									Ledger Tree
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="<?php echo base_url(); ?>account/profit_and_loss">
									<i class="menu-icon fa fa-caret-right"></i>

									P&L Statement
								</a>

								<b class="arrow"></b>
							</li>

							 
						</ul>
					</li>

<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-desktop"></i>
							<span class="menu-text">
								Package
							</span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							
							<li class="">
								<a href="<?php echo base_url(); ?>package/packageMaster">
									<i class="menu-icon fa fa-caret-right"></i>

									Add Package
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="<?php echo base_url(); ?>package/packageList">
									<i class="menu-icon fa fa-caret-right"></i>

									Package list
								</a>

								<b class="arrow"></b>
							</li>
						</ul>
					</li>




				</ul><!-- /.nav-list -->

				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>
			</div>

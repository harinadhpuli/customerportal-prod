<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="app-main">
<div class="app-sidebar sidebar-shadow" id="LongThumb">
                    <div class="app-header__logo">
                        <div class="logo-src"></div>
                        <div class="header__pane ml-auto">
                            <div>
                                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                                    <span class="hamburger-box">
                                        <span class="hamburger-inner"></span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="app-header__mobile-menu">
                        <div>
                            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="app-header__menu">
                        <span>
                            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                                <span class="btn-icon-wrapper">
                                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                                </span>
                            </button>
                        </span>
                    </div>    
					<div class="scrollbar-sidebar" >
                        <div class="app-sidebar__inner">
                            <ul class="vertical-nav-menu">
                                <li class="app-sidebar__heading">Dashboard</li>
                                <li>
                                    <a href="<?php echo CONFIG_SERVER_ADMIN_ROOT ?>dashboard" class="mm-active">
                                        <i class="metismenu-icon fa fa-tachometer"></i>
                                        Dashboard
                                    </a>
                                </li>
                                <li class="app-sidebar__heading">Masters</li>
                                <li>
                                    <a href="<?php echo CONFIG_SERVER_ADMIN_ROOT ?>userRegistration">
                                        <i class="metismenu-icon fa fa-user-circle-o"></i>
                                       User Registration
                                        <i class="metismenu-state-icon"></i>
                                    </a>

                                </li>
								 <li>
                                    <a href="<?php echo CONFIG_SERVER_ADMIN_ROOT ?>amenities">
                                        <i class="metismenu-icon fa fa-car"></i>
                                        Amenities
                                        <i class="metismenu-state-icon"></i>
                                    </a>

                                </li>
                                <?php /* ?>
                                <li>
                                    <a href="<?php echo CONFIG_SERVER_ADMIN_ROOT ?>facing">
                                        <i class="metismenu-icon fa fa-arrows"></i>
                                        Facings
                                        <i class="metismenu-state-icon"></i>
                                    </a>

                                </li>

                                <li>
                                    <a href="<?php echo CONFIG_SERVER_ADMIN_ROOT ?>bhk">
                                        <i class="metismenu-icon fa fa-user-circle-o"></i>
                                        BHK's
                                        <i class="metismenu-state-icon"></i>
                                    </a>

                                </li>

                                <li>
                                    <a href="<?php echo CONFIG_SERVER_ADMIN_ROOT ?>city">
                                        <i class="metismenu-icon fa fa fa-university"></i>
                                        city
                                        <i class="metismenu-state-icon"></i>
                                    </a>

                                </li>

                                <li>
                                    <a href="<?php echo CONFIG_SERVER_ADMIN_ROOT ?>region">
                                        <i class="metismenu-icon fa fa fa-university"></i>
                                        Regions
                                        <i class="metismenu-state-icon"></i>
                                    </a>

                                </li>

    <?php */ ?>
                                <li class="app-sidebar__heading">Projects</li>
                                <li>
                                    <a href="<?php echo CONFIG_SERVER_ADMIN_ROOT ?>projects" class="mm-active">
                                        <i class="metismenu-icon fa fa-tachometer"></i>
                                        Projects
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo CONFIG_SERVER_ADMIN_ROOT ?>cms" class="">
                                        <i class="metismenu-icon fa fa-file-text"></i>
                                        CMS
                                    </a>
                                </li>

                                <li class="app-sidebar__heading">Orders</li>
                                <li>
                                    <a href="<?php echo CONFIG_SERVER_ADMIN_ROOT ?>orders" class="mm-active">
                                        <i class="metismenu-icon fa fa-first-order"></i>
                                        Orders
                                    </a>
                                </li>
                                <li class="app-sidebar__heading">Site Visit Requests</li>
                                <li>
                                    <a href="<?php echo CONFIG_SERVER_ADMIN_ROOT ?>siteVisits" class="mm-active">
                                        <i class="metismenu-icon fa fa-first-order"></i>
                                        Requested Site Visits
                                    </a>
                                </li>
                               
                              

                                <li class="app-sidebar__heading">My Account</li>
                                <li>
                                    <a href="<?php echo CONFIG_SERVER_ADMIN_ROOT ?>myProfile">
                                        <i class="metismenu-icon fa fa-address-card"></i>
                                       My Profile
                                        <i class="metismenu-state-icon"></i>
                                    </a>

                                </li>
								 <li>
                                    <a href="<?php echo CONFIG_SERVER_ADMIN_ROOT ?>myProfile/changePassword">
                                        <i class="metismenu-icon fa fa-key"></i>
                                       Change Password
                                        <i class="metismenu-state-icon"></i>
                                    </a>

                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>login/doLogout">
                                        <i class="metismenu-icon fa fa-sign-out "></i>
                                       Logout
                                        <i class="metismenu-state-icon"></i>
                                    </a>

                                </li>

                               

                                 
                               
                            </ul>
                        </div>
                    </div>
                </div>   
<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php 
	error_reporting(0);
	//header of template
	$this->load->view('layout/header');	
?>		
	

	
	<!-- Content Wrapper. Contains page content -->
	
	<div class="app-main__outer">  
	<div class="app-main__inner bg-white ">
<?php
$this->load->view('layout/breadcrumbs'); 
	// display success/error message
?>
<!-- ajax messages -->

<?php
	echo $this->messages->getMessageFront();
	// load content area
	echo "<div class='' style='min-height:350px;'>";
	echo $content;
	echo "</div></div>";

?>

<?php
	//footer of template
	$this->load->view('layout/footer')
?>

<?php



class ControllerExtensionTmdstyle extends Controller {







	public function index() {



	



		header("Content-type: text/css", true);



		



		// My Cart Color



		$data['tmdqc_content_background'] = ($this->config->get('tmdqc_content_background'))  ? $this->config->get('tmdqc_content_background')  :'';



		



		$data['tmdqc_content_heading_color'] = ($this->config->get('tmdqc_content_heading_color'))  ? $this->config->get('tmdqc_content_heading_color')  :'';



		$data['tmdqc_cart_heading_color'] = ($this->config->get('tmdqc_cart_heading_color'))  ? $this->config->get('tmdqc_cart_heading_color')  :'';



		$data['tmdqc_cart_heading_background'] = ($this->config->get('tmdqc_cart_heading_background'))  ? $this->config->get('tmdqc_cart_heading_background')  :'';



		$data['tmdqc_cart_table_color'] = ($this->config->get('tmdqc_cart_table_color'))  ? $this->config->get('tmdqc_cart_table_color')  :'';



		$data['tmdqc_cart_table_background'] = ($this->config->get('tmdqc_cart_table_background'))  ? $this->config->get('tmdqc_cart_table_background')  :'';



		$data['tmdqc_cart_table_border'] = ($this->config->get('tmdqc_cart_table_border'))  ? $this->config->get('tmdqc_cart_table_border')  :'';



		// Buttons Color



		$data['tmdqc_primary_button_color'] = ($this->config->get('tmdqc_primary_button_color'))  ? $this->config->get('tmdqc_primary_button_color')  :'';



		$data['tmdqc_primary_button_background'] = ($this->config->get('tmdqc_primary_button_background'))  ? $this->config->get('tmdqc_primary_button_background')  :'';



		$data['tmdqc_primary_button_background_hover'] = ($this->config->get('tmdqc_primary_button_background_hover'))  ? $this->config->get('tmdqc_primary_button_background_hover')  :'';



		$data['tmdqc_primary_button_border'] = ($this->config->get('tmdqc_primary_button_border'))  ? $this->config->get('tmdqc_primary_button_border')  :'';



		



		$data['tmdqc_danger_button_color'] = ($this->config->get('tmdqc_danger_button_color'))  ? $this->config->get('tmdqc_danger_button_color')  :'';



		$data['tmdqc_danger_button_background'] = ($this->config->get('tmdqc_danger_button_background'))  ? $this->config->get('tmdqc_danger_button_background')  :'';



		$data['tmdqc_danger_button_background_hover'] = ($this->config->get('tmdqc_danger_button_background_hover'))  ? $this->config->get('tmdqc_danger_button_background_hover')  :'';



		$data['tmdqc_danger_button_border'] = ($this->config->get('tmdqc_danger_button_border'))  ? $this->config->get('tmdqc_danger_button_border')  :'';



		$data['tmdqc_logintextcolor'] = ($this->config->get('tmdqc_logintextcolor'))  ? $this->config->get('tmdqc_logintextcolor')  :'';



		// Input Color



		$data['tmdqc_input_background'] = ($this->config->get('tmdqc_input_background'))  ? $this->config->get('tmdqc_input_background')  :'';



		$data['tmdqc_input_color'] = ($this->config->get('tmdqc_input_color'))  ? $this->config->get('tmdqc_input_color')  :'';



		$data['tmdqc_input_border'] = ($this->config->get('tmdqc_input_border'))  ? $this->config->get('tmdqc_input_border')  :'';



		$data['tmdqc_label_color'] = ($this->config->get('tmdqc_label_color'))  ? $this->config->get('tmdqc_label_color')  :'';



		



		//Sub content



		$data['tmdqc_sub_content_background'] = ($this->config->get('tmdqc_sub_content_background'))  ? $this->config->get('tmdqc_sub_content_background')  :'';



		$data['tmdqc_sub_content_border'] = ($this->config->get('tmdqc_sub_content_border'))  ? $this->config->get('tmdqc_sub_content_border')  :'';



		$data['tmdqc_block_heading_color'] = ($this->config->get('tmdqc_block_heading_color'))  ? $this->config->get('tmdqc_block_heading_color')  :'';



		$data['tmdqc_block_heading_background'] = ($this->config->get('tmdqc_block_heading_background'))  ? $this->config->get('tmdqc_block_heading_background')  :'';



		$data['tmdqc_block_heading_border'] = ($this->config->get('tmdqc_block_heading_border'))  ? $this->config->get('tmdqc_block_heading_border')  :'';	



		



		echo "#quick-checkout #warning{padding:10px;}



		.loader{position: fixed;top: 30%;z-index: 999;width:100%;margin:0 auto;text-align: center;}



		";		



		echo "#quick-checkout #content > h1{color:".$data['tmdqc_content_heading_color']."; }";		



		echo "#quick-checkout #content{background:".$data['tmdqc_content_background'].";padding:15px; }";



		echo "#quick-checkout #tmd_cart table tr th{color:".$data['tmdqc_cart_heading_color']."; background:".$data['tmdqc_cart_heading_background'].";text-transform: uppercase; }";



		echo "#quick-checkout #tmd_cart table tr{color:".$data['tmdqc_cart_table_color']."; background:".$data['tmdqc_cart_table_background']."; }";



		



		echo "#quick-checkout #tmd_cart table tr td, #quick-checkout #tmd_cart table tr th, #quick-checkout #tmd_cart .table-bordered{border-color:".$data['tmdqc_cart_table_border']."; font-size:13px; }";



		



		echo "#quick-checkout .panel{border:none;border-radius:0 !important;border-top: solid 1px ".$data['tmdqc_block_heading_border'].";border-bottom: solid 1px ".$data['tmdqc_block_heading_border'].";}";



		



		echo "#quick-checkout .panel-heading{border:none;font-size:13px;font-weight:bold;text-align:center;text-transform:uppercase;border-radius:0 !important; border-top-left-radius:0 !important; border-top-right-radius:0 !important;padding:7px 15px; color:".$data['tmdqc_block_heading_color']."; background:".$data['tmdqc_block_heading_background']."}";



		



		echo "#quick-checkout .buttons .btn-primary, #quick-checkout .btn-primary{background:".$data['tmdqc_primary_button_background']."!important;border-color:".$data['tmdqc_primary_button_border'].";color:".$data['tmdqc_primary_button_color'].";}";



		



		echo "#quick-checkout .buttons .btn-primary:hover, #quick-checkout .btn-primary:hover{background:".$data['tmdqc_primary_button_background_hover']."!important;}";



		



		echo "#quick-checkout .btn-danger{color:".$data['tmdqc_danger_button_color']."; background:".$data['tmdqc_danger_button_background']."!important; border-color:".$data['tmdqc_danger_button_border']."!important;}";



		



		echo "#quick-checkout .btn-danger:hover{background:".$data['tmdqc_danger_button_background_hover'].";}";



		



		echo "#warning .form-control, #quick-checkout .modal-content .form-control{color:".$data['tmdqc_input_color'].";border:1px solid ".$data['tmdqc_input_border']."}";



		



		echo "#warning label{color:".$data['tmdqc_label_color']."; font-size:13px;}";



		



		echo "#accountcontent{background:".$data['tmdqc_sub_content_background']."; border:1px solid ".$data['tmdqc_sub_content_border']."; }";



		



		echo "#tmd_payment_method{padding:0px 0px 10px;margin-top:15px; background:".$data['tmdqc_sub_content_background']."; border:1px solid ".$data['tmdqc_sub_content_border']."; min-height:120px;}";



		



		echo "#tmd_shipping_method{padding:0px 0px 10px; background:".$data['tmdqc_sub_content_background']."; border:1px solid ".$data['tmdqc_sub_content_border']."; min-height:120px;}";



	



		echo "#tmd_delivery_address{padding:0px 0px 10px;margin-bottom:15px; background:".$data['tmdqc_sub_content_background']."; border:1px solid ".$data['tmdqc_sub_content_border']."; }";



		



		echo ".checkator_source:checked+.checkator:after {background-color:".$data['tmdqc_block_heading_background'].";}";



		



		echo ".checkator_source:focus+.checkator {border: 2px solid ".$data['tmdqc_block_heading_background'].";}";



		



		echo "#quick-checkout .form-horizontal .checkbox,#quick-checkout .form-horizontal .radio{min-height:23px;}";



		



		echo "#quick-checkout .btn-primary:hover, #quick-checkout .btn-primary:active, #quick-checkout .btn-primary.active, #quick-checkout .btn-primary.disabled, #quick-checkout .btn-primary[disabled]{background-position:0 -32px}";



		



		echo "#typeaccount a{cursor:pointer;color:".$data['tmdqc_logintextcolor'].";font-size:13px;}";

		echo "#typeaccount .loginfa{color:".$data['tmdqc_block_heading_background'].";}";



		echo ".padd1{margin-bottom:10px;padding-left:0px;}";



		echo "#tmd_login .panel{margin-bottom:0px;}";



		echo "#tmd_login #wrapper{ border-bottom: 1px solid #ddd;border-left: 1px solid #ddd;



			border-right: 1px solid #ddd;margin-bottom: 15px;padding-top: 10px;}";



		echo "#account .form-group{margin-bottom:10px; margin-top:10px;}";



		



		echo "#wrapper{background:".$data['tmdqc_sub_content_background']."; border:1px solid ".$data['tmdqc_sub_content_border']."; }";



		



		echo "#typeaccount{border:1px solid ".$data['tmdqc_sub_content_border'].";margin-bottom:13px;padding-bottom:5px}";



		



		



		



		echo "#tmd_cart .form-control{height:35.5px;}



		#accountcontent .buttons{padding:0px 15px;}



		.padd{padding:0 10px;}



		.padd{padding:0 10px;}



		.modal-dialog{width:33%;}



		#quick-checkout legend{margin-bottom:0px;}



		.padd1 label,.checkbox.padd label{padding-left:25px;}



		#shipping-new .form-group{margin-left:0px!important;margin-right:0px!important}



		#payment-new .form-group{margin-right:0px!important;}



		.modal-dialog .btn{font-size:16px;}



		.modal-dialog label{font-size:13px}



		.modal-dialog .form-control{height:36px;}



		.modal-title {font-size:16px}



		#tmd_login #typeaccount{border:none;margin-bottom:0px;padding-bottom:0px;}



		#tmdlogin .modal-body .close{right:2px}

		

		@media (max-width: 1199px) and (min-width: 992px){

		#content .col-lg-2:nth-child(6n+1), #content .col-lg-3:nth-child(4n+1), #content .col-lg-4:nth-child(3n+1), #content .col-lg-6:nth-child(2n+1){}

		}

		@media (min-width: 1200px){

		#content .col-lg-2:nth-child(6n+1), #content .col-lg-3:nth-child(4n+1), #content .col-lg-4:nth-child(3n+1), #content .col-lg-6:nth-child(2n+1){clear:none!important}

		}

		@media(max-width:767px){#quick-checkout .pull-right{float:none!important



		display:block;margin-top:10px;}}



		";



	}



}
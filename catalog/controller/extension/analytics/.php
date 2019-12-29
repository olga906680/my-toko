<?php
class ControllerExtensionAnalytics extends Controller {
	public function index($setting) {
		$this->load->language('extension/analytics/');
		
		$this->load->model('extension/analytics/');
				
		$data['heading_title'] = $this->language->get('heading_title');
		return $this->load->view('extension/analytics/', $data);
	}}
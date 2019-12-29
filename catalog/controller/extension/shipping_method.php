<?php
class ControllerExtensionShippingMethod extends Controller {
	public function index() {
		
		$this->load->language('extension/tmdcheckout');
		$text_delivery_method_title = $this->language->get('text_delivery_method_title');
		if($this->config->get('tmdqc_title')) {
				$tmdqc_title = $this->config->get('tmdqc_title');
				$text_delivery_method_title = (!empty($tmdqc_title['delivery_method_title'][$this->config->get('config_language_id')])) ?   $tmdqc_title['delivery_method_title'][$this->config->get('config_language_id')] : $this->language->get('text_delivery_method_title');
		}
		
		$data['text_delivery_method_title'] = $text_delivery_method_title;
		
		if(isset($this->request->post['zone_id']))
		{
			$this->session->data['shipping_address']['zone_id']=$this->request->post['zone_id'];
		}
		if(isset($this->request->post['country_id']))
		{
			$this->session->data['shipping_address']['country_id']=$this->request->post['country_id'];
			$this->session->data['shipping_address']['postcode']=$this->request->post['postcode'];
			$this->session->data['shipping_address']['firstname']=$this->request->post['firstname'];
			$this->session->data['shipping_address']['lastname']=$this->request->post['lastname'];
			$this->session->data['shipping_address']['address_1']=$this->request->post['address_1'];
			$this->session->data['shipping_address']['city'] = $this->request->post['city'];
			$this->load->model('localisation/country');

			$country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);

			if ($country_info) {
				$this->session->data['shipping_address']['country'] = $country_info['name'];
				$this->session->data['shipping_address']['iso_code_2'] = $country_info['iso_code_2'];
				$this->session->data['shipping_address']['iso_code_3'] = $country_info['iso_code_3'];
				$this->session->data['shipping_address']['address_format'] = $country_info['address_format'];
			} else {
				$this->session->data['shipping_address']['country'] = '';
				$this->session->data['shipping_address']['iso_code_2'] = '';
				$this->session->data['shipping_address']['iso_code_3'] = '';
				$this->session->data['shipping_address']['address_format'] = '';
			}
		}
		
		
		if (isset($this->session->data['shipping_address'])) {	
			// Shipping Methods
			$method_data = array();

			$this->load->model('setting/extension');
			$this->load->model('tool/image');

			$results = $this->model_setting_extension->getExtensions('shipping');

			foreach ($results as $result){
				
				if ($this->config->get('shipping_' . $result['code'] . '_status')) {
					$tmdshippingsetting = $this->config->get('tmdqc_'.$result['code']);
					
					if(!empty($tmdshippingsetting[$this->config->get('config_language_id')]['image'])){
						$image = $this->model_tool_image->resize($tmdshippingsetting[$this->config->get('config_language_id')]['image'],50,50);
					}else{
						$image = '';
					}
					
					
					$this->load->model('extension/shipping/' . $result['code']);

					if(isset($this->session->data['shipping_address'])){
						$address = $this->session->data['shipping_address'];
					}else{
						$address = array();
					}
					
					$quote = $this->{'model_extension_shipping_' . $result['code']}->getQuote($address);
					if(!empty($tmdshippingsetting[$this->config->get('config_language_id')]['label'])){
						$title = $tmdshippingsetting[$this->config->get('config_language_id')]['label'];
					}else{
						$title = $quote['title'];
					}
					if($quote){
						$method_data[$result['code']] = array(
							'title'      => $title,
							'image'      => $image,
							'quote'      => $quote['quote'],
							'sort_order' => $quote['sort_order'],
							'error'      => $quote['error']
						);
					}
				}
			}

			$sort_order = array();

			foreach ($method_data as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}

			array_multisort($sort_order, SORT_ASC, $method_data);
			if(isset($method_data)){
			$this->session->data['shipping_methods'] = $method_data;
			}
		}

		$data['text_shipping_method'] = $this->language->get('text_shipping_method');
		$data['text_comments'] = $this->language->get('text_comments');
		$data['text_loading'] = $this->language->get('text_loading');

		$data['button_continue'] = $this->language->get('button_continue');

		if (empty($this->session->data['shipping_methods'])) {
			$data['error_warning'] = sprintf($this->language->get('error_no_shipping'), $this->url->link('information/contact'));
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['shipping_methods'])) {
			$data['shipping_methods'] = $this->session->data['shipping_methods'];
		} else {
			$data['shipping_methods'] = array();
		}

		if (isset($this->session->data['shipping_method']['code'])) {
			$data['code'] = $this->session->data['shipping_method']['code'];
		} else {
			$data['code'] = '';
		}

		if (isset($this->session->data['comment'])) {
			$data['comment'] = $this->session->data['comment'];
		} else {
			$data['comment'] = '';
		}
		
		if($this->config->get('tmdqc_shipping_comment')){
			$data['tmdqc_shipping_comment'] = '';
		}else{
			$data['tmdqc_shipping_comment'] = 'hide';
		}
		
		if($this->config->get('tmdqc_shipping_label')){
			$data['tmdqc_shipping_label'] = true;
		}else{
			$data['tmdqc_shipping_label'] = false;
		}
		
		
		
		$this->response->setOutput($this->load->view('extension/shipping_method', $data));
	}

	public function save() {
		$this->load->language('extension/tmdcheckout');

		if (isset($this->session->data['shipping_address'])) {	
			// Shipping Methods
			$method_data = array();

			$this->load->model('setting/extension');
			$this->load->model('tool/image');

			$results = $this->model_setting_extension->getExtensions('shipping');

			foreach ($results as $result){
				
				if ($this->config->get('shipping_' . $result['code'] . '_status')) {
					$tmdshippingsetting = $this->config->get('tmdqc_'.$result['code']);
					
					if(!empty($tmdshippingsetting[$this->config->get('config_language_id')]['image'])){
						$image = $this->model_tool_image->resize($tmdshippingsetting[$this->config->get('config_language_id')]['image'],50,50);
					}else{
						$image = '';
					}
					
					
					$this->load->model('extension/shipping/' . $result['code']);

					if(isset($this->session->data['shipping_address'])){
						$address = $this->session->data['shipping_address'];
					}else{
						$address = array();
					}
					
					$quote = $this->{'model_extension_shipping_' . $result['code']}->getQuote($address);
					if(!empty($tmdshippingsetting[$this->config->get('config_language_id')]['label'])){
						$title = $tmdshippingsetting[$this->config->get('config_language_id')]['label'];
					}else{
						$title = $quote['title'];
					}
					if($quote){
						$method_data[$result['code']] = array(
							'title'      => $title,
							'image'      => $image,
							'quote'      => $quote['quote'],
							'sort_order' => $quote['sort_order'],
							'error'      => $quote['error']
						);
					}
				}
			}

			$sort_order = array();

			foreach ($method_data as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}

			array_multisort($sort_order, SORT_ASC, $method_data);
			if(isset($method_data)){
			$this->session->data['shipping_methods'] = $method_data;
			}
		}

		$json = array();

		// Validate if shipping is required. If not the customer should not have reached this page.
		if (!$this->cart->hasShipping()) {
			$json['redirect'] = $this->url->link('extension/tmdcheckout', '', true);
		}

		// Validate if shipping address has been set.
		if (!isset($this->session->data['shipping_address'])) {
			$json['redirect'] = $this->url->link('extension/tmdcheckout', '', true);
		}

		// Validate cart has products and has stock.
		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$json['redirect'] = $this->url->link('extension/tmdcheckout');
		}

		// Validate minimum quantity requirements.
		$products = $this->cart->getProducts();

		foreach ($products as $product) {
			$product_total = 0;

			foreach ($products as $product_2) {
				if ($product_2['product_id'] == $product['product_id']) {
					$product_total += $product_2['quantity'];
				}
			}

			if ($product['minimum'] > $product_total) {
				$json['redirect'] = $this->url->link('extension/tmdcheckout');

				break;
			}
		}

		if (!isset($this->request->post['shipping_method'])) {
			$json['error']['warning'] = $this->language->get('error_shipping');
		} else {
			$shipping = explode('.', $this->request->post['shipping_method']);

			if (!isset($shipping[0]) || !isset($shipping[1]) || !isset($this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]])) {
				$json['error']['warning'] = $this->language->get('error_shipping');
			}
		}

		if (!$json) {
			$this->session->data['shipping_method'] = $this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]];

			$this->session->data['comment'] = strip_tags($this->request->post['comment']);
	
			
		/* if(isset($this->session->data['order_id'])){
				$json['order_id'] = $this->session->data['order_id'];
		}else{
				$json['order_id'] = false;	
		} */
		
	}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
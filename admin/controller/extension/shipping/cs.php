<?php
class ControllerExtensionShippingCs extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/shipping/cs');

		$this->document->setTitle($this->language->get('page_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('shipping_cs', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=shipping', true));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_shipping'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=shipping', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('page_title'),
			'href' => $this->url->link('extension/shipping/cs', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/shipping/cs', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=shipping', true);

		$this->load->model('localisation/language');
		
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (isset($this->request->post['shipping_cs'])) {
			$data['multiple_shippings']['shipping_cs'] = $this->request->post['shipping_cs'];
		} else {
			$data['multiple_shippings'] = $this->model_setting_setting->getSetting('shipping_cs');
		}

		$this->load->model('localisation/tax_class');

		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		$this->load->model('localisation/geo_zone');

		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();


		//Error
		
		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = array();
		}
		
		if (isset($this->error['shipping_option'])) {
			$data['error_shipping_option'] = $this->error['shipping_option'];
		} else {
			$data['error_shipping_option'] = array();
		}
		
		if (isset($this->request->post['shipping_cs_group_shipping'])) {
			$data['shipping_cs_group_shipping'] = $this->request->post['shipping_cs_group_shipping'];
		} else {
			$data['shipping_cs_group_shipping'] = $this->config->get('shipping_cs_group_shipping');
		}

		if (isset($this->request->post['shipping_cs_status'])) {
			$data['shipping_cs_status'] = $this->request->post['shipping_cs_status'];
		} else {
			$data['shipping_cs_status'] = $this->config->get('shipping_cs_status');
		}

		if (isset($this->request->post['shipping_cs_sort_order'])) {
			$data['shipping_cs_sort_order'] = $this->request->post['shipping_cs_sort_order'];
		} else {
			$data['shipping_cs_sort_order'] = $this->config->get('shipping_cs_sort_order');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/shipping/cs', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/shipping/cs')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		foreach ($this->request->post['shipping_cs_group_shipping'] as $language_id => $value) {
			if ((utf8_strlen($value['shipping_name']) < 1) || (utf8_strlen($value['shipping_name']) > 64)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}
		}
		
		if (isset($this->request->post['shipping_cs'])) {
			foreach ($this->request->post['shipping_cs'] as $shipping_id => $shipping) { 
				foreach ($shipping['shipping_description'] as $language_id => $shipping_description) {
					if ((utf8_strlen($shipping_description['name']) < 1) || (utf8_strlen($shipping_description['name']) > 64)) {
						$this->error['shipping_option'][$shipping_id][$language_id] = $this->language->get('error_shipping_option');
					}
				}
			}
		}
		return !$this->error;
	}
}
<?php
class ControllerCommonToken extends Controller {
	    private $error = array(); 
    	public function index() {
        if(!isset($this->request->get['code']))
        { 
            $error['code'] =  $this->request->get['error'];
            return false;
        } 
    	$this->load->model('setting/setting');
    	$this->load->model('setting/token');
    	$client_data = $this->model_setting_setting->getSetting('insta_client'); 
    	$redirect_uri  = HTTP_SERVER."index.php?route=common/token";
    	$code = $this->request->get['code'];
    	$cid = trim($client_data['insta_client_id']);
    	$csecret = trim( $client_data['insta_client_secret']);
    	$client['insta_access_token']  = $this->getToken($code ,$cid, $csecret, $redirect_uri);  
        if(!empty( $client['insta_access_token'] ))
    	{
    	    $this->model_setting_token->editSetting('insta_access_token', $client );
             echo '<script>alert(\'successfully authenticated...\') </script>';
             echo '<script> setTimeout(function () { window.close();}, 1000);</script>';
    	}
		$this->document->setTitle($this->config->get('config_meta_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));
		$this->document->setKeywords($this->config->get('config_meta_keyword'));

		if (isset($this->request->get['route'])) {
			$this->document->addLink($this->config->get('config_url'), 'canonical');
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('common/home', $data));
	}
	
	protected function getToken( $code , $client_id, $secret, $redirect_uri)
	{  
	    $api_url =  'https://api.instagram.com/oauth/access_token'; 
	    $data = array('client_id' => $client_id,
	                  'client_secret' => $secret,
	                   'grant_type' => 'authorization_code',
	                   'redirect_uri' => $redirect_uri,
	                    'code' => $code
	                   );
            $params = '';
            foreach($data as $key=>$value){
                        $params .= $key.'='.$value.'&';
            }
            $params = trim($params, '&');
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $api_url); //Remote Location URL
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Return data instead printing directly in Browser
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 7); //Timeout after 7 seconds  
            //We add these 2 lines to create POST request
            curl_setopt($ch, CURLOPT_POST, count($data)); //number of parameters sent
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params); //parameters data
            $result = curl_exec($ch);
            curl_close($ch);
            $results = json_decode($result , true);  
            if(empty($results['access_token']))
            {
               echo "<div class='alert alert-danger'>".$results['error_message']."</div>";    
               return false;
            }
            $access_token = $results['access_token']; 
            return $access_token;
        
	}
 }


?>
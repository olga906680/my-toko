<?php
class ControllerExtensionModuleEhubInstafeed extends Controller {
  public function index($setting) {  
    static $module = 0;
    $this->load->model('setting/token');
    $this->document->addStyle('catalog/view/theme/default/stylesheet/instafeed_style.css'); 
    $this->document->addScript('catalog/view/javascript/masonry.js');
    $this->document->addScript('catalog/view/javascript/imagesloaded.pkgd.min.js');
    $data['route'] = isset($this->request->get['route']) ? $this->request->get['route'] : ''; 
    if( $data['route'] !== 'product/product'){
    $this->document->addScript('catalog/view/javascript/magnific-popup.js');
    $this->document->addStyle('catalog/view/theme/default/stylesheet/magnific_popup.css');
    }
    $token = $this->model_setting_token->getSetting('insta_access_token');
    $client_token = $token['insta_access_token']; 
    $data['module_name']  = $setting['name'];
    $data['insta_posts_data']= $this->getInstaPosts('https://api.instagram.com/v1/users/self/media/recent/?access_token='.$client_token);  

    $data['module'] = $module++; 
    return $this->load->view('extension/module/ehub_instafeed', $data);
  }

   public function getInstaPosts( $url )
    {
        $instagram_data['insta_results'] = array();
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url ); // API URL to connect
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 ); // return the result, do not print
        curl_setopt( $ch, CURLOPT_TIMEOUT, 20 ); 
        $results = curl_exec($ch);
        curl_close($ch);
        $results_obj = json_decode( $results );  
        if(isset( $results_obj->meta->error_message ))
        {
          $instagram_data['token_error'] =  $results_obj->meta->error_message ;
          return $instagram_data;
        }
        foreach ($results_obj->data as $results_val)
          {
           $instagram_data['insta_results'][] = array(
          'image_url' => $results_val->images->low_resolution->url,
          'standard_img_url' => $results_val->images->standard_resolution->url,
          'likes'  => $results_val->likes->count,
          'comments' => $results_val->comments->count, 
           'links' => $results_val->link
           );
          }
        return $instagram_data;
     }
    

}
?>

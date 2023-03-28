<?php
	class sparkPostApi{
		
		public $curl       = '';
		public $settings   = array();
		public $msg       = array(
			'options'    => array(
				'open_tracking' => true,
				'click_tracking' => false
			),
			'content'    => array(),
			'recipients' => array(),
		    'attachments'=>array(),
		);
		
		public $recipients = array();
		
		public function sparkPostApi($url,$key){
			
			$this->settings['api-key'] = $key;
			$this->settings['api-url'] = $url;			
		}
		
		public function from($from){			
			
			$this->msg['content']['from'] = $from;		
			
		}
		
		public function attachments($attach){
		    
		    $this->msg['content']['attachments'] = $attach;
		    
		}
		
		public function subject($subject){
			
			$this->msg['content']['subject'] = $subject;
			
		}

		public function template($template_ID,$data=array()){
			
			$this->msg['content']['template_id'] = $template_ID;
			
			if (count($data)>1):
				
				$this->msg['substitution_data'] = $data;
				
			endif;
			
			
			
			
		}

		public function html($html){
			
			$this->msg['content']['html'] = $html;
			
		}
		public function setReplyTo($reply){
			
			$this->msg['content']['reply_to'] = $reply;
			
		}
		public function setTo($recipients){
			
			foreach($recipients as $recipient){
				
				if (!isset($this->recipients[$recipient])):
					$this->recipients[$recipient] = $recipient;
				endif;
			
			}
			
		}
		
		public function setCc($cc){
			
			foreach($cc as $recipient){
				
				if (!isset($this->recipients[$recipient])):
					$this->recipients[$recipient] = $recipient;
				endif;
			
			}
				
		}
		public function setBcc($bcc){
			
			
			foreach($bcc as $recipient){
				
				if (!isset($this->recipients[$recipient])):
					$this->recipients[$recipient] = $recipient;
				endif;
			
			}
				
		}

		public function send(){
			
			foreach($this->recipients as $index => $email){
				
				array_push($this->msg['recipients'],array('address' => $email));
					
			}
			
			
			
			$this->curl = curl_init();
			
			curl_setopt($this->curl,CURLOPT_URL,$this->settings['api-url']);
			curl_setopt($this->curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Authorization: '.$this->settings['api-key']));
			curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, "POST");  
			curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($this->curl, CURLOPT_POSTFIELDS,json_encode($this->msg));
			curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, 1); 			
			
			$result = json_decode(curl_exec($this->curl));
			print_r($result);
			if (!isset($result)):
				
				//throw new Exception('ERROR: CURL WAS NULL');
				
			
			elseif (isset($result->errors)):
				foreach($result->errors as $error){
					
					//throw new Exception($error->code.':'.$error->message.' | '.$error->description);
						
				}
			
			else:
			return true;
			endif;
			
			
				
		}
		
		public function close(){
			curl_close($this->curl);
		}
			
	}

?>
<?php
/**
 * @file logger.php
 * @date 2018-01-10
 * @author Go Namhyeon <gnh1201@gmail.com>
 * @brief Logger for VSPF
 */
class Logger {
	public function sendMessage($message, $component = "web", $program = "unknown", $method="syslog") {
		switch($method) {
			case "syslog":
				$this->sendMessageBySyslog($message, $component, $program);
				break;
			case "http":
				$this->sendMessageByHttp($message, $component, $program);
				break;
			default:
				$this->sendMessageBySyslog($message, $component, $program);
		}
	}

	// send to loggy via HTTP (loggy.com)
	protected function sendMessageByHttp($message, $component = "web", $program = "unknown") {
		$data = $this->getEventData();

		foreach(explode("\n", $message) as $line) {
			$dataByLine = $data;
			$dataByLine["message"] = $line;
			$dataMessage = "";
			foreach($dataByLine as $k=>$v) {
				$dataMessage .= "{$k}={$v};";
			}
			$syslog_message = "<22>" . date('M d H:i:s ') . $program . ' ' . $component . ': ' . $dataMessage;

			$ch = curl_init();
			$logTicket = "aHR0cDovL2xvZ3MtMDEubG9nZ2x5LmNvbS9pbnB1dHMvMDE0YzVkZDYtNDI0YS00MzIzLWJlNjUtNDhiNDZmMTZkYjU1L3RhZy9odHRwLw==";
			curl_setopt($ch, CURLOPT_URL, base64_decode($logTicket));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
				"weblog" => $syslog_message,
				"detail" => $dataByLine
			)));
			curl_setopt($ch, CURLOPT_POST, 1);

			$headers = array();
			$headers[] = "Content-Type: application/x-www-form-urlencoded";
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			$result = curl_exec($ch);
			if (curl_errno($ch)) {
				echo 'Error:' . curl_error($ch);
			}
			curl_close($ch);
		}
	}

	// send to papertail via Syslog (papertail.com)
	protected function sendMessageBySyslog($message, $component = "web", $program = "unknown") {
		$logTicket = "bG9nczYucGFwZXJ0cmFpbGFwcC5jb206NDI5ODY=";
		$logInfo = base64_decode($logTicket);
		list($logHost, $logPort) = explode(':', $logInfo);

		$data = $this->getEventData();

		$sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
		foreach(explode("\n", $message) as $line) {
			$dataByLine = $data;
			$dataByLine["message"] = $line;
			$dataMessage = json_encode($dataByLine);

			$syslog_message = "<22>" . date('M d H:i:s ') . $program . ' ' . $component . ': ' . $dataMessage;
			if(!@socket_sendto($sock, $syslog_message, strlen($syslog_message), 0, $logHost, $logPort)) {
				$this->sendMessage($message, $component, $program, "http");
			}
		}
		socket_close($sock);
	}

	protected function getEventData() {
		$data = array(
			"time"       => date("M j G:i:s Y"),
			"server"     => $this->getServerAddr(),
			"hostname"   => $this->getHostname(),
			"client"     => $this->getClientAddr(),
			"agent"      => getenv('HTTP_USER_AGENT'),
			"referrer"   => getenv('HTTP_REFERER'),
			"query"      => getenv('QUERY_STRING'),
			"self"       => $_SERVER['PHP_SELF'],
			"method"     => $_SERVER['REQUEST_METHOD']
		);
		
		return $data;
	}
	
	protected function getClientAddr() {
		$addr = '';
		if (isset($_SERVER['HTTP_CLIENT_IP']))
			$addr = $_SERVER['HTTP_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$addr = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_X_FORWARDED']))
			$addr = $_SERVER['HTTP_X_FORWARDED'];
		else if(isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
			$addr = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
			$addr = $_SERVER['HTTP_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_FORWARDED']))
			$addr = $_SERVER['HTTP_FORWARDED'];
		else if(isset($_SERVER['REMOTE_ADDR']))
			$addr = $_SERVER['REMOTE_ADDR'];
		else
			$addr = 'UNKNOWN';

		return $addr;
	}

	protected function getServerAddr() {
		$addr = '';
		if(isset($_SERVER['SERVER_ADDR']) && isset($_SERVER['SERVER_PORT'])) {
			$addr = $_SERVER['SERVER_ADDR'] . ':' . $_SERVER['SERVER_PORT'];
		} else if(isset($_SERVER['SERVER_ADDR'])) {
			$addr = $_SERVER['SERVER_ADDR'];
		} else if(isset($_SERVER['LOCAL_ADDR'])) {
			$addr = $_SERVER['LOCAL_ADDR'];
		} else if(function_exists('gethostname') && function_exists('gethostbyname')) {
			$host = gethostname();
			$addr = gethostbyname($host);
		} else {
            $addr = 'UNKNOWN';
        }

		return $addr;
	}

    protected function getHostname() {
        $host = '';
        if(isset($_SERVER['HTTP_HOST'])) {
            $host = $_SERVER['HTTP_HOST'];
        } else if(isset($_SERVER['SERVER_NAME'])) {
            $host = $_SERVER['SERVER_NAME'];
        } else if(function_exists('gethostname')) {
            $host = gethostname();
        } else {
            $host = 'UNKNOWN';
        }
        
        return $host;
    }
    
    protected function isAvailable($func) {
		if (ini_get('safe_mode')) return false;
		$disabled = ini_get('disable_functions');
		if ($disabled) {
			$disabled = explode(',', $disabled);
			$disabled = array_map('trim', $disabled);
			return !in_array($func, $disabled);
		}
		return true;
	}
}

// create logger instance
$logger = new Logger();

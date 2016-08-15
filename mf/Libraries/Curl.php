<?php
namespace MF\Libraries;

final class Curl
{
	private $curl = null;
	private $response = null;
	private $options = array();
	private $defaultOpions
		= array(
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HEADER         => true,
			CURLOPT_VERBOSE        => false,
			CURLOPT_AUTOREFERER    => true,
			CURLOPT_CONNECTTIMEOUT => 1,
			CURLOPT_TIMEOUT        => 3,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_USERAGENT      => 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)',
		);

	public function __construct($options = array())
	{
		try {
			$this->curl = curl_init();
			if ($options) {
				foreach ($options as $k => $v) {
					$this->defaultOpions[$k] = $v;
				}
			}
			$this->setOptions($this->defaultOpions);
		} catch (Exception $e) {
			throw new Exception('curl is not installed');
		}
	}

	public function get($url, array $params = array())
	{
		$this->setOption(CURLOPT_HTTPGET, true);

		return $this->exec($this->buildUrl($url, $params));
	}

	public function post($url, array $params = array())
	{
		$this->setOption(CURLOPT_POST, true);
		$this->setOption(CURLOPT_POSTFIELDS, http_build_query($params));

		return $this->exec($url);
	}

	public function json($url, array $params = array())
	{
		$this->setOption(CURLOPT_CUSTOMREQUEST, 'POST');
		$this->setOption(CURLOPT_POSTFIELDS, json_encode($params));
		$this->setHeaders(array(
			'Content-Type'   => 'application/json',
			'Content-Length' => strlen(json_encode($params)),
		));

		return $this->exec($url);
	}

	public function buildUrl($url, array $params = array())
	{
		$parse = parse_url($url);
		(true === isset($parse['query'])) ? parse_str($parse['query'],
			$parse['query']) : $parse['query'] = array();
		$parse['query'] = array_merge($parse['query'], $params);
		$parse['query'] = http_build_query($parse['query']);
		$url            = '';
		if (true === isset($parse['scheme'])
		    && false === empty($parse['scheme'])
		) {
			$url .= $parse['scheme'] . '://';
		}
		if (true === isset($parse['host']) && false === empty($parse['host'])) {
			$url .= $parse['host'];
		}
		if (true === isset($parse['port']) && false === empty($parse['port'])) {
			$url .= ':' . $parse['port'];
		}
		if (true === isset($parse['path']) && false === empty($parse['path'])) {
			$url .= $parse['path'];
		}
		if (true === isset($parse['query'])
		    && false === empty($parse['query'])
		) {
			$url .= '?' . $parse['query'];
		}
		if (true === isset($parse['fragment'])
		    && false === empty($parse['fragment'])
		) {
			$url .= '#' . $parse['fragment'];
		}

		return $url;
	}

	public function setOption($option, $value)
	{
		$this->options[$option] = $value;
		curl_setopt($this->curl, $option, $value);

		return $this;
	}

	public function setOptions(array $options = array())
	{
		if (false === empty($options)) {
			foreach ($options as $key => $value) {
				$this->setOption($key, $value);
			}
		}

		return $this;
	}

	public function setHeaders(array $headers = array())
	{
		if (true === $this->isAssoc($headers)) {
			$header = array();
			foreach ($headers as $k => $v) {
				$header[] = $k . ': ' . $v;
			}
			$headers = $header;
			unset($header);
		}
		$this->setOption(CURLOPT_HTTPHEADER, $headers);

		return $this;
	}

	public function getHeaders()
	{
		$headers = array();
		if (true === isset($this->options[CURLOPT_HEADER])
		    && true === $this->options[CURLOPT_HEADER]
		) {
			$headerSize = curl_getinfo($this->curl, CURLINFO_HEADER_SIZE);
			$headerText = substr($this->response, 0, $headerSize);
			foreach (explode("\r\n", $headerText) as $key => $line) {
				if (true === empty($line)) {
					continue;
				}
				if (0 === $key) {
					$headers['Http-Status'] = $line;
				} else {
					list($key, $value) = explode(': ', $line);
					$headers[$key] = $value;
				}
			}
		}

		return $headers;
	}

	public function getStatus()
	{
		return curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
	}

	private function initService()
	{
		$this->options = array();
		try {
			$this->curl = curl_init();
			$this->setOptions($this->defaultOpions);
		} catch (Exception $e) {
			throw new Exception('curl is not installed');
		}
	}

	private function exec($url)
	{
		$this->setOption(CURLOPT_URL, $url);
		$this->response = curl_exec($this->curl);

		if (0 === curl_errno($this->curl)) {
			if (curl_getinfo($this->curl, CURLINFO_HTTP_CODE) == 200) {
				if (true === isset($this->options[CURLOPT_HEADER])
				    && true === $this->options[CURLOPT_HEADER]
				) {
					$headerSize = curl_getinfo($this->curl,
						CURLINFO_HEADER_SIZE);
					curl_close($this->curl);

					return substr($this->response, $headerSize);
				} else {
					return $this->response;
				}
			} else {
				curl_close($this->curl);
				throw new Exception($this->response);

				return false;
			}
		} else {
			throw new Exception(curl_error($this->curl));
			curl_close($this->curl);

			return false;
		}
	}

	private function isAssoc(array $params = array())
	{
		return array_keys($params) !== range(0, count($params) - 1);
	}
}
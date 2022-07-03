<?php
declare(strict_types=1);

namespace App\Mapping;

use GuzzleHttp\Exception\GuzzleException;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Guzzle\ClientFactory;

/**
 * 发起http请求
 *
 * Class HttpRequest
 * @package App\Mapping
 */
class HttpRequest
{
	/**
	 * @Inject()
	 * @var ClientFactory
	 */
	protected $clientFactory;

	/**
	 * get请求
	 *
	 * @param string $url    请求地址
	 * @param array $options 请求参数
	 * @return array
	 */
	public function getRequest(string $url, array $options = []): array
	{
		$client     = $this->clientFactory->create($options);
		$returnInfo = [
			'code' => 0,
			'data' => [],
			'msg'  => 'success',
		];

		try {
			$string             = $client->get($url, [])->getBody()->getContents();
			$info               = json_decode($string, true);
			$returnInfo['data'] = $info;
		} catch (GuzzleException $e) {
			$returnInfo['code'] = 1;
			$returnInfo['msg']  = $e->getMessage();
		}

		return $returnInfo;
	}

	/**
	 * post请求
	 *
	 * @param string $url        请求地址
	 * @param array $requestData 请求参数
	 * @param array $options     请求基础参数
	 * @return array
	 */
	public function postRequest(string $url, array $requestData, array $options = []): array
	{
		$client     = $this->clientFactory->create($options);
		$returnInfo = [
			'code' => 0,
			'data' => [],
			'msg'  => '请求成功',
		];

		try {
			$string             = $client->post($url, $requestData)->getBody()->getContents();
			$info               = json_decode($string, true);
			$returnInfo['data'] = $info;
		} catch (GuzzleException $e) {
			$returnInfo['code'] = 1;
			$returnInfo['msg']  = $e->getMessage();
		}

		return $returnInfo;
	}
}
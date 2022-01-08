<?php
declare(strict_types=1);

namespace App\Controller\Api\Common;


use App\Controller\UserBaseController;
use App\Request\Api\Common\PositionValidate;
use App\Service\User\Platform\ContentService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 平台内容
 *
 * @Controller(prefix="api/v1/content")
 * Class ContentController
 * @package App\Controller\Api\Common
 */
class ContentController extends UserBaseController
{
	public function __construct(ContentService $contentService)
	{
		$this->service = $contentService;
		parent::__construct($contentService);
	}

	/**
	 * @GetMapping(path="show")
	 * @param PositionValidate $validate
	 * @return ResponseInterface
	 */
	public function show(PositionValidate $validate)
	{
		$bean = $this->service->serviceFind((array)$this->request->all());

		return $this->httpResponse->success((array)$bean);
	}
}
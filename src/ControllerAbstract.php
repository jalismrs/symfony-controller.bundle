<?php
declare(strict_types = 1);

namespace Jalismrs\ControllerBundle;

use ArrayObject;
use Jalismrs\HelpersRequestBundle\RequestHelpers;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use function array_replace;

/**
 * Class ControllerAbstract
 *
 * @package Jalismrs\ControllerBundle
 *
 * @codeCoverageIgnore
 */
abstract class ControllerAbstract extends
    AbstractController
{
    /**
     * returnJson
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \ArrayObject|null                         $data
     * @param string|null                               $group
     * @param array                                     $context
     * @param int                                       $status
     * @param array                                     $headers
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    protected function returnJson(
        Request $request,
        ArrayObject $data = null,
        string $group = null,
        array $context = [],
        int $status = 200,
        array $headers = []
    ) : JsonResponse {
        $context = array_replace(
            [
                'groups' => [
                    RequestHelpers::getRouteName($request),
                    $group ?? 'main',
                ],
            ],
            $context
        );
        
        return $this->json(
            $data ?? new ArrayObject(),
            $status,
            $headers,
            $context
        );
    }
}

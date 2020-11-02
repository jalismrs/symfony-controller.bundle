<?php
declare(strict_types = 1);

namespace Jalismrs\Symfony\Common;

use Jalismrs\Symfony\Common\Helpers\RequestHelpers;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Mime\FileinfoMimeTypeGuesser;
use function array_replace;
use function class_exists;

/**
 * Class ControllerAbstract
 *
 * @package Jalismrs\Symfony\Common
 *
 * @codeCoverageIgnore
 */
abstract class ControllerAbstract extends
    AbstractController
{
    /**
     * returnFile
     *
     * @param string $file
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     *
     * @throws \InvalidArgumentException
     * @throws \LogicException
     */
    protected function returnFile(
        string $file
    ) : BinaryFileResponse {
        /**
         * NOTE
         *
         * $this->file() is not used because
         * it lacks precise control over parameters
         */
    
        $contentType = 'text/plain';
        
        if (class_exists(FileinfoMimeTypeGuesser::class)) {
            $mimeTypeGuesser = new FileinfoMimeTypeGuesser();
            if ($mimeTypeGuesser->isGuesserSupported()) {
                $contentType = $mimeTypeGuesser->guessMimeType($file) ?? $contentType;
            }
        }
        
        return new BinaryFileResponse(
            $file,
            201,
            [
                'Content-Type' => $contentType,
            ],
            false,
            ResponseHeaderBag::DISPOSITION_ATTACHMENT
        );
    }
    
    /**
     * returnJson
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param iterable|null                             $data
     * @param string|null                               $group
     * @param array                                     $context
     * @param int                                       $status
     * @param array                                     $headers
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    protected function returnJson(
        Request $request,
        iterable $data = null,
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
            $data,
            $status,
            $headers,
            $context
        );
    }
}

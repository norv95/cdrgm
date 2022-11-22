<?php

use \App\Http\Request;
use \App\Http\StatusCode;
use \App\ContainerEmulator;
use \App\Service\Logger;
use \App\Http\ContentType;

class ExceptionHandler
{
    /**
     * Handle unexpected exception as API
     * @param Throwable $exception
     * @param Request $request
     * @return void
     * @throws \App\Exception\ServiceNotFoundException
     */
    public static function handleException(Throwable $exception, Request $request): void
    {
        header('Content-type:' . $request->getContentType() ?? ContentType::TXT);
        $statusCode = !empty($exception->getCode()) &&  $exception->getCode() > 100 ? $exception->getCode() : StatusCode::HTTP_INTERNAL_SERVER_ERROR;

        http_response_code($statusCode);

        $publicMessage = 'Error processing request';

        /** @var Logger $logger */
        $logger = ContainerEmulator::getService(Logger::class);

        if ($exception instanceof \App\Exception\PublicException) {
            $publicMessage = $exception->getMessage();
        } else {
            $logger->log(print_r([
                'message' => $exception->getMessage(),
                'code' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ],true));
        }

        echo self::createResponseErrorMessage($publicMessage, $statusCode, $request->getContentType());
    }

    /**
     * Handle errors
     * @param int $errorCode
     * @param string $errorMessage
     * @param string $errorFile
     * @param int $errorLine
     * @param Request $request
     * @return void
     * @throws ErrorException
     */
    public static function handleError(
        int $errorCode,
        string $errorMessage,
        string $errorFile,
        int $errorLine,
        Request $request): void
    {
        throw new ErrorException($errorMessage, $errorCode, 1, $errorFile, $errorLine);
    }

    /**
     * Handle fatal errors
     * @param int $errorCode
     * @param string $errorMessage
     * @param string $errorFile
     * @param int $errorLine
     * @param Request $request
     * @return void
     * @throws ErrorException
     */
    public static function handleFatalError(
        Error $error,
        Request $request): void
    {
        throw new ErrorException($error->getMessage(),$error->getCode(), 1, $error->getFile(), $error->getLine());
    }

    /**
     * Create response body depending on request Content-Type
     * @param string $message
     * @param string $contentType
     * @return void
     */
    private static function createResponseErrorMessage(string $message, int $statusCode, string $contentType): string
    {
        return match ($contentType) {
            ContentType::JSON => json_encode(['error' => $statusCode, 'message' => $message , 'data' => null]),
            ContentType::XML => "<?xml version=1.0 encoding=\"utf-8\"?><response>".
                "<error>{$statusCode}</error>".
                "<message>{$message}</message>".
                "<data></data></response>",
            default => $message
        };
    }
}

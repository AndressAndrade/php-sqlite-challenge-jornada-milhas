<?php

declare(strict_types=1);
// REQUEST_METHOD
if (!array_key_exists('PATH_INFO', $_SERVER) || $_SERVER['PATH_INFO'] === '/') {
	http_response_code(404);
}

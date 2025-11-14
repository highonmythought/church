<?php

use Throwable;

public function render($request, Throwable $exception)
{
    // Always use friendly error pages if debug is off
    if (!config('app.debug')) {

        // Handle authentication exceptions
        if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
            return redirect()->route('login');
        }

        // Handle HTTP exceptions (404, 403, 419, 500, 503, etc.)
        if ($this->isHttpException($exception)) {
            $status = $exception->getStatusCode();
            $view = "errors.$status";

            if (view()->exists($view)) {
                return response()->view($view, ['exception' => $exception], $status);
            }

            // Fallback to default error page if specific view doesn't exist
            return response()->view('errors.default', ['exception' => $exception], $status);
        }

        // All other unexpected exceptions
        return response()->view('errors.default', ['exception' => $exception], 500);
    }

    // Default Laravel behavior when debug is on
    return parent::render($request, $exception);
}

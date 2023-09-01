<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ErrorException){
            
            // Log the error
            Log::error($exception);

            // Return a custom error response
            return response()->view('errors.general', ['exception' => $exception], 500);

        }

        // Default exception handling
        return parent::render($request, $exception);
    }

    public function renderNotFound(Request $request) {
        return redirect()->route('notFound');
      }
}

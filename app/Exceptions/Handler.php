<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

public function register(): void
{
    $this->renderable(function (ModelNotFoundException|NotFoundHttpException|MethodNotAllowedHttpException $e, $request) {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return redirect()->route('home');
    });
}

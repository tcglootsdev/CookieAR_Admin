<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class FileUpload
{
    public function handle(Request $request, Closure $next, string ...$params): Response
    {
        $body = $request->all();

        $options = unserialize($params[0]);
        $modelName = $options['modelName'];
        $files = $options['files'];

        $rules = [];
        $messages = [];

        foreach ($body as $key => $value) {
            $suffix = substr($key, strlen($key) - 4, 4);
            $prefix = substr($key, 0, strlen($key) - 4);
            if ($suffix === "File") {
                $rules[$key] = 'file';
                if (key_exists($prefix, $files) && key_exists('extension', $files[$prefix])) {
                    $rules[$key] .= '|mimes:' . implode(',', $files[$prefix]['extension']);
                }
                $messages[$key . '.file'] = trans('invalid_' . $modelName . '_' . $prefix);
            }
        }

        $validator = Validator::make($body, $rules, $messages);
        if ($validator->fails()) {
            return Utils::responseJsonError($validator->errors()->first());
        }

        foreach ($rules as $key => $value) {
            $prefix = substr($key, 0, strlen($key) - 4);
            $file = $request->file($key);
            $filename = $file->getClientOriginalName();
            $path = 'uploads/others';
            if (key_exists($prefix, $files) && key_exists('path', $files[$prefix])) {
                $path = $files[$prefix]['path'];
            }
            $storage_path = $file->store($path);
            $request->merge([$prefix => [
                'storage_path' => $storage_path,
                'filename' => $filename
            ]]);
        }

        return $next($request);
    }
}

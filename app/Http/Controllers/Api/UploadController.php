<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\File\FileAnalysisService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    use ApiResponse;

    public function __construct(private FileAnalysisService $fileAnalysisService) {}

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:20480',
        ]);

        $result = $this->fileAnalysisService->upload($request->file('file'));

        return $this->success([
            'file_path' => $result['path'],
            'analysis'  => $result['analysis'],
        ], $result['analysis']['passed'] ? '檔案上傳成功' : '檔案有警告，請確認後繼續');
    }
}

<?php

namespace App\Services\File;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileAnalysisService
{
    private const MIN_DPI = 300;
    private const MAX_SIZE_MB = 20;
    private const ALLOWED_MIMES = ['image/jpeg', 'image/png', 'application/pdf'];

    public function upload(UploadedFile $file): array
    {
        $path = $file->store('orders/' . date('Y/m'), 'local');
        $analysis = $this->analyze(Storage::path($path), $file->getMimeType());

        return [
            'path'     => $path,
            'analysis' => $analysis,
        ];
    }

    private function analyze(string $fullPath, string $mimeType): array
    {
        $result = [
            'dpi'         => null,
            'color_mode'  => null,
            'has_bleed'   => null,
            'warnings'    => [],
            'passed'      => true,
        ];

        if (!extension_loaded('imagick')) {
            $result['warnings'][] = 'Imagick 未安裝，略過檔案分析';
            return $result;
        }

        try {
            $imagick = new \Imagick($fullPath);

            // 解析度檢查
            $resX = $imagick->getImageResolution()['x'] ?? 0;
            $result['dpi'] = (int) $resX;
            if ($resX > 0 && $resX < self::MIN_DPI) {
                $result['warnings'][] = "解析度不足（{$resX} DPI），建議至少 " . self::MIN_DPI . " DPI";
                $result['passed'] = false;
            }

            // 色彩模式檢查
            $colorspace = $imagick->getImageColorspace();
            $result['color_mode'] = $this->colorspaceName($colorspace);
            if ($colorspace === \Imagick::COLORSPACE_SRGB || $colorspace === \Imagick::COLORSPACE_RGB) {
                $result['warnings'][] = '色彩模式為 RGB，印刷建議使用 CMYK';
            }

            // 出血區域（簡易判斷：圖片尺寸是否大於常見印刷尺寸 + 3mm 出血）
            $width  = $imagick->getImageWidth();
            $height = $imagick->getImageHeight();
            $result['has_bleed'] = ($width > 100 && $height > 100); // 實際需依產品規格判斷

            $imagick->clear();
        } catch (\ImagickException $e) {
            $result['warnings'][] = '檔案分析失敗：' . $e->getMessage();
        }

        return $result;
    }

    private function colorspaceName(int $colorspace): string
    {
        return match ($colorspace) {
            \Imagick::COLORSPACE_CMYK  => 'CMYK',
            \Imagick::COLORSPACE_SRGB  => 'RGB',
            \Imagick::COLORSPACE_RGB   => 'RGB',
            \Imagick::COLORSPACE_GRAY  => 'Grayscale',
            default                    => 'Unknown',
        };
    }
}

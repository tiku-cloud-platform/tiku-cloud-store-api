<?php
declare(strict_types = 1);

namespace App\Library\File;

/**
 * 从文本从提取图片的url地址信息
 *
 * Class ImageSrcSearch
 * @package App\Library\File
 */
class ImageSrcSearch
{
    /**
     * 提取富文本文本中的图片地址
     * @param string $content 提取的字符串内容
     * @return array 替换之后的数组
     */
    public static function searchImageUrl(string $content): array
    {
        $imgSrcArr      = [];
        $pattern_imgTag = '/<img\b.*?(?:\>|\/>)/i';
        preg_match_all($pattern_imgTag, $content, $matchIMG);
        if (isset($matchIMG[0])) {
            foreach ($matchIMG[0] as $imgTag) {
                $pattern_src = '/\bsrc\b\s*=\s*[\'\"]?([^\'\"]*)[\'\"]?/i';
                preg_match_all($pattern_src, $imgTag, $matchSrc);
                if (isset($matchSrc[1])) {
                    foreach ($matchSrc[1] as $src) {
                        $imgSrcArr[] = $src;
                    }
                }
            }
        }

        return $imgSrcArr;
    }

    /**
     * 提取markdown语法中的图片地址
     * @param string $content
     * @return array
     */
    public static function searchMarkDownIMageUrl(string $content): array
    {
        $matchArray = array ();
        preg_match_all('/\]\((.*?)\)/i', $content, $matchArray);
        $imageArray    = $matchArray[1];
        $newImageArray = [];
        foreach ($imageArray as $key => $value) {
            $valueImage = explode(".", $value);
            if (count($valueImage) > 1) {
                if (in_array($valueImage[count($valueImage) - 1], ["bmp", "jpg", "png", "tif", "gif", "pcx", "tga", "exif", "fpx", "svg", "psd", "cdr", "pcd", "dxf", "ufo", "eps", "ai", "raw", "WMF", "webp", "avif", "apng"])) {
                    $newImageArray[] = $value;
                }
            }
        }
        return $newImageArray;
    }

    /**
     * 替换文本中的图片路径
     *
     * @param string $content 替换字符串
     * @param array $realImageArray 图片真实路径[['origin' => '原图片地址', 'remote' => '实际图片地址']]
     * @param int $contentType 文档类型，1富文本，2markdown
     * @return string
     */
    public static function replaceImageUrl(string $content, array $realImageArray, int $contentType = 1): string
    {
        $originImageArray = array_column($realImageArray, 'origin');
        $remoteImageArray = array_column($realImageArray, 'remote');

        $content = str_replace($originImageArray, $remoteImageArray, $content);
        if ($contentType == 1) {
            return preg_replace("/<img/i", "<img width='100%' ", $content);
        }
        return $content;
    }
}
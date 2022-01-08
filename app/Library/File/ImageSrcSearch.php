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
     * 提取文本中的图片地址
     *
     * @param string $content 提取的字符串内容
     * @return array 替换之后的数组
     */
    public static function searchImageUrl(string $content): array
    {
        $imgSrcArr      = [];
        $pattern_imgTag = '/<img\b.*?(?:\>|\/>)/i';
        preg_match_all($pattern_imgTag, $content, $matchIMG);
        if (isset($matchIMG[0])) {
            foreach ($matchIMG[0] as $key => $imgTag) {
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
     * 替换文本中的图片路径
     *
     * @param string $content 替换字符串
     * @param array $realImageArray 图片真实路径[['origin' => '原图片地址', 'remote' => '实际图片地址']]
     * @return string
     */
    public static function replaceImageUrl(string $content, array $realImageArray): string
    {
        $originImageArray = array_column($realImageArray, 'origin');
        $remoteImageArray = array_column($realImageArray, 'remote');

        return str_replace($originImageArray, $remoteImageArray, $content);
    }
}
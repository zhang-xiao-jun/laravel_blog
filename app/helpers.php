<?php
/**
 * 返回可读性更好的尺寸格式
 */
function human_filesize ($bytes, $decimals)
{
    $size = ['B','KB','MB','GB','TB','PB'];
    $factor = floor((strlen($bytes) - 1) / 3);

    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) .@$size[$factor];
}

/**
 * 判断文件的MIME类型是否为图片
 */
function is_image($mimeType)
{
    return starts_with($mimeType, 'image/');
}

function test123 ()
{
    return 'hello world';
}

function checked($value)
{
    return $value ? 'checked' : '';
}

function page_image($value = null)
{
    if (empty($value)) {
        $value = config('blog.page_image');
    }
    if (! starts_with($value, 'http') && $value[0] !== '/') {
        $value = config('blog.uploads.webpath') . '/' . $value;
    }

    return $value;
}
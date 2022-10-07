<?php
namespace Muravian;

class ImageResize
{
    /**
     * @var int
     *
     * Default: Original Width
     */
    private int $newWidth;

    /**
     * @var int
     *
     * Default: Original Width
     */
    private int $newHeight;

    /**
     * @var string
     */
    private string $path;

    /**
     * @var
     */
    private $newImage;

    /**
     * @param $width
     * @return void
     */
    public function setWidth($width)
    {
        $this->newWidth = $width;
    }

    /**
     * @param $height
     * @return void
     */
    public function setHeight($height)
    {
        $this->newHeight = $height;
    }

    /**
     * @param $path
     * @return void
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return array
     *
     * Get Image informations: Width, Height, Ratio, Mime
     */
    private function imageInfo(): array
    {
        list($originWidth, $originHeight) = getimagesize($this->path);

        return [
            $originWidth,
            $originHeight,
            $originWidth / $originHeight,
            mime_content_type($this->path)
        ];
    }

    /**
     * @param $mime
     * @return void
     * Create Image resource
     */
    private function createImage($mime)
    {
        switch ($mime) {
            case 'image/jpeg':
                $this->newImage = imagecreatefromjpeg($this->path);
                break;
            case 'image/gif':
                $this->newImage = imagecreatefromgif($this->path);
                break;
            case 'image/png':
                $this->newImage = imagecreatefrompng($this->path);
                break;
            case 'image/bmp':
                $this->newImage = imagecreatefrombmp($this->path);
                break;
            case 'image/webp':
                $this->newImage = imagecreatefromwebp($this->path);
                break;
        }

    }

    /**
     * @return false|GdImage|resource
     *
     * Resize Images
     */
    private function imgResize()
    {
        list($originWidth, $originHeight) = $this->imageInfo();

        $process = imagecreatetruecolor($this->newWidth, $this->newHeight);
        imagecopyresampled($process, $this->newImage, 0, 0, 0, 0, $this->newWidth, $this->newHeight, $originWidth, $originHeight);

        return $process;
    }

    /**
     * @param $args
     * @return false|GdImage|resource
     *
     * Crop Images
     */
    private function imgCrop($args)
    {

        list($originWidth, $originHeight, $newWidth, $newHeight) = $args;

        $w_mid = round($originWidth / 2);
        $h_mid = round($originHeight / 2);

        $img = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($img, $this->newImage, 0, 0, ($w_mid - ($newWidth / 2)), ($h_mid - ($newHeight / 2)), $originWidth, $originHeight, $newWidth, $newHeight);

        return $img;
    }

    /**
     * @return false|string
     *
     * If No parameters received show Image.
     */
    private function showImage()
    {
        return file_get_contents($this->path);
    }

    /**
     * @return false|GdImage|resource
     *
     * If both Width & Height are received, resize and crop image
     */
    private function cropImage()
    {
        $imageInfo = $this->imageInfo();
        $newRatio = $this->newWidth / $this->newHeight;
        $processWidth = $this->newWidth;
        $processHeight = $this->newHeight;

        if ($newRatio >= $imageInfo[2])
            $this->setHeight($this->newWidth / $imageInfo[2]);

        if ($newRatio < $imageInfo[2])
            $this->setWidth($this->newHeight * $imageInfo[2]);

        $this->newImage = $this->imgResize();

        $args = [
            $this->newWidth,
            $this->newHeight,
            $processWidth,
            $processHeight
        ];

        return $this->imgCrop($args);
    }

    /**
     * @return false|GdImage|resource
     *
     * Resize the image based on Width
     */
    private function resizeImageByW()
    {
        $imageInfo = $this->imageInfo();
        $this->setHeight($this->newWidth / $imageInfo[2]);
        return $this->imgResize();
    }

    /**
     * @return false|GdImage|resource
     *
     * Resize the image based on Height
     */
    private function resizeImageByH()
    {
        $imageInfo = $this->imageInfo();
        $this->setWidth($this->newHeight * $imageInfo[2]);
        return $this->imgResize();
    }

    /**
     * @return bool|string
     *
     * Render.
     */
    public function render()
    {
        $imageInfo = $this->imageInfo();
        $this->createImage($imageInfo[3]);

        if (isset($this->newWidth) && !isset($this->newHeight))
            return imagewebp($this->resizeImageByW());

        if (!isset($this->newWidth) && isset($this->newHeight))
            return imagewebp($this->resizeImageByH());

        if (isset($this->newWidth) && isset($this->newHeight))
            return imagewebp($this->cropImage());

        return $this->showImage();
    }
}
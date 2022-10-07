If you don't want to crop, resize or just show images from your server.
# Install

```bash
composer require muravian/php-image-resize
```

# Features

- Show Images
- Resize image based on Width
- Resize image based on Height
- Resize & Crop image

## Usage

### Show Image

```php
use Muravian\PhpImageResize\ImageResize;

$image = new ImageResize();
$image->setPath('../path/to/your/file');
echo $image->render();
```

### Resize Image based on Width

```php
use Muravian\PhpImageResize\ImageResize;

$image = new ImageResize();
$image->setPath('../path/to/your/file');
$image->setWidth(500);
echo $image->render();
```

### Resize Image based on Height

```php
use Muravian\PhpImageResize\ImageResize;

$image = new ImageResize();
$image->setPath('../path/to/your/file');
$image->setHeight(500);
echo $image->render();
```

### Resize & Crop Image

```php
use Muravian\PhpImageResize\ImageResize;

$image = new ImageResize();
$image->setPath('../path/to/your/file');
$image->setWidth(500);
$image->setHeight(500);
echo $image->render();
```

Thanks to : [MURAVIAN](https://muravian.com)
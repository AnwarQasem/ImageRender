If you don't want to crop, resize or just show images from your server.

# Features

- Show Images
- Resize image based on Width
- Resize image based on Height
- Resize & Crop image

## Examples

### Show Image

```php
use \Muravian\ImageResize;

$image = new ImageResize();
$image->setPath('../path/to/your/file');
echo $image->render();
```

### Resize Image based on Width

```php
use \Muravian\ImageResize;

$image = new ImageResize();
$image->setPath('../path/to/your/file');
$image->setWidth(500);
echo $image->render();
```

### Resize Image based on Height

```php
use \Muravian\ImageResize;

$image = new ImageResize();
$image->setPath('../path/to/your/file');
$image->setHeight(500);
echo $image->render();
```

### Resize & Crop Image

```php
use \Muravian\ImageResize;

$image = new ImageResize();
$image->setPath('../path/to/your/file');
$image->setWidth(500);
$image->setHeight(500);
echo $image->render();
```
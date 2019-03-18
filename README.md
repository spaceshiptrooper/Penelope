# Penelope

Penelope is a file that's used to remove unwanted files dynamically. The story behind creating Penelope is that since I use macOS, it automatically creates a file called `.DS_Store` in folders that you access via Finder. This gets annoying when you have to upload your files to a live server or transfer folders and files from macOS to Windows or Linux. `.DS_Store` files typically get uploaded to your live server if you are uploading an entire folder by just uploading the parent folder. This can get annoying when you have to delete those files manually one-by-one because they really have no use outside of the macOS. In addition, if you compress a folder or multiple files within Mac and then transfer that compressed file to Windows or Linux you will receive a folder called `__MACOSX`. This folder typically comes in a compressed file when transferring from Mac to other operating systems. It has really no use other than duplicating files within that folder and naming them with a prefix of `.`. This would double the total size which clogs and wastes space. So I created this `PHP` file to remove those files and directories dynamically. This can also be done to other files as well if you'd like.

---

# Usage

To use `Penelope` all you have to do is require the `Penelope.php` file and then instantiate the `Penelope` class. Below is a short and simple example.

```
<?php
// Require the Penelope file
require_once 'Penelope.php';

// Instantiate the Penelope class
$run = new Penelope([
	'path' => __DIR__ . '/', // The desired directory
	'blacklist' => [
		'.DS_Store',
		'__MACOSX'
	]	
]);

// Run the run() method
$run->run();
```

The `'path' => __DIR__ . '/'` line doesn't even have to contain the `__DIR__ . '/'` syntax if you don't want it to. You can specify the targeted folder as absolute or relative as you desire. The use for `__DIR__ . '/'` is to target the current folder in which the example code is initiated in. For instance, if this file is within `https://localhost/sample/index.php`, `Penelope` will target all folders and files under the `sample` folder. If the initiated file is within the root directory, then you will be targeting the root directory. If you want to target a folder outside of such premises, you can just define that targeted path in the `'path' => ''` line.

The `blacklist` array is a sequential array so all you have to do is list the filenames you want `Penelope` to target and delete. That's it. It's pretty simple to use.

---

If you have any questions. Please PM me at [@spaceshiptrooper](https://sitepoint.com/community/users/spaceshiptrooper).
# bootstrap-imageupload

A [Bootstrap](https://getbootstrap.com/)/[jQuery](https://jquery.com/) plugin to preview image uploads.

## Table of contents

* [Demo](#demo)
* [Installation](#installation)
* [Usage](#usage)
* [Limitations](#limitations)

## Demo

[https://egonolieux.github.io/bootstrap-imageupload](https://egonolieux.github.io/bootstrap-imageupload)

## Installation

Following installation options are available:

- Download and include the files manually.
- Install with [npm](https://www.npmjs.com): `npm install bootstrap-imageupload --save`.

## Usage

```JavaScript
$('#my-imageupload').imageupload(options);
```

### HTML

Copy this snippet into your HTML.

```HTML
<div class="imageupload panel panel-default">
    <div class="panel-heading clearfix">
        <h3 class="panel-title pull-left">Upload Image</h3>
        <div class="btn-group pull-right">
            <button type="button" class="btn btn-default active">File</button>
            <button type="button" class="btn btn-default">URL</button>
        </div>
    </div>
    <div class="file-tab panel-body">
        <label class="btn btn-default btn-file">
            <span>Browse</span>
            <!-- The file is stored here. -->
            <input type="file" name="image-file">
        </label>
        <button type="button" class="btn btn-default">Remove</button>
    </div>
    <div class="url-tab panel-body">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Image URL">
            <div class="input-group-btn">
                <button type="button" class="btn btn-default">Submit</button>
            </div>
        </div>
        <button type="button" class="btn btn-default">Remove</button>
        <!-- The URL is stored here. -->
        <input type="hidden" name="image-url">
    </div>
</div>
```

### JavaScript

#### Options

| Name           | Type   | Default                       |
| ---------------|--------| ------------------------------|
| allowedFormats | Array  | ['jpg', 'jpeg', 'png', 'gif'] |
| maxWidth       | Number | 250                           |
| maxHeight      | Number | 250                           |
| maxFileSizeKb  | Number | 2048                          |

#### Methods

##### .imageupload(options)

Initializes *bootstrap-imageupload*.
If no options are given, defaults are used.

```JavaScript
$('#my-imageupload').imageupload({
    allowedFormats: [ 'jpg' ],
    maxFileSizeKb: 512
});
```

##### .imageupload('disable')

Disables user input.

```JavaScript
$('#my-imageupload').imageupload('disable');
```

##### .imageupload('enable')

Enables user input (after being disabled).

```JavaScript
$('#my-imageupload').imageupload('enable');
```

##### .imageupload('reset')

Resets *bootstrap-imageupload* to its initial state.
Options from initialization are preserved.

```JavaScript
$('#my-imageupload').imageupload('reset');
```

## Limitations

The *upload image by URL* feature has the following limitations:

- The URL must contain the filename including its extension.
- The file size cannot be verified.

These limitations exist because the image element constructor is used to load the image.
The only accurate method to verify the image format and file size, is to perform a HTTP HEAD request, which might not work because of the same origin policy.
In order to avoid loading very large image files, a timeout of 3000ms is used.

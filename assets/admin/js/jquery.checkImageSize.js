/* ========================================================================
 * Check Image Size - v1.0
 * http://josephilipraja.github.io/jquery-check-image-size
 * ========================================================================
 * Made with Love by: Jose Philip Raja
 * Founder & Creative Director of CreaveLabs IT Solutions LLP
 * http://josephilipraja.com, http://creavelabs.com
 * ========================================================================
 * Released under the MIT license.
 * Read more at: http://opensource.org/licenses/MIT
 * ========================================================================
 */
 (function($) {
    $.fn.checkImageSize = function(options) {

        if (!this.length) { return this; }

        var opts = $.extend(true, {}, $.fn.checkImageSize.defaults, options);
        var _URL = window.URL || window.webkitURL;

        this.each(function() {
            var $this = $(this);
            $this.change(function (e) {
		        var file, img, minWidth, minHeight, maxWidth, maxHeight;
		        
		        if ($this.data('min-width')) {
		            minWidth = parseInt($this.data('min-width'));
		        } else {
		            minWidth = opts.minWidth;
		        }
		        if ($this.data('min-height')) {
		            minHeight = parseInt($this.data('min-height'));
		        } else {
		            minHeight = opts.minHeight;
		        }
		        if ($this.data('max-width')) {
		            maxWidth = parseInt($this.data('max-width'));
		        } else {
		            maxWidth = opts.maxWidth;
		        }
		        if ($this.data('max-height')) {
		            maxHeight = parseInt($this.data('max-height'));
		        } else {
		            maxHeight = opts.maxHeight;
		        }

		        if ((file = this.files[0])) {
		            img = new Image();
		            img.onload = function () {
		                var validImage = true;
		                var imgWidth = this.width;
		                var imgHeight = this.height;

		                if (imgWidth < minWidth || imgHeight < minHeight) {
		                    validImage = false;
		                    if (opts.showError) {
		                    	alert('Please select an image with at-least ' + minWidth + 'px width & ' + minHeight + 'px height!');
		                    }
		                }

		                if (imgWidth > maxWidth || imgHeight > maxHeight) {
		                    validImage = false;
		                    if (opts.showError) {
		                    	alert('Please select an image of maximum ' + maxWidth + 'px width & ' + maxHeight + 'px height!');
		                    }
		                }

		                if(!validImage && !opts.ignoreError) {
		                    $this.val("");
		                }

		            };
		            img.src = _URL.createObjectURL(file);
		        }
		    });
        });

        return this;
    };

    // default options
    $.fn.checkImageSize.defaults = {
        minWidth: 800,		// Numeric; Pixel value
        minHeight: 600,		// Numeric; Pixel value
        maxWidth: 8000,		// Numeric; Pixel value
        maxHeight: 6000,	// Numeric; Pixel value
        showError: true,	// Boolean; Whether to show error messages
        ignoreError: false	// Boolean; Whether to ignore error and let the image pass through
    };

})(jQuery);

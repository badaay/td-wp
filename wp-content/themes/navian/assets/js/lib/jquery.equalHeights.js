/*!
 * Equal Heights Plugin
 * Equalize the heights of elements. Great for columns or any elements
 * that need to be the same size (floats, etc).
 * 
 * Version 1.0
 * Updated 12/109/2008
 *
 * Copyright (c) 2008 Rob Glazebrook (cssnewbie.com)
 * 
 */(function($) {"use strict";$.fn.equalHeights = function(options) {var settings = $.extend( {container: null}, options);var currentTallest = 0;var outerTallest = 0;var $this = $(this);$this.css({'height': 'auto','min-height': '0px'}).each(function() {var $el = $(this);if ($el.height() > currentTallest) {currentTallest = $el.height();outerTallest = $el.outerHeight();}}).css({'height': outerTallest,'min-height': outerTallest});if (settings.container!=null) {$this.parents(settings.container).css({'height': outerTallest,'min-height': outerTallest});}return this;};$.fn.equalHeightsRemove = function(){$(this).css({'height': 'auto','min-height': '0px'});return this;};})(jQuery);
/**
 * Applies body classes based on pixel/percent distances scrolled
 * 
 * Use window.ScrollDetection.GetConfig() to get the default configuration
 * Use window.ScrollDetection.SetConfig() to set a new configuration
 * 
 * Scroll detection calculations thanks to:
 * http://javascriptkit.com/javatutors/detect-user-scroll-amount.shtml
 */
( function() {

	function ScrollDetection() {

		var config = {
			singlePixelClassesUntil: 200,
			singlePercentClassesUntil: 100,
			stickyScrollDistances: [50, 100, 150, 200, 300],
			stickyScrollPercentages: [25, 50, 75],
		}
	
		// Max pixel distance to watch for applying pixel-based scroll classes
		var maxPixelScrollDistanceToWatch;
		function calculateMaxPixelScrollDistanceToWatch() {
			maxPixelScrollDistanceToWatch = Math.max(config.singlePixelClassesUntil, Math.max.apply(null, config.stickyScrollDistances));
		}
		calculateMaxPixelScrollDistanceToWatch();
	
		window.addEventListener("scroll", addBodyClasses, false);
		window.addEventListener("resize", addBodyClasses, false);
	
		var body = document.querySelector("body");
		
		function addBodyClasses() {
			var distanceScrolled = getDistanceScrolled();
			var percentScrolled = getPercentScrolled();
	
			// Remove previous scrolled class
			if (distanceScrolled <= maxPixelScrollDistanceToWatch) {
				// Remove pixel-based scroll classes as well as percent-based
				body.className = body.className.replace(/\s?scrolled(-pct)?-\d+/gi, "");
			} else {
				// Only remove percent-based scroll classes
				body.className = body.className.replace(/\s?scrolled-pct-\d+/gi, "");
			}
	
			// Add single-pixel scroll classes
			if (distanceScrolled > 0 && distanceScrolled <= config.singlePixelClassesUntil) {
				body.className += " scrolled-" + distanceScrolled;
			}
	
			// Add sticky pixel scroll classes
			for (var i = 0; i < config.stickyScrollDistances.length; i++) {
				var dist = config.stickyScrollDistances[i];
				if (distanceScrolled >= dist && ! body.className.includes(" scrolled-" + dist)) {
					body.className += " scrolled-" + dist;
				}
			}
	
			// Add single-percent scroll classes
			if (percentScrolled > 0 && percentScrolled <= config.singlePercentClassesUntil) {
				body.className += " scrolled-pct-" + percentScrolled;
			}
	
			// Add sticky percent scroll classes
			for (var i = 0; i < config.stickyScrollPercentages.length; i++) {
				var dist = config.stickyScrollPercentages[i];
				if (percentScrolled > dist && ! body.className.includes(" scrolled-pct-" + dist)) {
					body.className += " scrolled-pct-" + dist;
				}
			}
		}
	
		function getDistanceScrolled() {
			return window.pageYOffset || (document.documentElement || document.body.parentNode || document.body).scrollTop
		}
	
		function getPercentScrolled() {
			var scrollTop = getDistanceScrolled();
			var winheight= window.innerHeight || (document.documentElement || document.body).clientHeight
			var docheight = getDocHeight()
			var trackLength = docheight - winheight
			
			return Math.floor(scrollTop/trackLength * 100) // gets percentage scrolled (ie: 80 or NaN if tracklength == 0)
		}
	
		function getDocHeight() {
			var D = document;
			return Math.max(
				D.body.scrollHeight, D.documentElement.scrollHeight,
				D.body.offsetHeight, D.documentElement.offsetHeight,
				D.body.clientHeight, D.documentElement.clientHeight
			)
		}

		function getConfig() {
			return config;
		}

		function setConfig(newConfig) {
			config = newConfig;
			calculateMaxPixelScrollDistanceToWatch();
		}

		return {
			getConfig: getConfig,
			setconfig: setConfig
		}

	}

	window.ScrollDetection = new ScrollDetection();

} )();
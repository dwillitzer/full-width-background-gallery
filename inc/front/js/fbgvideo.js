;(function($) {

    $.FbgVideo = function(options) {
        var defaults = {
			// If you want to use a single mp4 source, set as true
			useFlashForFirefox:true,
			// If you are doing a playlist, the video won't play the first time
			// on a touchscreen unless the play event is attached to a user click
			forceAutoplay:false,
			controls:true,
			doLoop:false
        };

        var FbgVideo = this,
			player,
			vidEl = '#fbg-video-vid',
			wrap = $('<div id="fbg-video-wrap"></div>'),
			video = $(''),
			mediaAspect = 16/9,
			vidDur = 0,
			defaultVolume = 0.8,
			isInitialized = false,
			isSeeking = false,
			isPlaying = false,
			isQueued = false,
			isAmbient = false,
			playlist = [],
			currMediaIndex,
			currMediaType;

        var settings = $.extend({}, defaults, options);

        // If only using mp4s and on firefox, use flash fallback
        var ua = navigator.userAgent.toLowerCase();
        var isFirefox = ua.indexOf('firefox') != -1;
        if (settings.useFlashForFirefox && (isFirefox)) {
			VideoJS.options.techOrder = ['flash'];
		}


		function updateSize() {
			var windowW = $(window).width();
			var windowH = $(window).height();
			var windowAspect = windowW/windowH;
			if (windowAspect < mediaAspect) {
				// taller
				if (currMediaType === 'video') {
					player
						.width(windowH*mediaAspect)
						.height(windowH);
					$(vidEl)
						.css('top',0)
						.css('left',-(windowH*mediaAspect-windowW)/2)
						.css('height',windowH);
					$(vidEl+'_html5_api').css('width',windowH*mediaAspect);
					$(vidEl+'_flash_api')
						.css('width',windowH*mediaAspect)
						.css('height',windowH);
				} else {
					// is image
					$('#fbg-video-image')
						.width(windowH*mediaAspect)
						.height(windowH)
						.css('top',0)
						.css('left',-(windowH*mediaAspect-windowW)/2);
				}
			} else {
				// wider
				if (currMediaType === 'video') {
					player
						.width(windowW)
						.height(windowW/mediaAspect);
					$(vidEl)
						.css('top',-(windowW/mediaAspect-windowH)/2)
						.css('left',0)
						.css('height',windowW/mediaAspect);
					$(vidEl+'_html5_api').css('width','100%');
					$(vidEl+'_flash_api')
						.css('width',windowW)
						.css('height',windowW/mediaAspect);
				} else {
					// is image
					$('#fbg-video-image')
						.width(windowW)
						.height(windowW/mediaAspect)
						.css('top',-(windowW/mediaAspect-windowH)/2)
						.css('left',0);
				}
			}
		}

		function initPlayControl() {
			// create video controller
			var markup = '<div id="fbg-video-control-container">';
			markup += '<div id="fbg-video-control">';
			markup += '<a href="#" id="fbg-video-control-play"></a>';
			markup += '<div id="fbg-video-control-middle">';
			markup += '<div id="fbg-video-control-bar">';
			markup += '<div id="fbg-video-control-bound-left"></div>';
			markup += '<div id="fbg-video-control-progress"></div>';
			markup += '<div id="fbg-video-control-track"></div>';
			markup += '<div id="fbg-video-control-bound-right"></div>';
			markup += '</div>';
			markup += '</div>';
			markup += '<div id="fbg-video-control-timer"></div>';
			markup += '</div>';
			markup += '</div>';
			$('body').append(markup);

			// hide until playVideo
			$('#fbg-video-control-container').css('display','none');

			// add events
			$('#fbg-video-control-track').slider({
				animate: true,
				step: 0.01,
				slide: function(e,ui) {
					isSeeking = true;
					$('#fbg-video-control-progress').css('width',(ui.value-0.16)+'%');
					player.currentTime((ui.value/100)*player.duration());
				},
				stop:function(e,ui) {
					isSeeking = false;
					player.currentTime((ui.value/100)*player.duration());
				}
			});
			$('#fbg-video-control-bar').click(function(e) {
				player.currentTime((e.offsetX/$(this).width())*player.duration());
			});
			$('#fbg-video-control-play').click(function(e) {
				e.preventDefault();
				playControl('toggle');
			});
			player.addEvent('timeupdate', function() {
				if (!isSeeking && (player.currentTime()/player.duration())) {
					var currTime = player.currentTime();
					var minutes = Math.floor(currTime/60);
					var seconds = Math.floor(currTime) - (60*minutes);
					if (seconds < 10) seconds='0'+seconds;
					var progress = player.currentTime()/player.duration()*100;
					$('#fbg-video-control-track').slider('value',progress);
					$('#fbg-video-control-progress').css('width',(progress-0.16)+'%');
					$('#fbg-video-control-timer').text(minutes+':'+seconds+' / '+vidDur);
				}
			});
		}

		function playControl(a) {
			var action = a || 'toggle';
			if (action === 'toggle') action = isPlaying ? 'pause' : 'play';
			if (action === 'pause') {
				player.pause();
				$('#fbg-video-control-play').css('background-position','-16px');
				isPlaying = false;

			} else if (action === 'play') {
				player.play();
				$('#fbg-video-control-play').css('background-position','0');
				isPlaying = true;
			}
		}

		function setUpAutoPlay() {
			player.play();
			$('body').off('click',setUpAutoPlay);
        }

		function nextMedia() {
			currMediaIndex++;
			if (currMediaIndex === playlist.length) currMediaIndex=0;
			playVideo(playlist[currMediaIndex]);
        }

        function playVideo(source) {
			// clear image
			$(vidEl).css('display','block');
			currMediaType = 'video';
			player.src(source);
			isPlaying = true;
			if (isAmbient) {
				$('#fbg-video-control-container').css('display','none');
				player.volume(0);
				doLoop = true;
			} else {
				$('#fbg-video-control-container').css('display','block');
				player.volume(defaultVolume);
				doLoop = false;
			}
			$('#fbg-video-image').css('display','none');
			$(vidEl).css('display','block');
        }

        function showPoster(source) {
			// remove old image
			$('#fbg-video-image').remove();

			// hide video
			player.pause();
			$(vidEl).css('display','none');
			$('#fbg-video-control-container').css('display','none');

			// show image
			currMediaType = 'image';
			var bgImage = $('<img id="fbg-video-image" src='+source+' />');
			wrap.append(bgImage);

			$('#fbg-video-image').imagesLoaded(function() {
				mediaAspect = $('#fbg-video-image').width() / $('#fbg-video-image').height();
				updateSize();
			});
        }

		FbgVideo.init = function() {
			if (!isInitialized) {
				// create player
				$('body').prepend(wrap);
				var autoPlayString = settings.forceAutoplay ? 'autoplay' : '';
				player = $('<video id="'+vidEl.substr(1)+'" class="video-js vjs-default-skin" preload="auto" data-setup="{}" '+autoPlayString+' webkit-playsinline></video>');
				player.css('position','absolute');
				wrap.append(player);
				player = _V_(vidEl.substr(1), { 'controls': false, 'autoplay': true, 'preload': 'auto' });
				
				// add controls
				if (settings.controls) initPlayControl();
				
				// set initial state
				updateSize();
				isInitialized = true;
				isPlaying = false;

				if (settings.forceAutoplay) {
					$('body').on('click', setUpAutoPlay);
				}

				$('#fbg-video-vid_flash_api')
					.attr('scale','noborder')
					.attr('width','100%')
					.attr('height','100%');
				
				// set events
				$(window).resize(function() {
					updateSize();
				});

				player.addEvent('loadedmetadata', function(data) {
					if (document.getElementById('fbg-video-vid_flash_api')) {
						// use flash callback to get mediaAspect ratio
						mediaAspect = document.getElementById('fbg-video-vid_flash_api').vjs_getProperty('videoWidth')/document.getElementById('fbg-video-vid_flash_api').vjs_getProperty('videoHeight');
					} else {
						// use html5 player to get mediaAspect
						mediaAspect = $('#fbg-video-vid_html5_api').prop('videoWidth')/$('#fbg-video-vid_html5_api').prop('videoHeight');
					}
					updateSize();
					var dur = Math.round(player.duration());
					var durMinutes = Math.floor(dur/60);
					var durSeconds = dur - durMinutes*60;
					if (durSeconds < 10) durSeconds='0'+durSeconds;
					vidDur = durMinutes+':'+durSeconds;
				});
				
				player.addEvent('ended', function() {
					if (settings.doLoop) {
						player.currentTime(0);
						player.play();
					}
					if (isQueued) {
						nextMedia();
					}
				});
			}
        };

        FbgVideo.show = function(source,options) {
        	if (options === undefined) options = {};
			isAmbient = options.ambient === true;
			if (isAmbient || options.doLoop) settings.doLoop = true;
			if (typeof(source) === 'string') {
				var ext = source.substring(source.lastIndexOf('.')+1);
				if (ext === 'jpg' || ext === 'gif' || ext === 'png') {
					showPoster(source);
				} else {
					if (options.altSource && navigator.userAgent.toLowerCase().indexOf('firefox') > -1) {
						source = options.altSource;
					}
					playVideo(source);
					isQueued = false;
				}
			} else {
				playlist = source;
				currMediaIndex = 0;
				playVideo(playlist[currMediaIndex]);
				isQueued = true;
			}
        };
	
        // Expose Video.js player
        FbgVideo.getPlayer = function() {
			return player;
        };
    };

})(jQuery);
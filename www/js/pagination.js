/*
 * 	wdzPaginate 1.0 - jQuery plugin
 *	written by Frederic DESCHAMPS	
 *	http://webdropzone.net/
 *
 *	Copyright (c) 2012 Frederic DESCHAMPS (http://webdropzone.net)
 *
 *	Built for jQuery library
 *	http://jquery.com
 *
 */

(function($) {
		  
	$.fn.wdzPaginate = function(options){

		var defaults = {				
			step: 4,
			delay: 300,
			numeric: true,
			nextprev: true,
			auto:false,
			loop:false,
			pause:4000,
			clickstop:true,
			controls: 'pagination',
			current: 'active',
			randomstart: false
		}; 
		
		var options = $.extend(defaults, options); 
		var step = options.step;
		var lower, upper;
		var children = $(this).children();
		var count = children.length;
		var obj, next, prev;		
		var pages = Math.floor(count/step);
		var page = (options.randomstart) ? Math.floor(Math.random()*pages)+1 : 1;
		var timeout;
		var clicked = false;
		
		function show(){
			clearTimeout(timeout);
			lower = ((page-1) * step);
			upper = lower+step;
			$(children).each(function(i){
				var child = $(this);
				
				child.fadeOut(300);
				if(i>=lower && i<upper){ setTimeout(function(){ child.fadeIn(500); }, options.delay ); }
				if(options.nextprev){
					if(upper >= count) { next.addClass('disabled'); } else { next.removeClass('disabled'); };
					if(lower >= 1) { prev.removeClass('disabled'); } else { prev.addClass('disabled'); };
				};
			});	
			$('li','#'+ options.controls).removeClass(options.current);
			$('li[data-index="'+page+'"]','#'+ options.controls).addClass(options.current);
			
			if(options.auto){
				if(options.clickstop && clicked){}else{ timeout = setTimeout(auto,options.pause); };
			};
		};
		
		function auto(){
			if(options.loop) if(upper >= count){ page=0; show(); }
			if(upper < count){ page++; show(); }				
		};
		
		this.each(function(){ 
			
			obj = this;
			
			if(count>step){
							
				if((count/step) > pages) pages++;
				var div_pag = $('<div class="pagination pagination-centered"></div>').appendTo(obj);
				  
				var ul = $('<ul id="'+ options.controls +'"></ul>').appendTo(div_pag);
				
				if(options.nextprev){
					prev = $('<li class="prev"><a href="#"><<</a></li>')
						.addClass('disabled')
						.appendTo(ul)
						.click(function(){
							if (!$(this).hasClass('disabled')) {
								clicked = true;
								page--;
								show();
							}
							return false;
						});
				};
				
				if(options.numeric){
					for(var i=1;i<=pages;i++){
					$('<li data-index="'+ i +'"><a href="#">'+ i +'</a></li>')
						.appendTo(ul)
						.click(function(){
							if (!$(this).hasClass('disabled')) {	
								clicked = true;
								page = $(this).attr('data-index');
								show();
							}
							return false;
						});					
					};				
				};
				
				if(options.nextprev){
					next = $('<li class="next"><a href="#">>></a></li>')
						.addClass('disabled')
						.appendTo(ul)
						.click(function(){
							
							if (!$(this).hasClass('disabled')) {
								clicked = true;			
								page++;
								show();
							}
							return false;
						});
				};
			
				show();
			};
		});	
		
	};	

})(jQuery);
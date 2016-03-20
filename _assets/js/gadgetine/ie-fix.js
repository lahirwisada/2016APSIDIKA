
var flexedItems = [
		{
			"dom": ".main-content-wrapper",
			"break": 882
		},
		{
			"dom": ".footer > .wrapper ul.right",
			"break": 0
		},
		{
			"dom": ".has-ot-mega-menu > ul.ot-mega-menu > li",
			"break": 0
		},
		{
			"dom": ".small-article-list .item",
			"break": 0
		},
		{
			"dom": ".contact-us-page",
			"break": 0
		},
		{
			"dom": ".medium-article-list .item",
			"break": 0
		},
		{
			"dom": ".split-blocks",
			"break": 0
		},
		{
			"dom": ".widget .comment-list .item",
			"break": 0
		}
	];

function fixMyFlex() {
	var elarray = [];
	jQuery.each(flexedItems, function(index, value){
		var theparent = jQuery(flexedItems[index].dom),
			theparentbreak = flexedItems[index].break,
			orderme = [],
			abort = false;

		if(theparent.length){

			jQuery(".news-video-icon, .related-articles").css("display", "none");
			jQuery(".small-article-list .item .item-header, .widget .comment-list .item .item-header, .widget .comment-list .item .item-header, .medium-article-list .item > .item-header").attr("style", "padding-right: 12px!important;");
			theparent.css("display", "table");
			jQuery("img").css("width", "inherit").css("max-width", "100%");
			jQuery.each(theparent.children(), function(index, value){
				var curitem = theparent.children().eq(index),
					tempitems = curitem.css("order");
				if(!tempitems) abort = true;
				curitem.attr("rel", index);
				orderme[tempitems-1] = curitem;
				curitem.css({
					'-webkit-box-sizing': 'border-box',
					'-moz-box-sizing': 'border-box',
					'box-sizing': 'border-box',
					'display': 'table-cell',
					'vertical-align': 'top',
					'width': parseInt(curitem.css("max-width"))+parseInt(curitem.css("margin-left"))+parseInt(curitem.css("margin-right")),
					'max-width': parseInt(curitem.css("max-width"))+parseInt(curitem.css("margin-left"))+parseInt(curitem.css("margin-right")),
					'padding-left': curitem.css("margin-left"),
					'padding-right': curitem.css("margin-right")
				});
				if(theparent.parent().hasClass("ot-mega-menu")){curitem.css("padding", "20px")}
			});

			jQuery.each(orderme, function(index, value){
				if(abort)return;
				if(orderme[index])
					orderme[index].css({
						'width': (100/parseInt(theparent.css("width"))*parseInt(orderme[index].css("width")))+"%",
					});

				if(jQuery(window).width() > theparentbreak){
					theparent.append(orderme[index]);
				}
			});
		}
	});

	fixMyResponsive();
}

function fixMyResponsive() {
	jQuery('img').each(function(){
		var thisimg = jQuery(this);

		if(parseInt(thisimg.width()) >= parseInt(thisimg.prop('naturalWidth'))){
			thisimg.css("max-width", thisimg.width());
		}else{
			thisimg.css("width", thisimg.prop('naturalWidth'));
		}
		thisimg.css("width", "100%");
	});
}

function fixDomResponsive(direction, index, value) {
	if(direction == true){

		var theparent = jQuery(flexedItems[index].dom),
			orderme = [],
			abort = false;

		jQuery.each(theparent.children(), function(index, value){
			var curitem = theparent.children().eq(index);
			if(!curitem.attr("rel")) abort = true;
			orderme[curitem.attr("rel")] = curitem;
		});

		jQuery.each(orderme, function(index, value){
			if(abort)return;
			theparent.append(orderme[index]);
		});

	}else if(direction == false){

		var theparent = jQuery(flexedItems[index].dom),
			orderme = [],
			abort = false;

		jQuery.each(theparent.children(), function(index, value){
			var curitem = theparent.children().eq(index),
				tempitems = curitem.css("order");
			if(!tempitems) abort = true;
			orderme[tempitems-1] = curitem;
		});

		jQuery.each(orderme, function(index, value){
			if(abort)return;
			theparent.append(orderme[index]);
		});

	}
}

jQuery(window).resize(function() {

	jQuery.each(flexedItems, function(index, value){
		if(jQuery(window).width() <= value.break && jQuery(value.dom).attr("broken") == "over"){
			jQuery(value.dom).attr("style", "display: block!important; width: 100%;").attr("broken", "under");
			fixDomResponsive(true, index, value);
		}else if(jQuery(window).width() > value.break && jQuery(value.dom).attr("broken") == "under"){
			jQuery(value.dom).attr("style", "display: table-cell;").attr("broken", "over");
			fixDomResponsive(false, index, value);
		}else if(!jQuery(value.dom).attr("broken")){
			if(jQuery(window).width() <= value.break){
				jQuery(value.dom).attr("broken", "under");
			}else{
				jQuery(value.dom).attr("broken", "over");
			}
		}
	});
	
});


jQuery(window).ready(function() {

	setTimeout(function(){fixMyFlex();}, 10);

});

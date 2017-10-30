$(document).ready(()=>{

	//Hover the main link on icon hover, couldn't find any correct way to do that in CSS
	$(".shortcutIcons a").each((i, e)=>{
		$(e).hover(()=>{
			$(e).parent().parent().find(".searchResultRow").attr('hovered', true);
		},
		() => {
			$(e).parent().parent().find(".searchResultRow").removeAttr('hovered');
		});
	});

});
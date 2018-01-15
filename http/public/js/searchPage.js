$(document).ready(()=>{
	//Make the shortcut icons functionnal
	new Clipboard(".shortcutIcons *");

	//Hover the main link on icon hover, couldn't find any correct way to do that in CSS
	$(".shortcutIcons a").each((i, e)=>{
		$(e).hover(()=>{
			$(e).parent().parent().find(".result-mainLink").attr('hovered', true);
		},
		() => {
			$(e).parent().parent().find(".result-mainLink").removeAttr('hovered');
		});
	});

});
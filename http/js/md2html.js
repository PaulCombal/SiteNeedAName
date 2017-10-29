$(document).ready(()=>{
	new Clipboard(".btn");
	if ($("#text-longDesc").length != 0) {
		//Process markdown transformation
		var converter = new showdown.Converter(),
		text      = $("#text-longDesc").text().trim(),
		html      = converter.makeHtml(text);

		$("#text-longDesc").html(html);
	}
});
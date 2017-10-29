$(document).ready(()=>{
	//Process markdown transformation
	var converter = new showdown.Converter(),
	text      = $("#text-longDesc").text().trim(),
	html      = converter.makeHtml(text);

	$("#text-longDesc").html(html);
});
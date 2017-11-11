$(document).ready(() => {

	/** File global */
	var file_id = $("html").data("file-id");


	/** Functions declarations */
	function alertError() {
		alert("Oups, une erreur s'est produite. Réessayez plus tard, ou parlez-en directement aux admins!");
	}

	function sendFlag(actionValue, printSelector = "body") {
		$.post(
			"../../parts/action_manage_flags.php",
			{
				action: actionValue,
				fileid: file_id
			}
		)
		.done((data) => {
			try {
				data = JSON.parse(data);
				if (data.print === null || data.print === undefined) {
					console.log("Missing 'print' value.");
					alertError();
				}
				else if (data.error) {
					console.log(data.content);
					alertError();
				}
				else if (data.print) {
					//Print the message on the HTML page
					$(printSelector).append(data.content);
				}
				else {
					console.log(data.content);
				}
			}
			catch (e) {
				console.log("Invalid JSON received");
				console.log(data);
				console.log(e);
				alertError();
			}
		})
		.fail(() => {
			console.log("Like could not be sent.");
			alertError();
		});
	}

	/** Instructions start here */

	$("#likeBut").click(() => {
		sendFlag("like");
	});

	$("#dislikeBut").click(() => {
		sendFlag("dislike");
	});
});
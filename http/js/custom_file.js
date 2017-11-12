$(document).ready(() => {

	/** File global */
	var file_id = $("html").data("file-id");


	/** Functions declarations */

	/**
	* alertError
	* 	Displays a generic error message to the user
	* @return boolean
	*	Consistently returns false
	*/
	function alertError() {
		alert("Oups, une erreur s'est produite. Réessayez plus tard, ou parlez-en directement aux admins!");
		return false;
	}

	/**
	* sendFlag
	* @param actionValue as string, INPUT 
	* 	The flag to apply. Possible values are to be seen in action_manage_flags
	* @param callbackSuccess as function, INPUT
	*	The function to be executed if everything went right (play an animation, chnage the color of the button, etc)
	* @param printSelector as string, INPUT
	*	If the server's answer must be printed on the page, then the received text will be appended to the given selector
	* @return void
	*	nothing
	*/
	function sendFlag(actionValue, callbackSuccess, printSelector = "body") {
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
					
					if(!data.noCallback)
						callbackSuccess();
				}
				else {
					if(data.content != undefined)
						console.log(data.content);
					
					if(!data.noCallback)
						callbackSuccess();
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

	$("#likeBut").click(function() {
		sendFlag(
			"like", 
			() => {$(this).toggleClass("active");}
		);
	});

	$("#dislikeBut").click(function(){
		sendFlag(
			"dislike", 
			() => {$(this).toggleClass("active");}
		);
	});
});
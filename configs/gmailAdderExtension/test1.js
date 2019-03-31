InboxSDK.load('1', 'sdk_newtelco_1_c1fb774414').then(function(sdk){

	// the SDK has been loaded, now do something with it!
	sdk.Compose.registerThreadRowViewHandler(function(threadView1){

		// a thread view has come into existence, do something with it!
		threadView1.addButton({
			title: "My Nifty Button!",
			iconUrl: 'https://lh5.googleusercontent.com/itq66nh65lfCick8cJ-OPuqZ8OUDTIxjCc25dkc4WUT1JG8XG3z6-eboCu63_uDXSqMnLRdlvQ=s128-h128-e365',
			onClick: function(event) {
				event.addLabel('Maintenance1');
				openInNewTab('https://maintenance.newtelco.de/addedit?gmid=');
			},
		});
		function openInNewTab(url) {
			var win = window.open(url, '_blank');
			win.focus();
		}
	});

});
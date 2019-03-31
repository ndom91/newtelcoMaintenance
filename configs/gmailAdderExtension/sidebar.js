'use strict';

InboxSDK.load(1, 'sdk_newtelco_1_c1fb774414').then(sdk => {
	sdk.Conversations.registerThreadViewHandler(threadView => {
		const el = document.createElement("div");
		el.innerHTML = 'Hello world!';

		threadView.addSidebarContentPanel({
			title: 'Sidebar Example',
			iconUrl: 'https://lh5.googleusercontent.com/itq66nh65lfCick8cJ-OPuqZ8OUDTIxjCc25dkc4WUT1JG8XG3z6-eboCu63_uDXSqMnLRdlvQ=s128-h128-e365',
			el
		});
	});
});
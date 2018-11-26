'use strict';

/*************************** 
 * https://www.inboxsdk.com/docs/#ToolbarButtonDescriptor
 * 
 * InboxSDK_ID: sdk_newtelco_1_c1fb774414
 *
 */

InboxSDK.load('1', 'sdk_newtelco_1_c1fb774414').then(function(sdk){

    /*
    sdk.Toolbars.registerThreadRowViewHandler(function(threadView1){
        threadView1.addButton({
            type: "LINK",
            title: "Add to Maint",
            iconUrl: 'https://newtelco.tech/done2.png',
            onClick:  function(event) {
                event.getMessageID().then(msgId => msgId.toLowerCase());
                event.getThreadID().then(threadId => threadId.toLowerCase());
                openInNewTab('https://maintenance.newtelco.de/addedit?gmid=123') ;
            }
        });

    });
    sdk.Conversations.registerThreadViewHandler
   */

    sdk.Toolbars.registerThreadRowViewHandler(function(threadView1){
        
    });
	sdk.Toolbars.registerThreadButton({
			title: "Send to Maintenance",
            iconUrl: 'https://newtelco.tech/done2.png',
            positions: ['THREAD','ROW'],
            onClick:  function(event) {
                var id = threadView1.getThreadIDAsync(event);
                console.log("gmid: " + id);
                openInNewTab('https://maintenance.newtelco.de/addedit?gmid');
            }
    });
    
                
    
    function openInNewTab(url) {
        var win = window.open(url, '_blank');
        // win.focus();
    }


});
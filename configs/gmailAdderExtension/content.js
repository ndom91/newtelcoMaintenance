'use strict';

/***************************
 * https://www.inboxsdk.com/docs/#ToolbarButtonDescriptor
 *
 * InboxSDK_ID: sdk_newtelco_1_c1fb774414
 *
 */

InboxSDK.load('1', 'sdk_newtelco_1_c1fb774414').then(function(sdk){

    sdk.Lists.registerThreadRowViewHandler(function(threadView1){
      var threadClicked = threadView1.getThreadIDAsync();
      console.log(threadClicked);

      threadView1.addButton({
        title: "Send to Maintenance2",
        iconUrl: chrome.extension.getURL('images/nt48.png'),
        onClick: function(event) {
          threadView1.addLabel({
            title: "Sent to Maintenance",
            iconUrl: chrome.extension.getURL('images/nt48.png'),
            backgroundColor: "#67B246",
            foregroundColor: "#fff"
          })
          console.log("threadView1 onClick: " + threadClicked);
          threadClicked.then(function(result) {
            openInNewTab('https://maintenance.newtelco.de/addedit?gmid=' + result);
            console.log("threadView1 2: " + result);
          })

        },
      });

    });

    function openInNewTab(url) {
        var win = window.open(url, '_blank');
        // win.focus();
    }


});

// Select pages with context menu enabled
var showForPages = ["http://mail.google.com/*","https://mail.google.com/*"];

// Set up context menu at install time.
chrome.runtime.onInstalled.addListener(function() {
  var context = "editable";
  var title = "Append clipboard as HTML";
  var id = chrome.contextMenus.create({"title": title, "contexts":[context],
                                        "documentUrlPatterns":showForPages,
                                        "id": "context" + context });
});

// Add click event
chrome.contextMenus.onClicked.addListener(onClickHandler);

chrome.commands.onCommand.addListener(function(command) {
  console.log("Command2: ", command);
  if(command=="html_paste"){
    chrome.tabs.query({active: true, currentWindow: true}, function(tabs){
      // console.log(tabs);
      chrome.tabs.sendMessage(tabs[0].id, {action: "pasteHTML"}, function(resp) {
        console.log(resp);   
      });
      console.log("Tabs[0]: ",tabs[0].id);
    });
  }
  //if (request.action == 'pasteHTML') {
    //checkIfCanInsertHTML();
  //}
});
// The onClicked callback function.
function onClickHandler(info, tab) {
  // Notify the current tab that the context item has been clicked
  chrome.tabs.query({active: true, currentWindow: true}, function(tabs){
    chrome.tabs.sendMessage(tab.id, {action: "pasteHTML"});
  });
};

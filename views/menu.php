<?php
if(isset($_POST['label']) || isset($_SESSION['label'])) {
  if(! empty($_POST['label'])) {
  $labelID = $_POST['label'];
  $_SESSION['label'] = $labelID;
  } else {
    $labelID = $_SESSION['label'];
  }
} else {
  if(isset($_COOKIE['label'])) {
    $labelID = $_COOKIE['label'];
  } else {
    $labelID = '0';
  }
}

if (isset($_SESSION['endlabel'])) {
  $gmailLabelAdd = $_SESSION['endlabel'];
} else if(isset($_COOKIE['endlabel'])){
  $gmailLabelAdd = $_COOKIE['endlabel'];
} else {
  $gmailLabelAdd = 'Choose label for \"completed mails\" in settings!';
}


$service3 = new Google_Service_Gmail($clientService);

if ($labelID != '0') {
  $results3 = $service3->users_labels->get($user,$labelID);
}

if ($gmailLabelAdd != 'Choose label for \"completed mails\" in settings!') {
  $results4 = $service3->users_labels->get($user,$gmailLabelAdd);
}

?>

<div class="mdl-layout__drawer">
  <span class="mdl-layout-title"><img src="/dist/images/newtelco_black.png"/></span>
  <nav class="mdl-navigation">
    <a class="mdl-navigation__link homeLink" href="index.php"><img src="/dist/images/svg/home.svg" class="ndl-home"/>  Home</a>
    <a class="mdl-navigation__link historyLink" href="overview.php"><img src="/dist/images/svg/overview.svg" class="ndl-overview"/>  History</a>
    <a class="mdl-navigation__link incomingLink" href="incoming.php"><img src="/dist/images/svg/ballot.svg" class="ndl-ballot mdl-badge mdl-badge--overlap" data-badge="3"/>  Incoming<div class="material-icons mdl-badge mdl-badge--overlap menuSubLabel2" data-badge="<?php if ($labelID != '0') { if ($results3['messagesUnread'] == 0) { echo "♥"; } else { echo $results3['messagesUnread']; }} else {  echo "♥"; } ?>"></div></a></a>
    <a class="mdl-navigation__link group1Link" href="group.php"><img src="/dist/images/svg/group.svg" class="ndl-group1"/>  Group <small class="menuSubLabel">maintenance</small></a>
    <a class="mdl-navigation__link group2Link" href="groupservice.php"><img src="/dist/images/svg/group.svg" class="ndl-group2"/>  Group <small class="menuSubLabel">service</small></a>
    <a class="mdl-navigation__link calendarLink" href="calendar.php"><img src="/dist/images/svg/calendar.svg" class="ndl-calendar"/>  Calendar</a>
    <a class="mdl-navigation__link crmLink" href="crm_iframe.php"><img src="/dist/images/svg/work.svg" class="ndl-work"/>  CRM</a>
    <a class="mdl-navigation__link settingsLink" href="settings.php"><img src="/dist/images/svg/settings.svg" class="ndl-settings"/>  Settings</a>
    <div class="mdl-layout-spacer"></div>
    <a class="mdl-navigation__link menu_logout" href="?logout">
      <button id="menuLogout" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored">
        <span style="margin-left: 5px;" class="mdi mdi-24px mdi-logout mdi-light"></span>
      </button>
      <div class="mdl-tooltip  mdl-tooltip--top" data-mdl-for="menuLogout">
        Logout
      </div>
    </a>
  </nav>
  <script>
    $('.homeLink').hover( function() {
        $('.ndl-home').toggleClass('hvr-grow2');
    });
    $('.historyLink').hover( function() {
        $('.ndl-overview').toggleClass('hvr-grow2');
    });
    $('.incomingLink').hover( function() {
        $('.ndl-ballot').toggleClass('hvr-grow2');
    });
    $('.group1Link').hover( function() {
        $('.ndl-group1').toggleClass('hvr-grow2');
    });
    $('.group2Link').hover( function() {
        $('.ndl-group2').toggleClass('hvr-grow2');
    });
    $('.calendarLink').hover( function() {
        $('.ndl-calendar').toggleClass('hvr-grow2');
    });
    $('.crmLink').hover( function() {
        $('.ndl-work').toggleClass('hvr-grow2');
    });
    $('.settingsLink').hover( function() {
        $('.ndl-settings').toggleClass('hvr-grow2');
    }); 

    // alt + r - open menu
    var codeset = { 82: false, 18: false };
    // alt + h - open history directly
    var codeset3 = { 72: false, 18: false };
    // alt + i - open incoming directly
    var codeset4 = { 73: false, 18: false };
    $(document).on('keydown', function (e) {
      console.log(e.keyCode);
      if (e.keyCode in codeset) {
        codeset[e.keyCode] = true;
        if (codeset[82] && codeset[18]) {
          $('.mdl-layout__drawer').toggleClass('is-visible');
          $('.mdl-layout__obfuscator').toggleClass('is-visible');
        }
      } else if (e.keyCode in codeset3) {
        codeset3[e.keyCode] = true;
        if (codeset3[72] && codeset3[18]) {
          // alt + h
          
          window.location.href = 'https://maintenance.newtelco.de/overview';
        }
      } else if (e.keyCode in codeset4) {
        codeset4[e.keyCode] = true;
        if (codeset4[73] && codeset4[18]) {
          // alt + i
          window.location.href = 'https://maintenance.newtelco.de/incoming';
        }
      }
    }).on('keyup', function (e) {
      if (e.keyCode in codeset) {
        codeset[e.keyCode] = false;
      } else if (e.keyCode in codeset3) {
        codeset3[e.keyCode] = false;
      } else if (e.keyCode in codeset4) {
        codeset4[e.keyCode] = false;
      }
    });

  </script>
</div>

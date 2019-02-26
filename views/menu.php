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
    <a class="mdl-navigation__link incomingLink" href="incoming.php"><img src="/dist/images/svg/ballot.svg" class="ndl-ballot mdl-badge mdl-badge--overlap" data-badge="3"/>  Incoming<div class="material-icons mdl-badge mdl-badge--overlap menuSubLabel2" data-badge="<?php if ($labelID != '0') { if ($results3['messagesUnread'] == 0) { echo "ϟ"; } else { echo $results3['messagesUnread']; }} else {  echo "♥"; } ?>"></div></a></a>
    <a class="mdl-navigation__link group1Link" href="group.php"><img src="/dist/images/svg/group.svg" class="ndl-group1"/>  Group <small class="menuSubLabel">maintenance</small></a>
    <a class="mdl-navigation__link group2Link" href="groupservice.php"><img src="/dist/images/svg/group.svg" class="ndl-group2"/>  Group <small class="menuSubLabel">service</small></a>
    <a class="mdl-navigation__link calendarLink" href="calendar.php"><img src="/dist/images/svg/calendar.svg" class="ndl-calendar"/>  Calendar</a>
    <a class="mdl-navigation__link crmLink" target="_blank" href="https://crm.newtelco.de"><img src="/dist/images/svg/work.svg" class="ndl-work"/>  CRM</a>
    <a class="mdl-navigation__link settingsLink" href="settings.php"><img src="/dist/images/svg/settings.svg" class="ndl-settings"/>  Settings</a>
    <div class="mdl-layout-spacer"></div>
    <div class="shortcutText">
      <font style="font-size:10px; color:rgba(0,0,0,0.5);">for keyboard shortcuts press (?)</font>
    </div>
  </nav>
  <!-- keymaster.js -->
  <script rel="preload" as="script" src="dist/js/keymaster.js"></script>
  <!-- favicon.js -->
  <script rel="preload" as="script" src="dist/js/favicon.js"></script>
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

    key('alt+r', function(){ $('.mdl-layout__drawer').toggleClass('is-visible'); $('.mdl-layout__obfuscator').toggleClass('is-visible'); return false });
    key('alt+h', function(){ window.location.href = 'https://maintenance.newtelco.de/index'; return false });
    key('alt+o', function(){ window.location.href = 'https://maintenance.newtelco.de/overview'; return false });
    key('alt+i', function(){ window.location.href = 'https://maintenance.newtelco.de/incoming'; return false });
    key('alt+m', function(){ $('.mdl-menu__container').toggleClass('is-visible'); return false });
    key('shift+c', function(){ window.location.href = 'https://maintenance.newtelco.de/addedit'; });

    $(document.body).on('keypress', function(e) {
      if (e.charCode === 63) {
        $('.md-modal').toggleClass('md-show');
        $('.mdl-layout__header').toggleClass('blur4');
        $('.mdl-layout__drawer').toggleClass('blur4');
        $('.mdl-layout__content').toggleClass('blur4');
        $('.mdl-mini-footer').toggleClass('blur4');
        return false;
      }
    });

    $(document).mouseup(function(e) {
        var container = $('.md-modal');
        if (!container.is(e.target) && container.has(e.target).length === 0 && container.hasClass('md-show')) {
          container.removeClass('md-show');
          $('.mdl-layout__header').toggleClass('blur4');
          $('.mdl-layout__drawer').toggleClass('blur4');
          $('.mdl-layout__content').toggleClass('blur4');
          $('.mdl-mini-footer').toggleClass('blur4');
        }
    });

    $(document).ready(function() {

    // dynamic favicon
    var unreadCounter = $('.menuSubLabel2').attr('data-badge');
    if(unreadCounter !== 'ϟ') {
        var favNumber = unreadCounter;
        var favicon=new Favico({
            animation:'slide'
        });
        favicon.badge(favNumber);
      }
    });

  </script>
</div>

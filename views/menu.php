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
    <a class="mdl-navigation__link" href="index.php"><span class="ndl-home"></span>  Home</a>
    <!-- <a class="mdl-navigation__link" href="userhome.php"><i class="ndl-face"></i>  <?php echo $token_data['name'] ?></a> -->
    <a class="mdl-navigation__link" href="overview.php"><i class="ndl-overview"></i>  Overview</a>
    <a class="mdl-navigation__link" href="incoming.php"><i class="ndl-ballot mdl-badge mdl-badge--overlap" data-badge="3"></i>  Incoming<div class="material-icons mdl-badge mdl-badge--overlap menuSubLabel2" data-badge="<?php if ($labelID != '0') { if ($results3['messagesUnread'] == 0) { echo "♥"; } else { echo $results3['messagesUnread']; }} else {  echo "♥"; } ?>"></div></a></a>
    <a class="mdl-navigation__link" href="group.php"><i class="ndl-group"></i>  Group <small class="menuSubLabel">maintenance</small></a>
    <a class="mdl-navigation__link" href="groupservice.php"><i class="ndl-group"></i>  Group <small class="menuSubLabel">service</small></a>
    <a class="mdl-navigation__link" href="calendar.php"><i class="ndl-calendar"></i></i>  Calendar</a>
    <a class="mdl-navigation__link" href="crm_iframe.php"><i class="ndl-work"></i>  CRM</a>
    <a class="mdl-navigation__link" href="settings.php"><i class="ndl-settings"></i>  Settings</a>
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
</div>

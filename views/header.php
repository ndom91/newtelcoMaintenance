<?php

use \Rollbar\Rollbar;
use \Rollbar\Payload\Level;
$username = $token_data['email'];
$userID = '';
if ($username == 'ndomino@newtelco.de') {
    $userID = 1;
} else if ($username == 'fwaleska@newtelco.de') {
    $userID = 2;
} else if ($username == 'sstergiou@newtelco.de') {
    $userID = 3;
} else if ($username == 'alissitsin@newtelco.de') {
    $userID = 4;
}
$person = array("id"=>$userID,"email"=>$username);
Rollbar::init(
    array(
        'access_token' => 'e0dbc12159df4dd3a6087170e3a8ace0',
        'environment' => 'production',
        'capture_username' => true,
        'person' => $person 
    )
);

?>
<header class="mdl-layout__header mdl-color--light-green-nt">
  <div class="mdl-layout__header-row">
    <div class="mdl-layout-title2 hvr-grow">
    <img style="margin-right: 10px" src="dist/images/nt_square32_2_light2.png"/>
    <span class="mdl-layout-title">Maintenance</span>
    </div>
    <script>
      $(".mdl-layout-title2").click(function(){
        window.location.replace("https://"+window.location.hostname+"/index");
      });
    </script>
    <div class="col">
      <div class="con">
        <div class="bar arrow-top"></div>
        <div class="bar arrow-middle"></div>
        <div class="bar arrow-bottom"></div>
      </div>
    </div>
    <div style="margin-left:10px;font-size:10px;height:40px;max-width:55%">
    <?php 
      // printf($debugpubsub);
      // var_dump($messages);
    ?>
    </div>
    <div class="mdl-layout-spacer"></div>
    <div class="menu_userdetails">
      <button id="user-profile-menu" class="mdl-button mdl-js-button mdl-userprofile-button">
        <img class="hvr-rotate menu_userphoto" src="
        <?php 
        // var_dump($token_data['email']);
        if ($token_data['email'] == 'alissitsin@newtelco.de') {
          echo '/dist/images/icons/ali_round.png';
        } else if ($token_data['email'] == 'fwaleska@newtelco.de') {
          echo '/dist/images/icons/fwa_round.png';
        } else if ($token_data['email'] == 'sstergiou@newtelco.de') {
          echo '/dist/images/icons/sst_round.png';
        } else if ($token_data['email'] == 'ndomino@newtelco.de') {
          echo '/dist/images/icons/ndo_round.png';
        }  else if ($token_data['email'] == 'jskribek@newtelco.de') {
          echo '/dist/images/icons/jsk_round.png';
        }   else if ($token_data['email'] == 'kmoeller@newtelco.de') {
          echo '/dist/images/icons/kmo_round.png';
        }    else if ($token_data['email'] == 'jharfert@newtelco.de') {
          echo '/dist/images/icons/jha_round.png';
        }     else if ($token_data['email'] == 'nchachua@newtelco.de') {
          echo '/dist/images/icons/nch_round.png';
        }      else if ($token_data['email'] == 'kkoester@newtelco.de') {
          echo '/dist/images/icons/kko_round.png';
        }        
        // for echoing google picture directly
        // echo $token_data['picture'] 
        ?>"/>
        <span class="mdl-layout-subtitle menumail"> <?php echo $token_data['email'] ?>
          <i class="fas fa-angle-down menuangle"></i>
        </span>        
      </button>
        <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
            for="user-profile-menu">
          <a class="usermenuhref" href="calendar">
            <li id="submenuCal" class="mdl-menu__item">
              Calendar
              <span class="mdi mdi-24px mdi-calendar-text mdi-dark mdi-inactive"></span>
            </li>
          </a>
          <!-- <div class="mdl-tooltip mdl-tooltip--bottom" data-mdl-for="submenuCal">
            <span class='mdi mdi-24px mdi-keyboard'></span> <span style="vertical-align:top;font-size:12px;">(c)</span>
          </div> -->
          <a class="usermenuhref" href="settings">
            <li id="submenuSettings" class="mdl-menu__item">
              Settings
              <span class="mdi mdi-24px mdi-settings-outline mdi-dark mdi-inactive"></span>
            </li>
          </a>
          <!-- <div class="mdl-tooltip mdl-tooltip--left" style="z-index:10 !important;" data-mdl-for="submenuSettings">
            <span class='mdi mdi-24px mdi-keyboard'></span> <span style="vertical-align:top;font-size:12px;">(s)</span>
          </div> -->
          <li>
            <div class="mailcHR3"></div>
          </li>
          <a class="usermenuhref" href="?logout">
            <li id="submenuLogout" class="mdl-menu__item">
              Logout
              <span class="mdi mdi-24px mdi-logout mdi-dark mdi-inactive"></span>
            </li>
          </a>
          <!-- <div class="mdl-tooltip mdl-tooltip--top" data-mdl-for="submenuLogout">
            <span class='mdi mdi-24px mdi-keyboard'></span> <span style="vertical-align:top;font-size:12px;">(l)</span>
          </div> -->
        </ul>
    </div>
  </div>
</header>

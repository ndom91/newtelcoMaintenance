<header class="mdl-layout__header mdl-color--light-green-nt">
  <div class="mdl-layout__header-row">
    <div class="mdl-layout-title2 hvr-grow">
    <img style="margin-right: 10px" src="dist/images/nt_square32_2_light2.png"/>
    <span class="mdl-layout-title">Maintenance</span>
    </div>
    <script>
      $(".mdl-layout-title2").click(function(){
        window.location.replace("https://maintenance.newtelco.de/index");
      });
    </script>
    <div class="col">
      <div class="con">
        <div class="bar arrow-top"></div>
        <div class="bar arrow-middle"></div>
        <div class="bar arrow-bottom"></div>
      </div>
    </div>
    <div class="mdl-layout-spacer"></div>
    <div class="menu_userdetails">
      <button id="user-profile-menu" class="mdl-button mdl-js-button mdl-userprofile-button">
        <img class="hvr-rotate menu_userphoto" src="<?php echo $token_data['picture'] ?>"/>
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
          <div class="mdl-tooltip mdl-tooltip--bottom" data-mdl-for="submenuCal">
            <span class='mdi mdi-24px mdi-keyboard'></span> <span style="vertical-align:top;font-size:12px;">(c)</span>
          </div>
          <a class="usermenuhref" href="settings">
            <li id="submenuSettings" class="mdl-menu__item">
              Settings
              <span class="mdi mdi-24px mdi-settings-outline mdi-dark mdi-inactive"></span>
            </li>
          </a>
          <div class="mdl-tooltip mdl-tooltip--left" style="z-index:10 !important;" data-mdl-for="submenuSettings">
            <span class='mdi mdi-24px mdi-keyboard'></span> <span style="vertical-align:top;font-size:12px;">(s)</span>
          </div>
          <li>
            <div class="mailcHR3"></div>
          </li>
          <a class="usermenuhref" href="?logout">
            <li id="submenuLogout" class="mdl-menu__item">
              Logout
              <span class="mdi mdi-24px mdi-logout mdi-dark mdi-inactive"></span>
            </li>
          </a>
          <div class="mdl-tooltip mdl-tooltip--top" data-mdl-for="submenuLogout">
            <span class='mdi mdi-24px mdi-keyboard'></span> <span style="vertical-align:top;font-size:12px;">(l)</span>
          </div>
        </ul>
    </div>
  </div>
</header>

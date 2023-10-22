
const loadCookieConsent = function () {

  /*-----------------------------------------------------------------------------------*/
  /* ADD DIALOG HTML */
  /*-----------------------------------------------------------------------------------*/

  const addDialog = document.createElement("div");
  addDialog.id = ('cookieConsent');
  addDialog.innerHTML = "{{load path='./src/html/dialog.html'}}"; //injected with gulp
  addDialog.className = ('cookie-dialog');
  document.body.prepend(addDialog);


  /*-----------------------------------------------------------------------------------*/
  /* GET & ADD COOKIES */
  /*-----------------------------------------------------------------------------------*/

  window.getCookie = function(name) {
    let nameEQ = name + "=";
    let ca = document.cookie.split(';');
    for(let i=0;i < ca.length;i++) {
      let c = ca[i];
      while (c.charAt(0)==' ') c = c.substring(1,c.length);
      if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
  }

  function addCookie(name) {
    let now = new Date();
    let time = now.getTime();
    let expireTime = time + 180*24*60*60*1000;
    now.setTime(expireTime);
    document.cookie = name + '=null; Path=/; Expires=' + now.toGMTString();
  }


  /*-----------------------------------------------------------------------------------*/
  /* DIALOG CONTROLS */
  /*-----------------------------------------------------------------------------------*/

  const resetButton = document.getElementById("resetCookieConsent");
  const manageButton = document.getElementById("manageCookies");
  const options = document.getElementById("optionsCookies");
  const dialog = document.getElementById("cookieConsent");

  function manageCookies() {
    options.classList.toggle("cookie-dialog__options--open");
    if(options.classList.contains("cookie-dialog__options--open")) {
      manageButton.innerHTML = "Close Options";
    } else {
      manageButton.innerHTML = "More Options";
    }
  }

  manageButton.addEventListener('click', manageCookies);

  function resetCookieConsent() {
    document.cookie = 'cookieConsent' + '=null; Path=/;';
    window.location.reload();
  }

  if(resetButton) {
    resetButton.addEventListener('click', resetCookieConsent);
  }


  /*-----------------------------------------------------------------------------------*/
  /* ACCESSIBILITY CONTROLS */
  /*-----------------------------------------------------------------------------------*/

  const pressed = document.querySelectorAll('[aria-pressed]');

  pressed.forEach(function(press) {

    press.addEventListener('click', (e) => {  
      let pressed = e.target.getAttribute('aria-pressed') === 'true';
      e.target.setAttribute('aria-pressed', String(!pressed));
    });

  });

  const expanded = document.querySelectorAll('[aria-expanded]');

  expanded.forEach(function(expand) {

    expand.addEventListener('click', (e) => {  
      let expanded = e.target.getAttribute('aria-expanded') === 'true';
      e.target.setAttribute('aria-expanded', String(!expanded));
    });

  });


  /*-----------------------------------------------------------------------------------*/
  /* OPTIONS CONTROLS */
  /*-----------------------------------------------------------------------------------*/

  const triggers = document.querySelectorAll('[data-toggle="collapse"]');

  triggers.forEach(function(trigger) {

    trigger.addEventListener('click', function(e) {

      const btn = e.target;
      const selector = btn.getAttribute('data-target');
      collapse(selector, 'toggle');

      if (btn.innerText === 'Info'){
        btn.innerText = 'Close';
      } else{
        btn.innerText = 'Info';
      }

    }, false);

    const collapse = (selector) => {
      const targets = Array.from(document.querySelectorAll(selector));
      targets.forEach(target => {
        if(target.classList.contains("cookie-dialog__description--open")) {
          target.classList.remove('cookie-dialog__description--open');
        } else {
          target.classList.add('cookie-dialog__description--open');
        }
      });
    }

  });


  /*-----------------------------------------------------------------------------------*/
  /* DIALOG SHOW/HIDE LISTENER */
  /*-----------------------------------------------------------------------------------*/

  window.addEventListener('load', function() {

    const cookieConsent = getCookie('cookieConsent');

    if (!cookieConsent) {

      addCookie('cookieConsent'); 
      dialog.classList.add("cookie-dialog--active");

    } else if (cookieConsent == 'true') {

      dialog.classList.remove("cookie-dialog--active");

    } else if (cookieConsent == 'false') {

      dialog.classList.remove("cookie-dialog--active");

    } else if (cookieConsent == 'null'){

      dialog.classList.add("cookie-dialog--active");

    }

  });

};

loadCookieConsent();

let setCookieConsent;
let timeout = 100;

setCookieConsent = function (id) {

  setTimeout(function () {
    timeout--;
    if (typeof loadCookieConsent !== 'undefined') {


      /*-----------------------------------------------------------------------------------*/
      /* POLICY LINK OPTIONS */
      /*-----------------------------------------------------------------------------------*/

      var policy = document.getElementById("cookiePolicy");

      if( id.policy_url ){
        policy.setAttribute('href', id.policy_url);
      }

      if( id.policy_link ){
        policy.innerHTML = id.policy_link;
      }


      /*-----------------------------------------------------------------------------------*/
      /* GOOGLE AND FACEBOOK SETTINGS */
      /*-----------------------------------------------------------------------------------*/

      if( id.tag ){

        window.dataLayer = window.dataLayer || [];

        function gtag(){dataLayer.push(arguments);}

        gtag('consent', 'default', {
          'ad_storage': 'granted',
          'analytics_storage': 'denied',
          'wait_for_update': 500
        });

        gtag('set', 'url_passthrough', true); 

        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer', id.tag);

      }

      if( id.pixel ){

        ! function(f, b, e, v, n, t, s) {
        if (f.fbq) return;
        n = f.fbq = function() {
          n.callMethod ?
            n.callMethod.apply(n, arguments) : n.queue.push(arguments)
        };
        if (!f._fbq) f._fbq = n;
        n.push = n;
        n.loaded = !0;
        n.version = '2.0';
        n.queue = [];
        t = b.createElement(e);
        t.async = !0;
        t.src = v;
        s = b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t, s)
        }(window, document, 'script','https://connect.facebook.net/en_US/fbevents.js');

      }

      const cookieConsent = getCookie('cookieConsent')
      
      if (!cookieConsent) {
        
      } else if (cookieConsent == 'true') {

        if( id.tag ){

          gtag('consent', 'update', {
            'ad_storage': 'granted',
            'analytics_storage': 'granted'
          });

        }

        if( id.pixel ){

          fbq('consent', 'grant');
          fbq('init', id.pixel);
          fbq('track', 'PageView');

        }
    
      } else if (cookieConsent == 'false') {

        if( id.tag ){

          gtag('consent', 'update', {
            'ad_storage': 'denied',
            'analytics_storage': 'denied'
          });

        }

        if( id.pixel ){

          fbq('consent', 'revoke');
          fbq('init', id.pixel);
          fbq('track', 'PageView');

        }

      } else if (cookieConsent == 'null') {

        if( id.tag ){

          gtag('consent', 'update', {
            'ad_storage': 'granted',
            'analytics_storage': 'denied'
          });

        }

        if( id.pixel ){

          fbq('consent', 'revoke');
          fbq('init', id.pixel);
          fbq('track', 'PageView');

        }

      }

      
      /*-----------------------------------------------------------------------------------*/
      /* CONSENT CONTROLS */
      /*-----------------------------------------------------------------------------------*/

      function acceptCookies() {

        if( id.tag ){

          dataLayer.push({
            event: 'pageview'
          });

          gtag('consent', 'update', {
            'ad_storage': 'granted',
            'analytics_storage': 'granted'
          });

        }

        if( id.pixel ){

          fbq('consent', 'grant');
          fbq('init', id.pixel);
          fbq('track', 'PageView');

        }

        dialog.classList.remove("cookie-dialog--active"); 
        document.cookie = 'cookieConsent' + '=true; Path=/;';

      }
  
      function declineCookies() {

        if( id.tag ){

          dataLayer.push({
            event: 'pageview'
          });

          gtag('consent', 'update', {
            'ad_storage': 'denied',
            'analytics_storage': 'denied'
          });

        }

        if( id.pixel ){

          fbq('consent', 'revoke');
          fbq('init', id.pixel);
          fbq('track', 'PageView');

        }

        dialog.classList.remove("cookie-dialog--active");
        document.cookie = 'cookieConsent' + '=false; Path=/;';

      }
  
      const dialog = document.getElementById("cookieConsent");
      const acceptButton = document.getElementById("acceptCookies");
      const manageButton = document.getElementById("manageCookies");
      const checkboxs = document.querySelectorAll('.cookie-dialog__checkbox');

      acceptButton.addEventListener('click', acceptCookies);

      checkboxs.forEach(function(checkbox) {

        checkbox.addEventListener( "change", function() {

          manageButton.innerText = 'Save Options';

          if (checkbox.checked == false ){
            manageButton.addEventListener('click', declineCookies);
          } else {
            manageButton.addEventListener('click', acceptCookies);
          }

        });

      });

    } else if (timeout > 0) {
      setCookieConsent();
    } else {
      console.log('No Cookie Script Loaded')
    }

  }, 100);

};
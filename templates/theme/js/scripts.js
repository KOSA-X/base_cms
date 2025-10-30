document.addEventListener("DOMContentLoaded", () => {
  const lenis = new Lenis({
    duration: 0,
    easing: t => t,
    smooth: true,
    smoothTouch: false
  });

  const parallaxItems = [
    { selector: '.imageParallax', scale: 1.2, strength: 0.1, max: 100, inverse: true, target: 'img' },
    { selector: '.contentParallax', scale: 1, strength: 0.1, max: 30, inverse: true },
    { selector: '.contentParallaxInverse', scale: 1, strength: 0.1, max: 20, inverse: false }
  ];

  function updateParallax(scrollY) {
    const winH = window.innerHeight;

    parallaxItems.forEach(({ selector, scale, strength, max, inverse, target }) => {
      $(selector).each(function () {
        const $el = $(this);
        const $target = target ? $el.find(target) : $el;
        const elOffset = $el.offset().top;
        const elHeight = $el.outerHeight();

        const elCenter = elOffset + elHeight / 2;
        const viewportCenter = scrollY + winH / 2;

        const dist = elCenter - viewportCenter;
        const movement = Math.max(-max, Math.min(max, (inverse ? -dist : dist) * strength));

        $target.css('transform', `scale(${scale}) translateY(${movement}px)`);
      });
    });
  }

  function raf(time) {
    lenis.raf(time);
    updateParallax(window.scrollY); // lub lenis.scroll jeśli preferujesz
    requestAnimationFrame(raf);
  }

  requestAnimationFrame(raf);
});


// FILTROWANIE ELEMENTOW PORTFOLIO

jQuery($ => {
  const $btns = $('.project__categoryFilter a');
  const $items = $('.projectsList li');

  function filter(cat) {
    $btns.removeClass('is-active').attr('aria-current', 'false');
    $btns.filter(`[href="#category-${cat}"]`)
         .addClass('is-active').attr('aria-current', 'true');

    if (cat === 'all') $items.stop().fadeIn(500);
    else $items.hide().filter(`[category="${cat}"]`).stop().fadeIn(500);
  }

  $btns.on('click', e => {
    e.preventDefault();
    const cat = $(e.currentTarget).attr('href').replace('#category-', '');
    history.replaceState(null, '', `#category-${cat}`);
    filter(cat);
  });

  $(window).on('hashchange', () =>
    filter(location.hash.replace('#category-', '') || 'all')
  );

  filter(location.hash.replace('#category-', '') || 'all');
});






$(document).ready(function() {
    
     
     var video = $(".videoHeader__background").get(0);
    if (video && video.paused) {
        video.play().catch(function(error) {
            console.log("Autoplay zablokowany:", error);
        });
    }
    
    let lastScrollTop = 0;
    $(window).on("scroll", function() {
        requestAnimationFrame(() => {
            let scrolled = $(this).scrollTop();
            let opacity = Math.max(0.7 - (scrolled * 0.001), 0); // Maksymalne opacity 0.5

            if (scrolled !== lastScrollTop) {
                $(".videoHeader__background").css("opacity", opacity);
                lastScrollTop = scrolled;
            }
        });
    });
    
 
    
    const toggleSwitch = $('#theme-switch-checkbox');

    function applyTheme(theme) {
        if (theme === 'dark') {
            $('body').addClass('dark-mode');
            toggleSwitch.prop('checked', true);
        } else {
            $('body').removeClass('dark-mode');
            toggleSwitch.prop('checked', false);
        }
        document.cookie = `theme=${theme}; path=/; max-age=31536000`; // Zapis w cookies na rok
    }

    function getThemeFromCookie() {
        const cookies = document.cookie.split('; ');
        const themeCookie = cookies.find(row => row.startsWith('theme='));
        return themeCookie ? themeCookie.split('=')[1] : null;
    }

    // Odczyt i ustawienie motywu na starcie
    const savedTheme = getThemeFromCookie() || 'light';
    applyTheme(savedTheme);

    // Obsługa przełącznika
    toggleSwitch.on('change', function() {
        const newTheme = toggleSwitch.is(':checked') ? 'dark' : 'light';
        applyTheme(newTheme);
    });

 
    
    // MENU MOBILNE
    $('.menuHamburger').click (function(){
        $(this).toggleClass('open');
        $('.mainHeader').toggleClass('menu_show');
        $('.mainHeader__menu').toggleClass('open');
        $('.mainBody, .mainFooter').toggleClass('blurEffect');
        
    });
    
    
    
    function initHoverEffect() {
      if ($(window).width() > 1200) {
        $('.menu_item_submenu').hover(
          function() {
            $(this).addClass('hover');
            $('.mainBody').addClass('blurEffect');
            $('.videoHeader').addClass('blurEffect');
          },
          function() {
            $(this).removeClass('hover');
            $('.mainBody').removeClass('blurEffect');
            $('.videoHeader').removeClass('blurEffect');
          }
        );
      } else {
        // Usuwamy hover jeśli było dodane wcześniej
        $('.menu_item_submenu').off('mouseenter mouseleave');
      }
    }

    $(document).ready(function() {
      initHoverEffect();
      $(window).resize(function() {
        initHoverEffect();
      });
    });
    
     // MENU MOBILNE
    $('.widget__arrow').click (function(){
        $(this).toggleClass("open");
        $(this).parent().parent().toggleClass("open");
    });
    
 
    
      // Inicjalizacja: dla każdej listy otwórz pierwszą pozycję,
// o ile w tej liście nie ma już pozycji z klasą "open".
$('.accordionList').each(function () {
  var $list = $(this);
  if ($list.find('.accordionItem__title.open').length === 0) {
    $list.find('li:first-child .accordionItem__content').show();
    $list.find('li:first-child .accordionItem__title').addClass('open');
  }
});

// Click handler z zawężeniem do klikniętej listy
$('.accordionItem__title').on('click', function () {
  var $header = $(this);
  var $content = $header.next('.accordionItem__content');
  var $list = $header.closest('.accordionList'); // <<< kluczowe

  if ($content.is(':visible')) {
    // Zamknij tylko klikniętą sekcję
    $content.slideUp();
    $header.removeClass('open');
  } else {
    // Zamknij pozostałe TYLKO w obrębie tej listy
    $list.find('.accordionItem__content:visible').slideUp();
    $list.find('.accordionItem__title.open').removeClass('open');

    // Otwórz klikniętą
    $content.slideDown();
    $header.addClass('open');
  }
});
//    
    
     
    
    $('.menu_arrow').click (function(){
        var id = $(this).attr("data-menu");
        $('#submenu_' + id).toggleClass('open');
    });
    
    $(".headerMenu__submenu .submenu_item.selected").parent().parent().parent().parent().addClass("selected");
    $(".headerMenu__submenu .submenu_item.selected").parent().parent().parent().addClass("open");
    
 
    $('.scrollTo').click (function(){
        var id = $(this).attr("data-id");
        event.preventDefault()
        $('html, body').animate({
            scrollTop: $("#section-"+id).offset().top
        }, 1000);
    });
    

    $('.faqItemCollapse').click (function(){
        var id = $(this).attr("data-id");
        event.preventDefault()
        $('.faqItem').removeClass('open');
         $('.faqItem-' + id).addClass('open');
    });
    
    
    
    
    // przyklejenie menu 
    $(document).scroll(function () {
        var y = $(this).scrollTop();
        if (y > 100) {
            $('.mainHeader').addClass('scroll');
        } else {
            $('.mainHeader').removeClass('scroll');
        }
    });
    
    
    
    ScrollReveal().reveal('.showUp',  {
        delay: 200,
        duration: 500,
        distance: 100,
        reset: true,
        scale: 1
    });
    
    Fancybox.bind("[data-fancybox]", {
      // Your custom options
    });
    
    


    
    $(document).scroll(function () {
        var y = $(this).scrollTop();
        if (y > 100) {
            $('.footerUp').addClass("show");   
            $('.mobileFooter').addClass("show");   
        }else{
            $('.footerUp').removeClass("show");   
            $('.mobileFooter').removeClass("show");   
        }
    });
    
     
    
        
});

 
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("input[type='text'], textarea").forEach(function (input) {
        input.addEventListener("keypress", function (event) {
            let char = String.fromCharCode(event.which);
            let regex = /^[a-zA-Z0-9\sąćęłńóśźżĄĆĘŁŃÓŚŹŻ\-\.]*$/; // Pozwala na litery, cyfry, spacje, polskie znaki diakrytyczne, myślniki i kropki
            
            if (!regex.test(char)) {
                event.preventDefault();
            }
        });
    });
});




// CART
// CART
// CART
 

$(document).ready(function() {
    function updateCart(productId, action, redirect = false) {
        $.post("/plugins/cart.php", { product_id: productId, action: action }, function(data) {
            if (redirect) {
                window.location.href = "./koszyk";
            } else {
                $(".cartListWrapper").load(window.location.href + " .cartListWrapper > *");
            }
        }, "json");
    }

    $(document).on("click", ".add-to-cart", function() {
        let $btn = $(this);
        let productId = $btn.data("product-id");

        if (!$btn.hasClass("button-active")) {
            updateCart(productId, "add");
            $btn.addClass("button-active").html("<img src='/images/icons/check.svg'>Koszyk");

            $(".cartIcon").addClass("active");
            setTimeout(() => $(".cartIcon").removeClass("active"), 500);

            $btn.off("click").on("click", () => window.location.href = "koszyk");
        } else {
            window.location.href = "/koszyk";
        }
    });

    $(document).on("click", ".add-to-cart-1", function() {
        updateCart($(this).data("product-id"), "add");
    });

    $(document).on("click", ".remove-from-cart", function() {
        updateCart($(this).data("product-id"), "remove");
    });

    $(document).on("click", ".delete-from-cart", function() {
        updateCart($(this).data("product-id"), "delete");
    });
});
 

// CART
// CART
// CART
// CART
// CART
 
    
$(document).ready(function() {
    
     $("html").click(function(event) {
        $(".lang-select").removeClass("open");
    });
      
    $(".lang-selected").click(function(e) {
        e.stopPropagation();
        $(".lang-select").toggleClass("open");
    });
      
    $(".lang-select-item").click(function(e) {
        e.stopPropagation();
        var dataVal = $(this).attr("data-val");
        var dataText = $(this).html();
        $(".lang-selected").attr("data-val", dataVal);
        $('.lang-selected img ').attr('src', '/images/icons/flag-' + dataVal + '.png');
        
//        $(".lang-selected").html(dataText);
        $(".lang-select").removeClass("open");
    });

    
    
     class GoogTrans {
        constructor() {
    
            this.events();
    
            this.currLng = this.readCookie('googtrans');
    
            if (this.currLng == "/en/pl") {
                this.setLng("pl");
            }
    
            if (this.currLng == "/en/en") {
                this.setLng("en");
            }
            if (this.currLng == "/en/uk") {
                this.setLng("uk");
            }
            if (this.currLng == "/en/ru") {
                this.setLng("ru");
            }
            if (this.currLng == "/en/de") {
                this.setLng("de");
            }
            
            if (this.currLng == "/fr/fr") {
                this.setLng("fr");
            }
            
        }
    
        events() {
    
            var self = this;                           
    
            document.querySelectorAll(".lang-select-item").forEach(function (item, index) {
    
                item.addEventListener("click", function (e) {
                    e.stopPropagation();
                    e.preventDefault()
                            
                    let lng = $(item).attr("data-val");                                        
                    
                    self.setLng(lng);
                });
            });
    
        }
    
        setLng(lng) {    
    
            if (lng === "pl") {
                jQuery('#\\:1\\.container').contents().find('#\\:1\\.restore').click(); //reset google translate                                          
            } else {
                jQuery('.goog-te-combo').val(lng);
                
                this.triggerHtmlEvent();
            }                                
    
            this.currLng = "/en/" + lng;
        }
    
    
        triggerHtmlEvent() {
            var event;
    
            try {
                let element = document.querySelector('.goog-te-combo');
                let eventName = "change";
        
                if (document.createEvent) {
                    event = document.createEvent('HTMLEvents');
                    event.initEvent(eventName, true, true);
                    element.dispatchEvent(event);            
                } else {
                    event = document.createEventObject();
                    event.eventType = eventName;
                    element.fireEvent('on' + event.eventType, event);            
                }
              }
              catch(err) {
                //err.message;
            }
         
        }
    
        readCookie(name) {
            var c = document.cookie.split('; '),
                cookies = {},
                i, C;
        
            for (i = c.length - 1; i >= 0; i--) {
                C = c[i].split('=');
                cookies[C[0]] = C[1];
            }
        
            return cookies[name];
        }
    
    }

    const googTrans = new GoogTrans();
    
    
    
        
});

// TŁUMACZENIA 
function googleTranslateElementInit() {
    new google.translate.TranslateElement({
        pageLanguage: 'pl',
        includedLanguages: 'en,pl,uk,de,fr', 
        layout: google.translate.TranslateElement.FloatPosition.SIMPLE
    }, 'google_translate_element');           
}
var first_load_lang = document.querySelector('html').getAttribute('lang');
var times_run = 0;
check_lang = setInterval(function(){
    times_run++;
    if(times_run >= 20){
        clearInterval(check_lang);
    }
    var lang = document.querySelector('html').getAttribute('lang');
    if(lang != first_load_lang) {
        jQuery('.lang-selected img ').attr('src', 'images/icons/flag-' + lang + '.png');
        clearInterval(check_lang);
    }
},200);
    
    
// COOCKIES
function WHCreateCookie(name, value, days) {
    var date = new Date();
    date.setTime(date.getTime() + (days*24*60*60*1000));
    var expires = "; expires=" + date.toGMTString();
	document.cookie = name+"="+value+expires+"; path=/";
}
function WHReadCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') c = c.substring(1, c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
	}
	return null;
}

window.onload = WHCheckCookies;

function WHCheckCookies() {
    if(WHReadCookie('cookies_accepted') != 'T') {
        var message_container = document.createElement('div');
        message_container.id = 'cookies-message-container';
        var html_code = '<div id="cookies-message"><img src="images/icons/info.svg" class="invert" alt="Informacja"><p>Korzystając z tej strony akceptujesz warunki zawarte w <a href="./?polityka-prywatnosci">Polityce Prywatności</a>.</p><a href="javascript:WHCloseCookiesWindow();" id="accept-cookies-checkbox" name="accept-cookies" class="button w-100">Akceptuję</a></div>';
        message_container.innerHTML = html_code;
        document.body.appendChild(message_container);
    }
}

function WHCloseCookiesWindow() {
    WHCreateCookie('cookies_accepted', 'T', 365);
    document.getElementById('cookies-message-container').removeChild(document.getElementById('cookies-message'));
}

/// Potwierdź wiek

//
//window.onload = checkAge;
//
//function checkAge() {
//    if(WHReadCookie('check_age') != 'T') {
//        var message_container = document.createElement('div');
//        message_container.id = 'age-message-container';
//        var html_code = '<div id="age-message"><h3>Potwierdź swój wiek</h3><p>Jeżeli chcesz skorzystać z naszej strony musisz mieć powyżej 18 lat.</p><a href="javascript:CloseWindowAge();" id="accept-age-checkbox" name="accept-age" class="button">Potwierdzam</a></div>';
//        message_container.innerHTML = html_code;
//        document.body.appendChild(message_container);
//    }
//}
//
//function CloseWindowAge() {
//    WHCreateCookie('check_age', 'T', 31);
//    document.getElementById('age-message-container').remove();
//}


 
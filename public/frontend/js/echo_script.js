//DYNAMIC HEIGHT
document.addEventListener('DOMContentLoaded', function() {
    var navbarHeight = document.querySelector('.navbar').offsetHeight;
    var headerGapElement = document.querySelector('.header_gap');
    var initialPaddingBottom = window.getComputedStyle(headerGapElement).paddingBottom;
    initialPaddingBottom = parseFloat(initialPaddingBottom) || 0;
    var newPaddingBottom = initialPaddingBottom + navbarHeight;
    headerGapElement.style.paddingBottom = newPaddingBottom + 'px';
    
    
    const footerMenuGrid = document.querySelector('.footer_menu_grid');
    const footer = document.querySelector('.footer');

    function checkPosition() {
        const footerRect = footer.getBoundingClientRect();
        const windowHeight = window.innerHeight;

        if (footerRect.top <= windowHeight) {
            footerMenuGrid.style.position = 'fixed';
        } else {
            footerMenuGrid.style.position = 'fixed';
            footerMenuGrid.style.bottom = '0';
        }
    }

    window.addEventListener('scroll', checkPosition);
    window.addEventListener('resize', checkPosition);
    checkPosition();

    if (window.matchMedia("(min-width: 768px)").matches) {
        var menuItems = document.querySelectorAll(".menu_item_div");
        menuItems.forEach(function(item) {
            var itemName = item.querySelector(".menu_item");
            var itemPrice = item.querySelector(".menu_price");
            var widthDiff = item.clientWidth - itemName.offsetWidth - itemPrice.offsetWidth;
            var dotsCount = Math.floor(widthDiff / 4.6);
            var dots = "";
            for (var i = 0; i < dotsCount; i++) {
                dots += ".";
            }
            itemName.insertAdjacentHTML("afterend", '<span class="menu_dots">' + dots + '</span>');
        });
    }
});


// OFFSET LINKS
$(document).ready(function() {
    var vm2Height = $('.vm2').outerHeight() || 0;
    var vm1Height = $('.vm1').outerHeight() || 0;
    var navbarHeight = $('.navbar').outerHeight() || 0;
    var footerMenuGridHeight = $('.footer_menu_grid').outerHeight() || 0;

    setupScrollLinks('a[href*="#"]:not([href="#"])', navbarHeight);
    setupScrollLinks('a.vm1_ahref[href*="#"]:not([href="#"])', vm1Height + navbarHeight);
    setupScrollLinks('a.vm2_ahref[href*="#"]:not([href="#"])', vm2Height + navbarHeight);
    $('.menu_table_tn').css('padding-bottom', (vm2Height + 15) + 'px');
    if ($(window).width() <= 767.98) {
        $('footer').css('padding-bottom', footerMenuGridHeight + 'px');
    }
});
function setupScrollLinks(selector, offset) {
    $(selector).on('click', function(e) {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') || location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                e.preventDefault();
                scrollToTarget(target, offset);
            }
        }
    });
}

function scrollToTarget(target, offset) {
    if (target.length) {
        $('html, body').scrollTop(target.offset().top - offset);
    }
}




// CUISINES CAROUSEL
$(document).ready(function(){
    $("#cuisine_items_lists").owlCarousel({
        items: 3,
        loop: true,
        margin: 10,
        responsiveClass: true,
        responsive:{
            0:{
                items: 2,
            },
            768:{
                items: 6,
            },
            1200:{
                items: 8,
            },
            1920:{
                items: 8,
            }
        },
        nav: true,
        dots: false
    });
});


// MENU CAT CAROUSEL
$(document).ready(function(){
    $("#menu_cat_items_lists").owlCarousel({
        items: 4,
        loop: true,
        margin: 5,
        nav: true,
        dots: false,
        responsiveClass: true,
        responsive:{
            0:{
                items: 3,
            },
            768:{
                items: 4,
            },
            1200:{
                items: 8,
            },
            1920:{
                items: 8,
            }
        },
    });
});

// OFFER CAROUSEL
$(document).ready(function(){
    $("#offer_items_lists").owlCarousel({
        items: 3,
        loop: true,
        margin: 10,
        responsiveClass: true,
        responsive:{
            0:{
                items: 1,
            },
            768:{
                items: 2,
            },
            1200:{
                items: 4,
            },
            1920:{
                items: 4,
            }
        },
        nav: true,
        dots: false
    });
});


// REVIEWS CAROUSEL
$(document).ready(function(){
    $("#reviews_items_lists").owlCarousel({
        items: 3,
        loop: true,
        margin: 40,
        responsiveClass: true,
        responsive:{
            0:{
                items: 1,
            },
            768:{
                items: 2,
            },
            1200:{
                items: 4,
            },
            1920:{
                items: 4,
            }
        },
        nav: true,
        dots: false
    });
});



//READ MORE + READ LESS
document.addEventListener("DOMContentLoaded", function () {
    if (isMobileDevice()) {
        var maxLength = 80;
        var paragraphs = document.querySelectorAll('.menu_desc');
        paragraphs.forEach(function (paragraph) {
            var content = paragraph.innerHTML;
            if (content.length > maxLength) {
                var truncatedContent = content.substr(0, maxLength);
                var remainingContent = content.substr(maxLength);
                paragraph.innerHTML = truncatedContent +
                    '<span class="read-more-content">' + remainingContent + '</span>' +
                    '<span class="read-more-toggle" onclick="toggleReadMore(this)"> Read More</span>';
            }
        });
    }
});
function isMobileDevice() {
    return window.innerWidth <= 768;
}
function toggleReadMore(button) {
    var content = button.previousElementSibling;
    var toggleText = button.innerHTML;

    if (toggleText === ' Read More') {
        content.style.display = 'inline';
        button.innerHTML = ' Read Less';
    } else {
        content.style.display = 'none';
        button.innerHTML = ' Read More';
    }
}


//ADD QUANTITY
function toggleProductQuantity(button) {
    var productContainer = button.parentNode;
    var hasQuantity = productContainer.classList.contains('quantity-container');
    if (hasQuantity) {
      productContainer.innerHTML = '<button class="toggle-btn" onclick="toggleProductQuantity(this)">ADD</button>';
    } else {
      var quantityContainer = document.createElement('div');
      quantityContainer.className = 'quantity-container';
      var decreaseBtn = document.createElement('button');
      decreaseBtn.innerHTML = '-';
      decreaseBtn.onclick = function() {
        updateQuantity(productContainer, -1);
      };
      var quantityInput = document.createElement('input');
      quantityInput.type = 'text';
      quantityInput.value = 1;
      quantityInput.className = 'quantity-input';
      quantityInput.disabled = true;
      var increaseBtn = document.createElement('button');
      increaseBtn.innerHTML = '+';
      increaseBtn.onclick = function() {
        updateQuantity(productContainer, 1);
      };
      quantityContainer.appendChild(decreaseBtn);
      quantityContainer.appendChild(quantityInput);
      quantityContainer.appendChild(increaseBtn);
      productContainer.innerHTML = '';
      productContainer.appendChild(quantityContainer);
    }
  }

  function updateQuantity(productContainer, amount) {
    var quantityInput = productContainer.querySelector('.quantity-input');
    var currentQuantity = parseInt(quantityInput.value) + amount;
    quantityInput.value = currentQuantity > 0 ? currentQuantity : 0;
    if (currentQuantity === 0) {
      productContainer.innerHTML = '<button class="toggle-btn" onclick="toggleProductQuantity(this)">ADD</button>';
    }
  }
(function ($) {
    "use strict";

    const isRTL = document.documentElement.dir === "rtl";

    function parents(element, selector) {
        const parentsArray = [];
        let currentElement = element.parentElement;

        while (currentElement !== null) {
            if (currentElement.matches(selector)) {
                parentsArray.push(currentElement);
            }
            currentElement = currentElement.parentElement;
        }

        return parentsArray;
    }

    var mobileQuery = window.matchMedia('(max-width: 450px)'),
        siteHeader = $('.site-header'),
        matchMedia = gsap.matchMedia(),
        isPhone = '(max-width: 450px)',
        isTablet = '(min-width: 450px) and (max-width: 900px)',
        isDesktop = '(min-width: 900px)';



    var cursor = document.getElementById('mouseCursor') ? document.getElementById('mouseCursor') : false,
        cursorText = cursor ? cursor.querySelector('.cursor-text') : false,
        cursorIcon = cursor ? cursor.querySelector('.cursor-icon') : false;


    var keys = {
        37: 1,
        38: 1,
        39: 1,
        40: 1
    };

    function preventDefault(e) {
        e.preventDefault();
    }

    function preventDefaultForScrollKeys(e) {
        if (keys[e.keyCode]) {
            preventDefault(e);
            return false;
        }
    }

    var supportsPassive = false;
    try {
        window.addEventListener("test", null, Object.defineProperty({}, 'passive', {
            get: function () {
                supportsPassive = true;
            }
        }));
    } catch (e) { }

    var wheelOpt = supportsPassive ? {
        passive: false
    } : false;
    var wheelEvent = 'onwheel' in document.createElement('div') ? 'wheel' : 'mousewheel';

    // call this to Disable
    function disableScroll() {
        if (sarenLenis) {
            sarenLenis.stop();
        } else {
            window.addEventListener('DOMMouseScroll', preventDefault, false); // older FF
            window.addEventListener(wheelEvent, preventDefault, wheelOpt); // modern desktop
            window.addEventListener('touchmove', preventDefault, wheelOpt); // mobile
            window.addEventListener('keydown', preventDefaultForScrollKeys, false);
        }
    }

    // call this to Enable
    function enableScroll() {

        if (sarenLenis) {

            sarenLenis.start();
        } else {
            window.removeEventListener('DOMMouseScroll', preventDefault, false);
            window.removeEventListener(wheelEvent, preventDefault, wheelOpt);
            window.removeEventListener('touchmove', preventDefault, wheelOpt);
            window.removeEventListener('keydown', preventDefaultForScrollKeys, false);
        }
    }

    function clearProps(target) {
        gsap.set(target, {
            clearProps: 'all'
        })
    }


    function wrapInner(element, wrapper) {

        var wrapperElement = document.createElement(wrapper.tagName);


        while (element.firstChild) {
            wrapperElement.appendChild(element.firstChild);
        }


        element.appendChild(wrapperElement);
    }

    function peCustomSelect() {

        var selectWrappers = document.getElementsByClassName("pe-select");
        var totalSelects = selectWrappers.length;


        for (var i = 0; i < totalSelects; i++) {
            var originalSelect = selectWrappers[i].getElementsByTagName("select")[0];
            var totalOptions = originalSelect.length;

            var selectedDiv = document.createElement("DIV");
            selectedDiv.setAttribute("class", "select-selected");
            selectedDiv.innerHTML = originalSelect.options[originalSelect.selectedIndex].innerHTML;
            selectedDiv.setAttribute('data-select', originalSelect.options[originalSelect.selectedIndex].innerHTML);
            selectWrappers[i].appendChild(selectedDiv);

            var optionsListDiv = document.createElement("DIV");
            optionsListDiv.setAttribute("class", "select-items select-hide");

            for (var j = 1; j < totalOptions; j++) {
                var optionDiv = document.createElement("DIV");
                optionDiv.innerHTML = originalSelect.options[j].innerHTML;

                optionDiv.addEventListener("click", function (e) {
                    var selectElement = this.parentNode.parentNode.getElementsByTagName("select")[0];
                    var totalOptionsInSelect = selectElement.length;
                    var selectedDivInThis = this.parentNode.previousSibling;

                    for (var k = 0; k < totalOptionsInSelect; k++) {
                        if (selectElement.options[k].innerHTML == this.innerHTML) {
                            selectElement.selectedIndex = k;
                            selectedDivInThis.innerHTML = this.innerHTML;
                            selectedDivInThis.setAttribute('data-select', this.innerHTML);

                            var previouslySelected = this.parentNode.getElementsByClassName("same-as-selected");
                            var totalSelected = previouslySelected.length;
                            for (var l = 0; l < totalSelected; l++) {
                                previouslySelected[l].removeAttribute("class");
                            }
                            this.setAttribute("class", "same-as-selected");

                            var event = new Event('change', { bubbles: true });
                            selectElement.dispatchEvent(event);

                            break;
                        }
                    }

                    selectedDivInThis.click();
                });
                optionsListDiv.appendChild(optionDiv);
            }
            selectWrappers[i].appendChild(optionsListDiv);

            selectedDiv.addEventListener("click", function (e) {
                e.stopPropagation();
                closeAllSelect(this);
                this.nextSibling.classList.toggle("select-hide");
                this.classList.toggle("select-arrow-active");
            });
        }

        function closeAllSelect(exceptThis) {
            var allOptionsDiv = document.getElementsByClassName("select-items");
            var allSelectedDivs = document.getElementsByClassName("select-selected");
            var totalOptionsDivs = allOptionsDiv.length;
            var totalSelectedDivs = allSelectedDivs.length;
            var openSelectIndexes = [];


            for (var i = 0; i < totalSelectedDivs; i++) {
                if (exceptThis == allSelectedDivs[i]) {
                    openSelectIndexes.push(i);
                } else {
                    allSelectedDivs[i].classList.remove("select-arrow-active");
                }
            }

            for (var i = 0; i < totalOptionsDivs; i++) {
                if (openSelectIndexes.indexOf(i) == -1) {
                    allOptionsDiv[i].classList.add("select-hide");
                }
            }
        }

        document.addEventListener("click", closeAllSelect);
    }


    /////////////////////////
    //   Global Scripts   //
    /////////////////////////


    function peScrollButton(button) {

        var target = button.dataset.scrollTo,
            duration = button.dataset.scrollDuration;

        button.addEventListener('click', () => {

            if (sarenLenis) {
                target = isNaN(parseFloat(target)) ? target : parseFloat(target);
                sarenLenis.scrollTo(target, {
                    duration: duration,
                    ease: 'cubic-bezier(0.65, 0, 0.35, 1)',
                })

            } else {
                gsap.to(window, {
                    duration: duration,
                    scrollTo: isNaN(target) ? $(target).offset().top : target,
                    ease: 'expo.out',
                });
            }

        })


    }

    function resetCursor() {

        var mouseCursor = document.getElementById('mouseCursor');
        if (mouseCursor) {
            cursor.classList.remove('cursor--default')
            cursor.classList.remove('cursor--text');
            cursor.classList.remove('cursor--icon');
            cursor.classList.remove('dragging--right');
            cursor.classList.remove('dragging--left');
            cursorText.innerHTML = '';
            cursorIcon.innerHTML = '';
        }
    }

    if (window.barba) {

        barba.hooks.before(() => {

            resetCursor();
        });

        barba.hooks.afterEnter(() => {

            resetCursor();
        });

    }

    function peCursorInteraction(target) {
        var mouseCursor = document.getElementById('mouseCursor');
        if (mouseCursor) {
            // Types: default/text/icon

            var type = target.dataset.cursorType,
                text = target.dataset.cursorText,
                icon = target.dataset.cursorIcon;

            target.addEventListener('mouseenter', () => {

                if (!target.classList.contains('cursor--disabled')) {


                    if (type === 'default') {

                        cursor.classList.add('cursor--default')
                    }

                    if (type === 'text') {

                        cursor.classList.add('cursor--text');
                        cursorText.innerHTML = text;

                    }

                    if (type === 'icon') {

                        cursor.classList.add('cursor--icon');
                        cursorIcon.innerHTML = icon;

                    }
                }
            });

            target.addEventListener('mouseleave', () => resetCursor());
        }
    }


    function peCursorDrag(target, init = true) {
        var mouseCursor = document.getElementById('mouseCursor');
        if (mouseCursor) {
            resetCursor()

            let width = target.clientWidth;

            function init() {

                cursor.classList.add('cursor--icon');
                cursor.classList.add('cursor--drag');
                cursor.classList.add('dragging');

            }

            target.addEventListener('mouseleave', () => resetCursor());
            target.addEventListener('mouseenter', () => init());

        }
    }


    function isPinnng(trigger, add) {

        if (!mobileQuery.matches) {
            if (add) {
                if (document.querySelector(trigger)) {
                    document.querySelector(trigger).classList.add('is-pinning')
                }

            } else {
                if (document.querySelector(trigger)) {
                    document.querySelector(trigger).classList.remove('is-pinning')
                }
            }

        }

    }

    function pePopup(scope, wrapper) {

        let popButton = scope.querySelector('.pe--pop--button'),
            popup = scope.querySelector('.pe--styled--popup'),
            overlay = scope.querySelector('.pop--overlay'),
            close = scope.querySelector('.pop--close'),
            topSpacing = getComputedStyle(popup).getPropertyValue('--topSpacing');


        function popupact(open) {

            if (open) {

                if (parents(popup, '.pinned_true').length) {
                    parents(popup, '.pinned_true')[0].style.transition = 'none';
                    parents(popup, '.pinned_true')[0].style.transform = 'none';
                }

                if (parents(popup, '.e-transform').length) {
                    parents(popup, '.e-transform')[0].style.transition = 'none';
                    parents(popup, '.e-transform')[0].style.transform = 'none';
                    parents(popup, '.elementor-widget-container')[0].style.transition = 'none';
                    parents(popup, '.elementor-widget-container')[0].style.transform = 'none';
                }

                scope.classList.contains('pop--disable--scroll--true') ? disableScroll() : '';
                wrapper.classList.add('pop--active');

                gsap.fromTo(popup, {
                    xPercent: scope.classList.contains('pop--behavior--center') || scope.classList.contains('pop--behavior--top') || scope.classList.contains('pop--behavior--bottom') ? -50 : scope.classList.contains('pop--behavior--left') ? -120 : scope.classList.contains('pop--behavior--right') ? 120 : 0,
                    yPercent: scope.classList.contains('pop--behavior--top') ? -200 : scope.classList.contains('pop--behavior--bottom') ? 200 : scope.classList.contains('pop--behavior--center') ? -50 : 0,
                    scale: scope.classList.contains('pop--behavior--center') ? 0.7 : 1,
                    opacity: scope.classList.contains('pop--behavior--center') ? 0 : 1,
                }, {
                    xPercent: scope.classList.contains('pop--behavior--center') || scope.classList.contains('pop--behavior--top') || scope.classList.contains('pop--behavior--bottom') ? -50 : 0,
                    yPercent: scope.classList.contains('pop--behavior--center') ? -50 : 0,
                    y: 0,
                    opacity: 1,
                    scale: 1,
                    visibility: 'visible',
                    duration: 1,
                    ease: 'power3.out',
                    overwrite: true
                });

            } else {

                let backTop = parseInt(topSpacing) ? -200 - parseInt(topSpacing) : -200;

                scope.classList.contains('pop--disable--scroll--true') ? enableScroll() : '';
                wrapper.classList.remove('pop--active');
                gsap.to(popup, {
                    xPercent: scope.classList.contains('pop--behavior--center') || scope.classList.contains('pop--behavior--top') || scope.classList.contains('pop--behavior--bottom') ? -50 : scope.classList.contains('pop--behavior--left') ? -120 : scope.classList.contains('pop--behavior--right') ? 120 : 0,
                    yPercent: scope.classList.contains('pop--behavior--top') ? backTop : scope.classList.contains('pop--behavior--bottom') ? 200 : scope.classList.contains('pop--behavior--center') ? -50 : 0,
                    scale: scope.classList.contains('pop--behavior--center') ? 0.7 : 1,
                    opacity: scope.classList.contains('pop--behavior--center') ? 0 : 1,
                    onComplete: () => {
                        gsap.set(popup, {
                            visibility: 'hidden',
                        })
                    },
                    duration: 1,
                    ease: 'power3.out',
                    overwrite: true
                })
            }
        }

        if (scope.classList.contains('pop--action--hover')) {
            popButton.addEventListener('mouseenter', () => popupact(true));
            popup.addEventListener('mouseleave', () => popupact(false));
        }

        popButton.addEventListener('click', () => popupact(true));

        if (overlay) {
            overlay.addEventListener('click', () => popupact(false));
        }

        close.addEventListener('click', () => popupact(false));

        window.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                if (wrapper.classList.contains('pop--active')) {
                    popupact(false)
                }
            }
        })

    }

    function peSwitcher(scope, switcher, grid, gridItems) {

        let items = switcher.querySelectorAll('.switch--item');

        function moveFollower(follower) {

            let active = switcher.querySelector('.switch--active');
            let activeRect = active.getBoundingClientRect();
            let switcherRect = switcher.getBoundingClientRect();

            gsap.to(follower, {
                x: activeRect.left - switcherRect.left,
                y: activeRect.top - switcherRect.top,
                width: activeRect.width,
                height: activeRect.height,
                duration: 0.75,
                ease: 'power3.out'
            });
        }

        if (switcher.querySelector('.switch--follower')) {
            moveFollower(switcher.querySelector('.switch--follower'))
        }

        items.forEach(item => {

            item.addEventListener('click', () => {

                scope.querySelector('.switch--active').classList.remove('switch--active')
                item.classList.add('switch--active');

                if (switcher.querySelector('.switch--follower')) {
                    moveFollower(switcher.querySelector('.switch--follower'));
                }

                let state = Flip.getState(gridItems),
                    cols = item.dataset.switchCols;

                gsap.set(grid, {
                    "--columns": cols
                })

                Flip.from(state, {
                    duration: 1,
                    ease: 'power3.inOut',
                    absolute: true,
                    absoluteOnLeave: true,
                })

            })

        })

    }

    function updateActiveCarouselItem(wrapper, itemsSelector, activeClass = 'active') {
        const items = wrapper.querySelectorAll(itemsSelector);
        const centerX = window.innerWidth / 2;
        const centerY = window.innerHeight / 2;

        let closestItem = null;
        let closestDistance = Infinity;

        items.forEach(item => {
            const rect = item.getBoundingClientRect();
            const itemCenterX = rect.left + rect.width / 2;
            const itemCenterY = rect.top + rect.height / 2;

            const distance = Math.sqrt(
                Math.pow(itemCenterX - centerX, 2) + Math.pow(itemCenterY - centerY, 2)
            );

            if (distance < closestDistance) {
                closestDistance = distance;
                closestItem = item;
            }
        });

        items.forEach(item => item.classList.remove(activeClass));

        if (closestItem) {
            closestItem.classList.add(activeClass);
        }
    }

    function sarenLighbox(parent, wrapper, images) {

        var holder = parents(parent, 'div')[0],
            dragVal;

        gsap.set(holder, {
            height: parent.getBoundingClientRect().height
        })

        images.forEach((image, i) => {

            image.classList.add('lightbox--image');
            image.classList.add('lightbox--image_' + i);
            image.dataset.index = i;

            image.addEventListener('click', () => {

                if (!parent.classList.contains('lightbox--active')) {

                    disableScroll();
                    image.classList.add('active');

                    if (Draggable.get(wrapper)) {
                        let drag = Draggable.get(wrapper);
                        dragVal = drag.x;

                        drag.disable();
                        gsap.to(wrapper, {
                            x: 0,
                            y: 0,
                            duration: 2,
                            ease: 'expo.inOut',
                        })
                        // clearProps(images);
                    }

                    let state = Flip.getState(images, {
                        props: ['height']
                    });

                    parent.classList.add('lightbox--active');

                    gsap.set(images, {
                        height: mobileQuery.matches ? '75vh' : '90vh',
                        width: mobileQuery.matches ? '90%' : 'auto',
                        position: 'absolute',
                        top: '50%',
                        left: '50%',
                        xPercent: -50,
                        yPercent: -50
                    })

                    Flip.from(state, {
                        duration: 2,
                        stagger: {
                            grid: [1, images.length],
                            from: i,
                            amount: .25,
                        },
                        ease: 'expo.inOut',
                        absolute: true,
                        absoluteOnLeave: true,
                        onComplete: () => {
                            parent.classList.add('lightbox--nav--init');
                        }
                    })


                }




            })

        })

        if (parent.querySelector('.saren--lightbox--button')) {
            parent.querySelector('.saren--lightbox--button').addEventListener('click', () => {
                wrapper.querySelector('.active').click();

            })
        }

        let close = parent.querySelector('.saren--lightbox--close'),
            prev = parent.querySelector('.saren--lightbox--prev'),
            next = parent.querySelector('.saren--lightbox--next'),
            overlay = parent.querySelector('.saren--lightbox--overlay');

        function lightboxClose() {

            let state = Flip.getState(images, {
                props: ['height']
            });

            clearProps(images);
            parent.classList.remove('lightbox--active');
            let actIndex = parent.querySelector('.lightbox--image.active').dataset.index;

            if (Draggable.get(wrapper)) {
                let drag = Draggable.get(wrapper);

                gsap.to(wrapper, {
                    x: dragVal,
                    duration: 2,
                    ease: 'expo.inOut',
                    onComplete: () => {
                        drag.enable();
                        parent.querySelector('.lightbox--image.active').classList.remove('active');
                        updateActiveCarouselItem(wrapper, '.product--gallery--image');
                    }
                })
            }

            Flip.from(state, {
                duration: 2,
                ease: 'expo.inOut',
                absolute: true,
                absoluteOnLeave: true,
                onStart: () => {
                    parent.classList.remove('lightbox--nav--init');
                    enableScroll();
                }
            })

        }

        function lightboxNavigate(direction) {

            let activeItem = parent.querySelector('.lightbox--image.active'),
                activeIndex = activeItem.dataset.index;

            if (direction === 'prev' && activeIndex != 0) {

                activeItem.classList.remove('active');
                parent.querySelector('.lightbox--image_' + (parseInt(activeIndex) - 1)).classList.add('active');

            } else if (direction === 'next' && activeIndex != (images.length - 1)) {

                activeItem.classList.remove('active');
                parent.querySelector('.lightbox--image_' + (parseInt(activeIndex) + 1)).classList.add('active');

            }

        }

        overlay.addEventListener('click', () => lightboxClose());
        close.addEventListener('click', () => lightboxClose());
        prev.addEventListener('click', () => lightboxNavigate('prev'));
        next.addEventListener('click', () => lightboxNavigate('next'));

    }

    function saren_CheckoutPage() {

        if (!document.querySelector('.saren--checkout--wrapper')) {
            return false;
        }

        var accordion = document.querySelector('.checkout-type-accordion'),
            tabs = document.querySelector('.checkout-type-tabs');

        if (document.querySelector('.saren--checkout--login')) {
            let checkoutLogin = document.querySelector('.saren--checkout--login');

            if (checkoutLogin.querySelector('.scag--button')) {
                let button = checkoutLogin.querySelector('.scag--button'),
                    formCol = document.querySelector('.saren--checkout--form .form--col');


                button.addEventListener('click', () => {

                    gsap.to(checkoutLogin, {
                        opacity: 0,
                        onComplete: () => {
                            checkoutLogin.style.display = 'none'
                        }
                    })

                    gsap.to(formCol, {
                        opacity: 1,
                    })

                })
            }


        }

        if (tabs) {

            const sourceElement = document.querySelector('.saren--checkout--accordion');
            const targetElement = document.querySelector('.saren--checkout--tabs--titles');
            var wrapper = document.querySelector('.form--col');

            const titles = sourceElement.querySelectorAll('.checkout--accordion--title');


            titles.forEach((title, i) => {

                title.classList.add('title__' + i);
                title.setAttribute('data-index', i);

                const clone = title.cloneNode(true);
                clone.classList.add('title--clone');

                clone.addEventListener('click', () => title.click())
                targetElement.appendChild(clone);
            });

            if (targetElement.getBoundingClientRect().width > wrapper.getBoundingClientRect().width) {

                let paddingRight = window.getComputedStyle(wrapper).getPropertyValue('padding-right'),
                    endVal = -targetElement.getBoundingClientRect().width + wrapper.getBoundingClientRect().width - (parseFloat(paddingRight) * 3);

                Draggable.create(targetElement, {
                    id: 'checkoutTabTitles',
                    type: 'x',
                    bounds: {
                        minX: 0,
                        maxX: endVal,
                    },
                    lockAxis: true,
                    dragResistance: 0.5,
                    inertia: true,
                    allowContextMenu: true
                });

            }

        }

        function updateTitles() {

            let clones = document.querySelectorAll('.title--clone'),
                fields = document.querySelector('.saren--checkout--accordion');

            clones.forEach((clone, i) => {

                let index = clone.dataset.index,
                    findTitle = fields.querySelector('.title__' + i);

                parents(findTitle, '.active').length ? clone.classList.add('active') : clone.classList.remove('active');
                parents(findTitle, '.is--filled').length ? clone.classList.add('is--filled') : clone.classList.remove('is--filled');

            })
        }

        if (tabs || accordion) {

            setTimeout(() => {

                $('.saren--checkout--accordion').find('input').each(function () {

                    $(this).trigger('change');

                });

                let items = document.querySelectorAll('.checkout--accordion--field');

                function areAllItemsFilled() {
                    return Array.from(items).every(item => {
                        if (item.classList.contains('field--payment')) {
                            return true;
                        }
                        return item.classList.contains('is--filled');
                    });
                }

                setTimeout(() => {
                    if (areAllItemsFilled()) {
                        document.querySelector('.field--payment').classList.add('is--filled');
                    }
                    tabs ? updateTitles() : '';
                }, 1000);


                items.forEach((item, i, filled = false) => {

                    let title = item.querySelector('.checkout--accordion--title'),
                        content = item.querySelector('.checkout--accordion--content'),
                        button = item.querySelector('.saren--accordion--button'),
                        rows = item.querySelectorAll('.form-row'),
                        inputs = item.querySelectorAll('input');


                    function checkValidates() {
                        return Array.from(rows).every(row =>
                            row.classList.contains('validate-required') &&
                            row.classList.contains('woocommerce-validated') ||
                            item.querySelector('.saren--address--card')
                        );
                    }

                    item.classList.add('item__' + i);

                    function checkValidation() {

                        if (checkValidates()) {
                            item.classList.add('is--filled')
                        } else {
                            item.classList.remove('is--filled')
                        }
                        tabs ? updateTitles() : '';

                    }
                    checkValidation();

                    title.addEventListener('click', () => {

                        let state = Flip.getState(document.querySelectorAll('.checkout--accordion--content'),);

                        document.querySelector('.checkout--accordion--field.active').classList.remove('active');
                        item.classList.add('active');

                        Flip.from(state, {
                            duration: 1,
                            ease: 'power3.inOut',
                            absolute: true,
                            absoluteOnLeave: true
                        })

                    })

                    inputs.forEach(input => {
                        input.addEventListener('blur', () => {
                            checkValidation();
                        })
                    });

                    if (button) {
                        button.addEventListener('click', butt => {

                            let nextItem = document.querySelector('.item__' + (i + 1)),
                                nextContent = nextItem.querySelector('.checkout--accordion--content');
                            let state = Flip.getState(document.querySelectorAll('.checkout--accordion--content'),);

                            item.classList.remove('active');
                            nextItem.classList.add('active');

                            Flip.from(state, {
                                duration: 1,
                                ease: 'power3.inOut',
                                absolute: true,
                                absoluteOnLeave: true
                            })

                        })
                    }

                })

            }, 2000);

        }

        var reviewTable = document.querySelector('.woocommerce-checkout-review-order-table');

        if (reviewTable) {

            let couponInput = reviewTable.querySelector('#saren_coupon_code'),
                formCoupon = document.querySelector('#coupon_code'),
                formButton = document.querySelector('.wc--coupon--button'),
                couponButton = reviewTable.querySelector('.saren--coupon--button');

            couponButton.addEventListener('click', () => {
                formCoupon.value = couponInput.value;
                formButton.click();
            })

        }

        let orderCol = document.querySelector('.order--col');

        if (orderCol) {

            ScrollTrigger.getById('cartPin') ? ScrollTrigger.getById('cartPin').kill(true) : '';

            ScrollTrigger.create({
                trigger: document.body,
                start: 0,
                end: 'bottom top',
                pin: orderCol,
                id: 'cartPin'
            })

            matchMedia.add({
                isMobile: "(max-width: 570px)"
            }, (context) => {

                let {
                    isMobile
                } = context.conditions;

                ScrollTrigger.getById('cartPin') ? ScrollTrigger.getById('cartPin').kill(true) : '';

            });


        }

        if (document.querySelectorAll('.saren--address--card').length) {

            var cards = document.querySelectorAll('.saren--address--card');

            for (let i = 0; i < cards.length; i++) {

                let editButton = cards[i].querySelector('.address-card--edit');

                editButton.addEventListener('click', () => {
                    let form = document.querySelector(editButton.dataset.edit);

                    let state = Flip.getState(form);

                    if (editButton.classList.contains('active')) {
                        editButton.classList.remove('active')
                        form.style.height = 0;
                    } else {
                        editButton.classList.add('active')
                        form.style.height = 'auto';
                    }

                    Flip.from(state, {
                        duration: 1,
                        ease: 'power3.inOut',
                        absolute: false,
                        absoluteOnLeave: false
                    })

                })

            }


        }


    }

    window.addEventListener('elementor/frontend/init', function () {


        if (document.body.classList.contains('e-preview--show-hidden-elements')) {

            document.body.setAttribute('data-barba-prevent', 'all');

        }

        elementorFrontend.hooks.addAction('frontend/element_ready/global', function ($scope, $) {

            var jsScopeArray = $scope.toArray();
            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    id = scope.dataset.id;

                // Reset on Editor 
                if (document.body.classList.contains('e-preview--show-hidden-elements')) {
                    if (ScrollTrigger.getById(id)) {
                        ScrollTrigger.getById(id).kill();
                    }
                }
                // Reset on Editor 
                var containerBg = document.querySelector('.bg--for--' + id);
                containerBg ? scope.prepend(containerBg) : '';

                if (scope.querySelector('.container--bg')) {

                    if (scope.classList.contains('animated--gradient')) {

                        let bg = scope.querySelector('.container--bg');

                        const b1 = getComputedStyle(bg).getPropertyValue('--b1');
                        const b2 = getComputedStyle(bg).getPropertyValue('--b2');

                        let classes = scope.className.split(' '),
                            durationClass = classes.find(cls => cls.startsWith('gradient_animation_duration')),
                            duration = durationClass ? durationClass.substring("gradient_animation_duration_".length) : '.' + scope.classList[0];

                        console.l

                        gsap.fromTo(bg, {
                            background: b1
                        }, {
                            ease: "none",
                            duration: duration,
                            background: b2,
                            repeat: -1,
                            yoyo: true
                        });

                    }

                    if (scope.classList.contains('bg_fixed_true')) {

                        ScrollTrigger.create({
                            trigger: scope,
                            start: 'top top',
                            end: 'bottom bottom',
                            pin: scope.querySelector('.container--bg'),
                            pinSpacing: false,
                        })

                    }

                    if (scope.classList.contains('bg--image')) {

                        let bg = scope.querySelector('.container--bg'),
                            bgWrap = bg.querySelector('.cont--bg--wrap'),
                            img = bgWrap.querySelector('img');


                        if (scope.classList.contains('bg--behavior--parallax')) {

                            gsap.set(img, {
                                scale: 1.2
                            })

                            gsap.fromTo(img, {
                                yPercent: -10
                            }, {
                                yPercent: 10,
                                ease: 'none',
                                scrollTrigger: {
                                    trigger: bg,
                                    scrub: true,
                                    start: 'top bottom',
                                    end: 'bottom top'
                                }
                            })

                        } else if (scope.classList.contains('bg--behavior--zoom-in')) {

                            gsap.fromTo(img, {
                                scale: 1.25
                            }, {
                                scale: 1,
                                ease: 'power3.inOut',
                                scrollTrigger: {
                                    trigger: bg,
                                    scrub: true,
                                    start: 'top bottom',
                                    end: 'center center'
                                }
                            })

                        } else if (scope.classList.contains('bg--behavior--zoom-out')) {
                            gsap.fromTo(img, {
                                scale: 1
                            }, {
                                scale: 1.25,
                                ease: 'none',
                                scrollTrigger: {
                                    trigger: bg,
                                    scrub: true,
                                    start: 'top bottom',
                                    end: 'bottom top'
                                }
                            })
                        }
                    } else if (scope.classList.contains('bg--video')) {

                        if (scope.querySelector('.container--bg')) {

                            var bg = scope.querySelector('.container--bg'),
                                video = bg.querySelector('.pe-video');

                        } else {
                            var bg = document.querySelector('.bg--for--' + id),
                                video = bg.querySelector('.pe-video');
                        }

                        if (!document.body.classList.contains('window--initialized')) {
                            new peVideoPlayer(video);
                        } else {
                            window.addEventListener("load", function () {
                                new peVideoPlayer(video);
                            });
                        }

                    }

                }

                if (scope.classList.contains('animate--radius')) {

                    setTimeout(() => {

                        let radius = window.getComputedStyle(scope).borderRadius.split(' '),
                            width = scope.getBoundingClientRect().width,
                            padding = getComputedStyle(scope).getPropertyValue('--container-default-padding-left');

                        gsap.to(scope, {
                            borderRadius: '0px',
                            width: scope.classList.contains('integared--width') ? '100%' : '--width',
                            padding: padding,
                            ease: 'none',
                            scrollTrigger: {
                                trigger: scope,
                                start: 'top bottom',
                                end: 'top top',
                                scrub: true
                            }
                        })

                        gsap.fromTo(scope, {
                            borderRadius: '0px 0px 0px 0px',
                            padding: padding,
                        }, {
                            borderRadius: radius,
                            width: width,
                            padding: 0,
                            ease: 'none',
                            immediateRender: false,
                            scrollTrigger: {
                                trigger: scope,
                                start: 'bottom  bottom',
                                end: 'bottom center',
                                scrub: true
                            }
                        })

                    }, 1);

                }

                if (scope.classList.contains('backward__container')) {

                    ScrollTrigger.getById('backward_' + id) ? ScrollTrigger.getById('backward_' + id).kill(true) : '';

                    var backwardSc = ScrollTrigger.create({
                        trigger: scope,
                        start: 'bottom bottom',
                        end: 'bottom top',
                        scrub: 2,
                        pin: true,
                        pinSpacing: false,
                        id: 'backward_' + id
                    })

                    if (!scope.classList.contains('backward__mobile-yes')) {

                        matchMedia.add({
                            isMobile: "(max-width: 550px)"

                        }, (context) => {

                            let {
                                isMobile
                            } = context.conditions;

                            backwardSc.kill(true);

                        });

                    }

                }

                if (scope.classList.contains('highlight--inners')) {

                    let childNodes = scope.childNodes;

                    for (let i = 0; i < childNodes.length; i++) {

                        if (childNodes[i].tagName === 'DIV' && childNodes[i].classList.contains('elementor-element')) {

                            let child = childNodes[i];

                            ScrollTrigger.create({
                                trigger: child,
                                start: 'top center',
                                end: 'bottom center',
                                onEnter: () => {
                                    gsap.to(child, {
                                        opacity: 1
                                    })
                                },
                                onLeaveBack: () => {
                                    gsap.to(child, {
                                        opacity: 0
                                    })
                                },
                                onLeave: () => {
                                    gsap.to(child, {
                                        opacity: 0
                                    })
                                },
                                onEnterBack: () => {
                                    gsap.to(child, {
                                        opacity: 1
                                    })
                                }
                            })


                        }

                    }



                }

                if (scope.classList.contains('build--on--scroll') && !document.body.classList.contains('e-preview--show-hidden-elements') && !mobileQuery.matches) {

                    var grid = scope,
                        classList = grid.className,
                        classes = classList.split(' '),
                        targetClass = classes.find(cls => cls.startsWith('build_pin_container')),
                        target = targetClass ? targetClass.substring("build_pin_container_".length) : '.' + scope.classList[0],
                        fromClass = classes.find(cls => cls.startsWith('stagger_from')),
                        from = fromClass.substring("stagger_from_".length),
                        speedClass = classes.find(cls => cls.startsWith('build_speed')),
                        speed = speedClass.substring("build_speed_".length),
                        staggerClass = classes.find(cls => cls.startsWith('build_stagger')),
                        stagger = staggerClass.substring("build_stagger_".length),
                        buildTypeClass = classes.find(cls => cls.startsWith('build_type')),
                        buildType = buildTypeClass.substring("build_type_".length),
                        elements = grid.querySelectorAll(':scope > .e-con');


                    if (elements.length < 1) {

                        var elements = grid.querySelectorAll('.elementor-element');
                    }

                    gsap.getById(id) ? gsap.getById(id).scrollTrigger.kill(true) : '';

                    let tl = gsap.timeline({
                        id: id,
                        scrollTrigger: {
                            trigger: target,
                            pin: target,
                            scrub: true,
                            start: 'center center',
                            end: 'bottom+=' + speed + ' top',
                        }
                    });

                    let elementsArray = Array.from(elements),
                        animateTargets = [];

                    for (let i = 0; i < elementsArray.length; i++) {

                        if (from === 'end') {
                            if (i != (elementsArray.length - 1)) {
                                animateTargets.push(elementsArray[i])
                            }
                        } else if (from === 'start') {

                            if (i != 0) {
                                animateTargets.push(elementsArray[i])
                            }

                        } else if (from === 'center') {

                            let cent = parseInt((elementsArray.length - 1) / 2);


                            if (i != cent) {
                                animateTargets.push(elementsArray[i])
                            }

                        }
                    }

                    if (from === 'center' && animateTargets.length == 2) {
                        var animFrom = 'start';
                    } else {
                        var animFrom = 'from';
                    }

                    let animStagger = {
                        each: parseFloat(stagger),
                        from: animFrom,
                        ease: 'none'
                    };

                    tl.fromTo(animateTargets, {
                        y: buildType === 'slide-up' ? '100vh' : buildType === 'slide-down' ? '-100vh' : '0vh',
                        x: buildType === 'slide-left' ? '-100vw' : buildType === 'slide-right' ? '100vw' : '0vw',
                        scale: buildType === 'scale-up' ? 0 : 1,
                        opacity: buildType === 'fade' ? 0 : 1,
                    }, {
                        y: 0,
                        x: 0,
                        scale: 1,
                        opacity: 1,
                        stagger: animStagger,
                        ease: 'power2.out'
                    })

                    if (scope.classList.contains('animate--inners')) {

                        elements.forEach(element => {

                            let widgets = Array.from(element.querySelectorAll('.elementor-widget:not(.elementor-widget-pelottie), .e-con')),
                                animateWidgets = [];

                            if (widgets.length > 1) {

                                for (let i = 0; i < widgets.length; i++) {
                                    if (i != 0) {
                                        animateWidgets.push(widgets[i])
                                    }

                                }
                                tl.fromTo(animateWidgets, {
                                    y: buildType === 'slide-up' ? '100vh' : buildType === 'slide-down' ? '-100vh' : '0vh',
                                    x: buildType === 'slide-left' ? '100vw' : buildType === 'slide-right' ? '100vw' : '0vw',
                                    scale: buildType === 'scale-up' ? 0 : buildType === 'scale-down' ? 1.5 : 1,
                                    opacity: buildType === 'fade' ? 0 : 1,
                                }, {
                                    y: 0,
                                    x: 0,
                                    scale: 1,
                                    opacity: 1,
                                    ease: 'power2.out',
                                    stagger: parseFloat(stagger)
                                }, 0)
                            }

                        })

                    }



                }

                if (scope.classList.contains('parallax__container')) {

                    var classList = scope.classList,
                        parallaxStrengthClass = Array.from(classList).find(cls => cls.startsWith('parallax_strength_')),
                        strength = parallaxStrengthClass.split('_').pop(),
                        parallaxDirectionClass = Array.from(classList).find(cls => cls.startsWith('parallax_direction_')),
                        direction = parallaxDirectionClass.split('_').pop(),
                        x, y;

                    if (direction === 'down' || direction === 'up') {

                        x = 0;
                        direction === 'down' ? y = strength : y = -1 * strength;
                    }

                    if (direction === 'right' || direction === 'left') {

                        y = 0;
                        direction === 'right' ? x = strength : x = -1 * strength;
                    }


                    let anim = gsap.to(scope, {
                        yPercent: y,
                        xPercent: x,
                        ease: 'none',
                        scrollTrigger: {
                            trigger: scope,
                            start: 'top bottom',
                            end: 'bottom top',
                            scrub: 1.2,
                        }
                    })

                    matchMedia.add({
                        isMobile: "(max-width: 550px)"

                    }, (context) => {

                        let {
                            isMobile
                        } = context.conditions;

                        anim.kill();

                    });

                }


                //Animations
                setTimeout(() => {

                    if (scope.hasAttribute('data-anim-general')) {

                        new peGeneralAnimation(scope, id);

                    }

                    if (scope.classList.contains('will__animated') && scope.querySelector('.container--anim--hold')) {

                        let hold = scope.querySelector('.container--anim--hold'),
                            anim = hold.dataset.animation,
                            sett = hold.dataset.settings;

                        scope.setAttribute('data-animation', anim);
                        scope.setAttribute('data-settings', sett);

                        new peGeneralAnimation(scope, id);


                    }

                }, 10);

                if (scope.classList.contains('convert--carousel')) {

                    let width = scope.offsetWidth,
                        classList = scope.className,
                        classes = classList.split(' '),
                        carouselIdClass = classes.find(cls => cls.startsWith('carousel_id')),
                        carouselTriggerClass = classes.find(cls => cls.startsWith('carousel_trigger')),
                        trigger = carouselTriggerClass ? carouselTriggerClass.substring("carousel_trigger_".length) : '.' + scope.classList[0],
                        id = carouselIdClass ? carouselIdClass.substring("carousel_id_".length) : scope.dataset.id,
                        items = scope.children;

                    for (var i = 0; i < items.length; i++) {
                        items[i].classList.contains('e-con') || items[i].classList.contains('elementor-element') ? items[i].classList.add('cr--item') : '';
                        items[i].setAttribute('data-cr', i + 1);
                    }

                    scope.setAttribute('data-total', scope.querySelectorAll('.cr--item').length);


                    if (scope.classList.contains('cr--drag')) {

                        Draggable.create(scope, {
                            id: id,
                            type: 'x',
                            bounds: {
                                minX: 0,
                                maxX: -width + document.body.clientWidth
                            },
                            lockAxis: true,
                            dragResistance: 0.5,
                            inertia: true,
                        });

                        scope.classList.contains('cursor_drag') ? peCursorDrag(scope) : '';


                    } else if (scope.classList.contains('cr--scroll')) {

                        let carouselStart = getComputedStyle(scope).getPropertyValue('--carouselStart') ? getComputedStyle(scope).getPropertyValue('--carouselStart') : 0;

                        document.querySelector(trigger).classList.add('has--pinned--scroll');
                        document.querySelector(trigger).setAttribute('data-pin-for', scope.dataset.id);

                        gsap.getById(scope.dataset.id) ? gsap.getById(scope.dataset.id).scrollTrigger.kill(true) : '';

                        let giga = gsap.fromTo(scope, {
                            x: isRTL ? -1 * carouselStart : carouselStart,
                        }, {
                            x: isRTL ? width - document.body.clientWidth : (-1 * width) + document.body.clientWidth,
                            id: scope.dataset.id,
                            scrollTrigger: {
                                trigger: trigger,
                                scrub: true,
                                pin: trigger,
                                ease: "elastic.out(1, 0.3)",
                                start: 'center center',
                                end: 'bottom+=6000 bottom'
                            }
                        })


                    }

                }

                gsap.getById('layered_' + scope.dataset.id) ? gsap.getById('layered_' + scope.dataset.id).scrollTrigger.kill(true) : '';

                if (scope.classList.contains('convert--layered')) {

                    let items = scope.children,
                        classList = scope.className,
                        classes = classList.split(' '),
                        speedClass = classes.find(cls => cls.startsWith('layered_speed')),
                        speed = speedClass ? speedClass.substring("layered_speed_".length) : '.' + scope.classList[0],
                        triggerClass = classes.find(cls => cls.startsWith('layered_target')),
                        trigger = triggerClass ? triggerClass.substring("layered_target_".length) : scope;

                    let tl = gsap.timeline({
                        id: 'layered_' + scope.dataset.id,
                        ease: 'none',
                        scrollTrigger: {
                            trigger: trigger,
                            start: 'top top',
                            end: 'bottom+=' + speed + ' top',
                            pin: trigger,
                            scrub: 1,

                        }
                    });

                    for (var i = 0; i < items.length; i++) {

                        if (items[i].classList.contains('e-con')) {

                            if (i != 0) {
                                tl.to(items[i], {
                                    yPercent: 0,
                                    y: 0,
                                    duration: 1,
                                    ease: 'power2.out'
                                }, 'label_' + i)

                                if (window.screen.height < items[i].getBoundingClientRect().height) {

                                    tl.to(items[i], {
                                        y: window.screen.height - items[i].getBoundingClientRect().height,
                                        ease: 'none'
                                    }, 'label_' + i)

                                }

                                tl.to(items[i - 1], {
                                    duration: .5,
                                    delay: 1,
                                    ease: 'none'
                                }, 'label_' + i)

                                // if (scope.classList.contains('layered_out_anim')) {
                                //     tl.to(items[i - 1], {
                                //         duration: 1,
                                //         delay: 1,
                                //         ease: 'none'
                                //     }, 'label_' + i)

                                // }

                            }
                        }

                    }

                    imagesLoaded(scope, function (instance) {
                        ScrollTrigger.refresh(true);
                    })



                }

                if (scope.classList.contains('convert--tabs')) {
                    let id = scope.dataset.id,
                        innerContent = scope.innerHTML,
                        titles,
                        wrap = document.createElement("div");

                    wrap.classList.add('tabs--wrapper');
                    scope.insertBefore(wrap, scope.childNodes[0])

                    let wrapper = scope.querySelector('.tabs--wrapper'),
                        econs = Array.from(scope.children).filter(child => child.classList.contains('e-con'));

                    if (scope.querySelector('.container--tab--titles--wrap')) {
                        titles = scope.querySelector('.container--tab--titles--wrap');
                        scope.insertBefore(titles, scope.firstChild);

                    } else {
                        titles = document.querySelector('.container--tab--titles__' + id);
                        scope.insertBefore(titles, scope.firstChild);
                    }

                    let titlesWrap = scope.querySelector('.container--tab--titles--wrap');




                    for (let i = 0; i <= econs.length; i++) {
                        let tab = econs[i];

                        if (tab && tab.nodeName === 'DIV' && tab.classList.contains('e-con')) {
                            tab.classList.add('container--tab--item');
                        }
                    }

                    let tabItems = scope.querySelectorAll('.container--tab--item');

                    tabItems.forEach((tabItem, i) => {
                        i++
                        tabItem.classList.add('tab--item__' + i);
                        if (i == 1) {
                            tabItem.classList.add('active');
                        }
                    });

                    gsap.set(wrapper, {
                        height: scope.querySelector('.container--tab--item.active').offsetHeight
                    })

                    let arr = [];

                    titles.querySelectorAll('.container--tab--title').forEach(title => {


                        arr.push(title.getBoundingClientRect().left);

                        title.addEventListener('click', (self) => {

                            if (titlesWrap.getBoundingClientRect().width > document.body.clientWidth) {

                                gsap.to(titlesWrap, {
                                    x: arr[title.dataset.index - 1] * -1
                                })
                            }

                            scope.querySelector('.container--tab--title.active').classList.remove('active');
                            title.classList.add('active');

                            let findCont = scope.querySelector('.tab--item__' + title.dataset.index),
                                state = Flip.getState(tabItems);

                            gsap.set(tabItems, {
                                display: 'none',
                            })

                            gsap.set(findCont, {
                                display: 'flex',
                            });

                            Flip.from(state, {
                                duration: .75,
                                ease: "power3.inOut",
                                absolute: true,
                                fade: true,
                                onStart: () => {

                                    gsap.to(wrapper, {
                                        height: findCont.offsetHeight,
                                        duration: .75,
                                        ease: "power3.inOut",
                                    })

                                },
                                onComplete: () => {
                                    ScrollTrigger.refresh();
                                },
                                onEnter: (elements) =>
                                    gsap.fromTo(
                                        elements,
                                        {
                                            opacity: 0,
                                            // y: 300,
                                            scale: 0.9
                                        },
                                        {
                                            opacity: 1,
                                            scale: 1,
                                            duration: .75,
                                            // y: 0,
                                            delay: 0,
                                            ease: "power3.inOut",
                                        }
                                    ),
                                onLeave: (elements) =>
                                    gsap.to(elements, {
                                        opacity: 0,
                                        scale: .9,
                                        duration: .75,
                                        ease: "power3.inOut",
                                    })
                            });

                        })

                    })



                }
                if (scope.dataset.title && parents(scope, '.convert--accordion').length) {

                    scope.classList.add('container--accordion--item');
                    scope.classList.add('acc--item__' + scope.dataset.id);
                }

                if (scope.querySelector('.container--accordion--title') && (!scope.classList.contains('convert--accordion')) && (!scope.classList.contains('convert--tabs'))) {

                    let title = scope.querySelector('.container--accordion--title');

                    title.setAttribute('data-id', scope.dataset.id)

                    scope.classList.add('container--accordion--item');
                    scope.classList.add('acc--item__' + scope.dataset.id);

                    scope.parentNode.insertBefore(title, scope);


                }


                setTimeout(() => {
                    if (scope.classList.contains('convert--accordion')) {

                        let titles = scope.querySelectorAll('.container--accordion--title'),
                            contents = scope.querySelectorAll('.container--accordion--item');


                        if (scope.classList.contains('active--first')) {
                            contents[0].classList.add('cont--acc--active')
                        }

                        titles.forEach((title, i) => {
                            i++
                            title.querySelector('.ac-order').innerHTML = '(0' + i + ')';

                            title.addEventListener('click', () => {

                                let id = title.dataset.id,
                                    content = scope.querySelector('.acc--item__' + id);

                                if (content.classList.contains('cont--acc--active')) {

                                    title.classList.remove('active')

                                    var contentState = Flip.getState(content);
                                    content.classList.remove('cont--acc--active');

                                    Flip.from(contentState, {
                                        duration: .75,
                                        ease: 'expo.inOut',
                                        absolute: false,
                                        absoluteOnLeave: false,
                                        onComplete: () => {
                                            ScrollTrigger.refresh();
                                        },
                                    })

                                } else {

                                    var currentActive = scope.querySelector('.cont--acc--active');

                                    if (currentActive) {
                                        let currentTitle = scope.querySelector('.container--accordion--title.active');

                                        currentTitle.classList.remove('active');

                                        let currentContentState = Flip.getState(currentActive);

                                        currentActive.classList.remove('cont--acc--active');

                                        Flip.from(currentContentState, {
                                            duration: .75,
                                            ease: 'expo.inOut',
                                            absolute: false,
                                            absoluteOnLeave: false,
                                            onComplete: () => {
                                                ScrollTrigger.refresh();
                                            },
                                        })

                                    }

                                    //Open
                                    var contentState = Flip.getState(content);
                                    content.classList.add('cont--acc--active');
                                    title.classList.add('active')
                                    Flip.from(contentState, {
                                        duration: .75,
                                        ease: 'expo.inOut',
                                        absolute: false,
                                        absoluteOnLeave: false,
                                        onComplete: () => {
                                            ScrollTrigger.refresh();
                                        },
                                    })
                                }
                            })
                        })
                    }
                }, 10);

                setTimeout(() => {

                    if (scope.classList.contains('switch_on_enter')) {

                        function switcherClick() {

                            if (!document.documentElement.classList.contains('barba--running')) {

                                let switcher = document.querySelector('.pe-layout-switcher');

                                if (switcher) {
                                    switcher.click();
                                } else {

                                    let mainColors = [
                                        getComputedStyle(document.documentElement).getPropertyValue('--mainColor'),
                                        getComputedStyle(document.documentElement).getPropertyValue('--mainBackground'),
                                        getComputedStyle(document.documentElement).getPropertyValue('--secondaryColor'),
                                        getComputedStyle(document.documentElement).getPropertyValue('--secondaryBackground'),
                                        getComputedStyle(document.documentElement).getPropertyValue('--linesColor'),
                                    ]

                                    let switchedColors = [
                                        getComputedStyle(document.querySelector('.layout--colors')).getPropertyValue('--mainColor'),
                                        getComputedStyle(document.querySelector('.layout--colors')).getPropertyValue('--mainBackground'),
                                        getComputedStyle(document.querySelector('.layout--colors')).getPropertyValue('--secondaryColor'),
                                        getComputedStyle(document.querySelector('.layout--colors')).getPropertyValue('--secondaryBackground'),
                                        getComputedStyle(document.querySelector('.layout--colors')).getPropertyValue('--linesColor'),
                                    ]
                                    if (document.body.classList.contains('layout--switched')) {

                                        gsap.fromTo(document.body, {
                                            '--mainColor': switchedColors[0],
                                            '--mainBackground': switchedColors[1],
                                            '--secondaryColor': switchedColors[2],
                                            '--secondaryBackground': switchedColors[3],
                                        }, {
                                            '--mainColor': mainColors[0],
                                            '--mainBackground': mainColors[1],
                                            '--secondaryColor': mainColors[2],
                                            '--secondaryBackground': mainColors[3],
                                            duration: 1,
                                            ease: 'power3.out',
                                            onStart: () => {
                                                document.body.classList.remove('layout--switched')
                                            }
                                        })

                                    } else {
                                        gsap.fromTo(document.body, {
                                            '--mainColor': mainColors[0],
                                            '--mainBackground': mainColors[1],
                                            '--secondaryColor': mainColors[2],
                                            '--secondaryBackground': mainColors[3],
                                        }, {
                                            '--mainColor': switchedColors[0],
                                            '--mainBackground': switchedColors[1],
                                            '--secondaryColor': switchedColors[2],
                                            '--secondaryBackground': switchedColors[3],
                                            duration: 1,
                                            ease: 'power3.out',
                                            onStart: () => {
                                                document.body.classList.add('layout--switched')
                                            }
                                        })

                                    }

                                }
                            }

                        }

                        ScrollTrigger.create({
                            trigger: scope,
                            start: 'top center',
                            end: 'bottom center',
                            onEnter: () => switcherClick(),
                            onLeave: () => switcherClick(),
                            onEnterBack: () => switcherClick(),
                            onLeaveBack: () => switcherClick(),
                        })

                    }


                }, 20);

                if (scope.classList.contains('pinned_true')) {

                    ScrollTrigger.getById(scope.dataset.id) ? ScrollTrigger.getById(scope.dataset.id).kill(true) : '';

                    let items = scope.children,
                        classList = scope.className,
                        classes = classList.split(' '),
                        targetClass = classes.find(cls => cls.startsWith('pin_container')),
                        target = targetClass ? targetClass.substring("pin_container_".length) : '.' + scope.classList[0];

                    var pinnedScroll;

                    if (targetClass) {
                        pinnedScroll = ScrollTrigger.create({
                            trigger: document.querySelector(target),
                            pin: scope,
                            pinSpacing: true,
                            start: 'top top',
                            end: 'bottom bottom',
                            markares: true,
                            id: scope.dataset.id,
                        })

                    } else {

                        let settings;
                        if (scope.querySelector('.container--pin--sett')) {
                            settings = scope.querySelector('.container--pin--sett');
                        } else {
                            settings = scope;
                        }

                        var start = settings.dataset.pinStart,
                            end = settings.dataset.pinEnd,
                            pinMobile = settings.dataset.pinMobile;

                        pinnedScroll = ScrollTrigger.create({
                            trigger: scope,
                            start: start,
                            end: end,
                            id: scope.dataset.id,
                            pin: targetClass ? target : true,
                            pinSpacing: false,
                            pinSpacer: false,
                            endTrigger: targetClass ? target : 'body',

                        })
                    }

                    matchMedia.add({
                        isMobile: "(max-width: 570px)"
                    }, (context) => {
                        let {
                            isMobile
                        } = context.conditions;

                        if (!pinMobile) {
                            pinnedScroll.kill(true)
                        }
                    });

                }

                setTimeout(() => {
                    if (scope.classList.contains('curved_true')) {

                        let rhTop = document.querySelector('.rh--top.reverse__' + scope.dataset.id);
                        let rhBottom = document.querySelector('.rh--bottom.reverse__' + scope.dataset.id);

                        if (rhTop) {
                            gsap.set(rhTop, {
                                '--mainBackground': window.getComputedStyle(scope).backgroundColor
                            })
                        }
                        if (rhBottom) {
                            gsap.set(rhBottom, {
                                '--mainBackground': window.getComputedStyle(scope).backgroundColor
                            })

                        }
                    }

                }, 50);

                if (scope.classList.contains('e-parent') && document.querySelector('.site-header').classList.contains('header--auto--switch') || scope.classList.contains('switch--header--on--enter')) {

                    var scopeBg = getComputedStyle(scope).getPropertyValue('background-color');

                    if (scopeBg !== 'rgba(0, 0, 0, 0)' || scope.classList.contains('layout--switched')) {

                        ScrollTrigger.addEventListener("refreshInit", () => {
                            if (!parents(scope, '.site-header').length) {

                                setTimeout(() => {

                                    if (document.documentElement.classList.contains('loaded') && !scope.classList.contains('sc--initialized') && !parents(scope, '.site--menu').length) {
                                        scope.classList.add('sc--initialized');

                                        function integrateColors() {

                                            let headerColor = getComputedStyle(document.querySelector('.site-header')).getPropertyValue('--intColor'),
                                                headerBrightness = gsap.utils.splitColor(headerColor, true)[2],
                                                scopeBg = getComputedStyle(scope).getPropertyValue('background-color'),
                                                scopeBrightness = gsap.utils.splitColor(scopeBg, true)[2],
                                                header = document.querySelector('.site-header');

                                            if (headerBrightness >= scopeBrightness) {
                                                header.classList.add('header--switched')
                                            }

                                            if (scope.classList.contains('layout--switched') && !header.classList.contains('header--switched')) {
                                                header.classList.add('header--switched')
                                            }


                                        }

                                        let start = 'top top+=50',
                                            end = 'bottom top+=50';

                                        if (scope.classList.contains('pin--trigger')) {
                                            let scopeSc = ScrollTrigger.getById(scope.dataset.scrollId);
                                            start = scopeSc.start;
                                            end = scopeSc.end + scope.getBoundingClientRect().height;
                                        }

                                        if (scope.classList.contains('has--pinned--scroll')) {

                                            let pinFor = scope.dataset.pinFor,
                                                pinElement = document.querySelector('.elementor-element-' + pinFor),
                                                crId = pinElement.dataset.id,
                                                scopeSc = gsap.getById(crId).scrollTrigger;

                                            start = scopeSc.start < 0 ? -1 : scopeSc.start;
                                            end = scopeSc.end + scope.getBoundingClientRect().height;
                                        }

                                        ScrollTrigger.create({
                                            trigger: scope,
                                            start: start,
                                            end: end,
                                            onEnter: () => {
                                                integrateColors();
                                            },
                                            onEnterBack: () => {
                                                integrateColors()
                                            },
                                            onLeave: () => {
                                                document.querySelector('.site-header').classList.remove('header--switched')

                                            },
                                            onLeaveBack: () => {
                                                document.querySelector('.site-header').classList.remove('header--switched')
                                            },
                                        })

                                    }
                                }, 10);

                            }

                        });

                    }

                }

                if (scope.dataset.cursor) {

                    peCursorInteraction(scope);

                }

            }

        })

        elementorFrontend.hooks.addAction('frontend/element_ready/widget', function ($scope, $) {

            var jsScopeArray = $scope.toArray();
            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    id = scope.dataset.id;

                if (scope.classList.contains('cursor_drag')) {

                    peCursorDrag(scope)
                }

                // Scroll Buttons
                if (scope.querySelector('.pe--scroll--button')) {

                    scope.querySelectorAll('.pe--scroll--button').forEach(button => {
                        peScrollButton(button)
                    })
                }
                // Scroll Buttons

                if (scope.querySelector('.pe--browser--back')) {

                    scope.querySelector('.pe--browser--back').addEventListener('click', () => {

                        window.history.back();
                    })
                }

                //Animations
                setTimeout(() => {

                    if (scope.querySelector('[data-anim-general="true"]')) {

                        var hasAnim = scope.querySelectorAll('[data-anim-general="true"]');

                        hasAnim.forEach(element => {

                            if (!scope.querySelector('div[data-elementor-type="pe-menu"]')) {

                                new peGeneralAnimation(element)

                            }
                        })

                    }

                }, 10);


                if (scope.querySelector('[data-anim-image="true"]')) {

                    var hasAnim = scope.querySelectorAll('[data-anim-image="true"]');

                    hasAnim.forEach(element => {

                        if (!scope.querySelector('div[data-elementor-type="pe-menu"]')) {

                            new peImageAnimation(element)
                        }

                    })

                }

                setTimeout(() => {

                    if (scope.querySelector('[data-cursor="true"]')) {

                        var targets = scope.querySelectorAll('[data-cursor="true"]');

                        targets.forEach(target => {

                            peCursorInteraction(target);

                        })

                    }

                }, 10);

                if (scope.querySelector('[data-animate="true"]')) {

                    scope.querySelectorAll('[data-animate="true"]').forEach(text => {
                        if (!scope.querySelector('div[data-elementor-type="pe-menu"]')) {

                            document.fonts.ready.then((fontFaceSet) => {

                                if (!text.classList.contains('anim--hold')) {
                                    new peTextAnimation(text, false, false, id);

                                } else {

                                    let mainNav = scope.querySelector('.main-navigation > .menu'),
                                        items = mainNav.childNodes;

                                    for (let i = 0; i < items.length; i++) {

                                        if (items[i].tagName && items[i].tagName === 'LI') {
                                            items[i].querySelector('a').classList.add('menu--item--anim')
                                        }

                                    }

                                    mainNav.querySelectorAll('.menu--item--anim').forEach(link => {
                                        if (!link.classList.contains('anim--once')) {
                                            new peTextAnimation(link, text.dataset.settings, text.dataset.animation);
                                        }

                                    })


                                }



                            });

                        }
                    });

                }

                setTimeout(() => {

                    if (scope.querySelector('.pe-video')) {

                        let videos = scope.querySelectorAll('.pe-video');

                        if (!document.body.classList.contains('window--initialized')) {
                            for (var i = 0; i < videos.length; i++) {
                                new peVideoPlayer(videos[i]);
                            }
                        } else {
                            window.addEventListener("load", function () {
                                for (var i = 0; i < videos.length; i++) {
                                    new peVideoPlayer(videos[i]);
                                }
                            });
                        }

                    }

                }, 10);


                if (scope.querySelectorAll('.saren--single--product').length) {

                    scope.querySelectorAll('.saren--single--product').forEach(product => {

                        if (product.querySelector('.single_add_to_cart_button')) {
                            let button = product.querySelector('.single_add_to_cart_button'),
                                variationWrap = product.querySelector('.single_variation_wrap'),
                                table = product.querySelector('table.variations'),
                                form = product.querySelector('.variations_form');

                            if (product.classList.contains('product-type-variable')) {

                                setTimeout(() => {
                                    if (button.classList.contains('wc-variation-selection-needed')) {

                                        variationWrap.addEventListener('click', () => {

                                            if (!variationWrap.classList.contains('active')) {
                                                variationWrap.classList.add('active');
                                                form.classList.add('variations--active');
                                            } else {
                                                variationWrap.classList.remove('active');
                                                form.classList.remove('variations--active');
                                            }

                                        })

                                    }
                                }, 100);

                            }

                        }

                    })

                }

                if (scope.classList.contains('widget-pinned_true')) {

                    let settings = scope.querySelector('.widget--pin--sett'),
                        start = settings.dataset.pinStart,
                        end = settings.dataset.pinEnd,
                        target = settings.dataset.pinTarget,
                        pinMobile = settings.dataset.pinMobile;

                    ScrollTrigger.getById(scope.dataset.id) ? ScrollTrigger.getById(scope.dataset.id).kill(true) : '';

                    var widgetPin = ScrollTrigger.create({
                        trigger: scope,
                        start: start,
                        end: end,
                        id: scope.dataset.id,
                        pin: target ? target : true,
                        pinSpacing: false,
                        pinSpacer: false,
                        endTrigger: target ? target : 'body',
                    })

                    matchMedia.add({
                        isMobile: "(max-width: 570px)"
                    }, (context) => {

                        let {
                            isMobile
                        } = context.conditions;

                        if (!pinMobile) {
                            widgetPin.kill(true)
                        }

                    });

                }

            }

        })



        elementorFrontend.hooks.addAction('frontend/element_ready/peproductcards.default', function ($scope, $) {
            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    productCards = scope.querySelectorAll('.product--cards');

                productCards.forEach(function ($this) {
                    let cards = $this.querySelectorAll('.product--item'),
                        length = cards.length,
                        navWrap = scope.querySelector('.navigation--image--wrapper'),
                        navWrapWidth = navWrap.offsetWidth,
                        navImage = navWrap.querySelectorAll('.navigation--image'),
                        pinTarget = $this.getAttribute('data-pin-target'),
                        trigger = pinTarget,
                        e = 1;

                    if (scope.classList.contains('infinite--active')) {
                        e = 0
                        cards.forEach(function ($item) {
                            let clone = $item.cloneNode(true)
                            clone.classList.add('clone--product')
                            $this.querySelector('.products--wrapper').appendChild(clone)
                        })

                        navImage = navWrap.querySelectorAll('.navigation--image');

                        navImage.forEach(function ($nImage) {
                            let clone = $nImage.cloneNode(true)
                            navWrap.appendChild(clone)
                        })

                        navImage.forEach(function ($nImage) {
                            let clone = $nImage.cloneNode(true)
                            navWrap.appendChild(clone)
                        })

                        if (sarenLenis) {

                            sarenLenis.options.infinite = true;

                            if (window.barba) {
                                barba.hooks.before(() => {
                                    sarenLenis.options.infinite = false;
                                });
                            }
                        } else {

                            const lenis = new Lenis({
                                smooth: true,
                                infinite: true,
                                smoothTouch: true
                            });

                            function raf(time) {
                                lenis.raf(time);
                                requestAnimationFrame(raf);
                            }
                            requestAnimationFrame(raf);

                            if (window.barba) {

                                barba.hooks.before(() => {
                                    lenis.destroy();
                                });
                            }

                        }

                        cards = $this.querySelectorAll('.product--item');

                    };

                    cards[0].classList.add('product--active--meta')

                    cards.forEach(function ($item, i) {

                        $item.classList.add('product--index__' + i)

                        $item.setAttribute('data-y', (-i * 50) - (cards[0].offsetHeight / 2))
                        $item.setAttribute('data-z', -i * 150)
                        $item.setAttribute('data-opacity', 1 - (i * 0.25))

                        gsap.set($item, {
                            y: (-i * 50) - (cards[0].offsetHeight / 2),
                            z: -i * 150,
                            zIndex: 999 - i,
                            opacity: 1 - (i * 0.25)
                        })

                    })

                    if (!pinTarget) {
                        pinTarget = true
                        trigger = $this
                    }


                    ScrollTrigger.getById(scope.dataset.id) ? ScrollTrigger.getById(scope.dataset.id).kill(true) : '';

                    ScrollTrigger.create({
                        trigger: trigger,
                        pin: pinTarget,
                        scrub: true,
                        id: scope.dataset.id,
                        start: 'center center',
                        end: 'bottom+=' + $this.dataset.speed + ' bottom',
                        onUpdate: function (self) {
                            let yProg = (length) * 50 * self.progress,
                                zProg = (length) * 150 * self.progress,
                                opacityProg = length / 0.25 + self.progress * (length / 4),
                                activeIndex = parseInt(self.progress * length)

                            cards.forEach(function ($item, i) {
                                gsap.set($item, {
                                    y: parseInt($item.getAttribute('data-y')) + yProg,
                                    z: parseInt($item.getAttribute('data-z')) + zProg,
                                    opacity: 1 - ((i - 1) * 0.25) + (self.progress * (length / 4))
                                })
                                if (i < activeIndex - e) {
                                    gsap.set($item, {
                                        opacity: 0,
                                    })
                                }
                            })

                            cards.forEach(function ($card, i) {
                                if (i === activeIndex) {
                                    $card.classList.add('product--active--meta')
                                } else {
                                    $card.classList.remove('product--active--meta')
                                }

                            })


                            let prog = self.progress * (navWrapWidth - navImage[0].offsetWidth)
                            if (scope.classList.contains('infinite--active')) {
                                prog = self.progress * (navWrapWidth)
                            }
                            gsap.set(navWrap, {
                                x: -1 * prog
                            })
                            let navImages = navWrap.querySelectorAll('.navigation--image');
                            navImage.forEach(function ($card, i) {
                                if (i === Math.round(self.progress * (length))) {
                                    $card.classList.add('card--active')
                                } else {
                                    $card.classList.remove('card--active')
                                }
                            })
                        }
                    })

                    function triggerMouseWheel(deltaY) {
                        const event = new WheelEvent('wheel', {
                            deltaY: deltaY,
                        });
                        window.dispatchEvent(event);
                    }

                    navImage = navWrap.querySelectorAll('.navigation--image');
                    navImage.forEach(function ($navImage, i) {
                        $navImage.addEventListener('click', function ($click) {
                            let imageleft = this.getBoundingClientRect().left,
                                mainLeft = $this.getBoundingClientRect().left;
                            triggerMouseWheel((parseInt($this.dataset.speed) / navWrapWidth) * (imageleft - mainLeft))

                        })
                    })
                })
            }
        });

        elementorFrontend.hooks.addAction('frontend/element_ready/peproductslideshow.default', function ($scope, $) {
            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    productSlideshow = scope.querySelectorAll('.products--slideshow');

                productSlideshow.forEach(function ($this) {
                    let galleryWrap = $this.querySelectorAll('.product--image--gallery'),
                        productWrap = $this.querySelectorAll('.product--wrapper'),
                        length = $this.querySelectorAll('.product--item').length,
                        duration = $this.dataset.speed;


                    galleryWrap.forEach(function ($wrap) {

                        let galleryImage = $wrap.querySelectorAll('.product--gallery--image');
                        galleryImage.forEach(function ($gImage, i) {

                            var wrapper = document.createElement('div');
                            wrapper.className = 'parallax--wrap';

                            while ($gImage.firstChild) {
                                wrapper.appendChild($gImage.firstChild);
                            }

                            $gImage.appendChild(wrapper);

                            $gImage.setAttribute('data-index', i)
                            $gImage.classList.add('gallery--image__' + i)
                            gsap.set($gImage, {
                                zIndex: 100 - i
                            })
                            gsap.set($gImage.querySelector('.parallax--wrap'), {
                                width: $gImage.offsetWidth,
                                height: $gImage.offsetHeight
                            })
                        })
                    })


                    productWrap.forEach(function ($wrap) {
                        let product = $wrap.querySelectorAll('.product--item');
                        gsap.set(productWrap, {
                            height: product[0].offsetHeight
                        })
                        product.forEach(function ($product, i) {
                            $product.setAttribute('data-index', i)
                            gsap.set($product, {
                                zIndex: 100 - i
                            })
                        })
                    })

                    let activeIndex = 0
                    $this.querySelector('.nav--next').addEventListener('click', function () {

                        if (activeIndex < length - 1) {
                            activeIndex += 1
                            gsap.to($this.querySelector('.product--vertical--carousel--wrap'), {
                                yPercent: (100 / length) * activeIndex * -1,
                                duration: duration,
                                ease: 'expo.inOut'
                            })
                            galleryWrap.forEach(function ($wrap) {

                                let galleryImage = $wrap.querySelectorAll('.product--gallery--image');
                                galleryImage.forEach(function ($gImage, i) {

                                    if (activeIndex - 1 === i) {
                                        gsap.to($gImage, {
                                            width: 0,
                                            duration: duration,
                                            ease: 'expo.inOut'
                                        })
                                    }
                                })
                            })
                        }
                    })

                    $this.querySelector('.nav--prev').addEventListener('click', function () {

                        if (activeIndex > 0) {
                            activeIndex -= 1
                            gsap.to($this.querySelector('.product--vertical--carousel--wrap'), {
                                yPercent: (100 / length) * activeIndex * -1,
                                duration: duration,
                                ease: 'expo.inOut'
                            })

                            galleryWrap.forEach(function ($wrap) {

                                let galleryImage = $wrap.querySelectorAll('.product--gallery--image');
                                galleryImage.forEach(function ($gImage, i) {

                                    if (activeIndex === i) {
                                        gsap.to($gImage, {
                                            width: '100%',
                                            duration: duration,
                                            ease: 'expo.inOut'
                                        })
                                    }
                                })
                            })
                        }

                    })
                })


            }
        });


        elementorFrontend.hooks.addAction('frontend/element_ready/pecheckoutblock.default', function ($scope, $) {

            if (document.body.classList.contains('e-preview--show-hidden-elements')) {
                saren_CheckoutPage();
            }

        })

        elementorFrontend.hooks.addAction('frontend/element_ready/pe-slider.default', function ($scope, $) {

            peSlider();

            function peSlider() {

                var main = $scope.find('.pe-slider');

                main.each(function () {
                    let $this = $(this),
                        wrapper = $this.find('.slider-wrapper'),
                        slide = $this.find('.pe-slide'),
                        itemWidth = slide.outerWidth(true),
                        itemHeight = slide.outerHeight(true),
                        navButton = $this.find('.navigate-button'),
                        pinTarget = $this.data('pin-target'),
                        speed = $this.data('speed'),
                        next = $this.find('.next'),
                        prev = $this.find('.prev'),
                        fraction = $this.find('.pe-fraction'),
                        activeEl = fraction.find('.active'),
                        total = fraction.find('.total'),
                        trigger = pinTarget ? pinTarget : $this;

                    total.html(slide.length)

                    if (!pinTarget) {
                        pinTarget = true
                    }

                    slide.each(function (i) {
                        i++;

                        let item = $(this)

                        item.attr('data-index', i);
                        item.addClass('data-index_' + i)

                        item.find('.item-wrap').css('width', parseInt(itemWidth))
                        item.find('.item-wrap').css('height', parseInt(itemHeight))

                        item.find('.slide-image').css('width', parseInt(itemWidth))
                        item.find('.slide-image').css('height', parseInt(itemHeight))

                    })


                    if ($this.hasClass('nav_scroll')) {


                        let tl = gsap.timeline({
                            scrollTrigger: {
                                trigger: trigger,
                                start: 'top top',
                                end: 'bottom bottom',
                                pin: $this,
                                scrub: true,
                                onUpdate: (self) => {
                                    let prog = self.progress * slide.length;

                                    if (prog > 1) {
                                        activeEl.html(Math.floor(prog))
                                    }
                                }
                            }
                        })

                        slide.each(function (i) {
                            let item = $(this);

                            if ($this.hasClass('vertical')) {

                                tl.to($(this), {
                                    ease: 'none',
                                    height: '100%'
                                })

                                slide.first().nextAll().css('height', 0)

                            } else {

                                tl.to($(this), {
                                    ease: 'none',
                                    width: '100%'
                                })

                                slide.first().nextAll().css('width', 0)

                            }

                        })

                    } else if ($this.hasClass('nav_button')) {

                        var x;
                        x = 1

                        navButton.on('click', function (e) {

                            if ($(this).hasClass('prev')) {
                                x--;

                            } else if ($(this).hasClass('next')) {
                                x++;
                            }

                            if (x <= 1) {
                                x = 1

                                gsap.to(prev, {
                                    opacity: 0.2
                                })

                                gsap.to(next, {
                                    opacity: 1
                                })

                            } else if (x >= slide.length) {
                                x = slide.length

                                gsap.to(next, {
                                    opacity: 0.2
                                })

                                gsap.to(prev, {
                                    opacity: 1
                                })


                            } else if (1 < x < slide.length) {

                                gsap.to(next, {
                                    opacity: 1
                                })

                                gsap.to(prev, {
                                    opacity: 1
                                })

                            }

                            if ($(this).hasClass('prev')) {

                                if ($this.hasClass('vertical')) {

                                    gsap.to($this.find('.data-index_' + (x + 1)), {
                                        height: '0%',
                                        duration: 0.1
                                    })

                                } else {

                                    gsap.to($this.find('.data-index_' + (x + 1)), {
                                        width: '0%',
                                        duration: 0.1
                                    })

                                }

                                activeEl.html(x)

                            } else if ($(this).hasClass('next')) {

                                gsap.to($this.find('.data-index_' + x), {
                                    width: '100%',
                                    height: '100%',
                                    duration: 0.1
                                })

                                activeEl.html(x)

                            }



                        })

                    }



                })

            }



        });

        elementorFrontend.hooks.addAction('frontend/element_ready/peinnerpagenavigation.default', function ($scope, $) {

            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    nav = scope.querySelector('.pe--inner--page--navigation'),
                    items = scope.querySelectorAll('.inner--nav--element'),
                    follower = scope.querySelector('.nav--follower');

                function getActive(active) {

                    let width = active.getBoundingClientRect().width,
                        height = active.getBoundingClientRect().height,
                        left = active.getBoundingClientRect().left - nav.getBoundingClientRect().left,
                        top = active.getBoundingClientRect().top - nav.getBoundingClientRect().top;



                    if (scope.classList.contains('inner--nav--metro')) {

                        gsap.to(follower, {
                            width: width,
                            height: height,
                            left: left,
                            top: top,
                            duration: 1,
                            ease: 'expo.out',
                            overWrite: true
                        })
                    }

                }

                getActive(scope.querySelector('.active'));

                items.forEach(item => {

                    let target = item.dataset.scrollTo;

                    ScrollTrigger.create({
                        trigger: target,
                        start: 'top center',
                        end: 'bottom+=10 center',
                        onEnter: () => {
                            scope.querySelector('.active').classList.remove('active');
                            item.classList.add('active');
                            getActive(item);

                        },
                        onEnterBack: () => {
                            scope.querySelector('.active').classList.remove('active');
                            item.classList.add('active');
                            getActive(item);

                        }
                    })

                    item.addEventListener('click', () => {

                        scope.querySelector('.active').classList.remove('active');
                        item.classList.add('active');

                        getActive(item);

                    })

                })

            }

        })
        elementorFrontend.hooks.addAction('frontend/element_ready/petable.default', function ($scope, $) {

            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    rows = scope.querySelectorAll('.pe--table--row');

                rows.forEach(row => {

                    let image = row.querySelector('.pe--table--row--image');

                    row.addEventListener("mouseenter", (e) => {
                        if (image) {
                            gsap.set(image, {
                                x: e.layerX,
                                y: e.layerY
                            })
                        }


                    });
                    row.addEventListener("mousemove", (e) => {
                        if (image) {
                            gsap.to(image, {
                                x: e.layerX + 10,
                                y: e.layerY + 10,
                                rotate: e.movementX / 2
                            })
                        }

                    });

                })


            }

        });



        elementorFrontend.hooks.addAction('frontend/element_ready/pegooglemaps.default', function ($scope, $) {

            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i];

                function initMaps() {
                    function initMapSingle(latitude, longitude, zoomLevel, mapStyles, markerIcon) {

                        var mapOptions = {
                            zoom: zoomLevel,
                            center: { lat: parseFloat(latitude), lng: parseFloat(longitude) },
                            styles: mapStyles,
                            disableDefaultUI: true,
                            mapTypeControl: false,
                            fullscreenControl: false,
                            zoomControl: false,
                            streetViewControl: false,
                            rotateControl: false,
                            scaleControl: false
                        };

                        var map = new google.maps.Map(document.getElementById('pe--google--map'), mapOptions);

                        var markerOptions = {
                            position: mapOptions.center,
                            map: map,
                            icon: {
                                url: markerIcon,
                                scaledSize: new google.maps.Size(60, 60)
                            }
                        };

                        var marker = new google.maps.Marker(markerOptions);
                    }

                    function initMapMulti(markersData, mapStyles, zoomLevel) {
                        var mapOptions = {
                            zoom: zoomLevel,
                            center: {
                                lat: parseFloat(markersData[0].latitude),
                                lng: parseFloat(markersData[0].longitude)
                            },
                            styles: mapStyles,
                            disableDefaultUI: true
                        };

                        var map = new google.maps.Map(mapElement, mapOptions);
                        var markers = [];

                        markersData.forEach(function (markerData, i) {
                            var markerOptions = {
                                position: {
                                    lat: parseFloat(markerData.latitude),
                                    lng: parseFloat(markerData.longitude)
                                },
                                map: map,
                                icon: {
                                    url: markerData.icon,
                                    scaledSize: new google.maps.Size(60, 60)
                                },
                                title: markerData.title
                            };

                            const marker = new google.maps.Marker(markerOptions);
                            markers.push(marker);

                            marker.addListener('click', function (e, self) {
                                if (scope.querySelector('.map--marker--details.active')) {
                                    scope.querySelector('.map--marker--details.active').classList.remove('active');
                                }

                                var container = scope.querySelector('.map--multi--locations--wrapper');
                                var targetElement = container.querySelector('.marker__dets__' + i);

                                if (targetElement) {
                                    container.scrollTo({
                                        top: targetElement.offsetTop,
                                        left: targetElement.offsetLeft,
                                        behavior: "smooth"
                                    });
                                }

                                scope.querySelector('.marker__dets__' + i).classList.add('active');
                            });

                        });


                        if (scope.querySelector('.view--map--button')) {

                            scope.querySelectorAll('.view--map--button').forEach(button => {
                                button.addEventListener('click', function () {

                                    let index = button.dataset.marker,
                                        targetMarker = markers[parseInt(index)],
                                        parent = parents(button, '.map--marker--details')[0];

                                    if (scope.querySelector('.map--marker--details.active')) {
                                        scope.querySelector('.map--marker--details.active').classList.remove('active');
                                    }

                                    parent.classList.add('active');

                                    if (markers.length > 0) {

                                        // markers[0].setIcon({
                                        //     url: 'https://maps.google.com/mapfiles/ms/icons/red-dot.png',
                                        //     scaledSize: new google.maps.Size(60, 60)
                                        // });

                                        markers[index].setAnimation(google.maps.Animation.BOUNCE);
                                        map.setCenter(targetMarker.getPosition());
                                        map.setZoom(8);

                                        setTimeout(() => {
                                            markers[index].setAnimation(null);
                                        }, 2000);

                                    }
                                });
                            })

                        }
                    }

                    var mapElement = document.getElementById('pe--google--map');

                    if (mapElement) {
                        var zoomLevel = parseInt(mapElement.getAttribute('data-zoom-level'));
                        if (scope.classList.contains('map--type--single')) {
                            var latitude = mapElement.getAttribute('data-latitude');
                            var longitude = mapElement.getAttribute('data-longitude');

                            var mapStyles = JSON.parse(mapElement.getAttribute('data-map-styles'));
                            var markerIcon = mapElement.getAttribute('data-marker-icon');

                            initMapSingle(latitude, longitude, zoomLevel, mapStyles, markerIcon);

                        } else if (scope.classList.contains('map--type--multi')) {

                            var markersData = JSON.parse(mapElement.getAttribute('data-markers'));
                            var mapStyles = JSON.parse(mapElement.getAttribute('data-map-styles'));
                            initMapMulti(markersData, mapStyles, zoomLevel);
                        }

                    }

                }

                if (document.body.classList.contains('e-preview--show-hidden-elements')) {
                    initMaps();
                } else {

                    document.addEventListener('googleMapsLoaded', function () {
                        initMaps();
                    })


                }

            }

        });

        elementorFrontend.hooks.addAction('frontend/element_ready/pereviews.default', function ($scope, $) {

            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    cont = scope.querySelector('.ratings--swiper');

                if (scope.classList.contains('reviews--swiper--slideshow')) {
                    var reviewsSlider = new Swiper(cont, {
                        slidesPerView: 3,
                        speed: 750,
                        effect: 'fade',
                        fadeEffect: {
                            crossFade: true
                        },

                    });


                } else if (scope.classList.contains('reviews--swiper--carousel')) {
                    var reviewsSlider = new Swiper(cont, {
                        slidesPerView: 1,
                        spaceBetween: parseInt(cont.dataset.gap),
                        speed: 750,
                        breakpoints: {

                            570: {
                                slidesPerView: parseInt(cont.dataset.perView),
                                spaceBetween: parseInt(cont.dataset.gap),

                            },
                        }
                    });
                }


            }

        });

        elementorFrontend.hooks.addAction('frontend/element_ready/petestimonials.default', function ($scope, $) {

            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    testimonials = scope.querySelector('.pe--testimonials'),
                    wrapper = testimonials.querySelector('.pe--testimonials--wrapper'),
                    gap = window.getComputedStyle(wrapper).getPropertyValue('gap'),
                    wrapperHeight = wrapper.clientHeight,
                    wrapperWidth = wrapper.clientWidth,
                    items = wrapper.querySelectorAll('.pe-testimonial');

                let maxX = document.body.clientWidth * 0.75,
                    yVals = [];

                items.forEach((item, i) => {

                    if (testimonials.classList.contains('test--dynamic')) {
                        let itemX = item.getBoundingClientRect().x - testimonials.getBoundingClientRect().x,
                            itemWidth = item.getBoundingClientRect().width,
                            randX = gsap.utils.random((-maxX / 2), (maxX / 2)),
                            randY = gsap.utils.random(0, 400),
                            randR = gsap.utils.random(-15, 15);


                        if (itemX > maxX) {

                            gsap.set(item, {
                                x: (-itemX + (maxX / 2) - (itemWidth / 2) + (parseFloat(gap) * 3)) + randX,
                                y: randY,
                                rotate: randR
                            })

                        } else if (itemX < (maxX / 2)) {

                            gsap.set(item, {
                                x: gsap.utils.random(-250, -100),
                                y: gsap.utils.random(100, 300),
                                rotate: randR
                            })

                        } else if (itemX > (maxX / 2)) {

                            gsap.set(item, {
                                x: gsap.utils.random(100, (maxX / 3)),
                                y: gsap.utils.random(100, 300),
                                rotate: randR
                            })

                        }

                        yVals.push(randY)

                    }


                })

                wrapper.style.height = (100 + wrapperHeight + Math.max(...yVals)) + 'px';

                if (testimonials.classList.contains('carousel--centered')) {

                    gsap.set(wrapper, {
                        x: wrapperWidth / -6
                    })

                }

                Draggable.create(wrapper, {
                    type: 'x',
                    bounds: {
                        minX: 0,
                        maxX: -wrapperWidth + document.body.clientWidth - 50
                    },
                    lockAxis: true,
                    dragResistance: 0.5,
                    inertia: true,
                });

                var drag = Draggable.get(wrapper);

                if (testimonials.classList.contains('test--dynamic')) {

                    drag.disable();

                    wrapper.addEventListener('click', () => {

                        var state = Flip.getState(items);

                        testimonials.classList.add('pt--carousel')

                        gsap.set(items, {
                            clearProps: 'all'
                        })

                        Flip.from(state, {
                            duration: 1,
                            ease: "power3.inOut",
                            absolute: true,
                            absoluteOnLeave: true,
                            stagger: -0.05
                        });

                        drag.enable();
                        peCursorDrag(scope);
                        wrapper.classList.add('cursor--disabled');

                    })

                }



                matchMedia.add({
                    isMobile: "(max-width: 570px)"
                }, (context) => {

                    let {
                        isMobile
                    } = context.conditions;

                    wrapper.click();
                    gsap.set(wrapper, {
                        height: 'auto'
                    })

                });

            }
        });

        elementorFrontend.hooks.addAction('frontend/element_ready/pesitenavigation.default', function ($scope, $) {

            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    nav = scope.querySelector('.site--nav'),
                    toggle = scope.querySelector('.menu--toggle'),
                    menu = scope.querySelector('.site--menu'),
                    hideElements = nav.dataset.hideElements,
                    clicks = 0;

                function hideOnMenu(hide) {

                    if (hideElements) {

                        if (hide) {

                            gsap.to(hideElements, {
                                opacity: 0
                            })

                        } else {
                            gsap.to(hideElements, {
                                opacity: 1
                            })
                        }

                    }

                }

                if (scope.classList.contains('initialized')) {
                    return false;
                } else {
                    scope.classList.add('initialized')
                }

                toggle.addEventListener('click', () => {
                    clicks++


                    if (clicks % 2 == 0) {

                        if (nav.querySelectorAll('.st--active').length) {

                            nav.querySelectorAll('.st--active').forEach(st => {
                                st.click();
                            })
                        }

                        // Close
                        toggle.classList.remove('active');
                        enableScroll();

                        if (nav.classList.contains('nav--popup')) {
                            popUpNav(false);

                        } else if (nav.classList.contains('nav--fullscreen')) {
                            fullscreenNav(false);
                        }
                        hideOnMenu(false)

                    } else {
                        // Open
                        toggle.classList.add('active');
                        nav.querySelector('div[data-elementor-type=pe-menu]').style.visibility = 'visible'
                        disableScroll();

                        hideOnMenu(true)

                        if (nav.classList.contains('nav--popup')) {

                            popUpNav(true)

                        } else if (nav.classList.contains('nav--fullscreen')) {

                            fullscreenNav(true);

                        }

                    }

                })

                // Popup Navigation 

                function popUpNav(open) {

                    if (open) {

                        gsap.to(menu, {
                            x: scope.classList.contains('popup--pos--center') ? '-50%' : 0,
                            duration: 1.4,
                            ease: 'expo.inOut',
                            overwrite: true,
                            onStart: () => {
                                menu.classList.add('active')
                            }
                        })

                    } else {

                        gsap.to(menu, {
                            x: scope.classList.contains('popup--pos--right') ? '110%' : scope.classList.contains('popup--pos--left') ? '-110%' : '-50%',
                            duration: 1.4,
                            overwrite: true,
                            ease: 'expo.inOut',
                            onComplete: () => {
                                menu.classList.remove('active');
                                nav.querySelector('div[data-elementor-type=pe-menu]').style.visibility = 'hidden'
                            }
                        })
                    }

                }

                // Popup Navigation 

                // Fullscreen Navigation 
                function fullscreenNav(open) {

                    if (nav.classList.contains('overlay--slide')) {

                        if (open) {

                            gsap.to(menu, {
                                height: '100vh',
                                duration: .8,
                                overwrite: true,
                                ease: 'power4.out'
                            })

                            gsap.to('#primary', {
                                y: '50vh',
                                overwrite: true,
                                duration: .8,
                                ease: 'power4.out'
                            })


                        } else {

                            gsap.to(menu, {
                                height: '0vh',
                                duration: .8,
                                overwrite: true,
                                ease: 'power4.out'
                            })
                            gsap.to('#primary', {
                                y: '0vh',
                                duration: .8,
                                ease: 'power4.out',
                                overwrite: true,
                                onComplete: () => {
                                    nav.querySelector('div[data-elementor-type=pe-menu]').style.visibility = 'hidden'
                                }
                            })

                        }

                    } else if (nav.classList.contains('overlay--blocks')) {

                        let blocksWrapper = scope.querySelector('.nav--blocks');

                        if (open) {

                            gsap.to(scope.querySelectorAll('.fullscreen--menu--block'), {
                                height: '100vh',
                                duration: 1,
                                ease: 'power4.out',
                                overwrite: true,
                                stagger: {
                                    grid: [1, 20],
                                    from: "random",
                                    amount: .3,
                                },
                                onStart: () => {
                                    gsap.set([blocksWrapper, menu], {
                                        visibility: 'visible'
                                    })

                                }
                            })


                        } else {

                            gsap.to(scope.querySelectorAll('.fullscreen--menu--block'), {
                                height: '0vh',
                                duration: 1,
                                ease: 'power4.inOut',
                                overwrite: true,
                                id: 'fs--menu--blocks',
                                stagger: {
                                    grid: [1, 20],
                                    from: "random",
                                    amount: .3,
                                },
                                onComplete: () => {
                                    nav.querySelector('div[data-elementor-type=pe-menu]').style.visibility = 'hidden'
                                    gsap.set([blocksWrapper, menu], {
                                        visibility: 'hidden'
                                    })

                                }
                            })


                        }


                    } else if (nav.classList.contains('overlay--overlay')) {

                        let overlay = scope.querySelector('.nav_overlay'),
                            bgop = scope.querySelector('.nav_bg_opacity');

                        if (open) {

                            let state = Flip.getState(menu);

                            gsap.set(menu, {
                                height: 'auto'
                            })

                            Flip.from(state, {
                                duration: 1.25,
                                ease: 'expo.inOut',
                                absolute: false,
                                overwrite: true,
                                absoluteOnLeave: false
                            })

                        } else {
                            gsap.to(menu, {
                                height: '0',
                                duration: 1.25,
                                ease: 'expo.inOut',
                                overwrite: true,
                                onComplete: () => {
                                    nav.querySelector('div[data-elementor-type=pe-menu]').style.visibility = 'hidden'


                                }
                            })

                        }



                    }

                }


                // Fullscreen Navigation 




            }
        });

        elementorFrontend.hooks.addAction('frontend/element_ready/pefancyobjects.default', function ($scope, $) {
            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    scene = scope.querySelector('.pe--fancy--objects'),
                    wrapper = scope.querySelector('.fancy--objects--wrapper'),
                    objects = wrapper.querySelectorAll('.fancy--object'),
                    target = scene.dataset.eventsTarget,
                    mouseMoveElements = [],
                    prallaxTl = gsap.timeline({
                        scrollTrigger: {
                            trigger: target,
                            start: 'bottom bottom',
                            end: 'bottom top',
                            scrub: 1,
                        }
                    }),
                    fancyWraps = scene.querySelectorAll('.fancy--object--wrap');

                objects.forEach(object => {

                    if (object.classList.contains('motion--rotate')) {

                        gsap.to(object, {
                            rotate: 360,
                            ease: 'none',
                            duration: 15,
                            repeat: -1
                        })

                    } else if (object.classList.contains('motion--floating')) {

                        let tl = gsap.timeline({
                            repeat: -1
                        }),
                            xRand = gsap.utils.random(-50, 50),
                            yRand = gsap.utils.random(-50, 50);

                        tl.to(object, {
                            y: xRand,
                            x: yRand,
                            ease: 'none',
                            duration: 5,
                        })

                        tl.to(object, {
                            y: 0,
                            x: 0,
                            ease: 'none',
                            duration: 5,
                        })

                    } else if (object.classList.contains('motion--mousemove')) {

                        mouseMoveElements.push({
                            element: object,
                            xVal: gsap.utils.random(-75, 75),
                            yVal: gsap.utils.random(-75, 75)
                        })

                    } else if (object.classList.contains('motion--parallax')) {

                        prallaxTl.to(object, {
                            y: gsap.utils.random(-100, 100),
                        }, 0)

                    }

                })

                if (mouseMoveElements.length > 0) {

                    let windowWidth = window.innerWidth;
                    let windowHeight = window.innerHeight;

                    let movementStrength = 5;

                    document.querySelector(target).addEventListener('mousemove', (e) => {

                        let mouseX = e.clientX;
                        let mouseY = e.clientY;

                        for (let i = 0; i < mouseMoveElements.length; i++) {
                            let element = mouseMoveElements[i].element;
                            let movementX = (mouseX - windowWidth / 2) / windowWidth * movementStrength * mouseMoveElements[i].xVal;
                            let movementY = (mouseY - windowHeight / 2) / windowHeight * movementStrength * mouseMoveElements[i].yVal;

                            gsap.to(element, {
                                x: movementX,
                                y: movementY,
                                ease: "power1.out",
                                duration: 0.5
                            });
                        }
                    });
                }

                if (!scope.classList.contains('entrance--none')) {

                    let delay = scene.dataset.entranceDelay;

                    gsap.to(fancyWraps, {
                        scale: 1,
                        y: 0,
                        opacity: 1,
                        duration: 1,
                        stagger: 0.05,
                        ease: 'expo.out',
                        delay: delay ? delay : .3,
                        scrollTrigger: {
                            trigger: target,
                            start: 'center-=50 center',
                            end: 'bottom top'
                        }
                    })

                }



            }
        });

        elementorFrontend.hooks.addAction('frontend/element_ready/penavmenu.default', function ($scope, $) {
            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i];

                var nav = scope.querySelector('#site-navigation'),
                    menus = scope.querySelectorAll('ul'),
                    parentMenu = scope.querySelector('ul.main-menu'),
                    items = nav.querySelectorAll('.menu-item'),
                    toggleHTML = nav.dataset.subToggle,
                    toggle = document.createElement('div');

                if (scope.classList.contains('nav--initialized')) {
                    return false;
                } else {
                    scope.classList.add('nav--initialized');
                }

                items.forEach(item => {
                    item.querySelector('a').classList.add('menu--link');

                    item.querySelector('a').addEventListener('click', () => {
                        parentMenu.classList.add('menu--clicked');

                        if (parentMenu.querySelector('.current-menu-item')) {
                            parentMenu.querySelector('.current-menu-item').classList.remove('current-menu-item')
                        };

                        item.classList.add('current-menu-item');
                        if (parentMenu.classList.contains('menu--horizontal')) {
                            gsap.set(parentMenu, {
                                '--left': item.getBoundingClientRect().left - parentMenu.getBoundingClientRect().left + 'px',
                                '--width': item.getBoundingClientRect().width + 'px'
                            })

                        }
                    })

                    let link = item.querySelector('a');

                    if (scope.classList.contains('hover--chars-up')) {

                        new SplitText(link, {
                            type: "chars , words",
                            charsClass: "menu--item--char",
                            wordsClass: "menu--item--word",
                        });

                        link.addEventListener('mouseenter', () => {

                            let chars = link.querySelectorAll('.menu--item--char');

                            chars.forEach((char, i) => {

                                gsap.fromTo(char, {
                                    y: 0
                                }, {
                                    y: -17,
                                    duration: .4,
                                    ease: 'power2.in',
                                    delay: (i * 0.02),
                                    onComplete: () => {
                                        gsap.fromTo(char, {
                                            y: 17
                                        }, {
                                            y: 0,
                                            duration: .4,
                                            ease: 'power2.out',
                                        })

                                    }
                                })

                            })

                        })

                    };

                    if (scope.classList.contains('hover--words-up')) {

                        link.innerHTML = '<span>' + link.innerHTML + '</span>';
                        let span = link.querySelector('span');
                        let clone = span.cloneNode(true);
                        clone.classList.add('menu--item--clone');

                        link.appendChild(clone);

                    };

                })

                if (!scope.classList.contains('nav--init')) {

                    scope.classList.add('nav--init');

                    toggle.classList.add('st--wrap');
                    toggle.innerHTML = toggleHTML;

                    var childrens = [];
                    var childNodes = parentMenu.childNodes;

                    for (var i = 0; i < childNodes.length; i++) {

                        if (childNodes[i].nodeType === 1 && childNodes[i].tagName.toLowerCase() === "li") {

                            childrens.push(childNodes[i]);
                        }
                    }

                    if (!parentMenu.classList.contains('menu--horizontal')) {

                        parentMenu.querySelectorAll('.saren-sub-menu-wrap').forEach((sub) => {
                            sub.remove();
                        });

                    }

                    childrens.forEach((item, i) => {

                        i++
                        item.setAttribute('data-index', i);

                        if (item.classList.contains('menu-item-has-children') || item.classList.contains('saren-has-children')) {

                            let sub = item.querySelector('.sub-menu'),
                                a = item.childNodes[0];

                            item.insertBefore(toggle.cloneNode(true), sub);

                            item.querySelector('.st--wrap').addEventListener('click', (self) => {

                                self.target.classList.toggle('st--active');

                                if (item.classList.contains('sub--active')) {

                                    let subState = Flip.getState(sub, {
                                        props: ['padding']
                                    });
                                    item.classList.remove('sub--active');

                                    Flip.from(subState, {
                                        duration: .75,
                                        ease: 'expo.inOut',
                                        absolute: false,
                                        absoluteOnLeave: false,
                                    })

                                } else {

                                    nav.querySelector('.sub--active') ? nav.querySelector('.sub--active > .st--wrap').click() : '';

                                    let subState = Flip.getState(sub, {
                                        props: ['padding']
                                    });

                                    item.classList.add('sub--active');

                                    Flip.from(subState, {
                                        duration: .75,
                                        ease: 'expo.inOut',
                                        absolute: false,
                                        absoluteOnLeave: false,
                                    })
                                }

                            });

                            if (!nav.classList.contains('st--only')) {

                                a.addEventListener('click', (e) => {

                                    e.preventDefault();
                                    item.querySelector('.st--wrap').click();

                                })

                            }

                        }
                        // Has Children

                    })

                }

                if (scope.classList.contains('hover--background-follower') || scope.classList.contains('active--background-follower')) {

                    var activeItem;

                    if (scope.querySelector('.current-menu-item')) {
                        activeItem = scope.querySelector('.current-menu-item');
                        gsap.set(parentMenu, {
                            '--left': activeItem.getBoundingClientRect().left - parentMenu.getBoundingClientRect().left + 'px',
                            '--width': activeItem.getBoundingClientRect().width + 'px'
                        })
                    } else {
                        activeItem = false;
                    }

                    items.forEach(item => {

                        item.addEventListener('mouseenter', () => {
                            gsap.to(parentMenu, {
                                '--left': item.getBoundingClientRect().left - parentMenu.getBoundingClientRect().left + 'px',
                                '--width': item.getBoundingClientRect().width + 'px'
                            })
                        })

                        if (activeItem) {

                            parentMenu.addEventListener('mouseleave', () => {
                                if (!parentMenu.classList.contains('menu--clicked')) {
                                    gsap.to(parentMenu, {
                                        '--left': activeItem.getBoundingClientRect().left - parentMenu.getBoundingClientRect().left + 'px',
                                        '--width': activeItem.getBoundingClientRect().width + 'px'
                                    })
                                }

                            })

                        } else {

                            item.addEventListener('mouseleave', () => {
                                gsap.to(parentMenu, {
                                    '--left': item.getBoundingClientRect().left - parentMenu.getBoundingClientRect().left + 'px',
                                    '--width': '0px'
                                })
                            })

                        }

                    })

                }

            }
        });


        elementorFrontend.hooks.addAction('frontend/element_ready/petemplatepopup.default', function ($scope, $) {
            var jsScopeArray = $scope.toArray();
            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i];

                if (scope.querySelector('.pe--styled--popup')) {
                    pePopup(scope, scope);
                }

                if (!sarenLenis) {

                    const popLenis = new Lenis({
                        wrapper: scope.querySelector('.saren--popup--template'),
                        smooth: true,
                        smoothTouch: false
                    });

                    function raf(time) {
                        popLenis.raf(time);
                        requestAnimationFrame(raf);
                    }
                    requestAnimationFrame(raf);

                }

            };

        })

        elementorFrontend.hooks.addAction('frontend/element_ready/pewooajaxsearch.default', function ($scope, $) {

            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    wrapper = scope.querySelector('.saren--woo--ajax--search');

                if (!wrapper.classList.contains('search--default') && !wrapper.classList.contains('search--popup')) {

                    let button = scope.querySelector('.saren--woo--ajax--search--button'),
                        form = scope.querySelector('.saren-woo-ajax-search-form'),
                        overlay = scope.querySelector('.ajax--search--overlay');

                    button.addEventListener('click', () => {
                        wrapper.classList.toggle('active');
                    })

                    overlay.addEventListener('click', () => {
                        wrapper.classList.toggle('active');
                    })

                }

                if (wrapper.classList.contains('search--popup')) {
                    pePopup(scope, wrapper);
                }

                function wooAjaxSearch() {
                    var searchForm = $(scope).find('#saren-woo-ajax-search-form'),
                        parent = $(searchForm).closest('.saren--woo--ajax--search'),
                        count = parent.data('results-count'),
                        total,
                        debounceTimer;

                    if (!searchForm.length) {
                        return false;
                    }

                    $(scope).find('#saren-woo-search-input').on('keyup', function (e, offs) {
                        let searchQuery = $(this).val(),
                            resultsContainer = $(scope).find('.s--woo--search--results');

                        clearTimeout(debounceTimer);

                        debounceTimer = setTimeout(() => {
                            if (searchQuery && searchQuery.length > 2) {
                                $.ajax({
                                    url: woocommerce_params.ajax_url,
                                    type: 'POST',
                                    data: {
                                        action: 'woocommerce_ajax_search',
                                        search_query: searchQuery,
                                        count: parseInt(count),
                                        offset: offs ? offs : 0
                                    },
                                    beforeSend: function () {
                                        wrapper.classList.add('searching');
                                    },
                                    success: function (response) {
                                        const responseDoc = $.parseHTML(response)[0],
                                            products = responseDoc.querySelectorAll('.saren--search--product');

                                        total = responseDoc.dataset.total;

                                        if (parseInt(total) < count) {
                                            wrapper.classList.remove('has--pagination')
                                        }

                                        setTimeout(() => {
                                            wrapper.classList.remove('searching');

                                            if (offs) {
                                                products.forEach(product => {
                                                    scope.querySelector('.saren--ajax--search--result').appendChild(product);
                                                })
                                                let offset = (offs + 1) * parseInt(count);

                                                if (offset >= parseInt(total)) {
                                                    wrapper.classList.remove('has--pagination')
                                                }

                                            } else {
                                                resultsContainer.html(response).fadeIn();

                                                gsap.fromTo(scope.querySelector('.search--results-wrap'), {
                                                    opacity: 0,
                                                    yPercent: -20
                                                }, {
                                                    opacity: 1,
                                                    yPercent: 0,
                                                    delay: 0.5,
                                                    overwrite: true,
                                                    onComplete: () => {
                                                        total = responseDoc.dataset.total;

                                                        if (parseInt(total) > count) {
                                                            wrapper.classList.add('has--pagination')
                                                        } else {
                                                            wrapper.classList.remove('has--pagination')
                                                        }
                                                    }
                                                });
                                            }

                                            $(scope).find('a').on('click', function () {
                                                let searchPopButton = $(scope).find('.pe--search--pop--button');
                                                if (searchPopButton.length) {

                                                    searchPopButton.trigger('click');

                                                    let fullscreenNav = $(this).closest('.nav--fullscreen');

                                                    if (fullscreenNav.length) {
                                                        fullscreenNav.find('.menu--toggle').trigger('click');
                                                    }
                                                }
                                            });

                                            if (!sarenLenis) {
                                                const searchLenis = new Lenis({
                                                    wrapper: scope.querySelector('.search--results-wrap'),
                                                    smooth: false,
                                                    smoothTouch: false
                                                });

                                                function raf(time) {
                                                    siteHeader
                                                    searchLenis.raf(time);
                                                    requestAnimationFrame(raf);
                                                }
                                                requestAnimationFrame(raf);

                                            }

                                        }, 1000);
                                    }
                                });

                            } else {
                                resultsContainer.hide();
                            }
                        }, 500);
                    });

                    if (scope.querySelector('.search--products--load--more')) {

                        var button = scope.querySelector('.search--products--load--more'),
                            clicks = 0;

                        button.addEventListener('click', () => {
                            clicks++
                            $(scope).find('#saren-woo-search-input').trigger('keyup', [clicks]);
                        })

                    }

                    if (scope.querySelector('.woo--ajax--search--tags')) {

                        let tags = scope.querySelectorAll('.search-tag');

                        tags.forEach(tag => {
                            tag.addEventListener('click', () => {
                                scope.querySelector('#saren-woo-search-input').value = tag.dataset.val;
                                $(scope).find('#saren-woo-search-input').trigger('keyup');
                            })
                        })



                    }

                }

                wooAjaxSearch();


            }
        })



        elementorFrontend.hooks.addAction('frontend/element_ready/petextwrapper.default', function ($scope, $) {

            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    wrapper = scope.querySelector('.text-wrapper');


                document.fonts.ready.then((fontFaceSet) => {
                    //Inner Elements
                    var innerElements = wrapper.querySelectorAll('[class^="inner--"] , .customized--word');



                    innerElements.forEach((element) => {


                        let classes = element.classList,
                            hasMotion = Array.from(classes).some(className => className.startsWith('me--'));


                        // Motion Effects
                        if (hasMotion) {

                            let motion = hasMotion ? Array.from(classes).find(className => className.startsWith('me--')) : null,
                                duration = element.dataset.duration,
                                delay = element.dataset.delay,
                                ease = motion === 'me--flip-x' ? 'none' : motion === 'me--flip-y' ? 'none' : motion === 'me--hearthbeat-x' ? 'power4.inOut' : motion === 'me--slide-left' ? 'power3.in' : motion === 'me--slide-right' ? 'power3.in' : 'expo.out',
                                tl = gsap.timeline({
                                    repeat: -1,
                                    repeatDelay: parseInt(delay, 10)
                                }),
                                target = element;

                            if (motion === 'me--slide-left' || motion === 'me--slide-right') {

                                target = element.firstElementChild ? element.firstElementChild : element;
                            }

                            tl.fromTo(target, {
                                xPercent: 0,
                                scale: motion === 'me--hearth-beat' ? 0.6 : 1
                            }, {

                                scale: 1,
                                rotate: motion === 'me--rotate' ? -360 : 0,
                                rotateX: motion === 'me--flip-x' ? -360 : 0,
                                rotateY: motion === 'me--flip-y' ? -360 : 0,
                                xPercent: motion === 'me--slide-left' ? -100 : motion === 'me--slide-right' ? 100 : 0,
                                duration: duration,
                                ease: ease,

                            })

                            if (motion === 'me--slide-left' || motion === 'me--slide-right') {

                                tl.fromTo(target, {
                                    xPercent: motion === 'me--slide-left' ? 100 : motion === 'me--slide-right' ? -100 : 0
                                }, {
                                    xPercent: 0,
                                    duration: duration,
                                    ease: 'power3.out',
                                })
                            }

                            if (motion === 'me--hearth-beat') {

                                tl.to(target, {
                                    scale: 0.6,
                                    duration: duration
                                })
                            }

                        }

                        if (element.classList.contains('inserted--pin')) {

                            let state = Flip.getState(element),
                                target = element.dataset.zoomPin ? element.dataset.zoomPin : scope,
                                tl = gsap.timeline({
                                    scrollTrigger: {
                                        trigger: target,
                                        scrub: true,
                                        pin: true,
                                        start: 'center center',
                                        end: 'bottom+=500 top',
                                    }
                                });

                            gsap.set(element, {
                                position: 'fixed',
                                width: '100vw',
                                height: '100vh',
                                top: 0,
                                left: 0,

                            })

                            let fl = Flip.from(state, {
                                absolute: false,
                                absoluteOnLeave: false,
                            })

                            tl.add(fl, 0)

                        }

                    })
                    //Inner Elements

                    //Dyanmic words
                    function dynamicWordAnimation() {

                        let dynamicWords = wrapper.querySelectorAll('.pe-dynamic-words');

                        dynamicWords.forEach((dynamic) => {

                            if (!dynamic.classList.contains('dyno--init')) {
                                dynamic.classList.add('dyno--init');

                                let innerWrap = dynamic.firstElementChild,
                                    words = innerWrap.querySelectorAll('span'),
                                    duration = parseFloat(dynamic.dataset.duration),
                                    delay = parseFloat(dynamic.dataset.delay),
                                    pin = dynamic.dataset.pin,
                                    scrub = dynamic.dataset.scrub,
                                    scroll = false;

                                if (pin === 'true' || scrub === 'true') {

                                    scroll = {
                                        trigger: scope,
                                        pin: pin === 'true' ? scope : false,
                                        scrub: 1,
                                        start: pin === 'true' ? 'center center' : 'top bottom',
                                        end: pin === 'true' ? 'bottom+=500 top' : 'bottom top',
                                    };

                                }

                                let tl = gsap.timeline({
                                    repeat: pin === 'true' ? 0 : scrub === 'true' ? 0 : -1,
                                    scrollTrigger: scroll
                                });

                                dynamic.style.width = Math.ceil(words[0].getBoundingClientRect().width) + 'px';

                                words.forEach((word, i) => {

                                    tl.to(innerWrap, {
                                        yPercent: -100 / words.length * i,
                                        duration: duration,
                                        delay: i == 0 ? 0 : delay,
                                        ease: scroll ? 'none' : 'expo.inOut'
                                    }, 'label_' + i)

                                    tl.to(dynamic, {
                                        width: Math.ceil(word.getBoundingClientRect().width),
                                        duration: duration,
                                        delay: delay,
                                        ease: scroll ? 'none' : 'expo.inOut'
                                    }, 'label_' + i)


                                })

                            }



                        })

                    }

                    dynamicWordAnimation();
                    //Dyanmic words

                    setTimeout(() => {

                        if (scope.querySelector('.custom-lines-hold')) {

                            for (let i = 0; i < wrapper.childNodes.length; i++) {

                                if (wrapper.childNodes[i].tagName) {
                                    new SplitText(wrapper.childNodes[i], {
                                        type: "lines",
                                        linesClass: "customized--line",
                                    });
                                }

                            }

                            wrapper.querySelectorAll('.customized--line').forEach((line, i) => {
                                i++
                                line.classList.add('cs--line--' + i)
                            })

                            let holds = scope.querySelectorAll('.csl--hold');

                            if (holds) {

                                holds.forEach(hold => {

                                    let line = hold.dataset.line,
                                        id = hold.dataset.id,
                                        findLine = '.cs--line--' + line;

                                    if (scope.querySelector(findLine)) {

                                        scope.querySelector(findLine).classList.add('elementor-repeater-item-' + id);

                                    }





                                })
                            }

                        }

                    }, 50);

                    if (scope.classList.contains('slide--text')) {

                        gsap.to(wrapper, {
                            x: -wrapper.getBoundingClientRect().width + document.body.clientWidth - (wrapper.getBoundingClientRect().left * 2),
                            scrollTrigger: {
                                trigger: wrapper,
                                start: 'center center',
                                ease: 'none',
                                end: 'bottom+=2000 top',
                                scrub: 1,
                                pin: true
                            }
                        })

                    }


                });

            }

        });

        elementorFrontend.hooks.addAction('frontend/element_ready/pecircletext.default', function ($scope, $) {

            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i];

                if (scope) {
                    var circularText = document.querySelectorAll('.pe-circular-text');


                    circularText.forEach(function ($this) {
                        var textWrap = $this.querySelector('.circular-text-wrap'),
                            circularContent = $this.querySelector(".circular-text-content"),
                            dataHeight = $this.dataset.height,
                            dataDuration = $this.dataset.duration,
                            dataTarget = $this.dataset.target,
                            circleSplit = new SplitText($this.querySelector('.circle-text'), {
                                type: "words, chars",
                                charsClass: "circle-char",
                                wordsClass: "circle-word",
                                position: "absolute"
                            }),
                            fontSize = parseInt(window.getComputedStyle($this.querySelector('.circle-char')).fontSize),
                            charLength = $this.querySelectorAll('.circle-char').length,
                            textLength = (dataHeight / charLength) / (fontSize / 1.75),
                            circleChar = $this.querySelectorAll('.circle-char'),
                            circleWord = $this.querySelectorAll('.circle-word'),
                            snap = gsap.utils.snap(1),
                            dataIcon = $this.dataset.icon;

                        for (var i = 2; i <= snap(textLength); i++) {
                            var clonedContent = circularContent.cloneNode(true);
                            textWrap.appendChild(clonedContent);
                        }
                        circularContent = $this.querySelectorAll(".circular-text-content");

                        gsap.set(circularContent, {
                            width: dataHeight,
                            height: dataHeight
                        })

                        var circleWordElements = $this.querySelectorAll('.circle-word');

                        circleWordElements.forEach(function (circleWordElement) {
                            var circleCharElement = document.createElement('span');
                            circleCharElement.className = 'circle-char';
                            circleWordElement.appendChild(circleCharElement);
                        });

                        $this.querySelectorAll('.circle-word').forEach(function (circleWordElement) {
                            gsap.set(circleWordElement, {
                                left: '50%',
                                top: 0,
                                height: "100%",
                                xPercent: -50
                            })
                        });

                        var charElements = $this.querySelectorAll('.circle-char'),
                            rotateMultiplier = 360 / charElements.length;

                        charElements.forEach(function (charElement, index) {

                            gsap.set(charElement, {
                                rotate: rotateMultiplier * index,
                                left: '50%',
                                xPercent: -50,
                                top: 0,
                                height: "50%"
                            });

                        });

                        var tl = gsap.timeline();

                        gsap.set(textWrap, {
                            width: dataHeight,
                            height: dataHeight
                        });

                        if ($this.classList.contains('counter-clockwise')) {
                            tl.to(textWrap, {
                                rotation: -360,
                                duration: dataDuration,
                                ease: "none",
                                repeat: -1
                            });
                        } else {
                            tl.to(textWrap, {
                                rotation: 360,
                                duration: dataDuration,
                                ease: "none",
                                repeat: -1
                            });
                        }

                        let whaler = Hamster(document.querySelector('body')),
                            wheelDeltaY, currentDeltaY;

                        function createWheelStopListener(element, callback, timeout) {
                            var handle = null;
                            var onScroll = function () {
                                if (handle) {
                                    clearTimeout(handle);
                                }
                                handle = setTimeout(callback, timeout || 200); // 
                            };
                            element.addEventListener('wheel', onScroll);
                            return function () {
                                element.removeEventListener('wheel', onScroll);
                            };
                        }

                        whaler.wheel(function (event, delta, deltaX, deltaY) {

                            wheelDeltaY = event.deltaY;
                            event.deltaY < 0 ? wheelDeltaY = -1 * event.deltaY : '';
                            tl.timeScale(1 + (wheelDeltaY * 2))

                        });

                        createWheelStopListener(window, function () {
                            tl.timeScale(1)
                        });

                        $this.addEventListener('click', function () {
                            window.scrollTo({
                                top: document.querySelector(dataTarget).offsetTop,
                                behavior: "smooth"
                            });
                        });


                    })

                }


            }
        });


        elementorFrontend.hooks.addAction('frontend/element_ready/pecarousel.default', function ($scope, $) {

            var jsScopeArray = $scope.toArray();
            for (var i = 0; i < jsScopeArray.length; i++) {

                var scope = jsScopeArray[i],
                    carousel = scope.querySelector('.pe--carousel'),
                    wrapper = carousel.querySelector('.carousel--wrapper'),
                    id = carousel.dataset.id ? carousel.dataset.id : scope.dataset.id,
                    items = carousel.querySelectorAll('.carousel--item'),
                    length = items.length,
                    wrapperWidth = wrapper.offsetWidth,
                    carouselWidth = carousel.offsetWidth,
                    trigger = carousel.dataset.trigger ? carousel.dataset.trigger : '.' + carousel.classList[0];

                document.querySelector(trigger) ? document.querySelector(trigger).classList.add('pin--trigger') : '';
                document.querySelector(trigger) ? document.querySelector(trigger).dataset.scrollId = id : '';


                items.forEach(item => {
                    var index = parseInt(item.dataset.index);
                });



                function carouselScroll() {

                    gsap.getById(id) ? gsap.getById(id).scrollTrigger.kill(true) : '';

                    gsap.to(wrapper, {
                        x: isRTL ? wrapperWidth - carouselWidth : (-1 * wrapperWidth) + carouselWidth,
                        ease: 'none',
                        id: id,
                        scrollTrigger: {

                            trigger: trigger,
                            scrub: true,
                            pin: trigger,
                            ease: "elastic.out(1, 0.3)",
                            start: 'center center',
                            end: 'bottom+=6000 bottom',
                            pinSpacing: 'padding',
                            onEnter: () => isPinnng(trigger, true),
                            onEnterBack: () => isPinnng(trigger, true),
                            onLeave: () => isPinnng(trigger, false),
                            onLeaveBack: () => isPinnng(trigger, false),
                        }
                    })

                }

                function carouselDrag() {

                    Draggable.create(wrapper, {
                        type: 'x',
                        bounds: {
                            minX: 0,
                            maxX: -wrapperWidth + document.body.clientWidth - 50
                        },
                        onDrag: (self) => {



                        },
                        lockAxis: true,
                        dragResistance: 0.5,
                        inertia: true,
                        allowContextMenu: true,
                        allowEventDefault: true,
                    });


                }

                function carouselLoop() {

                    var tl = gsap.timeline({
                        repeat: -1,
                    }),
                        direction = wrapper.dataset.direction,
                        speed = parseInt(wrapper.dataset.speed),
                        speedUp = wrapper.dataset.speedUp;

                    
                    let cloneLength;
                    for (cloneLength = 0; cloneLength <= Math.floor(window.innerWidth / (items[0].offsetWidth * items.length)); cloneLength++) {
                        items.forEach(item => {
                            let clone = item.cloneNode(true);
                            wrapper.appendChild(clone);
                            
                        });
                    }


    
                    if (direction !== 'right-to-left') {
                        Array.from(items).reverse().forEach(item => {
                            let clone = item.cloneNode(true);
                            wrapper.prepend(clone);
                        });
                    }

                    wrapper.style.width = wrapperWidth * 2

                    let gap = window.getComputedStyle(wrapper).getPropertyValue('gap');

                    if (direction === 'right-to-left') {

                        tl.to(wrapper, {
                            x: -wrapperWidth - parseFloat(gap),
                            duration: speed,
                            ease: 'none',
                        });

                    } else {

                        gsap.set(wrapper, {
                            x: -wrapperWidth - parseFloat(gap)
                        })

                        tl.fromTo(wrapper, {
                            x: -wrapperWidth - parseFloat(gap)
                        }, {
                            x: 0,
                            duration: speed,
                            ease: 'none',
                        })
                    }

                    if (speedUp) {

                        let whaler = Hamster(document.querySelector('body')),
                            wheelDeltaY, currentDeltaY;

                        function createWheelStopListener(element, callback, timeout) {
                            var handle = null;
                            var onScroll = function () {
                                if (handle) {
                                    clearTimeout(handle);
                                }
                                handle = setTimeout(callback, timeout || 200); // 
                            };
                            element.addEventListener('wheel', onScroll);
                            return function () {
                                element.removeEventListener('wheel', onScroll);
                            };
                        }

                        whaler.wheel(function (event, delta, deltaX, deltaY) {

                            wheelDeltaY = event.deltaY;
                            event.deltaY < 0 ? wheelDeltaY = -1 * event.deltaY : '';
                            tl.timeScale(1 + (wheelDeltaY * 3))

                        });

                        createWheelStopListener(window, function () {
                            tl.timeScale(1)
                        });

                    }

                    if (scope.classList.contains('pause--on--hover')) {

                        wrapper.addEventListener('mouseenter', () => {
                            tl.pause();
                        })

                        wrapper.addEventListener('mouseleave', () => {
                            tl.play();
                        })

                    }

                }

                carousel.classList.contains('cr--scroll') ? carouselScroll() : carousel.classList.contains('cr--drag') ? carouselDrag() : carouselLoop();



                if (scope.querySelector('.product--archive--gallery')) {

                    let swiperCont = scope.querySelectorAll('.product--archive--gallery');

                    swiperCont.forEach(cont => {

                        var productArchiveGallery = new Swiper(cont, {
                            slidesPerView: 1,
                            speed: 750,
                            navigation: {
                                nextEl: cont.querySelector('.pag--next'),
                                prevEl: cont.querySelector('.pag--prev'),
                            },
                        });

                    });

                }


            }

        });

        elementorFrontend.hooks.addAction('frontend/element_ready/pecomparetable.default', function ($scope, $) {

            var jsScopeArray = $scope.toArray();
            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i];


                let container = scope.querySelector('.pe--compare--container'),
                    side = scope.querySelector('.pe--compare--container--side'),
                    main = scope.querySelector('.pe--compare--container--main'),
                    mainItemsWrap = main.querySelector('.pe--compare--items--wrap');


                function compareDraggable() {

                    if ((side.getBoundingClientRect().width + main.getBoundingClientRect().width) < container.getBoundingClientRect().width) {
                        return false;
                    }

                    let drag = Draggable.create(mainItemsWrap, {
                        type: 'x',
                        dragResistance: 0.35,
                        inertia: true,
                        bounds: main,
                        allowContextMenu: true
                    })

                };

                compareDraggable();

                document.addEventListener("compareUpdated", function () {
                    compareDraggable();
                })


            };

        });


        elementorFrontend.hooks.addAction('frontend/element_ready/pehotspotimage.default', function ($scope, $) {

            var jsScopeArray = $scope.toArray();
            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    wrapper = scope.querySelector('.pe--hotspot--image'),
                    markers = scope.querySelectorAll('.hotspot--marker'),
                    image = scope.querySelector('.main--hotspot--image');

                function calcContentPos(marker, content, index) {
                    let markerTop = marker.getBoundingClientRect().top - image.getBoundingClientRect().top,
                        markerBottom = image.getBoundingClientRect().bottom - marker.getBoundingClientRect().bottom,
                        markerLeft = marker.getBoundingClientRect().left - wrapper.getBoundingClientRect().left,
                        markerRight = wrapper.getBoundingClientRect().right - marker.getBoundingClientRect().right,
                        vOrientation = marker.dataset.verticalOrientation,
                        hOrientation = marker.dataset.horizontalOrientation;

                    if (vOrientation === 'top') {
                        content.style.top = markerTop - 15 + 'px';
                    } else {
                        content.style.bottom = markerBottom - 15 + 'px';
                    }

                    if (hOrientation === 'left') {

                        content.style.left = markerLeft - 15 + 'px';
                    } else {
                        content.style.right = markerRight - 15 + 'px';
                    }

                    content.style.display = 'block';
                }

                if (scope.classList.contains('open-on-scroll')) {

                    let pinTarget = wrapper.dataset.pinTarget,
                        duration = 500 * markers.length;

                    gsap.getById(scope.dataset.id) ? gsap.getById(scope.dataset.id).scrollTrigger.kill(true) : '';

                    var hotspotTl = gsap.timeline({
                        scrollTrigger: {
                            trigger: scope.classList.contains('pin-on-scroll') ? pinTarget : image,
                            pin: scope.classList.contains('pin-on-scroll') ? pinTarget : false,
                            id: scope.dataset.id,
                            scrub: true,
                            start: scope.classList.contains('pin-on-scroll') ? 'top top' : 'top center',
                            markers: false,
                            end: scope.classList.contains('pin-on-scroll') ? 'bottom+=' + duration + ' top' : 'top top'
                        }
                    })

                    matchMedia.add({
                        isPhone: "(max-width: 550px)"
                    }, (context) => {

                        hotspotTl.scrollTrigger.kill(true);

                    });

                }

                if (scope.querySelector('.hotspots--line--scene')) {

                    let scene = scope.querySelector('.hotspots--line--scene'),
                        lines = scene.querySelectorAll('polyline');

                    const width = wrapper.getBoundingClientRect().width;
                    const height = wrapper.getBoundingClientRect().height;

                    scene.setAttribute("viewBox", `0 0 ${width} ${height}`);

                    lines.forEach(line => {

                        let index = line.dataset.index,
                            content = scope.querySelector('.hp__content__' + index);

                        let p1x = width * (parseInt(getComputedStyle(line).getPropertyValue('--p1x')) * 0.01),
                            p1y = height * (parseInt(getComputedStyle(line).getPropertyValue('--p1y')) * 0.01),
                            p2x = width * (parseInt(getComputedStyle(line).getPropertyValue('--p2x')) * 0.01),
                            p2y = height * (parseInt(getComputedStyle(line).getPropertyValue('--p2y')) * 0.01),
                            p3x = width * (parseInt(getComputedStyle(line).getPropertyValue('--p3x')) * 0.01),
                            p3y = height * (parseInt(getComputedStyle(line).getPropertyValue('--p3y')) * 0.01);

                        line.setAttribute("points", `${p1x} ${p1y} ${p2x} ${p2y} ${p3x} ${p3y}`);


                        gsap.set(content, {
                            left: p3x,
                            right: 'unset',
                            top: p3y,
                            xPercent: p3x < (width / 2) ? -100 : 0,
                        })

                        if (scope.classList.contains('click-to-open') || scope.classList.contains('hover-to-open')) {
                            gsap.set(line, {
                                drawSVG: 0,
                            })
                        }

                    })

                    let dots = scope.querySelectorAll('.hotspot--line--dot');


                    dots.forEach((dot, i) => {

                        let line = scope.querySelector('.hp__marker__' + dot.dataset.index),
                            content = scope.querySelector('.hp__content__' + dot.dataset.index);

                        function contentToggle() {

                            gsap.fromTo(line, {
                                drawSVG: !dot.classList.contains('active') ? '0%' : '100%',
                            }, {
                                drawSVG: !dot.classList.contains('active') ? '100%' : '0%',
                                duration: 1.5,
                                ease: 'expo.inOut',
                                overWrite: true,
                            })

                            gsap.to(content, {
                                opacity: !dot.classList.contains('active') ? 1 : 0,
                                delay: !dot.classList.contains('active') ? 1 : 0,
                                overWrite: true,
                            })
                            !dot.classList.contains('active') ? dot.classList.add('active') : dot.classList.remove('active');
                        }

                        if (scope.classList.contains('click-to-open')) {
                            dot.addEventListener("click", (event) => contentToggle());

                        } else if (scope.classList.contains('hover-to-open')) {
                            dot.addEventListener("mouseenter", (event) => contentToggle());
                            dot.addEventListener("mouseleave", (event) => contentToggle());
                        } else if (scope.classList.contains('open-on-scroll')) {

                            hotspotTl.fromTo(line, {
                                drawSVG: '0%',
                            }, {
                                drawSVG: '100%',
                                ease: 'none',
                            }, 'label_' + i)

                            hotspotTl.fromTo(content, {
                                opacity: 0,
                            }, {
                                opacity: 1,
                                ease: 'none',
                                delay: .75,
                            }, 'label_' + i)

                            matchMedia.add({
                                isPhone: "(max-width: 550px)"
                            }, (context) => {

                                clearProps(content);
                                dot.addEventListener("click", (event) => contentToggle());

                                let closeButton = content.querySelector('.hotspot--close');

                                closeButton.addEventListener('click', () => {
                                    dot.click();
                                })

                            });

                        }



                    })

                } else {

                    if (markers) {

                        markers.forEach(marker => {

                            let index = marker.dataset.index,
                                content = scope.querySelector('.hp__content__' + index);

                            calcContentPos(marker, content, index);

                            window.addEventListener('resize', function () {
                                calcContentPos(marker, content, index);
                            });

                            if (scope.classList.contains('click-to-open')) {
                                marker.addEventListener('click', () => {
                                    content.classList.toggle('active')
                                })

                            } else if (scope.classList.contains('hover-to-open')) {
                                marker.addEventListener('mouseenter', () => {
                                    content.classList.add('active')
                                })
                                marker.addEventListener('mouseleave', () => {
                                    content.classList.remove('active')

                                })

                            } else if (scope.classList.contains('open-on-scroll')) {

                                if (!scope.classList.contains('pin-on-scroll')) {
                                    ScrollTrigger.create({
                                        trigger: content,
                                        start: 'center center',
                                        end: 'center top',
                                        onEnter: () => {
                                            content.classList.add('active')
                                        },
                                        onLeave: () => {
                                            content.classList.remove('active')
                                        },
                                        onEnterBack: () => {
                                            content.classList.add('active')
                                        },
                                        onLeaveBack: () => {
                                            content.classList.remove('active')
                                        },
                                    })
                                } else {
                                    tl.to(content, {
                                        clipPath: 'inset(0% 0% 0% 0% round 5px)',

                                    })
                                }

                            }


                        })
                    }
                }

            }

        });

        elementorFrontend.hooks.addAction('frontend/element_ready/peicon.default', function ($scope, $) {

            var jsScopeArray = $scope.toArray();
            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    animated = scope.querySelectorAll('.icon--motion');

                animated.forEach((element) => {

                    let classes = element.classList,
                        hasMotion = Array.from(classes).some(className => className.startsWith('me--'));

                    // Motion Effects
                    if (hasMotion) {

                        let motion = hasMotion ? Array.from(classes).find(className => className.startsWith('me--')) : null,
                            duration = element.dataset.duration,
                            delay = element.dataset.delay,
                            ease = motion === 'me--flip-x' ? 'none' : motion === 'me--flip-y' ? 'none' : motion === 'me--hearthbeat-x' ? 'power4.inOut' : motion === 'me--slide-left' ? 'power3.in' : motion === 'me--slide-right' ? 'power3.in' : motion === 'me--slide-down' ? 'expo.in' : motion === 'me--slide-up' ? 'expo.in' : 'expo.out',
                            tl = gsap.timeline({
                                repeat: -1,
                                repeatDelay: parseInt(delay, 10)
                            }),
                            target = element.querySelector('i, svg');



                        if (motion === 'me--slide-left' || motion === 'me--slide-right') {

                            target = element.firstElementChild;
                        }


                        var rotate = '';

                        if (motion === 'me--rotate') {
                            rotate = scope.classList.contains('rotate--dir--clockwise') ? 360 : -360
                        } else {
                            rotate = 0
                        }


                        tl.fromTo(target, {
                            xPercent: 0,
                            yPercent: 0,
                            scale: motion === 'me--hearth-beat' ? 0.6 : 1
                        }, {

                            scale: 1,
                            rotate: rotate,
                            rotateX: motion === 'me--flip-x' ? -360 : 0,
                            rotateY: motion === 'me--flip-y' ? -360 : 0,
                            xPercent: motion === 'me--slide-left' ? -300 : motion === 'me--slide-right' ? 300 : 0,
                            yPercent: motion === 'me--slide-down' ? 200 : motion === 'me--slide-up' ? -200 : 0,
                            duration: duration,
                            ease: ease,

                        })

                        if (motion === 'me--slide-left' || motion === 'me--slide-right') {

                            tl.fromTo(target, {
                                xPercent: motion === 'me--slide-left' ? 300 : motion === 'me--slide-right' ? -300 : 0
                            }, {
                                xPercent: 0,
                                duration: duration,
                                ease: 'power3.out',
                            })
                        }

                        if (motion === 'me--slide-down' || motion === 'me--slide-up') {

                            tl.fromTo(target, {
                                yPercent: motion === 'me--slide-down' ? -200 : motion === 'me--slide-up' ? 200 : 0
                            }, {
                                yPercent: 0,
                                duration: duration,
                                ease: 'power3.out',
                            })
                        }

                        if (motion === 'me--hearth-beat') {

                            tl.to(target, {
                                scale: 0.6,
                                duration: duration
                            })
                        }

                    }

                })


            }

        });

        elementorFrontend.hooks.addAction('frontend/element_ready/pelayoutswitcher.default', function ($scope, $) {

            var jsScopeArray = $scope.toArray();
            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    switcher = scope.querySelector('.pe-layout-switcher');

                let mainColors = [
                    getComputedStyle(document.documentElement).getPropertyValue('--mainColor'),
                    getComputedStyle(document.documentElement).getPropertyValue('--mainBackground'),
                    getComputedStyle(document.documentElement).getPropertyValue('--secondaryColor'),
                    getComputedStyle(document.documentElement).getPropertyValue('--secondaryBackground'),
                    getComputedStyle(document.documentElement).getPropertyValue('--linesColor'),
                ]

                let switchedColors = [
                    getComputedStyle(document.querySelector('.layout--colors')).getPropertyValue('--mainColor'),
                    getComputedStyle(document.querySelector('.layout--colors')).getPropertyValue('--mainBackground'),
                    getComputedStyle(document.querySelector('.layout--colors')).getPropertyValue('--secondaryColor'),
                    getComputedStyle(document.querySelector('.layout--colors')).getPropertyValue('--secondaryBackground'),
                    getComputedStyle(document.querySelector('.layout--colors')).getPropertyValue('--linesColor'),
                ]

                if (scope.classList.contains('show--labels--yes')) {

                    function switchFollower(parent, items, follower, selector) {

                        items.forEach(item => {

                            let width = item.getBoundingClientRect().width,
                                left = item.getBoundingClientRect().left - parent.getBoundingClientRect().left;

                            if (item.classList.contains('active')) {
                                gsap.set(follower, {
                                    width: width,
                                    left: left,
                                })

                            }
                            item.addEventListener('click', () => {
                                items.forEach(label => {
                                    label.classList.remove('active');
                                })

                                item.classList.add('active');
                                gsap.to(follower, {
                                    width: width,
                                    left: left,
                                    duration: 1,
                                    ease: 'power3.out',
                                })


                            })

                        })

                    }

                    let labels = scope.querySelectorAll('.pl--switch--button'),
                        follower = scope.querySelector('.pl--follower');

                    switchFollower(switcher, labels, follower);

                    if (document.body.classList.contains('layout--switched')) {
                        scope.querySelector('.pl--switched').click();
                    }

                }

                switcher.addEventListener('click', () => {

                    if (document.body.classList.contains('layout--switched')) {

                        gsap.fromTo(document.body, {
                            '--mainColor': switchedColors[0],
                            '--mainBackground': switchedColors[1],
                            '--secondaryColor': switchedColors[2],
                            '--secondaryBackground': switchedColors[3],
                        }, {
                            '--mainColor': mainColors[0],
                            '--mainBackground': mainColors[1],
                            '--secondaryColor': mainColors[2],
                            '--secondaryBackground': mainColors[3],
                            duration: 1,
                            ease: 'power3.out',
                            onStart: () => {
                                document.body.classList.remove('layout--switched')
                            }
                        })

                    } else {


                        gsap.fromTo(document.body, {
                            '--mainColor': mainColors[0],
                            '--mainBackground': mainColors[1],
                            '--secondaryColor': mainColors[2],
                            '--secondaryBackground': mainColors[3],
                        }, {
                            '--mainColor': switchedColors[0],
                            '--mainBackground': switchedColors[1],
                            '--secondaryColor': switchedColors[2],
                            '--secondaryBackground': switchedColors[3],
                            duration: 1,
                            ease: 'power3.out',
                            onStart: () => {
                                document.body.classList.add('layout--switched')
                            }
                        })

                    }

                })

            }

        });

        elementorFrontend.hooks.addAction('frontend/element_ready/peteammember.default', function ($scope, $) {

            var jsScopeArray = $scope.toArray();
            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    member = scope.querySelector('.pe--team--member'),
                    toggle = scope.querySelector('.team--member--toggle');

                toggle.addEventListener('click', () => {

                    member.classList.toggle('active');

                })


            }

        })

        elementorFrontend.hooks.addAction('frontend/element_ready/peclients.default', function ($scope, $) {

            var jsScopeArray = $scope.toArray();
            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    clients = scope.querySelector('.pe--clients');

                if (clients.classList.contains('pe--clients--carousel')) {

                    let wrapper = clients.querySelector('.pe--clients--wrapper'),
                        wrapperWidth = wrapper.offsetWidth,
                        items = wrapper.querySelectorAll('.pe-client'),
                        speed = clients.dataset.speed,
                        direction = clients.dataset.direction,
                        stopHover = clients.dataset.hover;

                    if (items.length > 0) {

                        var tl = gsap.timeline({
                            repeat: -1,
                        });

                        items.forEach(item => {
                            let clone = item.cloneNode(true);
                            wrapper.appendChild(clone);
                        });

                        if (direction !== 'right-to-left') {
                            // Reverse the order of items and prepend
                            Array.from(items).reverse().forEach(item => {
                                let clone = item.cloneNode(true);
                                wrapper.prepend(clone);
                            });
                        }


                        wrapper.style.width = wrapperWidth * 2


                        let gap = window.getComputedStyle(wrapper).getPropertyValue('gap');

                        if (direction === 'right-to-left') {

                            tl.to(wrapper, {
                                x: -wrapperWidth - parseFloat(gap),
                                duration: speed,
                                ease: 'none',

                            });


                        } else {

                            gsap.set(wrapper, {
                                x: -wrapperWidth - parseFloat(gap)
                            })

                            tl.fromTo(wrapper, {
                                x: -wrapperWidth - parseFloat(gap)
                            }, {
                                x: 0,
                                duration: speed,
                                ease: 'none',
                            })
                        }

                    }

                    if (stopHover) {
                        wrapper.addEventListener('mouseenter', () => {
                            tl.pause();
                        })

                        wrapper.addEventListener('mouseleave', () => {
                            tl.play();
                        })
                    }


                }

            }


        });

        elementorFrontend.hooks.addAction('frontend/element_ready/peaccordion.default', function ($scope, $) {

            var jsScopeArray = $scope.toArray();
            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    accordion = scope.querySelector('.pe--accordion'),
                    wrapper = accordion.querySelector('.pe--accordion--wrapper'),
                    items = wrapper.querySelectorAll('.pe-accordion-item');

                items.forEach((item, i) => {
                    i++;

                    let title = item.querySelector('.pe-accordion-item-title'),
                        content = item.querySelector('.pe-accordion-item-content');

                    title.addEventListener('click', () => {

                        if (scope.classList.contains('accordion--images--yes')) {

                            let imagesWrapper = scope.querySelector('.pe--accordion--images--wrapper');

                            imagesWrapper.querySelector('.accordion--image--active').classList.remove('accordion--image--active');
                            imagesWrapper.querySelector('.image__' + i).classList.add('accordion--image--active');
                        }

                        if (item.classList.contains('accordion--active')) {

                            var contentState = Flip.getState(content);
                            item.classList.remove('accordion--active');

                            Flip.from(contentState, {
                                duration: .75,
                                ease: 'expo.inOut',
                                absolute: false,
                                absoluteOnLeave: false,
                            })


                        } else {

                            if (!accordion.classList.contains('open--multiple')) {

                                var currentActive = accordion.querySelector('.accordion--active');

                                if (currentActive) {

                                    let currentContentState = Flip.getState(currentActive.querySelector('.pe-accordion-item-content'));

                                    currentActive.classList.remove('accordion--active');

                                    Flip.from(currentContentState, {
                                        duration: .75,
                                        ease: 'expo.inOut',
                                        absolute: false,
                                        absoluteOnLeave: false,
                                    })

                                }
                            }
                            //Open

                            var contentState = Flip.getState(content);
                            item.classList.add('accordion--active');

                            Flip.from(contentState, {
                                duration: .75,
                                ease: 'expo.inOut',
                                absolute: false,
                                absoluteOnLeave: false,
                            })

                        }


                    })

                })

            }

        });

        elementorFrontend.hooks.addAction('frontend/element_ready/pesingleimage.default', function ($scope, $) {
            var jsScopeArray = $scope.toArray();
            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    image = scope.querySelector('.single-image');


                imagesLoaded(image, function (instance) {

                    if (image.classList.contains('zoomed--image')) {

                        var before = image.querySelector('.zoomed--before'),
                            center = image.querySelector('.zoomed--center'),
                            after = image.querySelector('.zoomed--after'),
                            centerWidth = center.getBoundingClientRect().width,
                            centerHeight = center.getBoundingClientRect().height;


                        let hold = document.createElement('div');

                        image.insertBefore(hold, after);

                        center.classList.add('zoomed');

                        let tl = gsap.timeline({
                            scrollTrigger: {
                                trigger: scope,
                                start: 'top bottom',
                                end: 'center center',
                                scrub: true
                            }
                        });

                        tl.fromTo(image, {
                            xPercent: -100,

                        }, {
                            xPercent: 0,
                            duration: 20,
                            ease: 'none'
                        }, 0)

                        gsap.to(center, {
                            width: '100%',
                            height: '100%',
                            scrollTrigger: {
                                trigger: scope,
                                scrub: true,
                                pin: scope,
                                start: 'center center',
                                pinSpacing: 'margin'

                            }
                        })

                    }

                    if (image.classList.contains('parallax--image')) {

                        let img = image.querySelectorAll('img');

                        for (var i = 0; i < img.length; i++) {

                            gsap.set(img[i], {
                                scale: 1.2
                            })

                            gsap.fromTo(img[i], {
                                yPercent: -10
                            }, {
                                yPercent: 10,
                                ease: 'none',
                                scrollTrigger: {
                                    trigger: image,
                                    scrub: true,
                                    start: 'top bottom',
                                    end: 'bottom top'
                                }
                            })


                        }

                    }

                });

            }


        });

        elementorFrontend.hooks.addAction('frontend/element_ready/pemarquee.default', function ($scope, $) {

            var jsScopeArray = $scope.toArray();
            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    marqueeElement = scope.querySelector('.pe-marquee');

                if (!marqueeElement.classList.contains('initialized')) {
                    marqueeElement.classList.add('initialized');
                } else {
                    return;
                }

                var text = marqueeElement.children,
                    dataDuration = marqueeElement.getAttribute('data-duration'),
                    separator = marqueeElement.getAttribute('data-seperator');
                var wrapperElement = document.createElement("div");
                wrapperElement.className = "marquee-wrap";

                while (marqueeElement.firstChild) {
                    wrapperElement.appendChild(marqueeElement.firstChild);
                }
                marqueeElement.appendChild(wrapperElement);

                var infItem = marqueeElement.querySelector('.marquee-wrap'),
                    infWidth = infItem.offsetWidth;

                if (infWidth == 0) {
                    infWidth = document.body.clientWidth / 2;
                }

                if (infWidth > 0) {

                    var infLength = window.innerWidth / infWidth,
                        gap = infItem.getBoundingClientRect().left;
                    if (marqueeElement.classList.contains('icon_font')) {
                        var separators = infItem.querySelectorAll('.seperator');
                        separators.forEach(function (separator) {
                            separator.style.fontSize = window.getComputedStyle(separator.parentNode).getPropertyValue('font-size');
                        });
                    }

                    function infinityOnResize() {
                        for (var i = 2; i < infLength + 2; i++) {
                            var clonedItem = infItem.cloneNode(true);
                            marqueeElement.appendChild(clonedItem);
                        }
                        var infItemLength = marqueeElement.querySelectorAll('.marquee-wrap').length;
                        infWidth = parseInt(infWidth);
                        infItem.style.width = infWidth + 'px';
                        marqueeElement.style.width = (infItemLength * infItem.offsetWidth) + 'px';
                        marqueeElement.style.display = 'flex';

                        var tl = gsap.timeline({
                            repeat: -1
                        });
                        var tl2 = gsap.timeline({
                            repeat: -1
                        });

                        if (marqueeElement.classList.contains('left-to-right')) {
                            tl.fromTo(marqueeElement, {
                                x: -1 * (infWidth + gap)
                            }, {
                                x: -1 * gap,
                                ease: 'none',
                                duration: infWidth / 1000 * dataDuration
                            });
                        } else {
                            tl.fromTo(marqueeElement, {
                                x: -1 * gap
                            }, {
                                x: -1 * (infWidth + gap),
                                ease: 'none',
                                duration: infWidth / 1000 * dataDuration
                            });
                        }

                        if (marqueeElement.classList.contains('rotating_seperator')) {
                            var sepDuration = marqueeElement.getAttribute('data-sepduration');
                            var rotateValue = marqueeElement.classList.contains('counter-clockwise') ? -360 : 360;
                            tl2.fromTo(marqueeElement.querySelectorAll('.seperator'), {
                                rotate: 0
                            }, {
                                rotate: rotateValue,
                                duration: sepDuration,
                                ease: 'none'
                            });
                        }
                    }

                    infinityOnResize();
                }

            }

        });


        elementorFrontend.hooks.addAction('frontend/element_ready/peblogposts.default', function ($scope, $) {

            var jsScopeArray = $scope.toArray();
            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    grid = scope.querySelector('.pe--posts--grid'),
                    wrapper = scope.querySelector('.grid--posts--wrapper'),
                    posts = wrapper.querySelectorAll('.grid--post--item'),
                    filters = grid.querySelector('.grid--filters');

                if (filters) {

                    let filter = filters.querySelectorAll('.post-filter'),
                        ul = filters.querySelector('.filters-list');

                    filter.forEach(filter => {

                        filter.addEventListener('click', () => {

                            filters.querySelector('.active').classList.remove('active');
                            filter.classList.add('active');


                            gsap.to(ul, {
                                '--activeLeft': filter.offsetLeft - 10 + 'px',
                                '--activeWidth': filter.offsetWidth + filter.offsetLeft - 35 + 'px',
                                duration: .5,
                                ease: 'expo.out'
                            })

                            let cat = filter.dataset.category,
                                findPosts = 'cat_' + cat;

                            let state = Flip.getState(posts);

                            posts.forEach(post => {

                                if (cat !== 'all') {

                                    post.classList.contains(findPosts) ? post.style.display = 'block' : post.style.display = 'none';

                                } else {

                                    post.style.display = 'block'
                                }

                            })

                            Flip.from(state, {
                                duration: 1,
                                absolute: false,
                                absoluteOnLeave: false,
                                ease: "expo.inOut",
                                onEnter: elements => gsap.fromTo(elements, {
                                    opacity: 0,
                                    xPercent: 100
                                }, {
                                    opacity: 1,
                                    xPercent: 0
                                }),
                                onLeave: elements => gsap.fromTo(elements, {
                                    opacity: 1,
                                    xPercent: 0
                                }, {
                                    opacity: 0,
                                    xPercent: -100,
                                    stagger: 0.1
                                }),
                            })

                        })

                    })

                }

                if (grid.querySelector('.pe-load-more')) {

                    let button = grid.querySelector('.pe-load-more'),
                        currentWrapper = wrapper,
                        count = grid.dataset.total,
                        link = button.querySelector('a');

                    link.addEventListener('click', (e) => {

                        let apiUrl = link.getAttribute("href");
                        e.preventDefault();

                        button.classList.add('plm--loading');
                        document.documentElement.classList.add('loading');

                        var xhr = new XMLHttpRequest();
                        xhr.open('GET', apiUrl);
                        xhr.onreadystatechange = function () {

                            if (xhr.readyState === XMLHttpRequest.DONE) {

                                if (xhr.status === 200) {

                                    var response = xhr.responseText;

                                    setTimeout(function () {
                                        var parser = new DOMParser(),
                                            htmlDoc = parser.parseFromString(response, 'text/html'),
                                            newPosts = htmlDoc.querySelectorAll('.pe--posts--grid .grid--post--item'),
                                            newUrl = htmlDoc.querySelector('.pe-load-more a').getAttribute('href');

                                        link.setAttribute("href", newUrl);

                                        if (newPosts.length > 0) {

                                            let tl = gsap.timeline({
                                                onComplete: () => {
                                                    ScrollTrigger.refresh()

                                                }
                                            });

                                            newPosts.forEach(function (post, i) {

                                                let clone = post.cloneNode(true)
                                                currentWrapper.appendChild(clone);

                                                tl.fromTo(clone, {
                                                    opacity: 0,
                                                    yPercent: 100
                                                }, {
                                                    opacity: 1,
                                                    yPercent: 0,
                                                    duration: .75,
                                                    ease: 'expo.out'
                                                }, i * 0.15)

                                            });




                                            if (grid.querySelectorAll('.grid--post--item').length >= count) {
                                                button.classList.add('plm--disabled');
                                            }

                                            button.classList.remove('plm--loading');
                                            document.documentElement.classList.remove('loading');
                                        }

                                    }, 200);
                                } else {
                                    console.error('Request failed. Status: ' + xhr.status);
                                }
                            }
                        };
                        xhr.send();

                    })

                }

            }

        });

        elementorFrontend.hooks.addAction('frontend/element_ready/pepostmedia.default', function ($scope, $) {
            var jsScopeArray = $scope.toArray();
            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    image = scope.querySelector('.single-image');

                if (image.classList.contains('parallax--image')) {

                    let img = image.querySelectorAll('img');

                    for (var i = 0; i < img.length; i++) {

                        gsap.fromTo(img[i], {
                            yPercent: 0
                        }, {
                            yPercent: -10,
                            ease: 'none',
                            scrollTrigger: {
                                trigger: image,
                                scrub: true,
                                start: 0,
                                end: 'bottom top'
                            }
                        })


                    }

                }
            }

        });

        elementorFrontend.hooks.addAction('frontend/element_ready/projectmedia.default', function ($scope, $) {
            var jsScopeArray = $scope.toArray();
            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    gallery = scope.querySelector('.project--image--gallery');

                if (gallery) {

                    let wrapper = gallery.querySelector('.project--image--gallery--wrapper'),
                        images = wrapper.querySelectorAll('.project--gallery--image'),
                        gap = parseInt(window.getComputedStyle(wrapper).getPropertyValue('gap')),
                        val = wrapper.getBoundingClientRect().left + (wrapper.offsetWidth - document.body.clientWidth) + gap,
                        id = wrapper.dataset.id ? wrapper.dataset.id : scope.dataset.id,
                        trigger = gallery.dataset.trigger ? gallery.dataset.trigger : scope,
                        speed = wrapper.dataset.speed,
                        integrated = gallery.dataset.integrated;

                    wrapper.classList.add(id);
                    wrapper.setAttribute('data-total', images.length);
                    images.forEach((image, i) => {

                        image.setAttribute('data-cr', i + 1);
                    })

                    if (scope.classList.contains('cr--scroll')) {

                        wrapper.classList.add('cr--scroll');

                        var crScroll = gsap.to(wrapper, {
                            id: id,
                            x: -val,
                            ease: "sine.inOut",
                            scrollTrigger: {
                                trigger: trigger,
                                pin: trigger,
                                pinSpacing: 'margin',
                                scrub: true,
                                start: 'top top',
                                end: 'bottom+=3000 top',
                                onEnter: () => isPinnng(trigger, true),
                                onEnterBack: () => isPinnng(trigger, true),
                                onLeave: () => isPinnng(trigger, false),
                                onLeaveBack: () => isPinnng(trigger, false),
                                onUpdate: self => {

                                    if (integrated && !mobileQuery.matches) {

                                        gsap.to(integrated, {
                                            opacity: 1 - (self.progress * 5)
                                        })
                                    }
                                }
                            }
                        })

                        matchMedia.add({
                            isPhone: "(max-width: 550px)"
                        }, (context) => {

                            crScroll.scrollTrigger.kill(true);

                            Draggable.create(wrapper, {
                                type: 'x',
                                dragResistance: 0.35,
                                inertia: true,
                                bounds: {
                                    minX: 0,
                                    maxX: -val
                                },
                            })

                        });

                    }

                    if (scope.classList.contains('cr--drag')) {

                        wrapper.classList.add('cr--drag');

                        let drag = Draggable.create(wrapper, {
                            id: id,
                            type: 'x',
                            dragResistance: 0.35,
                            inertia: true,
                            bounds: {
                                minX: 0,
                                maxX: -val
                            },
                            onThrowUpdate: () => {
                                let prog = drag[0].x / drag[0].minX;

                                if (integrated) {

                                    gsap.to(integrated, {
                                        opacity: 1 - (prog * 5)
                                    })
                                }

                            },
                            onMove: () => {

                                let prog = drag[0].x / drag[0].minX;

                                if (integrated) {

                                    gsap.to(integrated, {
                                        opacity: 1 - (prog * 5)
                                    })
                                }

                            },
                            lockAxis: true,
                            dragResistance: 0.5,
                            inertia: true,
                        });

                    }


                } else {

                    let image = scope.querySelector('.project-featured-image');

                    if (image && image.classList.contains('parallax--image')) {

                        let img = image.querySelectorAll('img');


                        for (var i = 0; i < img.length; i++) {

                            gsap.fromTo(img[i], {
                                yPercent: 0
                            }, {
                                yPercent: 20,
                                ease: 'none',
                                scrollTrigger: {
                                    trigger: image,
                                    scrub: 1.2,
                                    start: 'top top',
                                    end: 'bottom top'
                                }
                            })


                        }

                    }
                }

            }

        });

        elementorFrontend.hooks.addAction('frontend/element_ready/pelanguagecurrencyswitcher.default', function ($scope, $) {

            var jsScopeArray = $scope.toArray();
            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    wrapper = scope.querySelector('.pe--language--currency--switcher'),
                    items = wrapper.querySelectorAll('li');

                // if (scope.classList.contains('.lcs--switcher')) {

                //     let follower = scope.querySelector('.lcs--follower');

                //     function switchFollower(parent, items, follower, selector) {

                //         items.forEach(item => {

                //             let width = item.getBoundingClientRect().width,
                //                 left = item.getBoundingClientRect().left - parent.getBoundingClientRect().left;

                //             if (item.classList.contains('wpml-ls-current-language') || item.classList.contains('wcml-cs-active-currency')) {
                //                 gsap.set(follower, {
                //                     width: width,
                //                     left: left,
                //                 })
                //             }

                //             item.addEventListener('click', () => {
                //                 items.forEach(label => {
                //                     label.classList.remove('active');
                //                 })

                //                 item.classList.add('active');
                //                 gsap.to(follower, {
                //                     width: width,
                //                     left: left,
                //                     duration: 1,
                //                     ease: 'power3.out',
                //                 })
                //             })

                //         })

                //     }

                //     switchFollower(switcher, items, follower);


                // }




            }

        });



        elementorFrontend.hooks.addAction('frontend/element_ready/peportfolio.default', function ($scope, $) {

            var jsScopeArray = $scope.toArray();
            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    filters = scope.querySelector('.portfolio--filters'),
                    id = scope.dataset.id,
                    wrapper = scope.querySelector('.portfolio--projects--wrapper'),
                    url = scope.querySelector('input[name="url"]').value,
                    catdata = scope.querySelector('input[name="cat"]'),
                    portfolio = scope.querySelector('.pe--portfolio'),
                    pagination = scope.querySelector('.portfolio--pagination'),
                    switcher = scope.querySelector('.ps--switch'),
                    projects = scope.querySelectorAll('.portfolio--project');

                if (switcher) {

                    let switchGrid = switcher.querySelector('.ps--grid'),
                        switchList = switcher.querySelector('.ps--list'),
                        follower = switcher.querySelector('.ps--follower'),
                        sgWidth = switchGrid.offsetWidth,
                        slWidth = switchList.offsetWidth;

                    if (portfolio.classList.contains('portfolio--list')) {

                        switchGrid.classList.remove('active')
                        switchList.classList.add('active')

                        switcher.classList.contains('switcher--switcher') ? follower.style.width = slWidth + 'px' : '';

                    } else {

                        switchGrid.classList.add('active')
                        switchList.classList.remove('active')

                        switcher.classList.contains('switcher--switcher') ? follower.style.width = sgWidth + 'px' : '';

                    }

                    switcher.addEventListener('click', () => {

                        let tl = gsap.timeline();

                        tl.to(wrapper, {
                            opacity: 0,
                            duration: .5,
                            onComplete: () => {

                                if (portfolio.classList.contains('portfolio--list')) {

                                    portfolio.classList.remove('portfolio--list')
                                    portfolio.classList.add('portfolio--grid');

                                    switchGrid.classList.add('active')
                                    switchList.classList.remove('active')


                                } else {
                                    portfolio.classList.remove('portfolio--grid')
                                    portfolio.classList.add('portfolio--list')

                                    sarenPortfolioList();

                                    switchGrid.classList.remove('active')
                                    switchList.classList.add('active')
                                }
                            }
                        })

                        tl.to(wrapper, {
                            opacity: 1,
                            duration: .5
                        })

                    })

                }

                if (filters) {

                    let trigger = filters.querySelector('.filter--active'),
                        cats = filters.querySelectorAll('.filter--cat');

                    trigger.addEventListener('click', () => {
                        filters.classList.toggle('filt--active');
                    })

                    cats.forEach(cat => {

                        cat.addEventListener('click', (e) => {

                            scope.querySelector('.filter--cat.active').classList.remove('active');
                            cat.classList.add('active');

                            var apiUrl = cat.dataset.id ? url + '?cat=' + cat.dataset.id : url;

                            e.preventDefault();

                            document.documentElement.classList.add('loading');

                            var xhr = new XMLHttpRequest();
                            xhr.open('GET', apiUrl);
                            xhr.onreadystatechange = function () {

                                if (xhr.readyState === XMLHttpRequest.DONE) {
                                    if (xhr.status === 200) {
                                        var response = xhr.responseText;
                                        setTimeout(function () {
                                            let items = wrapper.querySelectorAll('.portfolio--project'),
                                                state = Flip.getState(items);
                                            items.forEach(item => item.classList.add('hidden'))
                                            Flip.from(state, {
                                                duration: 1,
                                                ease: "power3.inOut",
                                                fade: true,
                                                absolute: false,
                                                absoluteOnLeave: false,
                                                onComplete: () => {
                                                    items.forEach(item => item.remove())
                                                },
                                                onLeave: elements => gsap.fromTo(elements, {
                                                    opacity: 1,
                                                    y: 0
                                                }, {
                                                    opacity: 0,
                                                    y: -50,
                                                }),
                                            });

                                            var parser = new DOMParser(),
                                                htmlDoc = parser.parseFromString(response, 'text/html'),
                                                newElement = htmlDoc.querySelector('.elementor-element-' + id),
                                                newPosts = newElement.querySelectorAll('.portfolio--project');


                                            if (newPosts.length > 0) {
                                                portfolio.setAttribute('data-max-pages', newElement.querySelector('.pe--portfolio').dataset.maxPages)


                                                let tl = gsap.timeline({
                                                    onComplete: () => {
                                                        ScrollTrigger.refresh()

                                                    }
                                                });

                                                newPosts.forEach(function (post, i) {

                                                    let clone = post.cloneNode(true)
                                                    wrapper.appendChild(clone);

                                                    tl.fromTo(clone, {
                                                        opacity: 0,
                                                        yPercent: 100
                                                    }, {
                                                        opacity: 1,
                                                        yPercent: 0,
                                                        duration: .75,
                                                        ease: 'expo.out'
                                                    }, i * 0.15)

                                                });


                                                cat.dataset.id ? trigger.classList.add('filtered') : trigger.classList.remove('filtered');
                                                cat.dataset.id ? portfolio.classList.add('filtered') : portfolio.classList.remove('filtered');
                                                filters.classList.remove('filt--active');
                                                trigger.innerHTML = cat.innerHTML;
                                                trigger.setAttribute('data-length', cat.dataset.length)
                                                document.documentElement.classList.remove('loading');
                                                catdata.value = cat.dataset.id;
                                            }

                                        }, 200);
                                    } else {
                                        console.error('Request failed. Status: ' + xhr.status);
                                    }
                                }
                            };
                            xhr.send();

                        })


                    })

                }

                if (pagination) {

                    let loadMore = pagination.querySelector('a'),
                        clicks = 0;

                    if (loadMore) {

                        loadMore.addEventListener('click', (e) => {

                            pagination.classList.add('loading');

                            clicks++
                            var apiUrl = catdata.value ? url + '?offset=' + clicks + '&cat=' + catdata.value : url + '?offset=' + clicks;

                            e.preventDefault();


                            document.documentElement.classList.add('loading');
                            pagination.classList.add('loading');

                            var xhr = new XMLHttpRequest();
                            xhr.open('GET', apiUrl);
                            xhr.onreadystatechange = function () {

                                if (xhr.readyState === XMLHttpRequest.DONE) {

                                    if (xhr.status === 200) {

                                        var response = xhr.responseText;

                                        setTimeout(function () {

                                            var parser = new DOMParser(),
                                                htmlDoc = parser.parseFromString(response, 'text/html'),
                                                newElement = htmlDoc.querySelector('.elementor-element-' + id),
                                                newPosts = newElement.querySelectorAll('.portfolio--project');

                                            if (newPosts.length > 0) {

                                                let tl = gsap.timeline({
                                                    onComplete: () => {
                                                        ScrollTrigger.refresh()

                                                    }
                                                });

                                                newPosts.forEach(function (post, i) {

                                                    let clone = post.cloneNode(true)
                                                    wrapper.appendChild(clone);

                                                    tl.fromTo(clone, {
                                                        opacity: 0,
                                                        yPercent: 100
                                                    }, {
                                                        opacity: 1,
                                                        yPercent: 0,
                                                        duration: .75,
                                                        ease: 'expo.out',
                                                        onComplete: () => {
                                                            pagination.classList.remove('loading');

                                                            if (clone.querySelector('.pe-video')) {

                                                                let videos = clone.querySelectorAll('.pe-video')

                                                                for (var i = 0; i < videos.length; i++) {
                                                                    new peVideoPlayer(videos[i]);
                                                                }

                                                            }

                                                        }
                                                    }, i * 0.15)

                                                });

                                                if (portfolio.dataset.maxPages == clicks + 1) {

                                                    pagination.classList.add('hidden');
                                                }

                                                document.documentElement.classList.remove('loading');

                                            }

                                        }, 200);
                                    } else {
                                        console.error('Request failed. Status: ' + xhr.status);
                                    }
                                }
                            };
                            xhr.send();

                        })

                    }

                }

                function sarenPortfolioList() {

                    let portfolio = $scope.find('.pe--portfolio'),
                        titlesWrap = $scope.find('.portfolio--projects--wrapper'),
                        imagesWrap = $scope.find('.portfolio--list--images--wrapper');


                    titlesWrap.hover(
                        () => {
                            imagesWrap.addClass('active');
                            titlesWrap.addClass('active');

                        },
                        () => {
                            imagesWrap.removeClass('active')
                            titlesWrap.removeClass('active')
                        }
                    );

                    gsap.set(imagesWrap, {
                        xPercent: -75,
                        yPercent: -50
                    });

                    titlesWrap.on('mousemove', function (e) {

                        let xTo = gsap.quickTo(imagesWrap, "left", {
                            duration: 0.6,
                            ease: "power3"
                        }),
                            yTo = gsap.quickTo(imagesWrap, "top", {
                                duration: 0.6,
                                ease: "power3"
                            });


                        function icko(e) {
                            xTo(e.pageX);
                            yTo(e.pageY - portfolio.offset().top);
                        }

                        icko(e)

                    });

                    matchMedia.add({
                        isMobile: "(max-width: 550px)"

                    }, (context) => {
                        let {
                            isMobile
                        } = context.conditions;

                        titlesWrap.off('mousemove')

                        return () => {

                            titlesWrap.on('mousemove')

                        }
                    });



                    let projects = titlesWrap.find('.portfolio--project'),
                        count = 0;


                    projects.each(function () {

                        let $this = $(this);

                        $this.on('mouseenter', function () {

                            let image = $('.image_' + $this.data('id'));
                            $this.addClass('active')

                            gsap.set(image, {
                                zIndex: 1
                            })

                            image.addClass('active')
                            image.addClass('trans-media')

                            let tl = gsap.timeline();

                            tl.fromTo(image, {

                                y: '100%'
                            }, {

                                y: '0%',
                                duration: 1.5,
                                ease: 'power3.inOut'
                            }, 0)

                            tl.fromTo(image.children('div'), {

                                scale: 1.3,
                                y: '-100%'
                            }, {

                                y: '0%',
                                scale: 1,
                                duration: 1.5,
                                ease: 'power3.inOut'
                            }, 0)

                        })

                        $this.on('mouseleave', function () {

                            count++

                            $this.removeClass('active')

                            let image = $('.image_' + $this.data('id'));

                            image.removeClass('active')
                            image.removeClass('trans-media')

                            gsap.set(image, {
                                zIndex: 0 - count
                            })

                            let tl = gsap.timeline();

                            tl.fromTo(image, {

                                y: '0%'
                            }, {

                                y: '-100%',
                                duration: 1.5,
                                ease: 'power3.inOut'
                            }, 0)

                            tl.fromTo(image.children('div'), {

                                y: '0%',
                                scale: 1
                            }, {

                                y: '100%',
                                scale: 1.3,
                                duration: 1.5,
                                ease: 'power3.inOut'
                            }, 0)

                        })

                        $this.find('a').on('click', function () {

                            $this.off('mouseleave')


                        })


                    })


                }

                if (portfolio.classList.contains('portfolio--list')) {

                    sarenPortfolioList();

                }




            }

        });

        elementorFrontend.hooks.addAction('frontend/element_ready/peinteractivegrid.default', function ($scope, $) {
            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    items = scope.querySelectorAll('.interactive--grid--item'),
                    clicks = 0;


                if (scope.classList.contains('expand--items--yes')) {
                    imagesLoaded(scope, function (instance) {
                        items.forEach(item => {

                            gsap.set(item, {
                                width: item.getBoundingClientRect().width,
                                height: item.getBoundingClientRect().height,
                            })

                            if (item.getBoundingClientRect().left > (document.body.clientWidth / 2)) {

                                item.classList.add('grid--item--right');

                            }

                            item.addEventListener('click', () => {

                                clicks++;

                                let states = Flip.getState(item.querySelectorAll('.grid--item--state'), {
                                    props: ['height', 'minHeight', 'maxHeight', 'padding', 'opacity']
                                });

                                item.classList.toggle('active');

                                gsap.set(item, {
                                    zIndex: clicks
                                })

                                Flip.from(states, {
                                    duration: 1.25,
                                    ease: 'expo.inOut',
                                    absolute: true,
                                    absoluteOnLeave: true
                                })

                            })

                        })

                    })

                }

            }
        })

        // Showcases 
        elementorFrontend.hooks.addAction('frontend/element_ready/pecategorieslist.default', function ($scope, $) {
            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    categoriesList = document.querySelectorAll('.categories--list');
                categoriesList.forEach(function ($this) {
                    let category = $this.querySelectorAll('.product--category'),
                        image = $this.querySelectorAll('.category--image'),
                        pinTarget = $this.dataset.pinTarget,
                        trigger = pinTarget

                    if (!pinTarget) {
                        pinTarget = true
                        trigger = $this
                    }



                    category.forEach(function ($cat, i) {
                        let rotate = -i * (120 / category.length);
                        $cat.style.setProperty('--rotate', rotate + "deg");
                        $cat.setAttribute('data-rotate', rotate + "deg");

                        if (rotate < -60 || rotate > 60) {
                            gsap.set($cat, { opacity: 0 });
                        }

                        $cat.addEventListener('mouseenter', function () {
                            gsap.to($this.querySelector('.images--wrapper'), { opacity: 1 });
                        });

                        $cat.addEventListener('mouseleave', function () {
                            gsap.to($this.querySelector('.images--wrapper'), { opacity: 0 });
                        });
                    });

                    let mm = gsap.matchMedia();

                    if ($this.classList.contains('cursor__image')) {

                        $this.addEventListener("mousemove", (e) => {
                            gsap.to($this.querySelector('.images--wrapper'), {
                                x: e.clientX - ((document.body.offsetWidth - $this.offsetWidth) / 2) - ($this.querySelector('.images--wrapper').offsetWidth / 2),
                                y: e.clientY - ($this.querySelector('.images--wrapper').offsetHeight / 2)
                            })
                        });

                    }

                    gsap.to($this.querySelector('.categories--wrapper'), {
                        rotateX: 120 - (120 / category.length),
                        ease: 'none',
                        scrollTrigger: {
                            trigger: trigger,
                            start: 'top top',
                            end: 'bottom+=' + $this.getAttribute('data-speed') + 'bottom',
                            scrub: 1,
                            pin: pinTarget,
                            onUpdate: (self) => {
                                let activeIndex = Math.floor(self.progress * (category.length - 1)),
                                    prog = Math.floor(self.progress * 120);

                                category.forEach(function ($cat) {
                                    let rotate = parseInt($cat.getAttribute('data-rotate')) + prog;
                                    if (rotate <= -60 || rotate >= 60) {
                                        gsap.set($cat, { opacity: 0 });
                                    } else {
                                        if ($cat.classList.contains('category__' + activeIndex)) {
                                            gsap.set($cat, { opacity: 1 });
                                            $cat.classList.add('category--active');
                                        } else {
                                            gsap.set($cat, { opacity: 0.2 });
                                            $cat.classList.remove('category--active');
                                        }
                                    }
                                });

                                image.forEach(function ($image) {
                                    if ($image.classList.contains('image__' + activeIndex)) {
                                        gsap.to($image, { opacity: 1 });
                                    } else {
                                        gsap.to($image, { opacity: 0 });
                                    }
                                });
                            }
                        }
                    });


                    mm.add("(max-width: 570px)", () => {

                        let draggableInstance = Draggable.create($this, {
                            type: 'y',
                            inertia: true,
                            onDrag: function () {
                                let rotationX = Math.min(Math.max(this.y / -7.5, 0), 180);
                                if (this.y >= 0) {
                                    this.y = 0
                                } else if (this.y <= -1350) {
                                    this.y = -1350
                                }
                                gsap.set($this, {
                                    y: this.y
                                })


                                gsap.set($this.querySelector('.categories--wrapper'), {
                                    rotateX: rotationX,
                                });

                                updateCategories(rotationX);
                            },
                            onThrowUpdate: function () {
                                let rotationX = Math.min(Math.max(this.y / -7.5, 0), 180);
                                if (this.y >= 0) {
                                    this.y = 0
                                } else if (this.y <= -1350) {
                                    this.y = -1350
                                }
                                gsap.set($this, {
                                    y: this.y
                                })

                                gsap.set($this.querySelector('.categories--wrapper'), {
                                    rotateX: rotationX,
                                });

                                updateCategories(rotationX);
                            }
                        });

                        function updateCategories(rotationX) {
                            let activeIndex = Math.floor(rotationX / 180 * (category.length - 1));

                            category.forEach(function ($cat) {

                                let rotate = parseInt($cat.getAttribute('data-rotate')) + rotationX;
                                if (rotate <= -90 || rotate >= 90) {
                                    gsap.set($cat, { opacity: 0 });
                                } else {
                                    if ($cat.classList.contains('category__' + activeIndex)) {
                                        gsap.set($cat, { opacity: 1 });
                                        $cat.classList.add('category--active');
                                    } else {
                                        gsap.set($cat, { opacity: 0.2 });
                                        $cat.classList.remove('category--active');
                                    }
                                }
                            });

                            image.forEach(function ($image) {
                                if ($image.classList.contains('image__' + activeIndex)) {
                                    gsap.to($image, { opacity: 1 });
                                } else {
                                    gsap.to($image, { opacity: 0 });
                                }
                            });
                        }
                    });
                });





            }
        });

        elementorFrontend.hooks.addAction('frontend/element_ready/pesocialshare.default', function ($scope, $) {
            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i];

                const shareButtons = scope.querySelectorAll('.social-share-button');

                shareButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        const url = button.getAttribute('data-url');
                        const network = button.getAttribute('data-network');

                        const width = 600;
                        const height = 400;
                        const left = (screen.width / 2) - (width / 2);
                        const top = (screen.height / 2) - (height / 2);

                        window.open(
                            url,
                            `${network} Share`,
                            `toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=${width}, height=${height}, top=${top}, left=${left}`
                        );
                    });
                });



            }

        })

        elementorFrontend.hooks.addAction('frontend/element_ready/pecategorieswall.default', function ($scope, $) {
            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    categoriesWall = document.querySelectorAll('.categories--wall');
                categoriesWall.forEach(function ($this) {
                    let category = $this.querySelectorAll('.product--category'),
                        image = $this.querySelectorAll('.category--image'),
                        wrapper = scope.querySelector('.categories--wrapper'),
                        wrapperHeight = wrapper.getBoundingClientRect().height,
                        wrapperTop = wrapper.getBoundingClientRect().top;


                    if (scope.classList.contains('cat--descs')) {

                        var descs = scope.querySelectorAll('.category--desc');

                        descs.forEach(desc => {

                            var index = desc.dataset.index,
                                randTop;

                            if (index % 2 === 0) {
                                randTop = gsap.utils.random(75, (wrapperTop - desc.getBoundingClientRect().height));
                            } else {
                                randTop = gsap.utils.random((wrapperTop + wrapperHeight), (window.innerHeight - desc.getBoundingClientRect().height));
                            }

                            gsap.set(desc, {
                                top: randTop,
                                left: gsap.utils.random(0, (window.innerWidth - desc.getBoundingClientRect().width)),
                            })

                            new SplitText(desc, {
                                type: "lines",
                                linesClass: "wall--line",
                            });

                            desc.querySelectorAll('.wall--line').forEach(line => wrapInner(line, { tagName: 'span', className: '' }))

                        })


                    }

                    category.forEach(function ($cat) {

                        const handleMouseEnter = function () {
                            $this.classList.add('hovered');
                            gsap.to($this.querySelector('.image__' + $cat.getAttribute('data-index')), {
                                opacity: 1
                            });

                            if (scope.classList.contains('cat--descs')) {

                                let desc = $this.querySelector('.desc__' + $cat.getAttribute('data-index'));

                                gsap.set(desc, {
                                    opacity: 1
                                });

                                gsap.to(desc.querySelectorAll('.wall--line span'), {
                                    y: '0%',
                                    duration: .55,
                                    ease: 'power2.out',
                                    stagger: 0.05,
                                })

                            }



                        };

                        const handleMouseLeave = function () {
                            $this.classList.remove('hovered');
                            gsap.to($this.querySelector('.image__' + $cat.getAttribute('data-index')), {
                                opacity: 0
                            });

                            if (scope.classList.contains('cat--descs')) {

                                let desc = $this.querySelector('.desc__' + $cat.getAttribute('data-index'));


                                gsap.to(desc.querySelectorAll('.wall--line span'), {
                                    y: '100%',
                                    duration: .55,
                                    ease: 'power2.in',
                                    stagger: -0.05,
                                    onComplete: () => {
                                        gsap.set(desc, {
                                            opacity: 0
                                        });
                                    }
                                })

                            }

                        };

                        $cat.addEventListener('mouseenter', handleMouseEnter);
                        $cat.addEventListener('mouseleave', handleMouseLeave);

                        $cat.addEventListener('touchstart', handleMouseEnter);
                        $cat.addEventListener('touchend', handleMouseLeave);

                    })
                });





            }
        });

        elementorFrontend.hooks.addAction('frontend/element_ready/peshowcaseverticalslider.default', function ($scope, $) {
            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    verticalSlider = document.querySelectorAll('.showcase--vertical--slider');
                verticalSlider.forEach(function ($this) {
                    let scrollWrap = $this.querySelector('.showcase--vertical--scroll--cards'),
                        productWrap = $this.querySelector('.showcase--vertical--products--wrapper'),
                        scrollImage = $this.querySelectorAll('.scroll--card--image'),
                        pinTarget = $this.getAttribute('data-pin-target'),
                        trigger = pinTarget

                    if (!pinTarget) {
                        pinTarget = true
                        trigger = $this
                    }

                    matchMedia.add({
                        isDesktop: "(min-width: 570px)"

                    }, (context) => {

                        let {
                            isDesktop
                        } = context.conditions;
                        scrollImage.forEach(function ($zoomImg, i) {
                            let scroll = parseInt($this.getAttribute('data-speed')) / (scrollImage.length - 1)

                            $zoomImg.addEventListener('click', function () {
                                gsap.to(window, {
                                    scrollTo: scroll * i,
                                    duration: 1.6,
                                    ease: 'power4.inOut',

                                })
                            })
                        })

                        gsap.getById(scope.dataset.id) ? gsap.getById(scope.dataset.id).scrollTrigger.kill(true) : '';

                        let tl = gsap.timeline({
                            ease: 'none',
                            id: scope.dataset.id,
                            scrollTrigger: {
                                trigger: trigger,
                                start: 'top top',
                                end: 'bottom+=' + $this.getAttribute('data-speed') + ' bottom',
                                pin: mobileQuery.matches ? false : pinTarget,
                                scrub: 1,
                                onUpdate: (self) => {

                                    if (scope.classList.contains('parallax__on')) {

                                        let prog = self.progress * 20
                                        $this.querySelectorAll('.parallax--wrap').forEach(function ($prlx) {
                                            gsap.to($prlx, {
                                                yPercent: (-1 * prog)
                                            })
                                        })
                                    }

                                },

                            }
                        })

                        tl.to(scrollWrap, {
                            y: -1 * scrollWrap.offsetHeight + scrollWrap.querySelectorAll('.scroll--card--image')[0].offsetHeight,
                            ease: 'none',
                        }, 0)

                        tl.to(productWrap, {
                            y: -1 * productWrap.offsetHeight + productWrap.querySelectorAll('.showcase--product')[0].offsetHeight,
                            ease: 'none'
                        }, 0)

                    });



                })





            }
        });

        elementorFrontend.hooks.addAction('frontend/element_ready/peshowcasecarousel.default', function ($scope, $) {
            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {

                var scope = jsScopeArray[i],
                    showcaseCarousel = document.querySelectorAll('.showcase--carousel');

                showcaseCarousel.forEach(function ($this) {
                    let wrap = $this.querySelector('.showcase--carousel--wrapper'),
                        project = $this.querySelectorAll('.showcase--product'),
                        wrapperWidth = wrap.offsetWidth + parseInt(window.getComputedStyle(wrap).gap)
                    if (scope.classList.contains('autoplay__active')) {
                        project.forEach(function ($item) {
                            let clone = $item.cloneNode(true)
                            wrap.appendChild(clone)
                        })
                        project = $this.querySelectorAll('.showcase--product')
                        let tl = gsap.timeline({
                            repeat: -1
                        })
                        tl.to(wrap, {
                            x: -1 * wrapperWidth,
                            ease: 'none',
                            duration: parseInt($this.getAttribute('data-autoplay-duration'))
                        }, 0)

                        if (scope.classList.contains('speed__on__autoplay')) {
                            let whaler = Hamster(document.querySelector('body')),
                                wheelDeltaY, currentDeltaY;

                            whaler.wheel(function (event, delta, deltaX, deltaY) {

                                wheelDeltaY = event.deltaY;
                                event.deltaY < 0 ? wheelDeltaY = -1 * event.deltaY : '';
                                tl.timeScale(1 + (wheelDeltaY * 2))

                            });

                        }

                        if (scope.classList.contains('parallax__on')) {
                            $this.querySelectorAll('.parallax--wrapper').forEach(function ($prlx) {
                                $prlx.style.width = '125%'
                            })
                        }

                        project.forEach(function ($item) {
                            $item.addEventListener('mouseenter', function () {
                                tl.pause()
                            })
                            $item.addEventListener('mouseleave', function () {
                                tl.play()
                                tl.timeScale(1)
                            })
                        })
                    } else if (scope.classList.contains('infinite__scroll')) {
                        project.forEach(function ($item) {
                            let clone = $item.cloneNode(true)
                            wrap.appendChild(clone)
                        })
                        let pinTarget = $this.dataset.pinTarget,
                            trigger = $this.dataset.pinTarget;

                        if (!pinTarget) {
                            pinTarget = true;
                        }

                        if (!trigger) {
                            trigger = $this
                        }

                        project = $this.querySelectorAll('.showcase--product')

                        let sct = ScrollTrigger.create({
                            trigger: trigger,
                            start: 'top top',
                            end: 'bottom+=' + $this.getAttribute('data-speed') + ' bottom',
                            scrub: true,
                            pin: pinTarget,
                            onUpdate: (self) => {
                                let prog = self.progress * wrapperWidth * -1
                                gsap.set(wrap, {
                                    x: prog
                                })
                            }
                        })

                    } else if (scope.classList.contains('navigate__draggable')) {
                        gsap.set(wrap, {
                            x: ($this.offsetWidth / 2) - (project[0].offsetWidth / 2)
                        })
                        Draggable.create(wrap, {
                            type: 'x',
                            inertia: true,
                            bounds: {
                                minX: (-1 * wrapperWidth) + (($this.offsetWidth / 2) + (project[0].offsetWidth / 2)),
                                maxX: ($this.offsetWidth / 2) - (project[0].offsetWidth / 2)
                            },
                            onDrag: function () {
                                if (scope.classList.contains('parallax__on')) {
                                    let prog = (this.x - (($this.offsetWidth / 2) - (project[0].offsetWidth / 2))) / ((-1 * wrapperWidth) + (($this.offsetWidth / 2) + (project[0].offsetWidth / 2)) - ($this.offsetWidth / 2) - (project[0].offsetWidth / 2))
                                    $this.querySelectorAll('.parallax--wrapper').forEach(function ($prlx) {
                                        gsap.set($prlx, {
                                            x: -prog * 20 + '%'
                                        })
                                    })
                                }
                            },
                            onThrowUpdate: function () {
                                if (scope.classList.contains('parallax__on')) {
                                    let prog = (this.x - (($this.offsetWidth / 2) - (project[0].offsetWidth / 2))) / ((-1 * wrapperWidth) + (($this.offsetWidth / 2) + (project[0].offsetWidth / 2)) - ($this.offsetWidth / 2) - (project[0].offsetWidth / 2))
                                    $this.querySelectorAll('.parallax--wrapper').forEach(function ($prlx) {
                                        gsap.set($prlx, {
                                            x: -prog * 20 + '%'
                                        })
                                    })
                                }
                            }
                        });

                    } else if (scope.classList.contains('navigate__scroll')) {
                        let pinTarget = $this.dataset.pinTarget,
                            trigger = $this.dataset.pinTarget;

                        if (!pinTarget) {
                            pinTarget = true;
                        }

                        if (!trigger) {
                            trigger = $this
                        }

                        ScrollTrigger.getById(scope.dataset.id) ? ScrollTrigger.getById(scope.dataset.id).kill(true) : '';

                        let tl = gsap.timeline({
                            id: wrap.dataset.id ? wrap.dataset.id : scope.dataset.id,
                            scrollTrigger: {
                                trigger: trigger,
                                id: scope.dataset.id,
                                start: 'top top',
                                end: 'bottom+=' + $this.getAttribute('data-speed') + ' bottom',
                                pin: pinTarget,
                                scrub: true,
                            }
                        });

                        tl.fromTo(wrap, {
                            x: ($this.offsetWidth / 2) - (project[0].offsetWidth / 2)
                        }, {
                            x: (-1 * wrapperWidth) + (($this.offsetWidth / 2) + (project[0].offsetWidth / 2)),
                        }, 0)
                        if (scope.classList.contains('parallax__on')) {
                            $this.querySelectorAll('.parallax--wrapper').forEach(function ($prlx) {
                                tl.to($prlx, {
                                    x: '-20%'
                                }, 0)
                            })
                        }
                    }
                    // let infinite = false
                    // if (scope.classList.contains('infinite__scroll')) {
                    //     infinite = true
                    // }

                    // const lenis = new Lenis({
                    //     infinite: infinite,
                    // });

                    // function onRaf(time) {
                    //     lenis.raf(time);
                    //     requestAnimationFrame(onRaf);
                    // }

                    // requestAnimationFrame(onRaf)

                })

            }
        });

        elementorFrontend.hooks.addAction('frontend/element_ready/peshowcaserotate.default', function ($scope, $) {
            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {

                var scope = jsScopeArray[i],
                    showcaseRotate = document.querySelectorAll('.showcase--rotate');

                showcaseRotate.forEach(function ($this) {
                    let product = $this.querySelectorAll('.showcase--product'),
                        wrap = $this.querySelector('.showcase--rotate--wrapper');

                    product.forEach(function ($item, index) {
                        gsap.set($item, {
                            rotate: (360 / product.length) * index
                        })
                    })
                    ///////////////////////////////////////////
                    product[0].classList.add('product--active')
                    ///////////////////////////////////////////


                    let rotateProg = 0,
                        segment = 360 / product.length

                    if ($this.classList.contains('has__mousewheel')) {
                        let wheeler = Hamster($this);

                        wheeler.wheel(function (event, delta, deltaX, deltaY) {

                            $this.querySelectorAll('.saren--single--product').forEach(function ($product) {
                                $product.classList.remove('product--active')
                            })

                            let wheelDeltaY = event.deltaY / -5;
                            rotateProg += wheelDeltaY

                            if (rotateProg < -360) {
                                rotateProg += 360
                            } else if (rotateProg > 0) {
                                rotateProg -= 360
                            }
                            gsap.set(wrap, {
                                rotate: rotateProg
                            })

                            clearTimeout(wheeler.timer);
                            wheeler.timer = setTimeout(function () {
                                let closestRotation = Math.round(rotateProg / segment) * segment;
                                gsap.to(wrap, {
                                    rotate: closestRotation,
                                    duration: 0.5,
                                    ease: 'power3.out'
                                });
                                rotateProg = closestRotation; // Yeni değeri güncelle

                                let activeIndex = parseInt(-closestRotation / segment);
                                if (activeIndex => product.length) {
                                    activeIndex = activeIndex % product.length
                                } else if (activeIndex < 0) {
                                    activeIndex = activeIndex + product.length
                                }

                                gsap.to($this.querySelector('.meta__' + activeIndex), {
                                    opacity: 1,
                                    pointerEvents: 'all'
                                })

                                ///////////////////////////////////////////

                                $this.querySelectorAll('.saren--single--product')[activeIndex].classList.add('product--active')
                                ///////////////////////////////////////////

                            }, 100);

                        });
                    }

                    if ($this.classList.contains('has__draggable')) {
                        Draggable.create(wrap, {
                            type: 'rotation',
                            inertia: true,
                            onDrag: function () {
                                $this.querySelectorAll('.saren--single--product').forEach(function ($product) {
                                    $product.classList.remove('product--active')
                                })
                            },
                            onThrowComplete: function () {

                                rotateProg = this.rotation

                                let closestRotation = Math.round(rotateProg / segment) * segment;

                                gsap.to(wrap, {
                                    rotate: closestRotation,
                                    duration: 0.5,
                                    ease: 'power3.out'
                                });

                                let activeIndex = parseInt(-closestRotation / segment)

                                if (activeIndex >= product.length) {
                                    activeIndex = activeIndex % product.length
                                }

                                rotateProg = closestRotation;


                                ///////////////////////////////////////////
                                $this.querySelectorAll('.saren--single--product')[activeIndex].classList.add('product--active')
                                ///////////////////////////////////////////

                            }
                        })
                    }

                })



            }
        });

        elementorFrontend.hooks.addAction('frontend/element_ready/peshowcasecards.default', function ($scope, $) {
            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {

                var scope = jsScopeArray[i],
                    showcaseCards = document.querySelectorAll('.showcase--cards')

                showcaseCards.forEach(function ($this, i) {
                    i++;

                    let productImage = $this.querySelectorAll('.saren--product--image--wrap'),
                        pinTarget = $this.getAttribute('data-pin-target'),
                        trigger = pinTarget

                    productImage.forEach((image, x) => {
                        x++
                        image.dataset.index = x;

                    })

                    if (!pinTarget) {
                        pinTarget = true;
                        trigger = $this
                    }

                    $this.querySelectorAll('.product--meta').forEach(function ($meta, x) {
                        x++
                        $meta.classList.add('sc--meta_' + x);
                        $meta.dataset.index = x;
                    })

                    gsap.getById(scope.dataset.id) ? gsap.getById(scope.dataset.id).scrollTrigger.kill(true) : '';

                    let tl = gsap.timeline({
                        id: scope.dataset.id,
                        scrollTrigger: {
                            trigger: trigger,
                            start: 'top top',
                            end: 'bottom+=' + $this.getAttribute('data-speed') + ' bottom',
                            scrub: 1,
                            pin: pinTarget,
                            onUpdate: (self) => {
                                let prog = self.progress * (productImage.length);

                                productImage.forEach(function ($image) {

                                    let index = $image.dataset.index;
                                    let meta = scope.querySelector('.sc--meta_' + index);
                                    if (index < prog) {



                                        gsap.to([$image, meta], {
                                            opacity: 0,
                                            pointerEvents: 'none'
                                        })

                                    } else {



                                        gsap.to($image, {
                                            opacity: 1,
                                            pointerEvents: 'all'
                                        });

                                    }

                                });

                                let metaIndex = Math.ceil(self.progress * (productImage.length));

                                $this.querySelectorAll('.product--meta').forEach(function ($meta, i) {

                                    if ($meta.classList.contains('sc--meta_' + metaIndex)) {
                                        $meta.classList.add('active');
                                        gsap.to($meta, {
                                            opacity: 1,
                                            pointerEvents: 'all'
                                        })
                                    } else {
                                        $meta.classList.remove('active');
                                        gsap.to($meta, {
                                            opacity: 0,
                                            pointerEvents: 'none'
                                        })
                                    }
                                })


                            }
                        }
                    })

                    productImage.forEach(function ($image, i) {
                        var index = i,
                            xSegment = 35,
                            ySegment = 35,
                            zSegment = 0

                        matchMedia.add({
                            isMobile: "(max-width: 550px)"

                        }, (context) => {

                            let {
                                isMobile
                            } = context.conditions;

                            xSegment = 0,
                                ySegment = -45
                            zSegment = -100

                        });
                        gsap.set($image, {
                            x: index * xSegment,
                            y: index * ySegment,
                            z: index * zSegment,
                            zIndex: 100 - index,
                        })

                        tl.to($image, {
                            ease: 'none',
                            x: index * xSegment - (productImage.length * xSegment),
                            y: index * ySegment - (productImage.length * ySegment),
                            z: index * zSegment - ((productImage.length - 1) * zSegment)
                        }, 0)
                    })

                    // matchMedia.add({
                    //     isMobile: "(max-width: 550px)"

                    // }, (context) => {

                    //     let {
                    //         isMobile
                    //     } = context.conditions;

                    //     xSegment = 0,
                    //         ySegment = -35

                    // });



                })

            }
        });

        // Showcases

        elementorFrontend.hooks.addAction('frontend/element_ready/peshoppingcart.default', function ($scope, $) {
            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    button = scope.querySelector('.saren--cart--button');

                if (scope.classList.contains('cart-mini-cart')) {
                    pePopup(scope, scope);
                }
                if (!sarenLenis && scope.querySelector('.cart_list')) {
                    const cartLenis = new Lenis({
                        wrapper: document.querySelector('.cart_list'),
                        smooth: false,
                        smoothTouch: false
                    });

                    function raf(time) {
                        siteHeader
                        cartLenis.raf(time);
                        requestAnimationFrame(raf);
                    }
                    requestAnimationFrame(raf);

                    window.cartLenis = cartLenis;

                } else {
                    window.cartLenis = false;
                }



            }

        });

        elementorFrontend.hooks.addAction('frontend/element_ready/peproductelements.default', function ($scope, $) {
            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i];

                if (scope.querySelector('.saren--sale--countdown')) {

                    let countdownElement = scope.querySelector('.saren--sale--countdown');
                    var saleEndTime = parseInt(countdownElement.getAttribute('data-endtime'));

                    var interval = setInterval(function () {
                        var now = new Date().getTime();
                        var distance = saleEndTime * 1000 - now;

                        if (distance < 0) {
                            clearInterval(interval);
                            countdownElement.innerHTML = "Sale Ended";
                        } else {
                            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                            gsap.to(countdownElement.querySelector('.days'), {
                                duration: 0.6,
                                text: { value: days, delimiter: '' },
                                ease: 'bounce.out'
                            });
                            gsap.to(countdownElement.querySelector('.hours'), {
                                duration: 0.6,
                                text: { value: hours, delimiter: '' },
                                ease: 'bounce.out'
                            });
                            gsap.to(countdownElement.querySelector('.minutes'), {
                                duration: 0.6,
                                text: { value: minutes, delimiter: '' },
                                ease: 'bounce.out'
                            });
                            gsap.to(countdownElement.querySelector('.seconds'), {
                                duration: 0.6,
                                text: { value: seconds, delimiter: '' },
                                ease: 'bounce.out'
                            });
                        }
                    }, 1000);
                }


                if (scope.classList.contains('atc--order--horizontal')) {

                    let wrap = scope.querySelector('tbody');

                    Draggable.create(wrap, {
                        type: 'x',
                        bounds: {
                            minX: 0,
                            maxX: -wrap.getBoundingClientRect().width + document.body.clientWidth - 100
                        },
                        lockAxis: true,
                        dragResistance: 0.5,
                        inertia: true,
                        allowContextMenu: true,
                    });


                }

                if (scope.querySelector('.pe--styled--popup')) {
                    pePopup(scope, scope.querySelector('.saren--product--element'));

                }

                if (scope.querySelector('.swc--accordion')) {

                    let items = scope.querySelectorAll('.swc--accordion--item');


                    items.forEach(item => {

                        let title = item.querySelector('.swc--item--title'),
                            content = item.querySelector('.swc--item--content');

                        title.addEventListener('click', () => {

                            let contState = Flip.getState(content, {
                                props: ['padding']
                            });

                            if (scope.querySelector('.swc--accordion--item.active') && !item.classList.contains('active')) {
                                scope.querySelector('.swc--accordion--item.active').querySelector('.swc--item--title').click();
                            }

                            item.classList.toggle('active');

                            Flip.from(contState, {
                                duration: 1,
                                ease: 'expo.inOut',
                                absolute: false,
                                absoluteOnLeave: false,
                            })


                        })


                    })

                    if (scope.classList.contains('accordion--first--active')) {
                        items[0].querySelector('.swc--item--title').click();
                        setTimeout(() => {
                            ScrollTrigger.refresh();
                        }, 1000);
                    }


                }

                if (scope.querySelector('.element--rating')) {

                    let ratings = scope.querySelectorAll('.element--rating');

                    ratings.forEach(rating => {

                        rating.addEventListener('click', () => {

                            if (parents(rating, '.product-page')) {

                                let page = parents(rating, '.product-page')[0];

                                if (page.querySelector('.item-reviews')) {

                                    page.querySelectorAll('.item-reviews').forEach(revs => revs.click());
                                }

                            }

                        })

                    })


                }

                if (scope.querySelector('.wc-tabs')) {

                    let tabs = scope.querySelector('.wc-tabs'),
                        titles = tabs.childNodes,
                        contents = scope.querySelectorAll('.woocommerce-Tabs-panel');

                    contents.forEach(cont => cont.style.display = 'none');

                    for (let i = 0; i < titles.length; i++) {

                        if (titles[i].tagName === 'LI') {
                            var findCont;
                            if (i == 1) {
                                titles[i].classList.add('active');
                                findCont = titles[i].getAttribute('aria-controls');
                                scope.querySelector('#' + findCont).style.display = 'block';
                            }
                        }
                    }

                    if (scope.querySelector('#rating')) {

                        scope.querySelectorAll('#rating').forEach(rating => {

                            const ratingElement = rating;
                            // Hide the #rating input and add the stars UI
                            ratingElement.style.display = 'none';
                            const starsContainer = document.createElement('p');
                            starsContainer.className = 'stars';
                            starsContainer.innerHTML = `
                <span>
                    <a class="star-1" href="#">1</a>
                    <a class="star-2" href="#">2</a>
                    <a class="star-3" href="#">3</a>
                    <a class="star-4" href="#">4</a>
                    <a class="star-5" href="#">5</a>
                </span>
            `;
                            ratingElement.insertAdjacentElement('beforebegin', starsContainer);
                        })



                    }

                }

                if (scope.classList.contains('add--configurator') && scope.querySelector('.variations_form')) {

                    var titlesWrap = scope.querySelector('.sv--configurator--titles'),
                        titles = titlesWrap.querySelectorAll('.svc--title'),
                        form = scope.querySelector('.variations_form'),
                        variations = form.querySelectorAll('tr'),
                        buttons = scope.querySelectorAll('.svc--button'),
                        inputs = scope.querySelectorAll('input[type=radio]');



                    variations.forEach((variation, i) => {
                        if (i == 0) {
                            variation.classList.add('active');
                        }
                    })

                    buttons.forEach((button, i) => {
                        if (i == 0) {
                            button.classList.add('active');
                        };

                        button.addEventListener('click', () => {
                            scope.querySelector('.svc--title--' + button.dataset.attr).click();
                        })
                    })

                    inputs.forEach(input => {

                        input.addEventListener('change', function () {

                            let parent = parents(input, 'tr'),
                                index = parseInt(parent[0].dataset.index) + 1,
                                button = scope.querySelector('.svc--button--' + index);

                            if (button) {
                                button.classList.remove('svc--disabled');
                            }
                            scope.querySelector('.svc--title--' + parent[0].dataset.attr).classList.remove('svc--disabled')
                        })
                    })


                    titles.forEach((title, i) => {

                        let attr = '.attr_' + title.dataset.attr,
                            button = scope.querySelector('.svc--button_' + title.dataset.attr),
                            buttonIndex = button ? parseInt(button.dataset.index) : null;

                        i == 0 ? title.classList.add('active') : '';

                        title.addEventListener('click', () => {

                            form.querySelector('.svc--title.active').classList.remove('active');
                            title.classList.add('active');

                            if (button) {
                                button.classList.remove('active');

                                if (scope.querySelector('.svc--button--' + (buttonIndex + 1))) {
                                    scope.querySelector('.svc--button--' + (buttonIndex + 1)).classList.add('active');
                                } else if (buttonIndex == buttons.length) {
                                    scope.querySelector('.single_variation_wrap').classList.add('active')
                                }
                            } else {

                                scope.querySelector('.single_variation_wrap').classList.remove('active');
                                buttons.forEach((button, i) => {
                                    button.classList.remove('active');
                                })
                                scope.querySelector('.svc--button--1').classList.add('active');
                            }

                            if (form.querySelector('tr.active')) {

                                form.querySelector('tr.active').classList.remove('active');
                            }

                            let state = Flip.getState(variations, {
                                props: ['display']
                            });

                            form.querySelector(attr).classList.add('active');

                            Flip.from(state, {
                                duration: 1,
                                ease: 'expo.inOut',
                                absolute: true,
                                absoluteOnLeave: true,
                                onEnter: elements => gsap.fromTo(elements, {
                                    opacity: 0,
                                    x: 100
                                }, {
                                    opacity: 1,
                                    x: 0
                                }),
                                onLeave: elements => gsap.fromTo(elements, {
                                    opacity: 1,
                                    x: 0
                                }, {
                                    opacity: 0,
                                    x: -100,
                                    stagger: 0.1
                                }),
                            })

                        })

                    })

                }

                scope.querySelectorAll('form.variations_form .saren-variation-radio-buttons input[type=radio]').forEach(function (radioButton) {
                    radioButton.addEventListener('change', function () {
                        var form = radioButton.closest('form.variations_form');
                        var attributeName = radioButton.getAttribute('name');
                        var attributeValue = radioButton.value;

                        var selectElement = form.querySelector('select[name="' + attributeName + '"]');

                        if (selectElement) {
                            selectElement.value = attributeValue;

                            var event = new Event('change', { bubbles: true });
                            selectElement.dispatchEvent(event);
                        }

                        var checkEvent = new Event('check_variations', { bubbles: true });
                        form.dispatchEvent(checkEvent);

                        if (scope.classList.contains('variation--selection--show')) {

                            let selectionText = form.querySelector('option[value="' + selectElement.value + '"]').innerHTML,
                                findLabel = parents(radioButton, 'tr')[0].querySelector('th.label label');

                            if (findLabel.querySelector('span')) {
                                findLabel.querySelector('span').remove();
                            }
                            findLabel.innerHTML += '<span> : ' + selectionText + '</span>';
                        }
                    });
                });

                if (scope.querySelector('select')) {
                    let selects = scope.querySelectorAll('select');
                    selects.forEach(select => {
                        let val = select.value; // Daha güvenli yol
                
                        if (val) {
                            let findRadio = scope.querySelector('input[value="' + val + '"]');
                            if (findRadio) {
                                findRadio.checked = true;
                
                                let event = new Event('change', { bubbles: true });
                                findRadio.dispatchEvent(event);
                            }
                        }
                    });
                }
                function saren_quantityControl(item) {
                    if (!item.querySelector('.input-text.qty') || !item.querySelector('.saren--quantity--control')) {
                        return false;
                    }
                    let qty = item.querySelector('.input-text.qty'),
                        max = parseInt(qty.max),
                        min = parseInt(qty.min),
                        val = parseInt(qty.value),
                        control = item.querySelector('.saren--quantity--control'),
                        decrease = control.querySelector('.quantity--decrease'),
                        increase = control.querySelector('.quantity--increase'),
                        current = control.querySelector('.current--quantity');

                    increase.addEventListener('click', () => {
                        val++;
                        val >= max ? val = max : '';
                        current.innerHTML = val;
                        qty.value = val;
                        updateButton.click();
                    })

                    decrease.addEventListener('click', () => {
                        val--
                        val <= min ? val = min : '';
                        current.innerHTML = val;
                        qty.value = val;
                        updateButton.click();

                    })

                }

                var addToCart = scope.querySelectorAll('.saren--cart--form');
                if (addToCart.length) {
                    addToCart.forEach(button => {
                        saren_quantityControl(button)
                    })
                }

                var inputs = scope.querySelectorAll('.inputfile');

                if (inputs.length) {

                    Array.prototype.forEach.call(inputs, function (input) {
                        var label = input.nextElementSibling,
                            labelVal = label.innerHTML;

                        input.addEventListener('change', function (e) {
                            var fileName = '';
                            if (this.files && this.files.length > 1)
                                fileName = (this.getAttribute('data-multiple-caption') || '').replace('{count}', this.files.length);
                            else
                                fileName = e.target.value.split('\\').pop();

                            if (fileName) {
                                label.querySelector('span').innerHTML = fileName;
                                input.classList.add('has--files');
                            } else {
                                label.innerHTML = labelVal;
                                input.classList.remove('has--files');
                            }
                        });

                        input.addEventListener('focus', function () { input.classList.add('has-focus'); });
                        input.addEventListener('blur', function () { input.classList.remove('has-focus'); });
                    });

                }

                if (scope.querySelector('.variations_form')) {
                    var form = scope.querySelector('.variations_form'),
                        tableRows = form.querySelectorAll('tr'),
                        disabled = true;

                    function checkVariations() {
                        disabled = false;
                        tableRows.forEach(row => {
                            let inputs = row.querySelectorAll('input');
                            let rowValid = false;

                            inputs.forEach(input => {

                                if (input.type === 'file') {
                                    rowValid = true;
                                } else if (input.checked) {
                                    rowValid = true;
                                }
                            });

                            if (!rowValid) {
                                disabled = true;
                            }
                        });

                        if (disabled == true) {
                            scope.querySelector('.woocommerce-variation-add-to-cart').classList.add('woocommerce-variation-add-to-cart-disabled')
                            scope.querySelector('.single_add_to_cart_button').classList.add('disabled')
                        } else {
                            scope.querySelector('.woocommerce-variation-add-to-cart').classList.remove('woocommerce-variation-add-to-cart-disabled')
                            scope.querySelector('.woocommerce-variation-add-to-cart').classList.add('woocommerce-variation-add-to-cart-enabled')
                            scope.querySelector('.single_add_to_cart_button').classList.remove('disabled')
                        }
                    }

                    checkVariations();

                    tableRows.forEach(row => {
                        row.querySelectorAll('input').forEach(input => {
                            input.addEventListener('change', () => {
                                checkVariations();
                            });
                        });
                    });
                }

                if (scope.querySelector('.saren--fbt-products')) {

                    const fbtCheckboxes = scope.querySelectorAll('.fbt-checkbox');
                    const fbtTotalValue = scope.querySelector('.fbt-total-value');

                    function updateTotalPrice() {
                        let total = 0;

                        fbtCheckboxes.forEach(checkbox => {
                            if (checkbox.checked) {
                                const productItem = checkbox.closest('.fbt-product-item');
                                const priceElement = productItem.querySelector('.fbt-price');
                                const priceText = priceElement.textContent.replace(/[^0-9.]/g, ''); // Remove currency symbols
                                total += parseFloat(priceText);

                                // Handle variations if any
                                const variationSelect = productItem.querySelector('.fbt-variation-select');
                                if (variationSelect && variationSelect.value) {
                                    const variationPrice = parseFloat(variationSelect.selectedOptions[0].dataset.price || 0);
                                    if (!isNaN(variationPrice)) {
                                        total += variationPrice - parseFloat(priceText); // Adjust for variation price
                                    }
                                }
                            }
                        });

                        fbtTotalValue.textContent = new Intl.NumberFormat('en-US', {
                            style: 'currency',
                            currency: 'USD',
                        }).format(total);
                    }

                    fbtCheckboxes.forEach(checkbox => {
                        checkbox.addEventListener('change', updateTotalPrice);
                    });

                    scope.querySelectorAll('.fbt-variation-select').forEach(select => {
                        select.addEventListener('change', updateTotalPrice);
                    });

                    // Initial total calculation
                    updateTotalPrice();


                }

                if (scope.classList.contains('sticky--atc--active')) {

                    let atc = scope.querySelector('.element--add-to-cart');
                    if (scope.querySelector('.saren--sticky--add--to--cart')) {
                        document.querySelector('.elementor_library-template').appendChild(scope.querySelector('.saren--sticky--add--to--cart'));
                    }

                    let stickyAtc = document.querySelector('.saren--sticky--add--to--cart');

                    ScrollTrigger.getById(scope.dataset.id) ? ScrollTrigger.getById(scope.dataset.id).kill(true) : '';

                    clearProps(stickyAtc);

                    ScrollTrigger.create({
                        trigger: atc,
                        id: scope.dataset.id,
                        start: 'bottom top',
                        onLeave: () => {
                            gsap.to(stickyAtc, {
                                yPercent: 0,
                                y: 0,
                                duration: .65,
                                ease: 'power4.out'
                            })
                        },
                        onLeaveBack: () => {
                            gsap.to(stickyAtc, {
                                yPercent: 100,
                                y: '100%',
                                duration: .65,
                                ease: 'power4.out'
                            })
                        }
                    })

                }





            }
        });

        elementorFrontend.hooks.addAction('frontend/element_ready/petimeline.default', function ($scope, $) {
            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {

                var scope = jsScopeArray[i],
                    timeline = scope.querySelectorAll('.pe--timeline');

                timeline.forEach(function ($this) {

                    let pinTarget = $this.getAttribute('data-pin-target'),
                        trigger = pinTarget,
                        start = parseInt($this.dataset.startItem),
                        item = $this.querySelectorAll('.timeline--item');

                    item.forEach(function ($item, i) {
                        if (i < start - 1) {
                            gsap.set($item, {
                                opacity: 0.3
                            })
                        }
                        let sep = $item.querySelector('.item--point')

                        setTimeout(function () {

                            if (scope.classList.contains('border__anim__active')) {
                                let tl = gsap.timeline({
                                    repeat: -1,
                                })

                                tl.to(sep, {
                                    width: sep.offsetWidth * 2,
                                    height: sep.offsetHeight * 2,
                                    ease: 'none',
                                    duration: 1.5
                                })

                                tl.to(sep, {
                                    width: sep.offsetWidth * 1,
                                    height: sep.offsetHeight * 1,
                                    ease: 'none',
                                    duration: 1.5
                                })
                            }

                        }, gsap.utils.random(500, 1500))


                    })

                    gsap.set($this, {
                        x: (-1 * ($this.offsetWidth / $this.querySelectorAll('.timeline--item').length)) * (start - 1)
                    })

                    if (!pinTarget) {
                        pinTarget = true
                        trigger = $this
                    }



                    if (scope.classList.contains('nav__scroll')) {
                        gsap.to($this, {
                            x: -1 * ($this.offsetWidth - scope.offsetWidth),
                            ease: 'none',
                            scrollTrigger: {
                                trigger: trigger,
                                pin: pinTarget,
                                scrub: true,
                                start: 'center center',
                                end: 'bottom+=' + $this.getAttribute('data-speed') + ' top'
                            }
                        })
                    } else {
                        Draggable.create($this, {
                            type: 'x',
                            bounds: {
                                minX: -1 * ($this.offsetWidth - scope.offsetWidth),
                                maxX: 0
                            },
                            inertia: true
                        })
                    }

                })




            }
        });


        elementorFrontend.hooks.addAction('frontend/element_ready/peyithwidgets.default', function ($scope, $) {
            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    account = scope.querySelector('.pe--yith--widget'),
                    wrap = scope.querySelector('.pe--yith--widget--wrap');

                if (scope.classList.contains('initialized')) {
                    return false;
                } else {
                    scope.classList.add('initialized');
                }

                function loadCompareTable() {
                    if (scope.querySelector('#yith-woocompare')) {
                        scope.querySelector('#yith-woocompare').remove();
                        scope.querySelector('h1').remove();
                    }

                    var compareTableElement = scope.querySelector('.saren--compare--table');
                    var compareTableUrl = compareTableElement.getAttribute('data-url');
                    var xhr = new XMLHttpRequest();
                    xhr.open('GET', compareTableUrl, true);

                    xhr.onload = function () {
                        if (xhr.status >= 200 && xhr.status < 300) {
                            var tempDiv = document.createElement('div');
                            tempDiv.innerHTML = xhr.responseText;

                            var compareContent = tempDiv.querySelector('#yith-woocompare'),
                                compareTitle = tempDiv.querySelector('h1');

                            if (compareContent) {
                                compareTableElement.innerHTML = compareContent.outerHTML;
                                compareTableElement.appendChild(compareTitle);

                                // Remove button listener
                                addRemoveButtonListeners();
                            } else {
                                compareTableElement.innerHTML = '<p>YITH Compare table not found.</p>';
                            }
                        } else {
                            console.error('AJAX Error: ' + xhr.statusText);
                            compareTableElement.innerHTML = '<p>Compare table couldn\'t be loaded.</p>';
                        }
                    };

                    xhr.onerror = function () {
                        console.error('AJAX Error: ' + xhr.statusText);
                        compareTableElement.innerHTML = '<p>An error occurred, please try again later.</p>';
                    };

                    xhr.send();
                }

                function addRemoveButtonListeners() {
                    var removeButtons = scope.querySelectorAll('.saren--compare--table a');
                    removeButtons.forEach(function (button) {
                        button.setAttribute('data-barba-prevent', 'all')
                        button.addEventListener('click', function (event) {
                            event.preventDefault();
                            setTimeout(() => {
                                let productId = button.getAttribute('data-product_id');
                                scope.querySelectorAll('.product_' + productId).forEach(item => item.remove());
                            }, 1000);

                        });
                    });
                }

                if (scope.querySelector('.saren--compare--table')) {
                    loadCompareTable();
                }

                if (scope.querySelector('.pe--yith--popup')) {
                    pePopup(scope, wrap)
                }
            }
        });


        elementorFrontend.hooks.addAction('frontend/element_ready/peaccount.default', function ($scope, $) {
            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    account = scope.querySelector('.pe--account'),
                    wrap = scope.querySelector('.pe--account--wrap');

                if (scope.querySelector('.pe--account--pop--button') && !account.classList.contains('is--logged--in')) {

                    pePopup(scope, wrap);

                    function handleMobile(open) {

                        let headerElements = document.querySelector('.site-header').querySelectorAll('.elementor-element:not(.elementor-widget-peaccount , .e-con , .elementor-widget-pesitenavigation)'),
                            toggle = document.querySelector('.menu--toggle--wrap');

                        clearProps('.site-header');

                        if (open) {
                            gsap.to([headerElements, toggle], {
                                opacity: 0,
                                pointerEvents: 'none'
                            })

                            if (parents(scope, '.elementor-widget-pesitenavigation').length) {

                                let navWidget = parents(scope, '.elementor-widget-pesitenavigation')[0],
                                    navParent = parents(navWidget, '.e-con')[0];

                                gsap.set(navParent, {
                                    zIndex: 999999999999
                                })
                            }

                        } else {

                            gsap.to([headerElements, toggle], {
                                opacity: 1,
                                pointerEvents: 'all',
                                onComplete: () => {
                                    gsap.set([headerElements, toggle], {
                                        clearProps: 'all'
                                    })
                                }
                            })

                            if (parents(scope, '.elementor-widget-pesitenavigation').length) {
                                let navWidget = parents(scope, '.elementor-widget-pesitenavigation')[0],
                                    navParent = parents(navWidget, '.e-con')[0];

                                gsap.set(navParent, {
                                    clearProps: 'all'
                                })
                            }


                        }

                    }

                }

            }
        });

        elementorFrontend.hooks.addAction('frontend/element_ready/peproductsarchive.default', function ($scope, $) {
            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i];

                if (scope.querySelector('.wishlist--empty')) {
                    return false;
                }

                var grid = scope.querySelector('.archive-products-section'),
                    items = grid.querySelectorAll('.saren--single--product');



                if (grid && grid.querySelector('.products--grid--switcher')) {

                    peSwitcher(scope, scope.querySelector('.products--grid--switcher'), scope.querySelector('.saren--products-grid '), items);

                }

                if (scope.querySelector('.pe--product--filters')) {

                    let filters = scope.querySelector('.pe--product--filters'),
                        wrapper = scope.querySelector('.filters--wrapper');

                    if (filters.classList.contains('filters--dropdown')) {

                        let button = scope.querySelector('.filters--button');

                        button.addEventListener('click', () => {



                            button.classList.toggle('active')

                            let state = Flip.getState(wrapper, {
                                props: ['border', 'margin', 'padding']
                            });

                            wrapper.classList.contains('active') ? wrapper.classList.remove('active') : wrapper.classList.add('active');

                            Flip.from(state, {
                                duration: 1,
                                ease: 'expo.inOut',
                                absolute: false,
                                absoluteOnLeave: false
                            })
                        })

                    } else if (filters.classList.contains('filters--popup')) {
                        pePopup(scope, scope);

                        if (scope.classList.contains('filters--button--fixed')) {

                            let button = scope.querySelector('.filters--button');
                            //     calc = window.innerHeight - scope.querySelector('.saren--products-grid').getBoundingClientRect().top - 45;

                            // gsap.set(button, {
                            //     top: calc
                            // })

                            ScrollTrigger.create({
                                trigger: scope,
                                start: 'top center',
                                end: 'bottom center',
                                onEnter: () => {
                                    button.classList.add('fb--active')
                                },
                                onEnterBack: () => {
                                    button.classList.add('fb--active')
                                },
                                onLeave: () => {
                                    button.classList.remove('fb--active')
                                },
                                onLeaveBack: () => {
                                    button.classList.remove('fb--active')
                                }
                            })

                        }
                    }

                }

                if (scope.querySelector('.filter-price-range')) {

                    let wrap = document.querySelector('.filter-price-range'),
                        labelMin = wrap.querySelector('.label--price--min span'),
                        labelMax = wrap.querySelector('.label--price--max span');

                    const rangeMin = document.getElementById('range_min');
                    const rangeMax = document.getElementById('range_max');
                    const minPrice = document.getElementById('min_price');
                    const maxPrice = document.getElementById('max_price');


                    rangeMin.addEventListener('input', updateRange);
                    rangeMax.addEventListener('input', updateRange);

                    function updateRange() {

                        if (parseInt(rangeMin.value) > parseInt(rangeMax.value)) {
                            rangeMin.value = rangeMax.value;
                        }
                        minPrice.value = rangeMin.value;
                        maxPrice.value = rangeMax.value;

                        labelMin.textContent = rangeMin.value;
                        labelMax.textContent = rangeMax.value;
                    }

                    minPrice.addEventListener('input', function () {
                        rangeMin.value = this.value;
                    });

                    maxPrice.addEventListener('input', function () {
                        rangeMax.value = this.value;
                    });

                }

                if (scope.querySelector('.saren--products--pagination')) {

                    var loadMore = scope.querySelector('.saren--products--load--more'),
                        clicks = 0;

                    function productsLoadMore(e, loadMore) {
                        if (document.body.classList.contains('e-preview--show-hidden-elements')) {
                            return false;
                        }

                        loadMore.classList.add('loading');
                        clicks++;

                        if (e) e.preventDefault();

                        document.documentElement.classList.add('loading');
                        loadMore.classList.add('loading');


                        $.ajax({
                            url: woocommerce_params.ajax_url,
                            type: "POST",
                            data: {
                                action: "pe_get_products",
                                offset: clicks,
                                args: grid.dataset.queryArgs,
                                settings: scope.dataset.settings
                            },
                            dataType: "json",
                            success: function (response) {
                                if (response.success) {

                                    let productsHtml = response.data.products;
                                    var wrapper = scope.querySelector('.saren--products-grid');

                                    if (productsHtml.length > 0) {

                                        let tl = gsap.timeline({
                                            onComplete: () => {
                                                ScrollTrigger.update();
                                                ScrollTrigger.getById('loadInfnite') ? ScrollTrigger.getById('loadInfnite').refresh() : '';
                                            }
                                        });

                                        productsHtml.forEach((productHtml, i) => {
                                            let tempDiv = document.createElement("div");
                                            tempDiv.innerHTML = productHtml;

                                            let productElement = tempDiv.firstElementChild;
                                            wrapper.appendChild(productElement);

                                            if (scope.querySelector('.archive-products-section').classList.contains('archive--masonry')) {
                                                let masonry = Masonry.data(scope.querySelector('.saren--products-grid'));

                                                masonry.appended(productElement);
                                                setTimeout(() => {
                                                    masonry.layout();
                                                    ScrollTrigger.update();
                                                    ScrollTrigger.getById('loadInfnite') ? ScrollTrigger.getById('loadInfnite').refresh() : '';
                                                }, 10);

                                                loadMore.classList.remove('loading');
                                            } else {

                                                tl.fromTo(productElement, {
                                                    opacity: 0,
                                                    yPercent: 100
                                                }, {
                                                    opacity: 1,
                                                    yPercent: 0,
                                                    duration: .75,
                                                    ease: 'expo.out',
                                                    onComplete: () => {
                                                        clearProps(productElement);
                                                        loadMore.classList.remove('loading');

                                                        if (productElement.querySelector('.pe-video')) {
                                                            let videos = productElement.querySelectorAll('.pe-video');

                                                            for (var i = 0; i < videos.length; i++) {
                                                                new peVideoPlayer(videos[i]);
                                                            }
                                                        }
                                                    }
                                                }, i * 0.15);
                                            }

                                            if (scope.querySelector('.archive-products-section').dataset.maxPages == clicks + 1) {
                                                loadMore.classList.add('hidden');
                                                ScrollTrigger.getById('loadInfnite') ? ScrollTrigger.getById('loadInfnite').kill(true) : '';

                                            }

                                            document.documentElement.classList.remove('loading');
                                            setTimeout(() => {
                                                ScrollTrigger.getById('fsb--' + scope.dataset.id,) ? ScrollTrigger.getById('fsb--' + scope.dataset.id).refresh(true) : '';
                                            }, 1000);

                                        });


                                    } else {
                                        console.log("No more products to load.");
                                    }
                                }
                            },
                            error: function (response) {
                                console.log(response.error);
                            }
                        });


                    }


                    if (loadMore) {
                        loadMore.addEventListener('click', (e) => {
                            productsLoadMore(e, loadMore);
                        })
                    }

                    let products = scope.querySelector('.archive-products-section');
                    if (products && products.classList.contains('pag_infinite-scroll')) {

                        let offset = 0;

                        ScrollTrigger.create({
                            trigger: products,
                            id: 'loadInfnite',
                            start: 'bottom bottom',
                            end: 'bottom top',
                            onEnter: () => {
                                offset++;
                                productsLoadMore(false, document.querySelector('.saren--products--infinite--scroll'))

                            }
                        })

                    }

                }

                scope.querySelectorAll('.pe--product--filters input , .products--sorting select').forEach(function (input) {

                    input.addEventListener('change', function () {
                        var filters = {};

                        let parentCats = parents(input, '.saren--products--filter--cats');

                        if (parentCats.length) {

                            parentCats[0].querySelectorAll('input[type="checkbox"]').forEach(function (checkbox) {
                                if (checkbox !== input) {
                                    checkbox.checked = false;
                                }
                            });
                        }

                        let filterparents = scope.querySelectorAll('.pe--product--filters');
                        filterparents.forEach(parent => {
                            parent.classList.add('loading');
                        });

                        var sortingSelect = scope.querySelector('.products--sorting select');
                        if (sortingSelect) {
                            filters['orderby'] = sortingSelect.value;
                        }

                        scope.querySelectorAll('.pe--product--filters input:checked').forEach(function (checkedInput) {
                            var filterName = checkedInput.getAttribute('name');

                            if (!filters[filterName]) {
                                filters[filterName] = [];
                            }

                            filters[filterName].push(checkedInput.value);

                            if (checkedInput.value === 'all') {
                                filters['product_cat'] = [];
                            }

                            if (input.classList.contains('check--sale')) {
                                filters['sale_products'] = checkedInput.value;
                            }

                        });

                        if (scope.querySelector('.filter-price-range')) {
                            var minPrice = scope.querySelector('#min_price').value;
                            var maxPrice = scope.querySelector('#max_price').value;

                            if (minPrice) {
                                filters['min_price'] = minPrice;
                            }
                            if (maxPrice) {
                                filters['max_price'] = maxPrice;
                            }
                        }

                        var queryParams = [];
                        for (var key in filters) {
                            if (filters.hasOwnProperty(key)) {
                                if (Array.isArray(filters[key])) {
                                    filters[key].forEach(function (value) {
                                        queryParams.push(encodeURIComponent(key) + '[]=' + encodeURIComponent(value));
                                    });
                                } else {
                                    queryParams.push(encodeURIComponent(key) + '=' + encodeURIComponent(filters[key]));
                                }
                            }
                        }

                        $.ajax({
                            url: woocommerce_params.ajax_url,
                            type: "POST",
                            data: {
                                action: "pe_get_products",
                                args: grid.dataset.queryArgs,
                                settings: scope.dataset.settings,
                                filters: filters
                            },
                            dataType: "json",
                            success: function (response) {
                                if (response.success) {



                                    let productsHtml = response.data.products;
                                    var productGrid = scope.querySelector('.saren--products-grid');
                                    productGrid.querySelectorAll('.saren--single--product').forEach(pr => pr.remove());

                                    let filterparents = scope.querySelectorAll('.pe--product--filters');
                                    filterparents.forEach(parent => {
                                        parent.classList.remove('loading');
                                    });

                                    productsHtml.forEach(function (newProduct) {
                                        let tempDiv = document.createElement("div");
                                        tempDiv.innerHTML = newProduct;

                                        let productElement = tempDiv.firstElementChild;
                                        productGrid.appendChild(productElement);

                                        setTimeout(() => {
                                            if (scope.querySelector('.archive-products-section').classList.contains('archive--masonry')) {
                                                var elem = scope.querySelector('.saren--products-grid');
                                                var msnry = new Masonry(elem, {
                                                    itemSelector: '.saren--single--product',
                                                    columnWidth: '.saren--products--masonry--sizer',
                                                    gutter: '.saren--products--masonry--gutter',
                                                    percentPosition: true,
                                                });
                                            }

                                            if (scope.querySelector('.product--archive--gallery')) {

                                                let swiperCont = scope.querySelectorAll('.product--archive--gallery');

                                                swiperCont.forEach(cont => {

                                                    var productArchiveGallery = new Swiper(cont, {
                                                        slidesPerView: 1,
                                                        speed: 750,
                                                        navigation: {
                                                            nextEl: cont.querySelector('.pag--next'),
                                                            prevEl: cont.querySelector('.pag--prev'),
                                                        },
                                                    });

                                                });

                                            }

                                        }, 10);


                                    });

                                }
                            },
                            error: function (response) {
                                console.log(response.error);
                            }
                        });

                    });

                });

                if (grid.classList.contains('archive--masonry')) {

                    var elem = scope.querySelector('.saren--products-grid');

                    var msnry = new Masonry(elem, {
                        itemSelector: '.saren--single--product',
                        columnWidth: '.saren--products--masonry--sizer',
                        gutter: '.saren--products--masonry--gutter',
                        percentPosition: true,
                    });

                    imagesLoaded(elem, function (instance) {
                        msnry.layout();
                    })


                }

                if (scope.querySelector('.saren--products--filter--cats')) {

                    let filterCats = scope.querySelector('.saren--products--filter--cats'),
                        catsWidth = filterCats.getBoundingClientRect().width;

                    if (filterCats.querySelector('.filter--cats--images--wrapper')) {

                        let imageCatsWrap = filterCats.querySelector('.filter--cats--images--wrapper');

                        if (catsWidth < imageCatsWrap.getBoundingClientRect().width) {

                            Draggable.create(imageCatsWrap, {
                                type: 'x',
                                bounds: filterCats,
                                lockAxis: true,
                                dragResistance: 0.5,
                                inertia: true,
                                allowContextMenu: true
                            });

                        }

                    }

                    matchMedia.add({
                        isMobile: "(max-width: 550px)"

                    }, (context) => {

                        let {
                            isMobile
                        } = context.conditions;

                        if (!filterCats.querySelector('.filter--cats--images--wrapper')) {

                            Draggable.create(filterCats, {
                                id: scope.dataset.id,
                                type: 'x',
                                bounds: {
                                    minX: 0,
                                    maxX: -catsWidth + (document.body.clientWidth / 2),
                                },
                                lockAxis: true,
                                dragResistance: 0.5,
                                inertia: true,
                                allowContextMenu: true
                            });

                        }

                    });

                }

                if (scope.classList.contains('filters--sidebar--pin') && scope.querySelector('.filters--sidebar')) {

                    let sidebar = scope.querySelector('.filters--sidebar'),
                        gridWrapper = scope.querySelector('.saren--products-grid'),
                        startOff = siteHeader[0].classList.contains('header--fixed') ? document.querySelector('.site-header').getBoundingClientRect().height : 25;

                    var filtersSidePin = ScrollTrigger.create({
                        trigger: gridWrapper,
                        pin: sidebar,
                        id: 'fsb--' + scope.dataset.id,
                        start: 'top top+=' + startOff,
                        end: 'bottom bottom',
                        pinSpacing: false
                    })

                    matchMedia.add({
                        isMobile: "(max-width: 550px)"

                    }, (context) => {

                        let {
                            isMobile
                        } = context.conditions;

                        filtersSidePin.kill(true);

                    });

                }

                if (scope.classList.contains('filters--accordion')) {

                    let wrapper = scope.querySelector('.filters--wrapper'),
                        titles = wrapper.querySelectorAll('.terms-list-title , .filter--label');

                        console.log(titles);

                    titles.forEach(title => {

                        let content, parent;
                        if (title.classList.contains('terms-list-title')) {
                            parent = parents(title, '.terms-list')[0],
                                content = parent.querySelector('.terms--terms')
                        } else {
                            parent = parents(title, '.filters--item')[0],
                                content = parent.querySelector('.terms-list')
                        }

                        if (content) {

                            title.addEventListener('click', (title) => {

                                if (parent.classList.contains('active')) {

                                    var contentState = Flip.getState(content, {
                                        props: ['padding']
                                    });
                                    parent.classList.remove('active');

                                    Flip.from(contentState, {
                                        duration: .75,
                                        ease: 'expo.inOut',
                                        absolute: false,
                                        absoluteOnLeave: false,
                                    })


                                } else {

                                    var contentState = Flip.getState(content, {
                                        props: ['padding']
                                    });

                                    parent.classList.add('active');

                                    Flip.from(contentState, {
                                        duration: .75,
                                        ease: 'expo.inOut',
                                        absolute: false,
                                        absoluteOnLeave: false,
                                    })

                                }

                            })


                        }





                    })


                }

                if (scope.querySelector('.product--archive--gallery')) {

                    let swiperCont = scope.querySelectorAll('.product--archive--gallery');

                    swiperCont.forEach(cont => {

                        var productArchiveGallery = new Swiper(cont, {
                            slidesPerView: 1,
                            speed: 750,
                            navigation: {
                                nextEl: cont.querySelector('.pag--next'),
                                prevEl: cont.querySelector('.pag--prev'),
                            },
                        });

                    });

                }

                if (scope.querySelector('.filters--wrapper--inner')) {

                    if (!sarenLenis) {
                        const popFiltersLenis = new Lenis({
                            wrapper: scope.querySelector('.filters--wrapper--inner'),
                            smooth: true,
                            smoothTouch: false
                        });

                        function raf(time) {
                            popFiltersLenis.raf(time);
                            requestAnimationFrame(raf);
                        }
                        requestAnimationFrame(raf);

                    }

                }

            }
        });


        elementorFrontend.hooks.addAction('frontend/element_ready/pelottie.default', function ($scope, $) {
            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    lottie = scope.querySelector('#dotlottie-canvas');



            }

        })


        elementorFrontend.hooks.addAction('frontend/element_ready/peforms.default', function ($scope, $) {
            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i],
                    form = scope.querySelector('.pe--form'),
                    inputs = form.querySelectorAll('input , textarea');

                if (scope.querySelector('.saren--form--submit--icon') && form.querySelector('.wpcf7-submit')) {
                    let p = parents(form.querySelector('.wpcf7-submit'), 'p')[0],
                        icon = scope.querySelector('.saren--form--submit--icon'),
                        submit = form.querySelector('.wpcf7-submit');

                    p.insertBefore(icon, submit)


                }

                inputs.forEach(input => {

                    input.addEventListener('input', function () {
                        if (input.value.trim() !== '') {
                            input.classList.add('has-content');
                            input.classList.remove('no-content');
                        } else {
                            input.classList.add('no-content');
                            input.classList.remove('has-content');
                        }
                    });

                })

            }

        })

        elementorFrontend.hooks.addAction('frontend/element_ready/pesingleproduct.default', function ($scope, $) {
            var jsScopeArray = $scope.toArray();
            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i];
                //     product = scope.querySelector('.saren--single--product'),
                //     button = scope.querySelector('.single_add_to_cart_button'),
                //     variationWrap = scope.querySelector('.single_variation_wrap'),
                //     table = scope.querySelector('table.variations'),
                //     form = scope.querySelector('.variations_form');

                // if (product.classList.contains('product-type-variable')) {

                //     setTimeout(() => {
                //         if (button.classList.contains('wc-variation-selection-needed')) {

                //             variationWrap.addEventListener('click', () => {

                //                 if (!variationWrap.classList.contains('active')) {
                //                     variationWrap.classList.add('active');
                //                     form.classList.add('variations--active');

                //                 } else {

                //                     variationWrap.classList.remove('active');
                //                     form.classList.remove('variations--active');


                //                 }

                //             })

                //         }
                //     }, 100);

                // }

                if (scope.querySelector('.product--archive--gallery')) {

                    let swiperCont = scope.querySelectorAll('.product--archive--gallery');

                    swiperCont.forEach(cont => {

                        var productArchiveGallery = new Swiper(cont, {
                            slidesPerView: 1,
                            speed: 750,
                            navigation: {
                                nextEl: cont.querySelector('.pag--next'),
                                prevEl: cont.querySelector('.pag--prev'),
                            },
                        });

                    });

                }

            }

        })

        elementorFrontend.hooks.addAction('frontend/element_ready/productmedia.default', function ($scope, $) {
            var jsScopeArray = $scope.toArray();

            for (var i = 0; i < jsScopeArray.length; i++) {
                var scope = jsScopeArray[i];

                if (!scope.querySelector('.product--gallery')) {
                    return false;
                }

                var gallery = scope.querySelector('.product--gallery'),
                    wrapper = gallery.querySelector('.product--gallery--wrapper'),
                    images = wrapper.querySelectorAll('.product--gallery--image'),
                    id = wrapper.dataset.id ? wrapper.dataset.id : scope.dataset.id,
                    trigger = wrapper.dataset.pinTarget ? wrapper.dataset.pinTarget : scope,
                    speed = wrapper.dataset.speed;


                images.forEach(image => {
                    if (image.querySelector('.img--zoom')) {
                        let zoomImage = image.querySelector('.img--zoom');

                        if (zoomImage.classList.contains('zoom-outer')) {
                            let zoomWrap = gallery.querySelector('.product--image--zoom--wrap');
                            zoomWrap.appendChild(zoomImage);
                        }

                        image.addEventListener('mouseenter', () => {
                            gsap.to(zoomImage, {
                                opacity: 1,
                                duration: 0.3,
                            });

                            image.classList.add('zoom--active');
                            gallery.querySelector('.product--image--zoom--wrap') ? gallery.querySelector('.product--image--zoom--wrap').classList.add('active') : '';
                        });

                        image.addEventListener('mousemove', (e) => {
                            const rect = image.getBoundingClientRect();
                            const zoomWidth = zoomImage.offsetWidth;
                            const zoomHeight = zoomImage.offsetHeight;

                            const xPercent = ((e.clientX - rect.left) / rect.width) * 100;
                            const yPercent = ((e.clientY - rect.top) / rect.height) * 100;

                            const offsetX = (xPercent - 50) * (zoomWidth / rect.width);
                            const offsetY = (yPercent - 50) * (zoomHeight / rect.height);

                            if (zoomImage.classList.contains('zoom-outer')) {

                                let zoomWrap = gallery.querySelector('.product--image--zoom--wrap'),
                                    follower = image.querySelector('.outer--zoom--follower');

                                gsap.to(zoomWrap, {
                                    left: rect.left + rect.width + 10,
                                    top: rect.top + 10,
                                    xPercent: rect.left > (window.outerWidth / 2) ? -200 : 0
                                });

                                gsap.to(follower, {
                                    x: (e.clientX - rect.left) - 50,
                                    y: (e.clientY - rect.top) - 50
                                });

                            }

                            gsap.to(zoomImage, {
                                x: -offsetX,
                                y: -offsetY,
                                duration: 0.1,
                                ease: "power2.out",
                            });
                        });

                        image.addEventListener('mouseleave', () => {

                            image.classList.remove('zoom--active');
                            gallery.querySelector('.product--image--zoom--wrap') ? gallery.querySelector('.product--image--zoom--wrap').classList.remove('active') : '';

                            gsap.to(zoomImage, {
                                opacity: 0,
                                x: 0,
                                y: 0,
                                duration: 0.3,
                            });
                        });

                    }
                });


                updateActiveCarouselItem(wrapper, '.product--gallery--image')

                if (gallery.classList.contains('gallery--carousel') && wrapper.classList.contains('cr--drag')) {
                    wrapper.classList.add(id);

                    Draggable.create(wrapper, {
                        id: id,
                        type: scope.classList.contains('carousel--vertical') ? 'y' : 'x',
                        bounds: {
                            minX: 0,
                            maxX: -wrapper.getBoundingClientRect().width + document.body.clientWidth,
                            minY: 0,
                            maxY: -wrapper.getBoundingClientRect().height + scope.getBoundingClientRect().height,
                        },
                        onDrag: () => {
                            updateActiveCarouselItem(wrapper, '.product--gallery--image')
                        },
                        lockAxis: true,
                        dragResistance: 0.5,
                        inertia: true,
                        allowContextMenu: true
                    });

                } else if (gallery.classList.contains('gallery--carousel') && wrapper.classList.contains
                    ('cr--scroll')) {

                    wrapper.classList.add(id);

                    var crScroll = gsap.to(wrapper, {
                        x: scope.classList.contains('carousel--horizontal') ? -wrapper.getBoundingClientRect().width + document.body.clientWidth : 0,
                        y: scope.classList.contains('carousel--vertical') ? -wrapper.getBoundingClientRect().height + scope.getBoundingClientRect().height : 0,
                        scrollTrigger: {
                            id: id,
                            trigger: trigger,
                            scrub: 1.2,
                            pin: trigger,
                            ease: "elastic.out(1, 0.3)",
                            start: 'top top',
                            end: 'bottom+=' + speed + ' bottom',
                            pinSpacing: 'padding',
                            onEnter: () => isPinnng(trigger, true),
                            onEnterBack: () => isPinnng(trigger, true),
                            onLeave: () => isPinnng(trigger, false),
                            onLeaveBack: () => isPinnng(trigger, false),
                            onUpdate: () => {
                                updateActiveCarouselItem(wrapper, '.product--gallery--image')
                            }
                        }
                    })

                    matchMedia.add({
                        isMobile: "(max-width: 550px)"

                    }, (context) => {

                        let {
                            isMobile
                        } = context.conditions;

                        crScroll.scrollTrigger.kill(true);

                        Draggable.create(wrapper, {
                            id: id,
                            type: 'x',
                            bounds: {
                                minX: 0,
                                maxX: -wrapper.getBoundingClientRect().width + document.body.clientWidth,
                                minY: 0,
                                maxY: -wrapper.getBoundingClientRect().height + scope.getBoundingClientRect().height,
                            },
                            lockAxis: true,
                            dragResistance: 0.5,
                            inertia: true,
                            allowContextMenu: true,
                            onDrag: () => {
                                updateActiveCarouselItem(wrapper, '.product--gallery--image')
                            },
                        });

                    });

                } else if (gallery.classList.contains('gallery--slideshow')) {
                    gallery.classList.add(id);
                    var interleaveOffset = 0.5;
                    var productSlider = new Swiper(gallery, {
                        slidesPerView: 1,
                        speed: 1250,
                        direction: scope.classList.contains('swiper--vertical') ? 'vertical' : 'horizontal',
                        loop: scope.classList.contains('swiper_loop') ? true : false,
                        parallax: scope.classList.contains('swiper_parallax') ? true : false,
                        mousewheel: scope.classList.contains('swiper_wheel') ? { invert: false } : false,
                        watchSlideProgress: true,
                        on: {
                            progress: function () {
                                if (scope.classList.contains('swiper_parallax')) {
                                    let swiper = this;
                                    for (let i = 0; i < swiper.slides.length; i++) {
                                        let slideProgress = swiper.slides[i].progress,
                                            innerOffset = swiper.height * interleaveOffset,
                                            innerTranslate = slideProgress * innerOffset;

                                        if (scope.classList.contains('swiper--vertical')) {
                                            swiper.slides[i].querySelector(".slide-bgimg").style.transform =
                                                "translateY(" + innerTranslate + "px)";
                                        } else {
                                            swiper.slides[i].querySelector(".slide-bgimg").style.transform =
                                                "translateX(" + innerTranslate + "px)";
                                        }




                                    }
                                }
                            },
                            setTransition: function (speed) {
                                if (scope.classList.contains('swiper_parallax')) {

                                    let swiper = this;
                                    for (let i = 0; i < swiper.slides.length; i++) {
                                        swiper.slides[i].style.transition = speed + "ms";
                                        swiper.slides[i].querySelector(".slide-bgimg").style.transition = 1250 + "ms";
                                    }
                                }
                            },
                            slideChangeTransitionEnd: () => {
                                if (scope.querySelector('.gallery--slideshow--thumbnails')) {
                                    scope.querySelector('.gs--thumb.active').classList.remove('active');
                                    scope.querySelector('.gs_thumb_' + productSlider.activeIndex).classList.add('active');

                                }

                            }
                        }
                    });

                    if (scope.querySelector('.gallery--slideshow--thumbnails')) {

                        let thumbs = scope.querySelectorAll('.gs--thumb');

                        scope.querySelectorAll('.gs--thumb')[0].classList.add('active');

                        thumbs.forEach(thumb => {

                            thumb.addEventListener('click', () => {
                                scope.querySelector('.gs--thumb.active').classList.remove('active');
                                thumb.classList.add('active');

                                productSlider.slideTo(thumb.dataset.id, 1250)
                            })

                        })
                    }



                }

                if (scope.classList.contains('images--lightbox--yes')) {
                    sarenLighbox(gallery, wrapper, images);
                }


            }
        });

        elementorFrontend.hooks.addAction('frontend/element_ready/pesccontrols.default', function ($scope, $) {

            setTimeout(function () {

                var jsScopeArray = $scope.toArray();

                for (var i = 0; i < jsScopeArray.length; i++) {

                    var scope = jsScopeArray[i],
                        control = scope.querySelector('.pe--sc--controls'),
                        id = control.dataset.id,
                        target = document.querySelector('.' + id);

                    if (target.querySelectorAll('.cr--item').length) {

                        var items = target.querySelectorAll('.cr--item'),
                            vars = {
                                progress: '',
                                current: '',
                                total: items.length,
                                width: items[0].offsetWidth
                            };

                        control.classList.add('sc--id__' + id);

                        items.forEach((item, c) => {
                            c++;
                            item.setAttribute('data-cr', c);

                        });

                        if (scope.querySelector('.sc--fraction')) {

                            if (control.classList.contains('unitaze--numbers')) {
                                scope.querySelector('.sc--total').innerHTML = vars.total < 10 ? '0' + vars.total : vars.total;
                            } else {
                                scope.querySelector('.sc--total').innerHTML = vars.total;
                            }

                        }

                        function getCurrentItem() {

                            let crValues = [];

                            items.forEach(item => {

                                if (item.getBoundingClientRect().x < (document.body.clientWidth * 0.75)) {
                                    crValues.push(parseInt(item.dataset.cr, 10));
                                }

                            });

                            if (crValues.length > 0) {
                                let maxCrValue = Math.max(...crValues);
                                if (control.classList.contains('unitaze--numbers')) {

                                    vars.current = maxCrValue < 10 ? '0' + maxCrValue : maxCrValue;
                                } else {
                                    vars.current = maxCrValue;
                                }

                            }

                            scope.querySelector('.sc--current') ? scope.querySelector('.sc--current').innerHTML = vars.current : '';


                        }

                        function updateOthers() {

                            let allControls = document.querySelectorAll('.sc--id__' + id);

                            if (allControls.length > 1) {

                                allControls.forEach(control => {

                                    let fraction = control.querySelector('.sc--fraction');

                                    if (fraction) {

                                        let current = fraction.querySelector('.sc--current'),
                                            total = fraction.querySelector('.sc--total');

                                        getCurrentItem()

                                        if (control.classList.contains('unitaze--numbers')) {

                                            current.innerHTML = vars.current < 10 ? '0' + vars.current : vars.current;
                                            total.innerHTML = vars.total < 10 ? '0' + vars.total : vars.total;

                                        } else {
                                            current.innerHTML = vars.current;
                                            total.innerHTML = vars.total;

                                        }

                                    }

                                })

                            }

                        }

                        if (target.classList.contains('cr--scroll')) {

                            let tween = gsap.getById(id);

                            if (tween) {
                                tween.eventCallback('onUpdate', self => {

                                    vars.progress = tween.progress() * 100;


                                    let crValues = [];

                                    items.forEach(item => {

                                        if (item.getBoundingClientRect().x < (document.body.clientWidth * 0.75)) {

                                            crValues.push(parseInt(item.dataset.cr, 10));
                                        }

                                    });

                                    if (crValues.length > 0) {
                                        let maxCrValue = Math.max(...crValues);
                                        vars.current = maxCrValue;

                                    }


                                    if (scope.querySelector('.sc--fraction')) {

                                        let current = scope.querySelector('.sc--current'),
                                            total = scope.querySelector('.sc--total');

                                        current.innerHTML = vars.current;
                                        total.innerHTML = vars.total;


                                    }

                                    if (scope.querySelector('.sc--progressbar')) {

                                        let prog = scope.querySelector('.sc--prog');

                                        gsap.to(prog, {
                                            width: vars.progress + '%'
                                        })

                                    }

                                })
                            }




                        }

                        if (target.classList.contains('cr--drag')) {

                            let draggable = Draggable.get(target);

                            if (draggable) {

                                draggable.addEventListener('throwupdate', () => {

                                    vars.progress = draggable.x / draggable.minX * 100;

                                    if (scope.querySelector('.sc--fraction')) {

                                        let current = scope.querySelector('.sc--current'),
                                            total = scope.querySelector('.sc--total');

                                        getCurrentItem()

                                        current.innerHTML = vars.current;
                                        total.innerHTML = vars.total;

                                    }

                                    if (scope.querySelector('.sc--progressbar')) {

                                        let prog = scope.querySelector('.sc--prog');

                                        gsap.to(prog, {
                                            width: vars.progress + '%'
                                        })
                                    }

                                });


                                if (scope.querySelector('.sc--navigation')) {

                                    let next = scope.querySelector('.sc--next'),
                                        prev = scope.querySelector('.sc--prev'),
                                        xVal = 0;

                                    next.addEventListener('click', () => {


                                        xVal = draggable.x;
                                        xVal -= vars.width;

                                        gsap.to(target, {
                                            x: xVal,
                                            onUpdate: () => {
                                                draggable.update(true);
                                                updateOthers();
                                            }
                                        })


                                    })

                                    prev.addEventListener('click', () => {

                                        xVal = draggable.x;
                                        xVal += vars.width;


                                        gsap.to(target, {
                                            x: xVal,
                                            onUpdate: () => {
                                                draggable.update(true);
                                                updateOthers();
                                            }
                                        })


                                    })

                                }

                            }

                        }

                        if (target.classList.contains('swiper-container')) {

                            let swiper = target.swiper,
                                speed = swiper.passedParams.speed;

                            if (scope.querySelector('.sc--navigation')) {

                                let prev = scope.querySelector('.sc--prev'),
                                    next = scope.querySelector('.sc--next');

                                prev.addEventListener('click', () => {
                                    swiper.slidePrev(speed, true);
                                })

                                next.addEventListener('click', () => {
                                    swiper.slideNext(speed, true)
                                })

                            } else if (scope.querySelector('.sc--fraction')) {

                                function unitize(number) {
                                    return number.toString().padStart(2, '0');
                                }

                                let curr = scope.querySelector('.sc--current'),
                                    tot = scope.querySelector('.sc--total'),
                                    length = target.querySelectorAll('.swiper-slide').length;

                                curr.innerHTML = control.classList.contains('unitaze--numbers') ? unitize(1) : 1;
                                tot.innerHTML = control.classList.contains('unitaze--numbers') ? unitize(length) : length;

                                swiper.on('slideChange', function () {
                                    curr.innerHTML = control.classList.contains('unitaze--numbers') ? unitize(swiper.activeIndex + 1) : swiper.activeIndex + 1;

                                });

                            }

                        } else {
                            getCurrentItem()
                        }

                    }


                }

            }, 10)

        })


    })


})(jQuery)

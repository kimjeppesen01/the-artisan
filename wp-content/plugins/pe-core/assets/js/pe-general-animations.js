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

var gmatchMedia = gsap.matchMedia();

function clearProps(target) {
    gsap.set(target, {
        clearProps: 'all'
    })
}

class peGeneralAnimation {

    constructor(DOM_el, id, options, fromOptions, scroll, out) {

        this.DOM = {
            el: null,
        };

        this.DOM.el = DOM_el;
        this.settings = this.DOM.el.dataset.settings;

        const properties = this.settings.slice(1, -1).split(';');

        const settings = properties.reduce((acc, property) => {
            const [key, value] = property.split('=');
            acc[key] = parseValue(value);
            return acc;
        }, {});


        function parseValue(value) {

            if (value === "true" || value === "false") {
                return value === "true";
            }

            const parsedNumber = parseFloat(value.replace(',', '.'));
            if (!isNaN(parsedNumber)) {
                return parsedNumber;
            }

            return value;
        }

        this.stagger = settings.stagger;
        this.duration = settings.duration;
        this.delay = settings.delay;
        this.scrub = settings.scrub;
        this.pin = settings.pin;
        this.pinMobile = settings.mobilePin;
        this.pinTarget = settings.pinTarget;
        this.animOut = settings.out;
        this.target = this.DOM.el.classList.contains('anim-multiple') ? this.DOM.el.querySelectorAll('.inner--anim') : this.DOM.el;


        // Animation Defaults
        this.defaults = {
            x: 0,
            y: 0,
            xPercent: 0,
            yPercent: 0,
            scale: 1,
            opacity: 1,
            duration: .75,
            delay: 0,
            stagger: 0,
            ease: 'expo.out',

        };

        // Animation start stages
        this.from = {
            yPercent: 0,
            xPercent: 0,
            x: 0,
            y: 0,
        }

        // Scroll options
        this.scroll = {
            scrollTrigger: {
                trigger: null,
                scrub: null,
                pin: null,
                start: 'top bottom',
                end: 'bottom center',
                pinSpacing: 'padding',
                onEnter: () => {
                    this.DOM.el.classList.add('viewport-enter');
                },
            }
        }

        this.out = {
            yPercent: null,
            stagger: null,
            duration: null,
            ease: 'expo.in',
            delay: 0
        }


        this.id = Math.random().toString(16).slice(2);

        this.scroll.scrollTrigger.start = settings.item_ref_start + ' ' + settings.window_ref_start;
        this.scroll.scrollTrigger.end = settings.item_ref_end + ' ' + settings.window_ref_end;

        this.progress = 0;

        this.pin == null ? this.pin = false : '';
        this.scrub == null ? this.scrub = false : '';
        this.animOut == null ? this.animOut = false : '';


        this.anim = this.DOM.el.dataset.animation;


        // Defaults for animations

        if (this.anim === 'fadeIn') {

            this.from.opacity = 0;

            this.defaults.duration = 0.75;
        }

        if ((this.anim === 'fadeUp') || (this.anim === 'fadeDown')) {

            this.from.opacity = 0;
            this.anim === 'fadeUp' ? this.from.y = 100 : this.from.y = -100;


        }

        if ((this.anim === 'fadeLeft') || (this.anim === 'fadeRight')) {

            this.from.opacity = 0;
            this.anim === 'fadeLeft' ? this.from.x = -100 : this.from.x = 100;


        }

        if (this.anim === 'slideUp') {

            //            this.scroll.scrollTrigger.start = 'top-=' + this.DOM.el.offsetHeight + ' bottom';
            this.scroll.scrollTrigger.start = 'top bottom';
            this.from.yPercent = 120;

        }

        if (this.anim === 'slideLeft' || this.anim === 'slideRight') {

            this.from.x = this.anim === 'slideLeft' ? (this.DOM.el.getBoundingClientRect().left + this.DOM.el.getBoundingClientRect().width) * -1 : (this.DOM.el.getBoundingClientRect().right + this.DOM.el.getBoundingClientRect().width);

        }

        if (this.anim === 'scaleUp') {

            let startScale = settings.start_scale,
                endScale = settings.end_scale;

            this.from.scale = startScale;
            this.defaults.scale = endScale;
            this.defaults.ease = 'expo.out';

        }

        if (this.anim === 'scaleDown') {

            let startScale = settings.start_scale,
                endScale = settings.end_scale;

            this.from.scale = startScale;
            this.defaults.scale = endScale;
            this.defaults.ease = 'expo.out';

            this.scroll.scrollTrigger.pinSpacing = 'padding';


        }

        if (this.anim === 'maskUp') {

            this.from.clipPath = ('inset(100% 0% 0% 0%)');
            this.defaults.clipPath = ('inset(0% 0% 0% 0%)');

        }

        if (this.anim === 'maskDown') {

            this.from.clipPath = ('inset(0% 0% 100% 0%)');
            this.defaults.clipPath = ('inset(0% 0% 0% 0%)');

            this.defaults.ease = 'power3.inOut'

        }

        if (this.anim === 'maskLeft') {

            this.from.clipPath = ('inset(0% 0% 0% 100%)');
            this.defaults.clipPath = ('inset(0% 0% 0% 0%)');
            this.defaults.ease = 'expo.inOut'

        }


        if (this.anim === 'maskRight') {

            this.from.clipPath = ('inset(0% 100% 0% 0%)');
            this.defaults.clipPath = ('inset(0% 0% 0% 0%)');

        }



        this.stagger == null ? this.stagger = this.defaults.stagger : '';
        this.delay == null ? this.delay = this.defaults.delay : '';
        this.duration == null ? this.duration = this.defaults.duration : '';

        this.options = Object.assign(this.defaults, options);
        this.fromOptions = Object.assign(this.from, fromOptions);
        this.scroll = Object.assign(this.scroll, scroll);

        this.options.stagger = this.stagger;
        this.options.delay = this.delay;
        this.options.duration = this.duration;

        this.scroll.scrollTrigger.trigger = this.DOM.el;

        if (this.pin) {

            this.scrub = true
            this.scroll.scrollTrigger.scrub = 1;

            if (this.pinTarget) {

                this.scroll.scrollTrigger.pin = this.pinTarget;
                this.scroll.scrollTrigger.trigger = this.pinTarget;

                const element = document.querySelector(this.pinTarget);

                element.style.cssText += 'transition-duration:0s';

            } else {

                this.scroll.scrollTrigger.pin = true;
            }

        }

        if ((this.scrub) && (!this.pin)) {
            this.scroll.scrollTrigger.scrub = 1;
        }

        if (this.scrub || this.pin) {

            this.defaults.ease = 'none';
        }


        gmatchMedia.add({
            isMobile: "(max-width: 550px)"

        }, (context) => {
            let {
                isMobile
            } = context.conditions;
            if (this.pinMobile !== true) {
                this.scroll.scrollTrigger.pin = false;
            }


        });


        if (this.animOut) {
            this.out.stagger = this.options.stagger;
            this.out.duration = this.options.duration;
            this.out = Object.assign(this.out, out);
        }
        if (parents(this.DOM.el, '.site--menu').length) {

            this.scroll.scrollTrigger = false;

        }

        this.render();


    }

    render() {


        this.tl = gsap.timeline(this.scroll)
        this.tl.fromTo(this.target, this.fromOptions, this.options);
        this.animOut == true ? this.tl.to(this.target, this.out) : '';

        this.tl.eventCallback("onStart", () => {
            this.DOM.el.classList.add('anim_start')
        });

        this.tl.eventCallback("onComplete", () => {
            if ((!this.scrub) && (!this.pin)) {

                clearProps(this.DOM.el)

            }
        });

        if (parents(this.DOM.el, '.site--menu').length) {

            let menu = parents(this.DOM.el, '.site--menu'),
                nav = parents(menu[0], '.site--nav');

            this.tl.pause();

            let toggle = nav[0].querySelector('.menu--toggle'),
                clicks = 0;

            toggle.addEventListener('click', () => {
                clicks++

                if (clicks % 2 == 0) {
                    // Close
                    this.tl.reverse();


                } else {
                    // Open

                    this.tl.play();
                }
            })


        }


    }

};

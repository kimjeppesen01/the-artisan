(function () {
    'use strict';

    if (typeof saRecipeData === 'undefined') return;

    var CIRCUMFERENCE = 339.29;

    var App = {
        currentMethod: null,
        currentLang: 'da',
        timerInterval: null,
        timerSeconds: 0,
        timerTotal: 0,
        timerRunning: false,
        timerPaused: false,
        activeStepIndex: null,
        activeStepMethod: null,
        audioCtx: null,
        el: {},

        init: function () {
            this.cacheDOM();
            if (!this.el.root) return;

            this.currentLang = saRecipeData.defaultLang || 'da';
            this.currentMethod = Object.keys(saRecipeData.methods)[0];

            this.bindEvents();
            this.updateGrind(saRecipeData.methods[this.currentMethod].grind);
            this.loadState();
            this.updateAllProgress();
            this.updateTimerControls();
        },

        cacheDOM: function () {
            this.el.root = document.getElementById('sa-recipe');
            if (!this.el.root) return;

            this.el.langBtn = document.getElementById('sa-recipe-lang');
            this.el.methods = this.el.root.querySelectorAll('.sa-recipe__method');
            this.el.paramsSets = this.el.root.querySelectorAll('.sa-recipe__params');
            this.el.stepsSets = this.el.root.querySelectorAll('.sa-recipe__steps');
            this.el.tips = this.el.root.querySelectorAll('.sa-recipe__tip');
            this.el.grindMarker = document.getElementById('sa-grind-marker');
            this.el.grindDots = document.getElementById('sa-grind-dots');
            this.el.timerRing = document.getElementById('sa-timer-ring');
            this.el.timerDisplay = document.getElementById('sa-timer-display');
            this.el.timerControls = document.getElementById('sa-timer-controls');
            this.el.timerStart = document.getElementById('sa-timer-start');
            this.el.timerStartWrap = document.getElementById('sa-timer-start-wrap');
            this.el.timerReset = document.getElementById('sa-timer-reset');
            this.el.timer = document.getElementById('sa-recipe-timer');
        },

        bindEvents: function () {
            var self = this;

            // Method switching
            this.el.methods.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    self.switchMethod(btn.dataset.method);
                });
            });

            // Language toggle
            if (this.el.langBtn) {
                this.el.langBtn.addEventListener('click', function () {
                    self.toggleLang();
                });
            }

            // Delegated clicks on recipe card
            this.el.root.addEventListener('click', function (e) {
                // Step check
                var checkBtn = e.target.closest('.sa-recipe__step-check');
                if (checkBtn) {
                    var step = checkBtn.closest('.sa-recipe__step');
                    if (step) self.toggleStep(step);
                    return;
                }

                // Step time pill -> start timer
                var timePill = e.target.closest('.sa-recipe__step-time');
                if (timePill && timePill.dataset.seconds) {
                    var stepEl = timePill.closest('.sa-recipe__step');
                    var stepsContainer = timePill.closest('.sa-recipe__steps');
                    if (stepEl && stepsContainer) {
                        self.activeStepIndex = parseInt(stepEl.dataset.step);
                        self.activeStepMethod = stepsContainer.dataset.method;
                        self.startTimer(parseInt(timePill.dataset.seconds));
                        self.scrollToTimer();
                    }
                    return;
                }

                // Next step button
                if (e.target.closest('#sa-next-step')) {
                    self.advanceToNextStep();
                    return;
                }
            });

            // Timer start/pause
            if (this.el.timerStart) {
                this.el.timerStart.addEventListener('click', function (e) {
                    e.preventDefault();
                    if (self.timerRunning && !self.timerPaused) {
                        self.pauseTimer();
                    } else if (self.timerPaused) {
                        self.resumeTimer();
                    }
                });
            }

            // Timer reset
            if (this.el.timerReset) {
                this.el.timerReset.addEventListener('click', function (e) {
                    e.preventDefault();
                    self.resetTimer();
                });
            }
        },

        // -- Helpers --

        // Update text content while preserving child elements (e.g. .pb__hover inside .pb__main)
        setTextSafe: function (el, text) {
            if (el.children.length > 0) {
                var firstChild = el.childNodes[0];
                if (firstChild && firstChild.nodeType === 3) {
                    firstChild.textContent = text;
                }
            } else {
                el.textContent = text;
            }
        },

        // Update text in a Saren pe--button anchor (finds .pb__main and .pb__hover)
        setButtonText: function (anchorEl, text) {
            if (!anchorEl) return;
            var mainSpan = anchorEl.querySelector('.pb__main');
            var hoverSpan = anchorEl.querySelector('.pb__hover');
            if (mainSpan) {
                var textNode = mainSpan.childNodes[0];
                if (textNode && textNode.nodeType === 3) {
                    textNode.textContent = text;
                }
            }
            if (hoverSpan) {
                hoverSpan.textContent = text;
            }
        },

        // -- Method Switching --

        switchMethod: function (methodKey) {
            if (!saRecipeData.methods[methodKey]) return;
            this.currentMethod = methodKey;

            this.el.methods.forEach(function (btn) {
                var isActive = btn.dataset.method === methodKey;
                btn.classList.toggle('active', isActive);
                btn.setAttribute('aria-selected', isActive ? 'true' : 'false');
            });

            this.el.paramsSets.forEach(function (set) {
                set.classList.toggle('active', set.dataset.method === methodKey);
            });

            this.el.stepsSets.forEach(function (set) {
                set.classList.toggle('active', set.dataset.method === methodKey);
            });

            this.el.tips.forEach(function (tip) {
                tip.classList.toggle('active', tip.dataset.method === methodKey);
            });

            this.updateGrind(saRecipeData.methods[methodKey].grind);
            this.resetTimer();
            this.saveState();
        },

        // -- Language Toggle --

        toggleLang: function () {
            this.currentLang = this.currentLang === 'da' ? 'en' : 'da';
            this.updateAllStrings();
            this.saveState();
        },

        updateAllStrings: function () {
            var lang = this.currentLang;
            var strings = saRecipeData.strings[lang];
            var self = this;

            // data-i18n labels: look up in strings object, preserve child elements
            this.el.root.querySelectorAll('[data-i18n]').forEach(function (el) {
                var key = el.dataset.i18n;
                if (!strings[key]) return;
                self.setTextSafe(el, strings[key]);
            });

            // data-da / data-en content: swap textContent
            this.el.root.querySelectorAll('[data-da]').forEach(function (el) {
                el.textContent = el.dataset[lang] || el.dataset.da;
            });

            // Guide card hrefs
            this.el.root.querySelectorAll('.sa-recipe__guide-card[data-url-da]').forEach(function (a) {
                a.href = lang === 'en' ? a.dataset.urlEn : a.dataset.urlDa;
            });
        },

        // -- Timer System --

        startTimer: function (seconds) {
            this.resetTimer();
            this.timerTotal = seconds;
            this.timerSeconds = seconds;
            this.timerRunning = true;
            this.timerPaused = false;

            this.updateTimerDisplay();
            this.updateTimerRing(0);
            this.updateTimerControls();

            var self = this;
            this.timerInterval = setInterval(function () {
                self.tickTimer();
            }, 1000);

            // Highlight active step
            if (this.activeStepMethod !== null && this.activeStepIndex !== null) {
                var step = this.el.root.querySelector(
                    '.sa-recipe__steps[data-method="' + this.activeStepMethod + '"] .sa-recipe__step[data-step="' + this.activeStepIndex + '"]'
                );
                if (step) step.classList.add('sa-recipe__step--active');
            }
            if (this.el.timer) this.el.timer.classList.add('sa-recipe__timer--running');
        },

        pauseTimer: function () {
            clearInterval(this.timerInterval);
            this.timerPaused = true;
            this.updateTimerControls();
            if (this.el.timer) this.el.timer.classList.remove('sa-recipe__timer--running');
        },

        resumeTimer: function () {
            this.timerPaused = false;
            this.updateTimerControls();
            if (this.el.timer) this.el.timer.classList.add('sa-recipe__timer--running');

            var self = this;
            this.timerInterval = setInterval(function () {
                self.tickTimer();
            }, 1000);
        },

        resetTimer: function () {
            clearInterval(this.timerInterval);
            this.timerRunning = false;
            this.timerPaused = false;
            this.timerSeconds = 0;
            this.timerTotal = 0;

            if (this.el.timerDisplay) {
                this.el.timerDisplay.textContent = '00:00';
                this.el.timerDisplay.classList.remove('sa-recipe__timer-done');
            }
            if (this.el.timerRing) {
                this.el.timerRing.style.strokeDashoffset = CIRCUMFERENCE;
            }

            // Remove next-step button
            var nextBtn = document.getElementById('sa-next-step');
            if (nextBtn) nextBtn.remove();

            // Remove active step highlights
            this.el.root.querySelectorAll('.sa-recipe__step--active').forEach(function (s) {
                s.classList.remove('sa-recipe__step--active');
            });
            if (this.el.timer) this.el.timer.classList.remove('sa-recipe__timer--running');

            this.updateTimerControls();
        },

        tickTimer: function () {
            this.timerSeconds--;
            this.updateTimerDisplay();

            var progress = 1 - (this.timerSeconds / this.timerTotal);
            this.updateTimerRing(progress);

            if (this.timerSeconds <= 0) {
                this.onTimerComplete();
            }
        },

        onTimerComplete: function () {
            clearInterval(this.timerInterval);
            this.timerRunning = false;

            if (this.el.timerDisplay) {
                this.el.timerDisplay.classList.add('sa-recipe__timer-done');
            }
            if (this.el.timer) this.el.timer.classList.remove('sa-recipe__timer--running');

            this.updateTimerControls();
            this.playChime();
            this.vibrate([100, 50, 100]);
            this.showNextStepButton();
        },

        updateTimerDisplay: function () {
            if (!this.el.timerDisplay) return;
            var mins = Math.floor(this.timerSeconds / 60);
            var secs = this.timerSeconds % 60;
            this.el.timerDisplay.textContent =
                (mins < 10 ? '0' : '') + mins + ':' + (secs < 10 ? '0' : '') + secs;
        },

        updateTimerRing: function (progress) {
            if (!this.el.timerRing) return;
            var offset = CIRCUMFERENCE * (1 - progress);
            this.el.timerRing.style.strokeDashoffset = offset;
        },

        updateTimerControls: function () {
            if (!this.el.timerStartWrap) return;
            var strings = saRecipeData.strings[this.currentLang];

            if (this.timerRunning && !this.timerPaused) {
                // Show pause
                this.setButtonText(this.el.timerStart, strings.timer_pause);
                this.el.timerStartWrap.style.display = '';
            } else if (this.timerPaused) {
                // Show resume
                this.setButtonText(this.el.timerStart, strings.timer_start);
                this.el.timerStartWrap.style.display = '';
            } else {
                // No timer active: hide start button
                this.el.timerStartWrap.style.display = 'none';
            }
        },

        showNextStepButton: function () {
            var existing = document.getElementById('sa-next-step');
            if (existing) existing.remove();

            var strings = saRecipeData.strings[this.currentLang];

            var wrap = document.createElement('div');
            wrap.className = 'pe--button pb--background pb--small sa-recipe__next-step-wrap';
            wrap.id = 'sa-next-step';
            wrap.innerHTML =
                '<div class="pe--button--wrapper">' +
                    '<a href="#" onclick="return false;">' +
                        '<span class="pb__main">' + strings.next_step +
                            '<span class="pb__hover">' + strings.next_step + '</span>' +
                        '</span>' +
                    '</a>' +
                '</div>';

            if (this.el.timerControls) {
                this.el.timerControls.appendChild(wrap);
            }
        },

        // -- Steps System --

        toggleStep: function (stepEl) {
            stepEl.classList.toggle('completed');
            this.vibrate([30]);
            this.updateProgress(stepEl.closest('.sa-recipe__steps'));
            this.saveState();
        },

        advanceToNextStep: function () {
            if (this.activeStepMethod === null || this.activeStepIndex === null) return;

            var stepsContainer = this.el.root.querySelector(
                '.sa-recipe__steps[data-method="' + this.activeStepMethod + '"]'
            );
            if (!stepsContainer) return;

            // Complete current step
            var currentStep = stepsContainer.querySelector(
                '.sa-recipe__step[data-step="' + this.activeStepIndex + '"]'
            );
            if (currentStep && !currentStep.classList.contains('completed')) {
                currentStep.classList.add('completed');
                this.vibrate([30]);
            }

            this.updateProgress(stepsContainer);

            // Find next uncompleted step
            var allSteps = stepsContainer.querySelectorAll('.sa-recipe__step');
            var nextStep = null;
            for (var i = 0; i < allSteps.length; i++) {
                if (!allSteps[i].classList.contains('completed')) {
                    nextStep = allSteps[i];
                    break;
                }
            }

            if (nextStep) {
                nextStep.scrollIntoView({ behavior: 'smooth', block: 'center' });

                // Auto-start timer if next step has one
                var timePill = nextStep.querySelector('.sa-recipe__step-time');
                if (timePill && timePill.dataset.seconds) {
                    this.activeStepIndex = parseInt(nextStep.dataset.step);
                    this.startTimer(parseInt(timePill.dataset.seconds));
                } else {
                    this.resetTimer();
                    this.activeStepIndex = parseInt(nextStep.dataset.step);
                }
            } else {
                // All done
                this.resetTimer();
                var strings = saRecipeData.strings[this.currentLang];
                if (this.el.timerDisplay) {
                    this.el.timerDisplay.textContent = strings.all_done;
                    this.el.timerDisplay.classList.add('sa-recipe__timer-done');
                }
                this.playChime();
                this.vibrate([100, 50, 100, 50, 100]);
            }

            this.saveState();
        },

        updateProgress: function (stepsContainer) {
            if (!stepsContainer) return;

            var allSteps = stepsContainer.querySelectorAll('.sa-recipe__step');
            var completed = stepsContainer.querySelectorAll('.sa-recipe__step.completed');
            var progressEl = stepsContainer.querySelector('.sa-recipe__steps-progress');

            if (progressEl) {
                progressEl.textContent = completed.length + ' / ' + allSteps.length;
            }

            stepsContainer.classList.toggle(
                'all-done',
                completed.length === allSteps.length && allSteps.length > 0
            );
        },

        updateAllProgress: function () {
            var self = this;
            this.el.stepsSets.forEach(function (set) {
                self.updateProgress(set);
            });
        },

        // -- Grind Visualizer --

        updateGrind: function (position) {
            if (this.el.grindMarker) {
                this.el.grindMarker.style.left = position + '%';
            }
            this.generateDots(position);
        },

        generateDots: function (position) {
            var container = this.el.grindDots;
            if (!container) return;
            container.innerHTML = '';

            var baseSize = 2 + (position / 100) * 8;
            var dotCount = 8;

            for (var i = 0; i < dotCount; i++) {
                var dot = document.createElement('span');
                dot.className = 'sa-recipe__grind-dot';
                var size = Math.max(2, baseSize + (Math.random() - 0.5) * 2);
                dot.style.width = size + 'px';
                dot.style.height = size + 'px';
                container.appendChild(dot);
            }
        },

        // -- Audio --

        playChime: function () {
            try {
                if (!this.audioCtx) {
                    this.audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                }
                var ctx = this.audioCtx;
                var now = ctx.currentTime;

                var osc1 = ctx.createOscillator();
                var gain1 = ctx.createGain();
                osc1.connect(gain1);
                gain1.connect(ctx.destination);
                osc1.type = 'sine';
                osc1.frequency.setValueAtTime(880, now);
                gain1.gain.setValueAtTime(0.3, now);
                gain1.gain.exponentialRampToValueAtTime(0.01, now + 0.4);
                osc1.start(now);
                osc1.stop(now + 0.4);

                var osc2 = ctx.createOscillator();
                var gain2 = ctx.createGain();
                osc2.connect(gain2);
                gain2.connect(ctx.destination);
                osc2.type = 'sine';
                osc2.frequency.setValueAtTime(1108.73, now + 0.15);
                gain2.gain.setValueAtTime(0, now);
                gain2.gain.setValueAtTime(0.3, now + 0.15);
                gain2.gain.exponentialRampToValueAtTime(0.01, now + 0.6);
                osc2.start(now + 0.15);
                osc2.stop(now + 0.6);
            } catch (e) {
                // Audio not critical
            }
        },

        // -- Haptic --

        vibrate: function (pattern) {
            if (navigator.vibrate) {
                navigator.vibrate(pattern);
            }
        },

        // -- Scroll --

        scrollToTimer: function () {
            if (this.el.timer) {
                this.el.timer.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        },

        // -- Local Storage --

        saveState: function () {
            try {
                var state = {
                    method: this.currentMethod,
                    lang: this.currentLang,
                    completed: {}
                };

                var methods = Object.keys(saRecipeData.methods);
                for (var m = 0; m < methods.length; m++) {
                    var key = methods[m];
                    var steps = this.el.root.querySelectorAll(
                        '.sa-recipe__steps[data-method="' + key + '"] .sa-recipe__step.completed'
                    );
                    if (steps.length > 0) {
                        state.completed[key] = [];
                        steps.forEach(function (s) {
                            state.completed[key].push(parseInt(s.dataset.step));
                        });
                    }
                }

                localStorage.setItem('sa-recipe-app', JSON.stringify(state));
            } catch (e) {
                // Storage unavailable
            }
        },

        loadState: function () {
            try {
                var raw = localStorage.getItem('sa-recipe-app');
                if (!raw) return;

                var state = JSON.parse(raw);

                if (state.method && saRecipeData.methods[state.method]) {
                    this.switchMethod(state.method);
                }

                if (state.lang && (state.lang === 'da' || state.lang === 'en')) {
                    this.currentLang = state.lang;
                    this.updateAllStrings();
                }

                if (state.completed) {
                    var self = this;
                    Object.keys(state.completed).forEach(function (method) {
                        var indices = state.completed[method];
                        if (!indices) return;
                        indices.forEach(function (i) {
                            var step = self.el.root.querySelector(
                                '.sa-recipe__steps[data-method="' + method + '"] .sa-recipe__step[data-step="' + i + '"]'
                            );
                            if (step) step.classList.add('completed');
                        });
                    });
                }
            } catch (e) {
                // Corrupt storage
            }
        }
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () { App.init(); });
    } else {
        App.init();
    }
})();

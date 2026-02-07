(function () {
    'use strict';

    if (typeof saRecipeData === 'undefined') return;

    var CIRCUMFERENCE = 339.292; // 2 * PI * 54

    var App = {
        // State
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

        // DOM cache
        el: {},

        init: function () {
            this.cacheDOM();
            if (!this.el.root) return;

            this.bindEvents();

            // Set first method
            var firstKey = Object.keys(saRecipeData.methods)[0];
            this.currentMethod = firstKey;

            // Generate initial grind dots
            this.updateGrind(saRecipeData.methods[firstKey].grind);

            // Restore saved state
            this.loadState();

            // Update progress counters
            this.updateAllProgress();
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

            // Step check buttons
            this.el.root.addEventListener('click', function (e) {
                var checkBtn = e.target.closest('.sa-recipe__step-check');
                if (checkBtn) {
                    var step = checkBtn.closest('.sa-recipe__step');
                    if (step) self.toggleStep(step);
                    return;
                }

                // Step time pill = start timer for that step
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
                var nextBtn = e.target.closest('#sa-next-step');
                if (nextBtn) {
                    self.advanceToNextStep();
                    return;
                }
            });

            // Timer controls
            if (this.el.timerStart) {
                this.el.timerStart.addEventListener('click', function () {
                    if (self.timerRunning && !self.timerPaused) {
                        self.pauseTimer();
                    } else if (self.timerPaused) {
                        self.resumeTimer();
                    }
                });
            }

            if (this.el.timerReset) {
                this.el.timerReset.addEventListener('click', function () {
                    self.resetTimer();
                });
            }
        },

        // ── Method Switching ──

        switchMethod: function (methodKey) {
            if (!saRecipeData.methods[methodKey]) return;
            this.currentMethod = methodKey;

            // Toggle .active on method buttons
            this.el.methods.forEach(function (btn) {
                btn.classList.toggle('active', btn.dataset.method === methodKey);
            });

            // Toggle .active on params
            this.el.paramsSets.forEach(function (set) {
                set.classList.toggle('active', set.dataset.method === methodKey);
            });

            // Toggle .active on steps
            this.el.stepsSets.forEach(function (set) {
                set.classList.toggle('active', set.dataset.method === methodKey);
            });

            // Toggle .active on tips
            this.el.tips.forEach(function (tip) {
                tip.classList.toggle('active', tip.dataset.method === methodKey);
            });

            // Update grind
            this.updateGrind(saRecipeData.methods[methodKey].grind);

            // Reset timer
            this.resetTimer();

            this.saveState();
        },

        // ── Language Toggle ──

        toggleLang: function () {
            this.currentLang = this.currentLang === 'da' ? 'en' : 'da';
            this.updateAllStrings();
            this.saveState();
        },

        updateAllStrings: function () {
            var lang = this.currentLang;
            var strings = saRecipeData.strings[lang];

            // data-i18n labels
            this.el.root.querySelectorAll('[data-i18n]').forEach(function (el) {
                var key = el.dataset.i18n;
                if (strings[key]) el.textContent = strings[key];
            });

            // data-da / data-en content
            this.el.root.querySelectorAll('[data-da]').forEach(function (el) {
                el.textContent = el.dataset[lang] || el.dataset.da;
            });
        },

        // ── Timer System ──

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
        },

        pauseTimer: function () {
            clearInterval(this.timerInterval);
            this.timerPaused = true;
            this.updateTimerControls();
        },

        resumeTimer: function () {
            this.timerPaused = false;
            this.updateTimerControls();

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
                this.el.timerDisplay.textContent = '0:00';
                this.el.timerDisplay.classList.remove('sa-recipe__timer-done');
            }
            if (this.el.timerRing) {
                this.el.timerRing.style.strokeDashoffset = CIRCUMFERENCE;
            }

            // Remove next-step button if present
            var nextBtn = document.getElementById('sa-next-step');
            if (nextBtn) nextBtn.remove();

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

            // Flash animation
            if (this.el.timerDisplay) {
                this.el.timerDisplay.classList.add('sa-recipe__timer-done');
            }

            // Audio chime
            this.playChime();

            // Haptic
            this.vibrate([100, 50, 100]);

            // Show "Next Step" button
            this.showNextStepButton();
        },

        updateTimerDisplay: function () {
            if (!this.el.timerDisplay) return;
            var mins = Math.floor(this.timerSeconds / 60);
            var secs = this.timerSeconds % 60;
            this.el.timerDisplay.textContent = mins + ':' + (secs < 10 ? '0' : '') + secs;
        },

        updateTimerRing: function (progress) {
            if (!this.el.timerRing) return;
            // progress 0 = empty ring (full dashoffset), 1 = full ring (0 offset)
            var offset = CIRCUMFERENCE * (1 - progress);
            this.el.timerRing.style.strokeDashoffset = offset;
        },

        updateTimerControls: function () {
            if (!this.el.timerStart) return;
            var strings = saRecipeData.strings[this.currentLang];

            if (this.timerRunning && !this.timerPaused) {
                this.el.timerStart.textContent = strings.pause;
                this.el.timerStart.style.display = '';
            } else if (this.timerPaused) {
                this.el.timerStart.textContent = strings.start;
                this.el.timerStart.style.display = '';
            } else {
                this.el.timerStart.style.display = 'none';
            }
        },

        showNextStepButton: function () {
            // Remove existing if any
            var existing = document.getElementById('sa-next-step');
            if (existing) existing.remove();

            var strings = saRecipeData.strings[this.currentLang];
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.id = 'sa-next-step';
            btn.className = 'sa-recipe__next-step';
            btn.textContent = strings.next_step;

            if (this.el.timerControls) {
                this.el.timerControls.appendChild(btn);
            }
        },

        // ── Steps System ──

        toggleStep: function (stepEl) {
            stepEl.classList.toggle('completed');
            this.vibrate([30]);
            this.updateProgress(stepEl.closest('.sa-recipe__steps'));
            this.saveState();
        },

        advanceToNextStep: function () {
            // Complete the active step
            if (this.activeStepMethod !== null && this.activeStepIndex !== null) {
                var stepsContainer = this.el.root.querySelector(
                    '.sa-recipe__steps[data-method="' + this.activeStepMethod + '"]'
                );
                if (stepsContainer) {
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
                        // Scroll to next step
                        nextStep.scrollIntoView({ behavior: 'smooth', block: 'center' });

                        // If next step has a timer, auto-start it
                        var timePill = nextStep.querySelector('.sa-recipe__step-time');
                        if (timePill && timePill.dataset.seconds) {
                            this.activeStepIndex = parseInt(nextStep.dataset.step);
                            this.startTimer(parseInt(timePill.dataset.seconds));
                        } else {
                            this.resetTimer();
                        }
                    } else {
                        // All done
                        this.resetTimer();
                        var doneStrings = saRecipeData.strings[this.currentLang];
                        if (this.el.timerDisplay) {
                            this.el.timerDisplay.textContent = doneStrings.done;
                        }
                    }
                }
            }

            this.saveState();
        },

        updateProgress: function (stepsContainer) {
            if (!stepsContainer) return;

            var allSteps = stepsContainer.querySelectorAll('.sa-recipe__step');
            var completed = stepsContainer.querySelectorAll('.sa-recipe__step.completed');
            var progressEl = stepsContainer.querySelector('.sa-recipe__steps-progress');

            if (progressEl) {
                progressEl.textContent = completed.length + '/' + allSteps.length;
            }

            if (completed.length === allSteps.length && allSteps.length > 0) {
                stepsContainer.classList.add('all-done');
            } else {
                stepsContainer.classList.remove('all-done');
            }
        },

        updateAllProgress: function () {
            var self = this;
            this.el.stepsSets.forEach(function (set) {
                self.updateProgress(set);
            });
        },

        // ── Grind Visualizer ──

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
            var dotCount = 7;

            for (var i = 0; i < dotCount; i++) {
                var dot = document.createElement('span');
                dot.className = 'sa-recipe__grind-dot';
                var size = Math.max(2, baseSize + (Math.random() - 0.5) * 2);
                dot.style.width = size + 'px';
                dot.style.height = size + 'px';
                container.appendChild(dot);
            }
        },

        // ── Audio ──

        playChime: function () {
            try {
                if (!this.audioCtx) {
                    this.audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                }
                var ctx = this.audioCtx;
                var now = ctx.currentTime;

                // First tone
                var osc1 = ctx.createOscillator();
                var gain1 = ctx.createGain();
                osc1.connect(gain1);
                gain1.connect(ctx.destination);
                osc1.type = 'sine';
                osc1.frequency.setValueAtTime(880, now); // A5
                gain1.gain.setValueAtTime(0.3, now);
                gain1.gain.exponentialRampToValueAtTime(0.01, now + 0.4);
                osc1.start(now);
                osc1.stop(now + 0.4);

                // Second tone (slightly delayed)
                var osc2 = ctx.createOscillator();
                var gain2 = ctx.createGain();
                osc2.connect(gain2);
                gain2.connect(ctx.destination);
                osc2.type = 'sine';
                osc2.frequency.setValueAtTime(1108.73, now + 0.15); // C#6
                gain2.gain.setValueAtTime(0, now);
                gain2.gain.setValueAtTime(0.3, now + 0.15);
                gain2.gain.exponentialRampToValueAtTime(0.01, now + 0.6);
                osc2.start(now + 0.15);
                osc2.stop(now + 0.6);
            } catch (e) {
                // Audio not critical
            }
        },

        // ── Haptic ──

        vibrate: function (pattern) {
            if (navigator.vibrate) {
                navigator.vibrate(pattern);
            }
        },

        // ── Scroll ──

        scrollToTimer: function () {
            if (this.el.timer) {
                this.el.timer.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        },

        // ── Local Storage ──

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

                localStorage.setItem('sa-recipe-' + saRecipeData.productId, JSON.stringify(state));
            } catch (e) {
                // Storage unavailable
            }
        },

        loadState: function () {
            try {
                var raw = localStorage.getItem('sa-recipe-' + saRecipeData.productId);
                if (!raw) return;

                var state = JSON.parse(raw);

                // Restore method
                if (state.method && saRecipeData.methods[state.method]) {
                    this.switchMethod(state.method);
                }

                // Restore language
                if (state.lang && (state.lang === 'da' || state.lang === 'en')) {
                    this.currentLang = state.lang;
                    this.updateAllStrings();
                }

                // Restore completed steps
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

    // Boot
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () { App.init(); });
    } else {
        App.init();
    }
})();

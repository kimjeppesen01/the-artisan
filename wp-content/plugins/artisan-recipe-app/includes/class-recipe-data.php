<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Central recipe data store.
 * All content is bilingual (da/en). Methods, parameters, steps, and tips.
 */
class SARA_Recipe_Data {

    public static function get_methods() {
        return [

            'espresso' => [
                'name'  => 'Espresso',
                'time'  => '25-30s',
                'grind' => 12, // 0=fine, 100=coarse
                'icon'  => '<svg viewBox="0 0 32 32" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="6" y="8" width="16" height="14" rx="2"/><path d="M22 12h3a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2h-3"/><line x1="8" y1="26" x2="20" y2="26"/><line x1="10" y1="22" x2="10" y2="26"/><line x1="18" y1="22" x2="18" y2="26"/><path d="M10 8c0-2 1-3 4-3s4 1 4 3" opacity="0.4"/></svg>',
                'params' => [
                    [ 'value' => '18g',    'da' => 'Dosis',      'en' => 'Dose' ],
                    [ 'value' => 'Fin',    'da' => 'Kvaerning',  'en' => 'Grind' ],
                    [ 'value' => '1:2',    'da' => 'Ratio',      'en' => 'Ratio' ],
                    [ 'value' => '93°C',   'da' => 'Temperatur', 'en' => 'Temp' ],
                    [ 'value' => '25-30s', 'da' => 'Tid',        'en' => 'Time' ],
                ],
                'steps' => [
                    [
                        'title_da' => 'Forvarm portafilter',
                        'title_en' => 'Preheat portafilter',
                        'desc_da'  => 'Skyl portafilteret og koppen med varmt vand. Toem begge dele og toer efter.',
                        'desc_en'  => 'Rinse the portafilter and cup with hot water. Empty both and dry.',
                        'time'     => 0,
                    ],
                    [
                        'title_da' => 'Dosering og fordeling',
                        'title_en' => 'Dose and distribute',
                        'desc_da'  => 'Mal 18g kaffe direkte i portafilteret. Fordel jaevnt og tamp med fast, helt lige tryk.',
                        'desc_en'  => 'Grind 18g coffee directly into the portafilter. Distribute evenly and tamp with firm, level pressure.',
                        'time'     => 0,
                    ],
                    [
                        'title_da' => 'Indsaet og start',
                        'title_en' => 'Insert and start',
                        'desc_da'  => 'Saet portafilteret i gruppen og start ekstraktion med det samme.',
                        'desc_en'  => 'Lock the portafilter into the group head and start extraction immediately.',
                        'time'     => 0,
                    ],
                    [
                        'title_da' => 'Ekstraktion',
                        'title_en' => 'Extraction',
                        'desc_da'  => 'Maal 36g i koppen paa 25-30 sekunder. Juster kvaerning hvis noedvendigt.',
                        'desc_en'  => 'Aim for 36g in the cup in 25-30 seconds. Adjust grind if needed.',
                        'time'     => 28,
                        'time_label' => '25-30s',
                    ],
                    [
                        'title_da' => 'Server og nyd',
                        'title_en' => 'Serve and enjoy',
                        'desc_da'  => 'Server med det samme. Skummet skal vaere gyldent.',
                        'desc_en'  => 'Serve immediately. The crema should be golden.',
                        'time'     => 0,
                    ],
                ],
                'tip_da' => 'Hvis dit skud loeber for hurtigt (under 20s), gaa finere. For langsomt (over 35s), gaa grovere. Juster altid en variabel ad gangen.',
                'tip_en' => 'If your shot runs too fast (under 20s), go finer. Too slow (over 35s), go coarser. Always adjust one variable at a time.',
            ],

            'pourover' => [
                'name'  => 'Pour Over',
                'time'  => '2:30-3:00',
                'grind' => 38,
                'icon'  => '<svg viewBox="0 0 32 32" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M8 6h16l-5 18H13L8 6z"/><line x1="10" y1="6" x2="22" y2="6"/><ellipse cx="16" cy="28" rx="6" ry="2"/><line x1="16" y1="24" x2="16" y2="26"/><path d="M12 12h8" opacity="0.4"/></svg>',
                'params' => [
                    [ 'value' => '15g',        'da' => 'Dosis',      'en' => 'Dose' ],
                    [ 'value' => 'Medium-fin',  'da' => 'Kvaerning',  'en' => 'Grind' ],
                    [ 'value' => '1:16',       'da' => 'Ratio',      'en' => 'Ratio' ],
                    [ 'value' => '93-96°C',    'da' => 'Temperatur', 'en' => 'Temp' ],
                    [ 'value' => '2:30-3:00',  'da' => 'Tid',        'en' => 'Time' ],
                ],
                'steps' => [
                    [
                        'title_da' => 'Skyl filter',
                        'title_en' => 'Rinse filter',
                        'desc_da'  => 'Placer filteret i dripper og skyl med varmt vand. Toem karaflen.',
                        'desc_en'  => 'Place the filter in the dripper and rinse with hot water. Empty the carafe.',
                        'time'     => 0,
                    ],
                    [
                        'title_da' => 'Tilfoej kaffe',
                        'title_en' => 'Add coffee',
                        'desc_da'  => 'Mal 15g kaffe (medium-fin) og haeld i filteret. Ryst let for jaevn fordeling.',
                        'desc_en'  => 'Grind 15g coffee (medium-fine) and pour into the filter. Shake gently to level.',
                        'time'     => 0,
                    ],
                    [
                        'title_da' => 'Bloom',
                        'title_en' => 'Bloom',
                        'desc_da'  => 'Haeld 30g vand over kaffen i cirkulaere bevaegelser. Vent 30-45 sekunder.',
                        'desc_en'  => 'Pour 30g of water over the coffee in circular motions. Wait 30-45 seconds.',
                        'time'     => 35,
                        'time_label' => '0:30',
                    ],
                    [
                        'title_da' => 'Haeld vand',
                        'title_en' => 'Pour water',
                        'desc_da'  => 'Haeld resten af vandet (240g total) i langsomme, cirkulaere bevaegelser over 1-2 minutter.',
                        'desc_en'  => 'Pour the remaining water (240g total) in slow, circular motions over 1-2 minutes.',
                        'time'     => 90,
                        'time_label' => '1:30',
                    ],
                    [
                        'title_da' => 'Drawdown og server',
                        'title_en' => 'Drawdown and serve',
                        'desc_da'  => 'Lad alt vandet loebe igennem. Total tid: 2:30-3:00. Fjern dripper og server.',
                        'desc_en'  => 'Let all the water drain through. Total time: 2:30-3:00. Remove dripper and serve.',
                        'time'     => 0,
                    ],
                ],
                'tip_da' => 'En god bloom er noeglen til jaevn ekstraktion. Kaffen skal boble og udvide sig. Hvis den ikke bobler, er kaffen sandsynligvis for gammel.',
                'tip_en' => 'A good bloom is key to even extraction. The coffee should bubble and expand. If it doesn\'t bubble, the coffee is likely too old.',
            ],

            'aeropress' => [
                'name'  => 'Aeropress',
                'time'  => '1:30-2:00',
                'grind' => 50,
                'icon'  => '<svg viewBox="0 0 32 32" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="10" y="8" width="12" height="18" rx="1"/><line x1="12" y1="4" x2="20" y2="4"/><line x1="12" y1="4" x2="12" y2="8"/><line x1="20" y1="4" x2="20" y2="8"/><line x1="12" y1="22" x2="20" y2="22" opacity="0.4"/><line x1="14" y1="26" x2="18" y2="26"/><line x1="16" y1="26" x2="16" y2="29"/></svg>',
                'params' => [
                    [ 'value' => '15g',      'da' => 'Dosis',      'en' => 'Dose' ],
                    [ 'value' => 'Medium',   'da' => 'Kvaerning',  'en' => 'Grind' ],
                    [ 'value' => '1:12',     'da' => 'Ratio',      'en' => 'Ratio' ],
                    [ 'value' => '85-90°C',  'da' => 'Temperatur', 'en' => 'Temp' ],
                    [ 'value' => '1:30-2:00','da' => 'Tid',        'en' => 'Time' ],
                ],
                'steps' => [
                    [
                        'title_da' => 'Forbered (inverteret)',
                        'title_en' => 'Prepare (inverted)',
                        'desc_da'  => 'Saet stemplet i bunden og vend Aeropress paa hovedet. Skyl med varmt vand.',
                        'desc_en'  => 'Insert the plunger at the bottom and flip the AeroPress upside down. Rinse with hot water.',
                        'time'     => 0,
                    ],
                    [
                        'title_da' => 'Tilfoej kaffe og vand',
                        'title_en' => 'Add coffee and water',
                        'desc_da'  => 'Mal 15g kaffe (medium). Haeld 180g vand ved 85-90°C.',
                        'desc_en'  => 'Grind 15g coffee (medium). Pour 180g water at 85-90°C.',
                        'time'     => 0,
                    ],
                    [
                        'title_da' => 'Roer og steep',
                        'title_en' => 'Stir and steep',
                        'desc_da'  => 'Roer forsigtigt 3-4 gange. Saet filteret paa og lad traekke i 1 minut.',
                        'desc_en'  => 'Stir gently 3-4 times. Attach the filter cap and let steep for 1 minute.',
                        'time'     => 60,
                        'time_label' => '1:00',
                    ],
                    [
                        'title_da' => 'Vend og pres',
                        'title_en' => 'Flip and press',
                        'desc_da'  => 'Vend forsigtigt over koppen. Pres langsomt og jaevnt ned i 20-30 sekunder.',
                        'desc_en'  => 'Carefully flip onto your cup. Press slowly and evenly for 20-30 seconds.',
                        'time'     => 25,
                        'time_label' => '0:25',
                    ],
                    [
                        'title_da' => 'Server',
                        'title_en' => 'Serve',
                        'desc_da'  => 'Stop naar du hoerer en hvaese lyd. Nyd din kaffe ren eller tilsat lidt varmt vand.',
                        'desc_en'  => 'Stop when you hear a hissing sound. Enjoy your coffee black or add a little hot water.',
                        'time'     => 0,
                    ],
                ],
                'tip_da' => 'Proev at saenke vandtemperaturen til 80°C for en mildere, mere frugtagtig kop. Aeropress er fantastisk til at eksperimentere.',
                'tip_en' => 'Try lowering the water temperature to 80°C for a smoother, more fruity cup. AeroPress is great for experimenting.',
            ],

            'frenchpress' => [
                'name'  => 'French Press',
                'time'  => '4:00',
                'grind' => 82,
                'icon'  => '<svg viewBox="0 0 32 32" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="8" y="8" width="16" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="8"/><circle cx="16" cy="2" r="1.5"/><line x1="10" y1="18" x2="22" y2="18" opacity="0.4"/><line x1="8" y1="26" x2="24" y2="26"/></svg>',
                'params' => [
                    [ 'value' => '30g',      'da' => 'Dosis',      'en' => 'Dose' ],
                    [ 'value' => 'Grov',     'da' => 'Kvaerning',  'en' => 'Grind' ],
                    [ 'value' => '1:15',     'da' => 'Ratio',      'en' => 'Ratio' ],
                    [ 'value' => '93-96°C',  'da' => 'Temperatur', 'en' => 'Temp' ],
                    [ 'value' => '4:00',     'da' => 'Tid',        'en' => 'Time' ],
                ],
                'steps' => [
                    [
                        'title_da' => 'Forvarm',
                        'title_en' => 'Preheat',
                        'desc_da'  => 'Skyl French Press med varmt vand for at forvarme. Toem vandet.',
                        'desc_en'  => 'Rinse the French Press with hot water to preheat. Discard the water.',
                        'time'     => 0,
                    ],
                    [
                        'title_da' => 'Tilfoej kaffe og vand',
                        'title_en' => 'Add coffee and water',
                        'desc_da'  => 'Mal 30g kaffe (grov). Haeld 450g vand (93-96°C) over kaffen.',
                        'desc_en'  => 'Grind 30g coffee (coarse). Pour 450g water (93-96°C) over the coffee.',
                        'time'     => 0,
                    ],
                    [
                        'title_da' => 'Steep',
                        'title_en' => 'Steep',
                        'desc_da'  => 'Laeg laaget paa uden at trykke stemplet ned. Lad traekke i 4 minutter.',
                        'desc_en'  => 'Place the lid on without pressing the plunger. Let steep for 4 minutes.',
                        'time'     => 240,
                        'time_label' => '4:00',
                    ],
                    [
                        'title_da' => 'Bryd skorpen',
                        'title_en' => 'Break the crust',
                        'desc_da'  => 'Fjern laaget. Bryd skorpen paa overfladen med en ske og skum af.',
                        'desc_en'  => 'Remove the lid. Break the crust on top with a spoon and skim off the foam.',
                        'time'     => 0,
                    ],
                    [
                        'title_da' => 'Pres og server',
                        'title_en' => 'Press and serve',
                        'desc_da'  => 'Saet laaget paa og tryk stemplet langsomt ned. Skaenk med det samme.',
                        'desc_en'  => 'Replace the lid and press the plunger down slowly. Pour immediately.',
                        'time'     => 0,
                    ],
                ],
                'tip_da' => 'Spring aldrig over at bryde skorpen og skumme af. Det fjerner fint sediment og giver en renere kop uden bitterhed.',
                'tip_en' => 'Never skip breaking the crust and skimming. It removes fine sediment and gives a cleaner cup without bitterness.',
            ],
        ];
    }

    /**
     * Profile section data.
     */
    public static function get_profile() {
        return [
            'details' => [
                [ 'da' => 'Oprindelse',    'en' => 'Origin',        'value' => 'Peru, Rioja' ],
                [ 'da' => 'Fermentering',  'en' => 'Fermentation',  'value' => 'Anaerobisk' ],
                [ 'da' => 'Hoejde',        'en' => 'Altitude',      'value' => '1.600-1.900 m' ],
                [ 'da' => 'Ristet',        'en' => 'Roasted',       'value_da' => 'Elektrisk i Koebenhavn', 'value_en' => 'Electric in Copenhagen' ],
            ],
            'tags_label' => [ 'da' => 'Risteprofiler', 'en' => 'Roast profiles' ],
            'tags' => [ 'Lys', 'Medium', 'Moerk' ],
        ];
    }

    /**
     * Guide links data.
     */
    public static function get_guides() {
        return [
            [
                'url'  => '/da/guide/komplet-guide-til-kaffekvaerning-2026/',
                'url_en' => '/en/guide/complete-coffee-grinding-guide-2026/',
                'title_da' => 'Kaffekvaerning',
                'title_en' => 'Coffee grinding',
                'desc_da'  => 'Komplet guide til kvaerning, burrs og teknik',
                'desc_en'  => 'Complete guide to grinding, burrs and technique',
                'icon'     => '<svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>',
            ],
            [
                'url'  => '/da/guide/espresso/',
                'url_en' => '/en/guide/espresso/',
                'title_da' => 'Espresso',
                'title_en' => 'Espresso',
                'desc_da'  => 'Fra grind til golden shot',
                'desc_en'  => 'From grind to golden shot',
                'icon'     => '<svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="4" y="6" width="12" height="10" rx="2"/><path d="M16 9h2a2 2 0 0 1 0 4h-2"/><line x1="6" y1="20" x2="14" y2="20"/></svg>',
            ],
            [
                'url'  => '/da/guide/pour-over/',
                'url_en' => '/en/guide/pour-over/',
                'title_da' => 'Pour Over',
                'title_en' => 'Pour Over',
                'desc_da'  => 'V60, Kalita og teknikker',
                'desc_en'  => 'V60, Kalita and techniques',
                'icon'     => '<svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M6 4h12l-4 14H10L6 4z"/><line x1="8" y1="4" x2="16" y2="4"/></svg>',
            ],
            [
                'url'  => '/da/guide/aeropress/',
                'url_en' => '/en/guide/aeropress/',
                'title_da' => 'Aeropress',
                'title_en' => 'AeroPress',
                'desc_da'  => 'Standard, inverteret og eksperimenter',
                'desc_en'  => 'Standard, inverted and experiments',
                'icon'     => '<svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="8" y="4" width="8" height="14" rx="1"/><line x1="10" y1="18" x2="14" y2="18"/><line x1="12" y1="18" x2="12" y2="21"/></svg>',
            ],
            [
                'url'  => '/da/guide/french-press/',
                'url_en' => '/en/guide/french-press/',
                'title_da' => 'French Press',
                'title_en' => 'French Press',
                'desc_da'  => 'Den klassiske immersionsmetode',
                'desc_en'  => 'The classic immersion method',
                'icon'     => '<svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="6" y="6" width="12" height="14" rx="2"/><line x1="12" y1="2" x2="12" y2="6"/><circle cx="12" cy="2" r="1"/></svg>',
            ],
            [
                'url'  => '/da/om-os/',
                'url_en' => '/en/about/',
                'title_da' => 'Vores historie',
                'title_en' => 'Our story',
                'desc_da'  => 'Kaffe ristet med hjaerte i Koebenhavn',
                'desc_en'  => 'Coffee roasted with heart in Copenhagen',
                'icon'     => '<svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 21C12 21 3 13.5 3 8a5 5 0 0 1 10 0 5 5 0 0 1 10 0c0 5.5-9 13-11 13z"/></svg>',
            ],
        ];
    }

    /**
     * UI strings for both languages.
     */
    public static function get_strings() {
        return [
            'da' => [
                'hero_badge'    => 'The Artisan',
                'hero_title'    => 'Din brygguide',
                'hero_subtitle' => 'Single-origin',
                'steps_title'   => 'Fremgangsmaade',
                'grind_label'   => 'Kvaerningsgrad',
                'grind_fine'    => 'Fin',
                'grind_medium'  => 'Medium',
                'grind_coarse'  => 'Grov',
                'pro_tip'       => 'Pro tip',
                'profile_title' => 'Om denne kaffe',
                'guides_title'  => 'Laer mere',
                'footer_text'   => 'Ristet til ordre i Koebenhavn',
                'footer_cta'    => 'Se alle kaffesorter',
                'timer_start'   => 'Start',
                'timer_pause'   => 'Pause',
                'timer_reset'   => 'Nulstil',
                'next_step'     => 'Naeste trin',
                'all_done'      => 'Faerdig!',
                'lang_toggle'   => 'EN',
            ],
            'en' => [
                'hero_badge'    => 'The Artisan',
                'hero_title'    => 'Your brew guide',
                'hero_subtitle' => 'Single-origin',
                'steps_title'   => 'Instructions',
                'grind_label'   => 'Grind size',
                'grind_fine'    => 'Fine',
                'grind_medium'  => 'Medium',
                'grind_coarse'  => 'Coarse',
                'pro_tip'       => 'Pro tip',
                'profile_title' => 'About this coffee',
                'guides_title'  => 'Learn more',
                'footer_text'   => 'Roasted to order in Copenhagen',
                'footer_cta'    => 'See all coffees',
                'timer_start'   => 'Start',
                'timer_pause'   => 'Pause',
                'timer_reset'   => 'Reset',
                'next_step'     => 'Next step',
                'all_done'      => 'Done!',
                'lang_toggle'   => 'DA',
            ],
        ];
    }
}

<?php
/**
 * Recipe App HTML template.
 *
 * Variables available (set by SARA_Recipe_Shortcode::render):
 *   $product_id, $product_name, $product_url, $origin, $roast_level,
 *   $roast_date, $highlights, $recipe (data array), $methods (name map)
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$first_method = array_key_first( $recipe );
?>
<div class="sa-recipe" id="sa-recipe" data-product-id="<?php echo esc_attr( $product_id ); ?>">

    <!-- Hero -->
    <div class="sa-recipe__hero">
        <?php if ( $roast_level ) : ?>
            <span class="sa-recipe__roast-badge"><?php echo esc_html( $roast_level ); ?></span>
        <?php endif; ?>
        <h1 class="sa-recipe__title"><?php echo esc_html( $product_name ); ?></h1>
        <?php if ( $origin ) : ?>
            <p class="sa-recipe__origin"><?php echo esc_html( $origin ); ?></p>
        <?php endif; ?>
        <button type="button" class="sa-recipe__lang-toggle" id="sa-recipe-lang" data-i18n="lang_toggle">EN</button>
    </div>

    <!-- Brew Method Selector -->
    <div class="sa-recipe__methods">
        <?php foreach ( $recipe as $key => $m ) : ?>
            <button type="button"
                    class="sa-recipe__method<?php echo $key === $first_method ? ' active' : ''; ?>"
                    data-method="<?php echo esc_attr( $key ); ?>">
                <span class="sa-recipe__method-icon"><?php echo self_get_method_icon( $key ); ?></span>
                <span class="sa-recipe__method-name" data-da="<?php echo esc_attr( $m['name_da'] ); ?>" data-en="<?php echo esc_attr( $m['name_en'] ); ?>"><?php echo esc_html( $m['name_da'] ); ?></span>
                <span class="sa-recipe__method-time"><?php echo esc_html( $m['time'] ); ?></span>
            </button>
        <?php endforeach; ?>
    </div>

    <!-- Recipe Card -->
    <div class="sa-recipe__card">

        <!-- Parameters -->
        <div class="sa-recipe__params-wrap">
            <?php foreach ( $recipe as $key => $m ) : ?>
                <div class="sa-recipe__params<?php echo $key === $first_method ? ' active' : ''; ?>" data-method="<?php echo esc_attr( $key ); ?>">
                    <div class="sa-recipe__param">
                        <span class="sa-recipe__param-value"><?php echo esc_html( $m['coffee_g'] ); ?>g</span>
                        <span class="sa-recipe__param-label" data-i18n="coffee">Kaffe</span>
                    </div>
                    <div class="sa-recipe__param">
                        <span class="sa-recipe__param-value"><?php echo esc_html( $m['water_ml'] ); ?>ml</span>
                        <span class="sa-recipe__param-label" data-i18n="water">Vand</span>
                    </div>
                    <div class="sa-recipe__param">
                        <span class="sa-recipe__param-value"><?php echo esc_html( $m['ratio'] ); ?></span>
                        <span class="sa-recipe__param-label" data-i18n="ratio">Ratio</span>
                    </div>
                    <div class="sa-recipe__param">
                        <span class="sa-recipe__param-value"><?php echo esc_html( $m['temp'] ); ?>&deg;C</span>
                        <span class="sa-recipe__param-label" data-i18n="temp">Temperatur</span>
                    </div>
                    <div class="sa-recipe__param">
                        <span class="sa-recipe__param-value"><?php echo esc_html( $m['time'] ); ?></span>
                        <span class="sa-recipe__param-label" data-i18n="time">Tid</span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Grind Size Visualizer -->
        <div class="sa-recipe__grind">
            <div class="sa-recipe__grind-label" data-i18n="grind_label">Formalingsgrad</div>
            <div class="sa-recipe__grind-track">
                <div class="sa-recipe__grind-marker" id="sa-grind-marker"
                     style="left: <?php echo esc_attr( $recipe[ $first_method ]['grind'] ); ?>%"></div>
            </div>
            <div class="sa-recipe__grind-labels">
                <span data-i18n="fine">Fin</span>
                <span data-i18n="coarse">Grov</span>
            </div>
            <div class="sa-recipe__grind-dots" id="sa-grind-dots"></div>
        </div>

        <!-- Brew Steps -->
        <div class="sa-recipe__steps-wrap">
            <?php foreach ( $recipe as $key => $m ) :
                $total_steps = count( $m['steps'] );
            ?>
                <div class="sa-recipe__steps<?php echo $key === $first_method ? ' active' : ''; ?>" data-method="<?php echo esc_attr( $key ); ?>">
                    <div class="sa-recipe__steps-header">
                        <span class="sa-recipe__steps-title" data-i18n="steps_title">Trin</span>
                        <span class="sa-recipe__steps-progress" data-total="<?php echo $total_steps; ?>">0/<?php echo $total_steps; ?></span>
                    </div>
                    <?php foreach ( $m['steps'] as $i => $step ) :
                        $has_timer = $step['time_seconds'] > 0;
                        $mins = floor( $step['time_seconds'] / 60 );
                        $secs = $step['time_seconds'] % 60;
                        $formatted = $mins > 0 ? $mins . ':' . str_pad( $secs, 2, '0', STR_PAD_LEFT ) : $secs . 's';
                    ?>
                        <div class="sa-recipe__step" data-step="<?php echo $i; ?>" data-time="<?php echo esc_attr( $step['time_seconds'] ); ?>">
                            <button type="button" class="sa-recipe__step-check" aria-label="Complete step"></button>
                            <div class="sa-recipe__step-body">
                                <strong data-da="<?php echo esc_attr( $step['title_da'] ); ?>" data-en="<?php echo esc_attr( $step['title_en'] ); ?>"><?php echo esc_html( $step['title_da'] ); ?></strong>
                                <p data-da="<?php echo esc_attr( $step['desc_da'] ); ?>" data-en="<?php echo esc_attr( $step['desc_en'] ); ?>"><?php echo esc_html( $step['desc_da'] ); ?></p>
                            </div>
                            <?php if ( $has_timer ) : ?>
                                <button type="button" class="sa-recipe__step-time" data-seconds="<?php echo esc_attr( $step['time_seconds'] ); ?>"><?php echo esc_html( $formatted ); ?></button>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Timer -->
        <div class="sa-recipe__timer" id="sa-recipe-timer">
            <div class="sa-recipe__timer-ring">
                <svg viewBox="0 0 120 120" width="120" height="120">
                    <circle cx="60" cy="60" r="54" fill="none"
                            stroke="var(--linesColor)" stroke-width="4"/>
                    <circle id="sa-timer-ring" cx="60" cy="60" r="54" fill="none"
                            stroke="var(--mainColor)" stroke-width="4"
                            stroke-dasharray="339.292" stroke-dashoffset="339.292"
                            stroke-linecap="round"
                            transform="rotate(-90 60 60)"/>
                </svg>
                <span class="sa-recipe__timer-display" id="sa-timer-display">0:00</span>
            </div>
            <div class="sa-recipe__timer-controls" id="sa-timer-controls">
                <button type="button" class="sa-recipe__timer-btn" id="sa-timer-start" data-i18n="start">Start</button>
                <button type="button" class="sa-recipe__timer-btn" id="sa-timer-reset" data-i18n="reset">Nulstil</button>
            </div>
        </div>

        <!-- Pro Tips (one per method) -->
        <?php foreach ( $recipe as $key => $m ) :
            if ( empty( $m['tip_da'] ) && empty( $m['tip_en'] ) ) continue;
        ?>
            <div class="sa-recipe__tip<?php echo $key === $first_method ? ' active' : ''; ?>" data-method="<?php echo esc_attr( $key ); ?>">
                <span class="sa-recipe__tip-icon">&#9749;</span>
                <div>
                    <strong data-i18n="pro_tip">Pro tip</strong>
                    <p data-da="<?php echo esc_attr( $m['tip_da'] ); ?>" data-en="<?php echo esc_attr( $m['tip_en'] ); ?>"><?php echo esc_html( $m['tip_da'] ); ?></p>
                </div>
            </div>
        <?php endforeach; ?>

    </div><!-- .sa-recipe__card -->

    <!-- Coffee Profile -->
    <h3 class="sa-recipe__section-title" data-i18n="profile_title">Kaffeprofil</h3>
    <div class="sa-recipe__profile">
        <div class="sa-recipe__profile-grid">
            <?php if ( $origin ) : ?>
                <div class="sa-recipe__profile-detail">
                    <span class="sa-recipe__profile-label" data-i18n="origin">Oprindelse</span>
                    <span class="sa-recipe__profile-value"><?php echo esc_html( $origin ); ?></span>
                </div>
            <?php endif; ?>
            <?php if ( $roast_date ) : ?>
                <div class="sa-recipe__profile-detail">
                    <span class="sa-recipe__profile-label" data-i18n="roast">Ristning</span>
                    <span class="sa-recipe__profile-value"><?php echo esc_html( $roast_date ); ?></span>
                </div>
            <?php endif; ?>
        </div>
        <?php if ( ! empty( $highlights ) ) : ?>
            <div class="sa-recipe__profile-notes">
                <span class="sa-recipe__profile-label" data-i18n="notes">Smagsnoter</span>
                <div class="sa-recipe__profile-tags">
                    <?php foreach ( $highlights as $hl ) : ?>
                        <span class="sa-recipe__tag"><?php echo esc_html( $hl ); ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Related Guides -->
    <h3 class="sa-recipe__section-title" data-i18n="guides_title">Laes mere</h3>
    <div class="sa-recipe__guides-grid">
        <a href="/da/guide/v60-brygning/" class="sa-recipe__guide-card">
            <span class="sa-recipe__guide-icon">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2L6 10h12L12 2z"/><rect x="8" y="10" width="8" height="10" rx="1"/></svg>
            </span>
            <div class="sa-recipe__guide-text">
                <strong data-da="V60 Guide" data-en="V60 Guide">V60 Guide</strong>
                <span data-da="Laer at brygge den perfekte V60" data-en="Learn to brew the perfect V60">Laer at brygge den perfekte V60</span>
            </div>
        </a>
        <a href="/da/guide/kaffeboenner/" class="sa-recipe__guide-card">
            <span class="sa-recipe__guide-icon">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="9"/><path d="M12 3c-2 4-2 8 0 12M7 6c3 2 7 2 10 0M7 18c3-2 7-2 10 0"/></svg>
            </span>
            <div class="sa-recipe__guide-text">
                <strong data-da="Om kaffeboenner" data-en="About coffee beans">Om kaffeboenner</strong>
                <span data-da="Forstaa din kaffe bedre" data-en="Understand your coffee better">Forstaa din kaffe bedre</span>
            </div>
        </a>
    </div>

    <!-- Footer CTA -->
    <div class="sa-recipe__footer">
        <p data-i18n="buy_cta">Kob denne kaffe</p>
        <div class="pe--button pb--background pb--normal">
            <div class="pe--button--wrapper">
                <a href="<?php echo esc_url( $product_url ); ?>">
                    <span class="pb__main"><?php echo esc_html( $product_name ); ?><span class="pb__hover"><?php echo esc_html( $product_name ); ?></span></span>
                </a>
            </div>
        </div>
    </div>

</div>
<?php

/**
 * Inline SVG icons for each brew method.
 */
function self_get_method_icon( $method ) {
    $icons = [
        'v60' => '<svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 6h14"/><path d="M7 6l2 14h6l2-14"/><path d="M10 2v4"/><circle cx="12" cy="3" r="1" fill="currentColor" stroke="none"/></svg>',

        'chemex' => '<svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2h8"/><path d="M9 2l3 9.5L9 22"/><path d="M15 2l-3 9.5L15 22"/><path d="M9 22h6"/><rect x="10" y="10" width="4" height="3" rx=".5" fill="currentColor" stroke="none" opacity=".3"/></svg>',

        'aeropress' => '<svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="8" y="6" width="8" height="14" rx="1"/><path d="M10 6V3h4v3"/><path d="M8 17h8"/><path d="M10 20h4v2h-4z"/></svg>',

        'french_press' => '<svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="6" y="4" width="12" height="16" rx="2"/><path d="M12 1v3"/><path d="M6 8h12"/><path d="M12 4v16"/><path d="M4 20h16"/></svg>',
    ];
    return $icons[ $method ] ?? '';
}

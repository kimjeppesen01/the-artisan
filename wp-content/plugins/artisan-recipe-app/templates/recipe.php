<?php
/**
 * Recipe App v2.0 template.
 *
 * Variables from SARA_Recipe_Shortcode::render():
 *   $methods, $profile, $guides, $strings, $first_method, $lang
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$s = $strings[ $lang ];
?>
<div class="sa-recipe" id="sa-recipe">

    <!-- ========== HERO ========== -->
    <div class="sa-recipe__hero">
        <div class="sa-recipe__hero-inner">
            <span class="sa-recipe__roast-badge" data-i18n="hero_badge"><?php echo esc_html( $s['hero_badge'] ); ?></span>
            <h1 class="sa-recipe__title" data-i18n="hero_title"><?php echo esc_html( $s['hero_title'] ); ?></h1>
            <p class="sa-recipe__origin" data-i18n="hero_subtitle"><?php echo esc_html( $s['hero_subtitle'] ); ?></p>
            <button type="button" class="sa-recipe__lang-toggle" id="sa-recipe-lang" data-i18n="lang_toggle"><?php echo esc_html( $s['lang_toggle'] ); ?></button>
        </div>
    </div>

    <!-- ========== BREW METHOD SELECTOR ========== -->
    <div class="sa-recipe__methods" role="tablist">
        <?php foreach ( $methods as $key => $m ) : ?>
            <button type="button"
                    class="sa-recipe__method<?php echo $key === $first_method ? ' active' : ''; ?>"
                    role="tab"
                    aria-selected="<?php echo $key === $first_method ? 'true' : 'false'; ?>"
                    data-method="<?php echo esc_attr( $key ); ?>">
                <span class="sa-recipe__method-icon"><?php echo $m['icon']; ?></span>
                <span class="sa-recipe__method-name"><?php echo esc_html( $m['name'] ); ?></span>
                <span class="sa-recipe__method-time"><?php echo esc_html( $m['time'] ); ?></span>
            </button>
        <?php endforeach; ?>
    </div>

    <!-- ========== RECIPE CARD ========== -->
    <div class="sa-recipe__card">

        <!-- Parameters -->
        <div class="sa-recipe__params-wrap">
            <?php foreach ( $methods as $key => $m ) : ?>
                <div class="sa-recipe__params<?php echo $key === $first_method ? ' active' : ''; ?>" data-method="<?php echo esc_attr( $key ); ?>">
                    <?php foreach ( $m['params'] as $p ) : ?>
                        <div class="sa-recipe__param">
                            <span class="sa-recipe__param-value"><?php echo esc_html( $p['value'] ); ?></span>
                            <span class="sa-recipe__param-label" data-da="<?php echo esc_attr( $p['da'] ); ?>" data-en="<?php echo esc_attr( $p['en'] ); ?>"><?php echo esc_html( $p[ $lang ] ); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Grind Size Visualizer -->
        <div class="sa-recipe__grind">
            <div class="sa-recipe__grind-label" data-i18n="grind_label"><?php echo esc_html( $s['grind_label'] ); ?></div>
            <div class="sa-recipe__grind-scale">
                <div class="sa-recipe__grind-track">
                    <div class="sa-recipe__grind-marker" id="sa-grind-marker"
                         style="left: <?php echo esc_attr( $methods[ $first_method ]['grind'] ); ?>%"></div>
                </div>
                <div class="sa-recipe__grind-labels">
                    <span data-i18n="grind_fine"><?php echo esc_html( $s['grind_fine'] ); ?></span>
                    <span data-i18n="grind_medium"><?php echo esc_html( $s['grind_medium'] ); ?></span>
                    <span data-i18n="grind_coarse"><?php echo esc_html( $s['grind_coarse'] ); ?></span>
                </div>
            </div>
            <div class="sa-recipe__grind-dots" id="sa-grind-dots"></div>
        </div>

        <!-- Brew Steps -->
        <div class="sa-recipe__steps-wrap">
            <?php foreach ( $methods as $key => $m ) :
                $step_count = count( $m['steps'] );
            ?>
                <div class="sa-recipe__steps<?php echo $key === $first_method ? ' active' : ''; ?>" data-method="<?php echo esc_attr( $key ); ?>">
                    <div class="sa-recipe__steps-header">
                        <span class="sa-recipe__steps-title" data-i18n="steps_title"><?php echo esc_html( $s['steps_title'] ); ?></span>
                        <span class="sa-recipe__steps-progress" data-total="<?php echo $step_count; ?>">0 / <?php echo $step_count; ?></span>
                    </div>
                    <?php foreach ( $m['steps'] as $i => $step ) : ?>
                        <div class="sa-recipe__step" data-step="<?php echo $i; ?>" data-time="<?php echo esc_attr( $step['time'] ); ?>">
                            <button type="button" class="sa-recipe__step-check" aria-label="<?php echo esc_attr( $lang === 'en' ? 'Mark step ' . ( $i + 1 ) . ' as done' : 'Marker trin ' . ( $i + 1 ) . ' som faerdig' ); ?>"></button>
                            <div class="sa-recipe__step-body">
                                <strong data-da="<?php echo esc_attr( $step['title_da'] ); ?>" data-en="<?php echo esc_attr( $step['title_en'] ); ?>"><?php echo esc_html( $step[ 'title_' . $lang ] ); ?></strong>
                                <p data-da="<?php echo esc_attr( $step['desc_da'] ); ?>" data-en="<?php echo esc_attr( $step['desc_en'] ); ?>"><?php echo esc_html( $step[ 'desc_' . $lang ] ); ?></p>
                            </div>
                            <?php if ( $step['time'] > 0 ) :
                                $label = isset( $step['time_label'] ) ? $step['time_label'] : gmdate( 'i:s', $step['time'] );
                            ?>
                                <button type="button" class="sa-recipe__step-time" data-seconds="<?php echo esc_attr( $step['time'] ); ?>"><?php echo esc_html( $label ); ?></button>
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
                            stroke-dasharray="339.29" stroke-dashoffset="339.29"
                            stroke-linecap="round"
                            transform="rotate(-90 60 60)"/>
                </svg>
                <div class="sa-recipe__timer-display" id="sa-timer-display">00:00</div>
            </div>
            <div class="sa-recipe__timer-controls" id="sa-timer-controls">
                <div class="pe--button pb--background pb--small sa-recipe__timer-btn-wrap" id="sa-timer-start-wrap">
                    <div class="pe--button--wrapper">
                        <a href="#" id="sa-timer-start" onclick="return false;">
                            <span class="pb__main" data-i18n="timer_start"><?php echo esc_html( $s['timer_start'] ); ?><span class="pb__hover" data-i18n="timer_start"><?php echo esc_html( $s['timer_start'] ); ?></span></span>
                        </a>
                    </div>
                </div>
                <div class="pe--button pb--bordered pb--small sa-recipe__timer-btn-wrap">
                    <div class="pe--button--wrapper">
                        <a href="#" id="sa-timer-reset" onclick="return false;">
                            <span class="pb__main" data-i18n="timer_reset"><?php echo esc_html( $s['timer_reset'] ); ?><span class="pb__hover" data-i18n="timer_reset"><?php echo esc_html( $s['timer_reset'] ); ?></span></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pro Tips -->
        <?php foreach ( $methods as $key => $m ) : ?>
            <div class="sa-recipe__tip<?php echo $key === $first_method ? ' active' : ''; ?>" data-method="<?php echo esc_attr( $key ); ?>">
                <div class="sa-recipe__tip-icon">&#9889;</div>
                <div>
                    <strong data-i18n="pro_tip"><?php echo esc_html( $s['pro_tip'] ); ?></strong>
                    <p data-da="<?php echo esc_attr( $m['tip_da'] ); ?>" data-en="<?php echo esc_attr( $m['tip_en'] ); ?>"><?php echo esc_html( $m[ 'tip_' . $lang ] ); ?></p>
                </div>
            </div>
        <?php endforeach; ?>

    </div><!-- /.sa-recipe__card -->

    <!-- ========== COFFEE PROFILE ========== -->
    <div class="sa-recipe__profile">
        <h2 class="sa-recipe__section-title" data-i18n="profile_title"><?php echo esc_html( $s['profile_title'] ); ?></h2>
        <div class="sa-recipe__profile-grid">
            <?php foreach ( $profile['details'] as $d ) : ?>
                <div class="sa-recipe__profile-detail">
                    <span class="sa-recipe__profile-label" data-da="<?php echo esc_attr( $d['da'] ); ?>" data-en="<?php echo esc_attr( $d['en'] ); ?>"><?php echo esc_html( $d[ $lang ] ); ?></span>
                    <?php
                    $val = $d['value'] ?? '';
                    $val_da = $d['value_da'] ?? $val;
                    $val_en = $d['value_en'] ?? $val;
                    $display = $lang === 'en' ? $val_en : $val_da;
                    ?>
                    <span class="sa-recipe__profile-value"
                          <?php if ( $val_da !== $val_en ) : ?>data-da="<?php echo esc_attr( $val_da ); ?>" data-en="<?php echo esc_attr( $val_en ); ?>"<?php endif; ?>
                    ><?php echo esc_html( $display ); ?></span>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="sa-recipe__profile-notes">
            <span class="sa-recipe__profile-label" data-da="<?php echo esc_attr( $profile['tags_label']['da'] ); ?>" data-en="<?php echo esc_attr( $profile['tags_label']['en'] ); ?>"><?php echo esc_html( $profile['tags_label'][ $lang ] ); ?></span>
            <div class="sa-recipe__profile-tags">
                <?php foreach ( $profile['tags'] as $tag ) : ?>
                    <span class="sa-recipe__tag"><?php echo esc_html( $tag ); ?></span>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- ========== GUIDES ========== -->
    <div class="sa-recipe__guides">
        <h2 class="sa-recipe__section-title" data-i18n="guides_title"><?php echo esc_html( $s['guides_title'] ); ?></h2>
        <div class="sa-recipe__guides-grid">
            <?php foreach ( $guides as $g ) : ?>
                <a href="<?php echo esc_url( $lang === 'en' ? $g['url_en'] : $g['url'] ); ?>"
                   class="sa-recipe__guide-card"
                   data-url-da="<?php echo esc_attr( $g['url'] ); ?>"
                   data-url-en="<?php echo esc_attr( $g['url_en'] ); ?>">
                    <div class="sa-recipe__guide-icon"><?php echo $g['icon']; ?></div>
                    <div class="sa-recipe__guide-text">
                        <strong data-da="<?php echo esc_attr( $g['title_da'] ); ?>" data-en="<?php echo esc_attr( $g['title_en'] ); ?>"><?php echo esc_html( $g[ 'title_' . $lang ] ); ?></strong>
                        <span data-da="<?php echo esc_attr( $g['desc_da'] ); ?>" data-en="<?php echo esc_attr( $g['desc_en'] ); ?>"><?php echo esc_html( $g[ 'desc_' . $lang ] ); ?></span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- ========== FOOTER CTA ========== -->
    <div class="sa-recipe__footer">
        <p data-i18n="footer_text"><?php echo esc_html( $s['footer_text'] ); ?></p>
        <div class="pe--button pb--bordered pb--small">
            <div class="pe--button--wrapper">
                <a href="https://theartisan.dk/butik/">
                    <span class="pb__main" data-i18n="footer_cta"><?php echo esc_html( $s['footer_cta'] ); ?><span class="pb__hover" data-i18n="footer_cta"><?php echo esc_html( $s['footer_cta'] ); ?></span></span>
                </a>
            </div>
        </div>
    </div>

</div>

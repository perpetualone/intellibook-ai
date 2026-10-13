<?php
/**
 * Plugin Name: Intellibook AI — WhatsApp Booking & AI Receptionist
 * Plugin URI: https://www.intellibookai.com
 * Description: Connect your WordPress salon, clinic, spa or fitness website to Intellibook AI. Add a floating "Book on WhatsApp" button and embed your online booking page with a shortcode.
 * Version: 1.0.0
 * Author: Intellibook AI
 * Author URI: https://www.intellibookai.com
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: intellibook-ai
 * Requires at least: 5.6
 * Requires PHP: 7.4
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class IntellibookAI_Plugin {
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'settings_init'));
        add_action('wp_footer', array($this, 'render_widget'));
        add_shortcode('intellibook_booking', array($this, 'render_shortcode'));
    }

    public function add_admin_menu() {
        add_options_page(
            'Intellibook AI Settings',
            'Intellibook AI',
            'manage_options',
            'intellibook-ai',
            array($this, 'options_page')
        );
    }

    public function settings_init() {
        register_setting('intellibook_settings_group', 'intellibook_business_slug', array(
            'type'              => 'string',
            'sanitize_callback' => array($this, 'sanitize_slug'),
            'default'           => '',
        ));
        register_setting('intellibook_settings_group', 'intellibook_enable_floating_button', array(
            'type'              => 'string',
            'sanitize_callback' => array($this, 'sanitize_checkbox'),
            'default'           => '1',
        ));
        register_setting('intellibook_settings_group', 'intellibook_show_credit', array(
            'type'              => 'string',
            'sanitize_callback' => array($this, 'sanitize_checkbox'),
            'default'           => '0',
        ));

        add_settings_section(
            'intellibook_settings_section',
            __('Connect Your Intellibook AI Business', 'intellibook-ai'),
            null,
            'intellibook-ai'
        );

        add_settings_field(
            'intellibook_business_slug',
            __('Business ID or Slug', 'intellibook-ai'),
            array($this, 'slug_field_render'),
            'intellibook-ai',
            'intellibook_settings_section'
        );

        add_settings_field(
            'intellibook_enable_floating_button',
            __('Enable Floating WhatsApp Booking Button', 'intellibook-ai'),
            array($this, 'floating_field_render'),
            'intellibook-ai',
            'intellibook_settings_section'
        );

        add_settings_field(
            'intellibook_show_credit',
            __('Show "Powered by Intellibook AI" link', 'intellibook-ai'),
            array($this, 'credit_field_render'),
            'intellibook-ai',
            'intellibook_settings_section'
        );
    }

    /**
     * Booking links look like "14" or "14-glow-salon": the business ID, optionally
     * followed by a name slug. Anything else would 404, so reject it on save.
     */
    public function sanitize_slug($value) {
        $value = strtolower(trim(sanitize_text_field($value)));
        if ($value !== '' && !preg_match('/^\d+(-[a-z0-9]+)*$/', $value)) {
            add_settings_error(
                'intellibook_business_slug',
                'intellibook_invalid_slug',
                __('Enter your business ID or booking-link name, for example 14 or 14-glow-salon.', 'intellibook-ai')
            );
            return get_option('intellibook_business_slug', '');
        }
        return $value;
    }

    public function sanitize_checkbox($value) {
        return $value ? '1' : '0';
    }

    public function slug_field_render() {
        $slug = get_option('intellibook_business_slug', '');
        echo '<input type="text" name="intellibook_business_slug" value="' . esc_attr($slug) . '" class="regular-text" placeholder="e.g. 14-glow-salon" />';
        echo '<p class="description">' . esc_html__('Your business ID, or the part of your booking link after /b/ (for example 14 or 14-glow-salon).', 'intellibook-ai') . ' ';
        echo '<a href="https://www.intellibookai.com/dashboard" target="_blank" rel="noopener">' . esc_html__('Open your Intellibook AI dashboard', 'intellibook-ai') . '</a>.</p>';
    }

    public function floating_field_render() {
        $enabled = get_option('intellibook_enable_floating_button', '1');
        echo '<label><input type="checkbox" name="intellibook_enable_floating_button" value="1" ' . checked('1', $enabled, false) . ' /> ' . esc_html__('Show floating WhatsApp appointment button on all pages', 'intellibook-ai') . '</label>';
    }

    public function credit_field_render() {
        $enabled = get_option('intellibook_show_credit', '0');
        echo '<label><input type="checkbox" name="intellibook_show_credit" value="1" ' . checked('1', $enabled, false) . ' /> ' . esc_html__('Show a small "Powered by Intellibook AI" link under the booking button (optional)', 'intellibook-ai') . '</label>';
    }

    public function options_page() {
        ?>
        <div class="wrap">
            <h2>Intellibook AI — WhatsApp AI Receptionist Setup</h2>
            <p>Empower your website with autonomous WhatsApp appointment booking, automated reminders, and instant inquiry resolution.</p>
            <p>Need an account? <a href="https://www.intellibookai.com" target="_blank" rel="noopener" class="button button-secondary">Get started free on Intellibook AI</a></p>
            <form action="options.php" method="post">
                <?php
                settings_fields('intellibook_settings_group');
                do_settings_sections('intellibook-ai');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function render_widget() {
        $slug = get_option('intellibook_business_slug', '');
        $floating = get_option('intellibook_enable_floating_button', '1');

        if (!$slug || !$floating) return;

        $target_url = 'https://www.intellibookai.com/b/' . rawurlencode($slug);
        ?>
        <div id="intellibook-floating-widget" style="position:fixed;bottom:24px;right:24px;z-index:999999;font-family:system-ui,-apple-system,sans-serif;">
            <a href="<?php echo esc_url($target_url); ?>" target="_blank" rel="noopener noreferrer" style="display:flex;align-items:center;gap:10px;background:#25D366;color:#ffffff;text-decoration:none;padding:12px 20px;border-radius:30px;font-weight:600;font-size:14px;box-shadow:0 4px 14px rgba(0,0,0,0.25);transition:all 0.2s ease;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/>
                </svg>
                <span>Book on WhatsApp</span>
            </a>
        </div>
        <?php
    }

    public function render_shortcode($atts) {
        $slug = get_option('intellibook_business_slug', '');
        if (!$slug) {
            if (current_user_can('manage_options')) {
                return '<p><em>' . esc_html__('Please set your Intellibook AI business ID in Settings > Intellibook AI.', 'intellibook-ai') . '</em></p>';
            }
            return '';
        }

        // /book/<id>-<name> is the embeddable booking page (the rest of the site refuses framing).
        $booking_url = 'https://www.intellibookai.com/book/' . rawurlencode($slug);
        $html  = '<div class="intellibook-embedded-booking" style="width:100%;max-width:650px;margin:20px auto;">';
        $html .= '<iframe src="' . esc_url($booking_url) . '" width="100%" height="700" style="border:0;border-radius:12px;box-shadow:0 2px 10px rgba(0,0,0,0.1);" title="' . esc_attr__('Book an appointment online', 'intellibook-ai') . '" loading="lazy"></iframe>';
        $html .= '<p style="text-align:center;font-size:13px;margin-top:8px;"><a href="' . esc_url($booking_url) . '" target="_blank" rel="noopener">' . esc_html__('Open the booking page in a new tab', 'intellibook-ai') . '</a></p>';
        if (get_option('intellibook_show_credit', '0') === '1') {
            $html .= '<p style="font-size:12px;color:#888;margin-top:8px;">' . esc_html__('Powered by', 'intellibook-ai') . ' <a href="https://www.intellibookai.com" target="_blank" rel="noopener">Intellibook AI</a></p>';
        }
        $html .= '</div>';
        return $html;
    }
}

new IntellibookAI_Plugin();

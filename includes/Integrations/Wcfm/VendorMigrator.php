<?php

namespace Wedevs\DokanMigrator\Integrations\Wcfm;

use Wedevs\DokanMigrator\Abstracts\VendorMigration;

/**
 * Formats vendor data for migration to Dokan.
 *
 * @since 1.0.0
 */
class VendorMigrator extends VendorMigration {

    /**
     * WCFM vendor profile settings key.
     *
     * @var string
     */
    private $vendor_profile = 'wcfmmp_profile_settings';

    /**
     * Returns store name
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function get_store_name() {
        $store_name = $this->get_val( 'store_name' );
        empty( $store_name ) ? $store_name = $this->vendor->display_name : '';
        return $store_name;
    }

    /**
     * Returns store description
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function get_store_biography() {
        return $this->get_val( 'description' );
    }

    /**
     * Returns is vendor has selling capability.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function get_enable_selling() {
        $caps    = $this->get_val( 'wp_capabilities' );
        $caps    = unserialize( $caps );
        $enabled = isset( $caps['disable_vendor'] ) ? 'no' : 'yes';
        return $enabled;
    }

    /**
     * Returns geo location address
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function get_geo_address() {
        return $this->get_val( '_wcfm_store_location' );
    }

    /**
     * Returns vendor location latitude.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function get_geo_lat() {
        return $this->get_val( '_wcfm_store_lat' );
    }

    /**
     * Returns vendor location longitude.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function get_geo_long() {
        return $this->get_val( '_wcfm_store_lng' );
    }

    /**
     * Returns vendor social data.
     *
     * @since 1.0.0
     *
     * @return array
     */
    public function get_social($default) {
        return $this->get_profile_settings_val( 'social', [] );
    }

    /**
     * Returns vendor payment data.
     *
     * @since 1.0.0
     *
     * @return array
     */
    public function get_payment($default) {
        return $this->get_profile_settings_val( 'payment', [
            'paypal' => [ 'email' ],
            'bank'   => [],
        ] );
    }

    /**
     * Returns vendor phone number.
     *
     * @since 1.0.0
     *
     * @param string $default
     *
     * @return string
     */
    public function get_phone($default) {
        $this->get_profile_settings_val( 'phone' );
    }

    /**
     * Returns if email show in store or not.
     *
     * @since 1.0.0
     *
     * @param string $default
     *
     * @return string
     */
    public function get_is_show_email($default) {
        return $this->get_profile_settings_val( 'show_email', 'no' );
    }

    /**
     * Returns  vendor address.
     *
     * @since 1.0.0
     *
     * @param string $default
     *
     * @return string
     */
    public function get_address($default) {
        return $this->get_profile_settings_val( 'address', [] );
    }

    /**
     * Returns vendor location.
     *
     * @since 1.0.0
     *
     * @param string $default
     *
     * @return string
     */
    public function get_location($default) {
        return $this->get_profile_settings_val( 'store_location', [] );
    }

    /**
     * Returns banner id.
     *
     * @since 1.0.0
     *
     * @param int $default
     *
     * @return int
     */
    public function get_banner($default) {
        return $this->get_profile_settings_val( 'banner' );
    }


    /**
     * Returns applied commission in an vendor.
     *
     * @since 1.0.0
     *
     * @param string $default
     *
     * @return int
     */
    public function get_icon($default) {
        return $this->get_profile_settings_val( 'icon' );
    }

    /**
     * Returns vendor gravatar.
     *
     * @since 1.0.0
     *
     * @param string $default
     *
     * @return int
     */
    public function get_gravatar($default) {
        return $this->get_profile_settings_val( 'gravatar' );
    }

    /**
     * Returns if show more p tab.
     *
     * @since 1.0.0
     *
     * @param mixed $default
     *
     * @return string
     */
    public function get_show_more_ptab($default) {
        return $this->get_profile_settings_val( 'show_more_ptab', 'yes' );
    }

    /**
     * Returns applied commission in an vendor.
     *
     * @since 1.0.0
     *
     * @param int $default
     *
     * @return int
     */
    public function get_sore_ppp($default) {
        return $this->get_profile_settings_val( 'store_ppp', 10 );
    }

    /**
     * Returns applied commission in an vendor.
     *
     * @since 1.0.0
     *
     * @param string $default
     *
     * @return string
     */
    public function get_is_enabled_tnc($default) {
        return $this->get_profile_settings_val( 'store_hide_policy', 'off' );
    }

    /**
     * Returns terms and comdition.
     *
     * @since 1.0.0
     *
     * @param string $default
     *
     * @return string
     */
    public function get_store_tnc($default) {
        return wp_strip_all_tags( $this->get_profile_settings_val( 'wcfm_shipping_policy' ) );
    }

    /**
     * Returns if min discount.
     *
     * @since 1.0.0
     *
     * @param string $default
     *
     * @return string
     */
    public function get_show_min_order_discount($default) {
        return $this->get_profile_settings_val( 'show_min_order_discount', 'no' );
    }

    /**
     * Returns store seo.
     *
     * @since 1.0.0
     *
     * @param array $default
     *
     * @return array
     */
    public function get_store_seo($default) {
        return $this->formate_dokan_store_seo_data( $this->get_profile_settings_val( 'store_seo', [] ) );
    }

    public function get_commission() {
        $accepted_commission_types = array( 'percent', 'fixed' );
        $dokan_commission = [
            'dokan_admin_percentage' => '', // WCFM fixed value, commission_fixed
            'dokan_admin_percentage_type' => '', // WCFM commission type, commission_mode
            'dokan_admin_additional_fee' => '', // WCFM percentage value, commission_percent
        ];
        $commission = $this->get_profile_settings_val( 'commission', [] );
        $commission_type = isset( $commission['commission_mode'] ) ? $commission['commission_mode'] : 'global';

        if ( in_array( $commission_type, $accepted_commission_types ) ) {
            $dokan_commission['dokan_admin_percentage']      = isset( $commission['commission_fixed'] ) ? $commission['commission_fixed']    : '';
            $dokan_commission['dokan_admin_additional_fee']  = isset( $commission['commission_percent'] ) ? $commission['commission_percent']: '';
            $dokan_commission['dokan_admin_percentage_type'] = $commission_type;
        }

        return $dokan_commission;
    }

    public function get_val( $key, $default = '' ) {
        return isset( $this->meta_data[ $key ] ) ? reset( $this->meta_data[ $key ] ) : $default;
    }

    public function get_profile_settings_val( $key, $default = '' ){
        $wcfm_profile_settings = $this->get_val( 'wcfmmp_profile_settings', [] );
        $wcfm_profile_settings = maybe_unserialize( $wcfm_profile_settings );
        return isset( $wcfm_profile_settings[ $key ] ) ? $wcfm_profile_settings[ $key ] : $default;
    }

    public function formate_dokan_store_seo_data ( $store_seo ) {
        $dokan_store_soe = [
            'dokan-seo-meta-title'    => isset( $store_seo['wcfmmp-seo-meta-title'] ) ? $store_seo['wcfmmp-seo-meta-title'] : '',
            'dokan-seo-meta-desc'     => isset( $store_seo['wcfmmp-seo-meta-desc'] ) ? $store_seo['wcfmmp-seo-meta-desc'] : '',
            'dokan-seo-meta-keywords' => isset( $store_seo['wcfmmp-seo-meta-keywords'] ) ? $store_seo['wcfmmp-seo-meta-keywords'] : '',
            'dokan-seo-og-title'      => isset( $store_seo['wcfmmp-seo-og-title'] ) ? $store_seo['wcfmmp-seo-og-title'] : '',
            'dokan-seo-og-desc'       => isset( $store_seo['wcfmmp-seo-og-desc'] ) ? $store_seo['wcfmmp-seo-og-desc'] : '',
            'dokan-seo-og-image'      => isset( $store_seo['wcfmmp-seo-og-image'] ) ? $store_seo['wcfmmp-seo-og-image'] : '',
            'dokan-seo-twitter-title' => isset( $store_seo['wcfmmp-seo-twitter-title'] ) ? $store_seo['wcfmmp-seo-twitter-title'] : '',
            'dokan-seo-twitter-desc'  => isset( $store_seo['wcfmmp-seo-twitter-desc'] ) ? $store_seo['wcfmmp-seo-twitter-desc'] : '',
            'dokan-seo-twitter-image' => isset( $store_seo['wcfmmp-seo-twitter-image'] ) ? $store_seo['wcfmmp-seo-twitter-image'] : '',
        ];

        return $dokan_store_soe;
    }

    public function get_from_wcfm_profile( $key ) {
        $profile = $this->get_val( $this->vendor_profile );
        $profile = maybe_serialize( $profile );

        return isset( $profile[ $key ] ) ? reset( $profile[ $key ] ) : '';
    }
}
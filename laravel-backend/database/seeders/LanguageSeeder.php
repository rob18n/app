<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = [
            'af_ZA', 'am_ET', 'ar_AE', 'ar_BH', 'ar_DZ', 'ar_EG', 'ar_IQ', 'ar_JO', 'ar_KW', 'ar_LB',
            'ar_LY', 'ar_MA', 'ar_OM', 'ar_QA', 'ar_SA', 'ar_SD', 'ar_SY', 'ar_TN', 'ar_YE', 'az_AZ',
            'be_BY', 'bg_BG', 'bn_BD', 'bs_BA', 'ca_ES', 'cs_CZ', 'cy_GB', 'da_DK', 'de_AT', 'de_BE',
            'de_CH', 'de_DE', 'de_LI', 'de_LU', 'dv_MV', 'dz_BT', 'el_CY', 'el_GR', 'en_AU', 'en_BZ',
            'en_CA', 'en_CB', 'en_GB', 'en_IE', 'en_IN', 'en_JM', 'en_MY', 'en_NZ', 'en_PH', 'en_SG',
            'en_TT', 'en_US', 'en_ZA', 'en_ZW', 'es_AR', 'es_BO', 'es_CL', 'es_CO', 'es_CR', 'es_DO',
            'es_EC', 'es_ES', 'es_GT', 'es_HN', 'es_MX', 'es_NI', 'es_PA', 'es_PE', 'es_PR', 'es_PY',
            'es_SV', 'es_US', 'es_UY', 'es_VE', 'et_EE', 'eu_ES', 'fa_IR', 'fi_FI', 'fo_FO', 'fr_BE',
            'fr_CA', 'fr_CH', 'fr_FR', 'fr_LU', 'fr_MC', 'gl_ES', 'gu_IN', 'he_IL', 'hi_IN', 'hr_HR',
            'hu_HU', 'hy_AM', 'id_ID', 'is_IS', 'it_CH', 'it_IT', 'ja_JP', 'ka_GE', 'kk_KZ', 'km_KH',
            'kn_IN', 'ko_KR', 'ky_KG', 'lt_LT', 'lv_LV', 'mk_MK', 'ml_IN', 'mn_MN', 'mr_IN', 'ms_BN',
            'ms_MY', 'mt_MT', 'nb_NO', 'nl_BE', 'nl_NL', 'nn_NO', 'pa_IN', 'pl_PL', 'pt_BR', 'pt_PT',
            'ro_RO', 'ru_RU', 'sa_IN', 'sk_SK', 'sl_SI', 'sq_AL', 'sr_BA', 'sr_ME', 'sr_RS', 'sv_FI',
            'sv_SE', 'sw_KE', 'ta_IN', 'te_IN', 'th_TH', 'tl_PH', 'tn_ZA', 'tr_TR', 'tt_RU', 'uk_UA',
            'ur_PK', 'uz_UZ', 'vi_VN', 'xh_ZA', 'zh_CN', 'zh_HK', 'zh_MO', 'zh_SG', 'zh_TW', 'zu_ZA'
        ];

        foreach ($languages as $language) {
            DB::table('languages')->insert([
                'shortkey' => $language,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

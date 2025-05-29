<?php
namespace Modules\App\Handlers;

use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\DB;
use Modules\App\Services\Wallet\KreditService;
use Modules\ChannelManager\Handlers\ChannelManagerAppHandler;
// use Modules\Dashboards\Handlers\DashboardsAppHandler;
use Modules\Inventory\Entities\UoM\UnitOfMeasureCategory;
use Modules\Inventory\Entities\UoM\UnitOfMeasure;
use Modules\Properties\Handlers\PropertiesAppHandler;
use Modules\FrontDesk\Handlers\FrontDeskAppHandler;
use Modules\RevenueManager\Handlers\FiscalLocalizationHandler;
use Modules\RevenueManager\Handlers\RevenueManagerAppHandler;
use Modules\Settings\Handlers\SettingsAppHandler;
use Modules\Settings\Models\Currency\Currency;
use Modules\Settings\Models\Language\Language;
use Illuminate\Support\Facades\Http;
use Modules\Settings\Models\Localization\Country;

class AppManagerHandler extends AppHandler
{
    protected function getModuleSlug()
    {
        return 'apps';
    }

    protected function handleInstallation($company)
    {
        // 
    }

    protected function handleUninstallation()
    {
        // Example: Drop blog-related tables and clean up configurations
    }


    /**
     * Install multiple modules at once, handling transactions and logging.
     *
     * @param array $modules An array of module handlers to install.
     * @param mixed $company The company context under which modules are being installed.
     * @param mixed $user The user performing the installation.
     */
    public function installModules($company, $user)
    {
        $modules = [
            new AppManagerHandler(),
            new SettingsAppHandler(),
            new PropertiesAppHandler(),
            new ChannelManagerAppHandler(),
            new RevenueManagerAppHandler(),
            new FiscalLocalizationHandler(),
            // Add other module handlers as needed
        ];

        // Start transaction to ensure all modules are installed successfully or none at all.
        try {
            foreach ($modules as $module) {
                // Validate prerequisites before installation.
                $module->validatePrerequisites();

                // Execute module-specific installation logic.
                $module->handleInstallation($company);

                // Load any necessary configuration after installation.
                $module->loadConfiguration();

                // Record the installation in the database.
                $module->recordInstallation($company, $user);
            }
            // Commit the transaction if all installations are successful.
            Log::info("Successfully installed modules: " . implode(', ', array_map(function ($m) { return get_class($m); }, $modules)));
        } catch (Exception $e) {
            // Roll back the transaction if any installation fails.
            Log::error("Error installing modules: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Create honorifics titles.
     *
     */
    public function configure(){
        $this->createCountries();
        $this->installCurrencies();
        $this->installLanguages();
    }


    /**
     * Create honorifics titles.
     *
     * @param int $companyId
     */
    private function createCountries(){
        
        $countries =  [
            [
                'name' => 'Afghanistan',
                'code' => 'AF',
                'currency_code' => 'AFN',
            ],
            [
                'name' => 'Åland Islands',
                'code' => 'AX',
                'currency_code' => 'EUR',
            ],
            [
                'name' => 'Albania',
                'code' => 'AL',
                'currency_code' => 'ALL',
            ],
            [
                'name' => 'Algeria',
                'code' => 'DZ',
                'currency_code' => 'DZD',
            ],
            [
                'name' => 'American Samoa',
                'code' => 'AS',
                'currency_code' => 'USD',
            ],
            [
                'name' => 'Andorra',
                'code' => 'AD',
                'currency_code' => 'EUR',
            ],
            [
                'name' => 'Angola',
                'code' => 'AO',
                'currency_code' => 'AOA',
            ],
            [
                'name' => 'Anguilla',
                'code' => 'AI',
                'currency_code' => 'XCD',
            ],
            [
                'name' => 'Antarctica',
                'code' => 'AQ',
                'currency_code' => 'AAD',
            ],
            [
                'name' => 'Antigua and Barbuda',
                'code' => 'AG',
                'currency_code' => 'XCD',
            ],
            [
                'name' => 'Argentina',
                'code' => 'AR',
                'currency_code' => 'ARS',
            ],
            [
                'name' => 'Armenia',
                'code' => 'AM',
                'currency_code' => 'AMD',
            ],
            [
                'name' => 'Aruba',
                'code' => 'AW',
                'currency_code' => 'AWG',
            ],
            [
                'name' => 'Australia',
                'code' => 'AU',
                'currency_code' => 'AUD',
            ],
            [
                'name' => 'Austria',
                'code' => 'AT',
                'currency_code' => 'EUR',
            ],
            [
                'name' => 'Azerbaijan',
                'code' => 'AZ',
                'currency_code' => 'AZN',
            ],
            [
                'name' => 'Bahamas',
                'code' => 'BS',
                'currency_code' => 'BSD',
            ],
            [
                'name' => 'Bahrain',
                'code' => 'BH',
                'currency_code' => 'BHD',
            ],
            [
                'name' => 'Bangladesh',
                'code' => 'BD',
                'currency_code' => 'BDT',
            ],
            [
                'name' => 'Barbados',
                'code' => 'BB',
                'currency_code' => 'BBD',
            ],
            [
                'name' => 'Belarus',
                'code' => 'BY',
                'currency_code' => 'BYN',
            ],
            [
                'name' => 'Belgium',
                'code' => 'BE',
                'currency_code' => 'EUR',
            ],
            [
                'name' => 'Belize',
                'code' => 'BZ',
                'currency_code' => 'BZD',
            ],
            [
                'name' => 'Benin',
                'code' => 'BJ',
                'currency_code' => 'XOF',
            ],
            [
                'name' => 'Bermuda',
                'code' => 'BM',
                'currency_code' => 'BMD',
            ],
            [
                'name' => 'Bhutan',
                'code' => 'BT',
                'currency_code' => 'BTN',
            ],
            [
                'name' => 'Bolivia (Plurinational State of)',
                'code' => 'BO',
                'currency_code' => 'BOB',
            ],
            [
                'name' => 'Bosnia and Herzegovina',
                'code' => 'BA',
                'currency_code' => 'BAM',
            ],
            [
                'name' => 'Botswana',
                'code' => 'BW',
                'currency_code' => 'BWP',
            ],
            [
                'name' => 'Bouvet Island',
                'code' => 'BV',
                'currency_code' => 'NOK',
            ],
            [
                'name' => 'Brazil',
                'code' => 'BR',
                'currency_code' => 'BRL',
            ],
            [
                'name' => 'British Indian Ocean Territory',
                'code' => 'IO',
                'currency_code' => 'USD',
            ],
            [
                'name' => 'Brunei Darussalam',
                'code' => 'BN',
                'currency_code' => 'BND',
            ],
            [
                'name' => 'Bulgaria',
                'code' => 'BG',
                'currency_code' => 'BGN',
            ],
            [
                'name' => 'Burkina Faso',
                'code' => 'BF',
                'currency_code' => 'XOF',
            ],
            [
                'name' => 'Burundi',
                'code' => 'BI',
                'currency_code' => 'BIF',
            ],
            [
                'name' => 'Cabo Verde',
                'code' => 'CV',
                'currency_code' => 'CVE',
            ],
            [
                'name' => 'Cambodia',
                'code' => 'KH',
                'currency_code' => 'KHR',
            ],
            [
                'name' => 'Cameroon',
                'code' => 'CM',
                'currency_code' => 'XAF',
            ],
            [
                'name' => 'Canada',
                'code' => 'CA',
                'currency_code' => 'CAD',
            ],
            [
                'name' => 'Caribbean Netherlands',
                'code' => 'BQ',
                'currency_code' => 'USD',
            ],
            [
                'name' => 'Cayman Islands',
                'code' => 'KY',
                'currency_code' => 'KYD',
            ],
            [
                'name' => 'Central African Republic',
                'code' => 'CF',
                'currency_code' => 'XAF',
            ],
            [
                'name' => 'Chad',
                'code' => 'TD',
                'currency_code' => 'XAF',
            ],
            [
                'name' => 'Chile',
                'code' => 'CL',
                'currency_code' => 'CLP',
            ],
            [
                'name' => 'China',
                'code' => 'CN',
                'currency_code' => 'CNY',
            ],
            [
                'name' => 'Christmas Island',
                'code' => 'CX',
                'currency_code' => 'AUD',
            ],
            [
                'name' => 'Cocos (Keeling) Islands',
                'code' => 'CC',
                'currency_code' => 'AUD',
            ],
            [
                'name' => 'Colombia',
                'code' => 'CO',
                'currency_code' => 'COP',
            ],
            [
                'name' => 'Comoros',
                'code' => 'KM',
                'currency_code' => 'KMF',
            ],
            [
                'name' => 'Congo',
                'code' => 'CG',
                'currency_code' => 'XAF',
            ],
            [
                'name' => 'Congo, Democratic Republic of the',
                'code' => 'CD',
                'currency_code' => 'CDF',
            ],
            [
                'name' => 'Cook Islands',
                'code' => 'CK',
                'currency_code' => 'NZD',
            ],
            [
                'name' => 'Costa Rica',
                'code' => 'CR',
                'currency_code' => 'CRC',
            ],
            [
                'name' => 'Croatia',
                'code' => 'HR',
                'currency_code' => 'HRK',
            ],
            [
                'name' => 'Cuba',
                'code' => 'CU',
                'currency_code' => 'CUP',
            ],
            [
                'name' => 'Curaçao',
                'code' => 'CW',
                'currency_code' => 'ANG',
            ],
            [
                'name' => 'Cyprus',
                'code' => 'CY',
                'currency_code' => 'EUR',
            ],
            [
                'name' => 'Czech Republic',
                'code' => 'CZ',
                'currency_code' => 'CZK',
            ],
            [
                'name' => "Côte d'Ivoire",
                'code' => 'CI',
                'currency_code' => 'XOF',
            ],
            [
                'name' => 'Denmark',
                'code' => 'DK',
                'currency_code' => 'DKK',
            ],
            [
                'name' => 'Djibouti',
                'code' => 'DJ',
                'currency_code' => 'DJF',
            ],
            [
                'name' => 'Dominica',
                'code' => 'DM',
                'currency_code' => 'XCD',
            ],
            [
                'name' => 'Dominican Republic',
                'code' => 'DO',
                'currency_code' => 'DOP',
            ],
            [
                'name' => 'Ecuador',
                'code' => 'EC',
                'currency_code' => 'USD',
            ],
            [
                'name' => 'Egypt',
                'code' => 'EG',
                'currency_code' => 'EGP',
            ],
            [
                'name' => 'El Salvador',
                'code' => 'SV',
                'currency_code' => 'USD',
            ],
            [
                'name' => 'Equatorial Guinea',
                'code' => 'GQ',
                'currency_code' => 'XAF',
            ],
            [
                'name' => 'Eritrea',
                'code' => 'ER',
                'currency_code' => 'ERN',
            ],
            [
                'name' => 'Estonia',
                'code' => 'EE',
                'currency_code' => 'EUR',
            ],
            [
                'name' => 'Eswatini (Swaziland)',
                'code' => 'SZ',
                'currency_code' => 'SZL',
            ],
            [
                'name' => 'Ethiopia',
                'code' => 'ET',
                'currency_code' => 'ETB',
            ],
            [
                'name' => 'Falkland Islands (Malvinas)',
                'code' => 'FK',
                'currency_code' => 'FKP',
            ],
            [
                'name' => 'Faroe Islands',
                'code' => 'FO',
                'currency_code' => 'DKK',
            ],
            [
                'name' => 'Fiji',
                'code' => 'FJ',
                'currency_code' => 'FJD',
            ],
            [
                'name' => 'Finland',
                'code' => 'FI',
                'currency_code' => 'EUR',
            ],
            [
                'name' => 'France',
                'code' => 'FR',
                'currency_code' => 'EUR',
            ],
            [
                'name' => 'French Guiana',
                'code' => 'GF',
                'currency_code' => 'EUR',
            ],
            [
                'name' => 'French Polynesia',
                'code' => 'PF',
                'currency_code' => 'XPF',
            ],
            [
                'name' => 'French Southern Territories',
                'code' => 'TF',
                'currency_code' => 'EUR',
            ],
            [
                'name' => 'Gabon',
                'code' => 'GA',
                'currency_code' => 'XAF',
            ],
            [
                'name' => 'Gambia',
                'code' => 'GM',
                'currency_code' => 'GMD',
            ],
            [
                'name' => 'Georgia',
                'code' => 'GE',
                'currency_code' => 'GEL',
            ],
            [
                'name' => 'Germany',
                'code' => 'DE',
                'currency_code' => 'EUR',
            ],
            [
                'name' => 'Ghana',
                'code' => 'GH',
                'currency_code' => 'GHS',
            ],
            [
                'name' => 'Gibraltar',
                'code' => 'GI',
                'currency_code' => 'GIP',
            ],
            [
                'name' => 'Greece',
                'code' => 'GR',
                'currency_code' => 'EUR',
            ],
            [
                'name' => 'Greenland',
                'code' => 'GL',
                'currency_code' => 'DKK',
            ],
            [
                'name' => 'Grenada',
                'code' => 'GD',
                'currency_code' => 'XCD',
            ],
            [
                'name' => 'Guadeloupe',
                'code' => 'GP',
                'currency_code' => 'EUR',
            ],
            [
                'name' => 'Guam',
                'code' => 'GU',
                'currency_code' => 'USD',
            ],
            [
                'name' => 'Guatemala',
                'code' => 'GT',
                'currency_code' => 'GTQ',
            ],
            [
                'name' => 'Guernsey',
                'code' => 'GG',
                'currency_code' => 'GBP',
            ],
            [
                'name' => 'Guinea',
                'code' => 'GN',
                'currency_code' => 'GNF',
            ],
            [
                'name' => 'Guinea-Bissau',
                'code' => 'GW',
                'currency_code' => 'XOF',
            ],
            [
                'name' => 'Guyana',
                'code' => 'GY',
                'currency_code' => 'GYD',
            ],
            [
                'name' => 'Haiti',
                'code' => 'HT',
                'currency_code' => 'HTG',
            ],
            [
                'name' => 'Heard Island and Mcdonald Islands',
                'code' => 'HM',
                'currency_code' => 'AUD',
            ],
            [
                'name' => 'Honduras',
                'code' => 'HN',
                'currency_code' => 'HNL',
            ],
            [
                'name' => 'Hong Kong',
                'code' => 'HK',
                'currency_code' => 'HKD',
            ],
            [
                'name' => 'Hungary',
                'code' => 'HU',
                'currency_code' => 'HUF',
            ],
            [
                'name' => 'Iceland',
                'code' => 'IS',
                'currency_code' => 'ISK',
            ],
            [
                'name' => 'India',
                'code' => 'IN',
                'currency_code' => 'INR',
            ],
            [
                'name' => 'Indonesia',
                'code' => 'ID',
                'currency_code' => 'IDR',
            ],
            [
                'name' => 'Iran',
                'code' => 'IR',
                'currency_code' => 'IRR',
            ],
            [
                'name' => 'Iraq',
                'code' => 'IQ',
                'currency_code' => 'IQD',
            ],
            [
                'name' => 'Ireland',
                'code' => 'IE',
                'currency_code' => 'EUR',
            ],
            [
                'name' => 'Isle of Man',
                'code' => 'IM',
                'currency_code' => 'GBP',
            ],
            [
                'name' => 'Israel',
                'code' => 'IL',
                'currency_code' => 'ILS',
            ],
            [
                'name' => 'Italy',
                'code' => 'IT',
                'currency_code' => 'EUR',
            ],
            [
                'name' => 'Jamaica',
                'code' => 'JM',
                'currency_code' => 'JMD',
            ],
            [
                'name' => 'Japan',
                'code' => 'JP',
                'currency_code' => 'JPY',
            ],
            [
                'name' => 'Jersey',
                'code' => 'JE',
                'currency_code' => 'GBP',
            ],
            [
                'name' => 'Jordan',
                'code' => 'JO',
                'currency_code' => 'JOD',
            ],
            [
                'name' => 'Kazakhstan',
                'code' => 'KZ',
                'currency_code' => 'KZT',
            ],
            [
                'name' => 'Kenya',
                'code' => 'KE',
                'currency_code' => 'KES',
            ],
            [
                'name' => 'Kiribati',
                'code' => 'KI',
                'currency_code' => 'AUD',
            ],
            [
                'name' => 'Korea, North',
                'code' => 'KP',
                'currency_code' => 'KPW',
            ],
            [
                'name' => 'Korea, South',
                'code' => 'KR',
                'currency_code' => 'KRW',
            ],
            [
                'name' => 'Kosovo',
                'code' => 'XK',
                'currency_code' => 'EUR',
            ],
            [
                'name' => 'Kuwait',
                'code' => 'KW',
                'currency_code' => 'KWD',
            ],
            [
                'name' => 'Kyrgyzstan',
                'code' => 'KG',
                'currency_code' => 'KGS',
            ],
            [
                'name' => "Lao People's Democratic Republic",
                'code' => 'LA',
                'currency_code' => 'LAK',
            ],
            [
                'name' => 'Latvia',
                'code' => 'LV',
                'currency_code' => 'EUR',
            ],
            [
                'name' => 'Lebanon',
                'code' => 'LB',
                'currency_code' => 'LBP',
            ],
            [
                'name' => 'Lesotho',
                'code' => 'LS',
                'currency_code' => 'LSL',
            ],
            [
                'name' => 'Liberia',
                'code' => 'LR',
                'currency_code' => 'LRD',
            ],
            [
                'name' => 'Libya',
                'code' => 'LY',
                'currency_code' => 'LYD',
            ],
            [
                'name' => 'Liechtenstein',
                'code' => 'LI',
                'currency_code' => 'CHF',
            ],
            [
                'name' => 'Lithuania',
                'code' => 'LT',
                'currency_code' => 'EUR',
            ],
            [
                'name' => 'Luxembourg',
                'code' => 'LU',
                'currency_code' => 'EUR',
            ],
            [
                'name' => 'Macao',
                'code' => 'MO',
                'currency_code' => 'MOP',
            ],
            [
                'name' => 'Macedonia North',
                'code' => 'MK',
                'currency_code' => 'MKD',
            ],
            [
                'name' => 'Madagascar',
                'code' => 'MG',
                'currency_code' => 'MGA',
            ],
            [
                'name' => 'Malawi',
                'code' => 'MW',
                'currency_code' => 'MWK',
            ],
            [
                'name' => 'Malaysia',
                'code' => 'MY',
                'currency_code' => 'MYR',
            ],
            [
                'name' => 'Maldives',
                'code' => 'MV',
                'currency_code' => 'MVR',
            ],
            [
                'name' => 'Mali',
                'code' => 'ML',
                'currency_code' => 'XOF',
            ],
            [
                'name' => 'Malta',
                'code' => 'MT',
                'currency_code' => 'EUR',
            ],
            [
                'name' => 'Marshall Islands',
                'code' => 'MH',
                'currency_code' => 'USD',
            ],
            [
                'name' => 'Martinique',
                'code' => 'MQ',
                'currency_code' => 'EUR',
            ],
            [
                'name' => 'Mauritania',
                'code' => 'MR',
                'currency_code' => 'MRO',
            ],
            [
                'name' => 'Mauritius',
                'code' => 'MU',
                'currency_code' => 'MUR',
            ],
            [
                'name' => 'Mayotte',
                'code' => 'YT',
                'currency_code' => 'EUR',
            ],
            [
                'name' => 'Mexico',
                'code' => 'MX',
                'currency_code' => 'MXN',
            ],
            [
                'name' => 'Micronesia',
                'code' => 'FM',
                'currency_code' => 'USD',
            ],
            [
                'name' => 'Moldova',
                'code' => 'MD',
                'currency_code' => 'MDL',
            ],
            [
                'name' => 'Monaco',
                'code' => 'MC',
                'currency_code' => 'EUR',
            ],
            [
                'name' => 'Mongolia',
                'code' => 'MN',
                'currency_code' => 'MNT',
            ],
            [
                'name' => 'Montenegro',
                'code' => 'ME',
                'currency_code' => 'EUR',
            ],
            [
                'name' => 'Montserrat',
                'code' => 'MS',
                'currency_code' => 'XCD',
            ],
            [
                'name' => 'Morocco',
                'code' => 'MA',
                'currency_code' => 'MAD',
            ],
            [
                'name' => 'Mozambique',
                'code' => 'MZ',
                'currency_code' => 'MZN',
            ],
            [
                'name' => 'Myanmar (Burma)',
                'code' => 'MM',
                'currency_code' => 'MMK',
            ],
            [
                'name' => 'Namibia',
                'code' => 'NA',
                'currency_code' => 'NAD',
            ],
            [
                'name' => 'Nauru',
                'code' => 'NR',
                'currency_code' => 'AUD',
            ],
            [
                'name' => 'Nepal',
                'code' => 'NP',
                'currency_code' => 'NPR',
            ],
            [
                'name' => 'Netherlands',
                'code' => 'NL',
                'currency_code' => 'EUR',
            ],
            [
                'name' => 'Netherlands Antilles',
                'code' => 'AN',
                'currency_code' => 'ANG',
            ],
            [
                'name' => 'New Caledonia',
                'code' => 'NC',
                'currency_code' => 'XPF',
            ],
            [
                'name' => 'New Zealand',
                'code' => 'NZ',
                'currency_code' => 'NZD',
            ],
            [
                'name' => 'Nicaragua',
                'code' => 'NI',
                'currency_code' => 'NIO',
            ],
            [
                'name' => 'Niger',
                'code' => 'NE',
                'currency_code' => 'XOF',
            ],
            [
                'name' => 'Nigeria',
                'code' => 'NG',
                'currency_code' => 'NGN',
            ],
            [
                'name' => 'Niue',
                'code' => 'NU',
                'currency_code' => 'NZD',
            ],
            [
                'name' => 'Norfolk Island',
                'code' => 'NF',
                'currency_code' => 'AUD',
            ],
            [
                'name' => 'Northern Mariana Islands',
                'code' => 'MP',
                'currency_code' => 'USD',
            ],
            [
                'name' => 'Norway',
                'code' => 'NO',
                'currency_code' => 'NOK',
            ],
            [
                'name' => 'Oman',
                'code' => 'OM',
                'currency_code' => 'OMR',
            ],
            [
                'name' => 'Pakistan',
                'code' => 'PK',
                'currency_code' => 'PKR',
            ],
            [
                'name' => 'Palau',
                'code' => 'PW',
                'currency_code' => 'USD',
            ],
            [
                'name' => 'Palestine',
                'code' => 'PS',
                'currency_code' => 'ILS',
            ],
            [
                'name' => 'Panama',
                'code' => 'PA',
                'currency_code' => 'PAB',
            ],
            [
                'name' => 'Papua New Guinea',
                'code' => 'PG',
                'currency_code' => 'PGK',
            ],
            [
                'name' => 'Paraguay',
                'code' => 'PY',
                'currency_code' => 'PYG',
            ],
            [
                'name' => 'Peru',
                'code' => 'PE',
                'currency_code' => 'PEN',
            ],
            [
                'name' => 'Philippines',
                'code' => 'PH',
                'currency_code' => 'PHP',
            ],
            [
                'name' => 'Pitcairn Islands',
                'code' => 'PN',
                'currency_code' => 'NZD',
            ],
            [
                'name' => 'Poland',
                'code' => 'PL',
                'currency_code' => 'PLN',
            ],
            [
                'name' => 'Portugal',
                'code' => 'PT',
                'currency_code' => 'EUR',
            ],
            [
                'name' => 'Puerto Rico',
                'code' => 'PR',
                'currency_code' => 'USD',
            ],
            [
                'name' => 'Qatar',
                'code' => 'QA',
                'currency_code' => 'QAR',
            ],
            [
                'name' => 'Reunion',
                'code' => 'RE',
                'currency_code' => 'EUR',
            ],
            [
                'name' => 'Romania',
                'code' => 'RO',
                'currency_code' => 'RON',
            ],
            [
                'name' => 'Russian Federation',
                'code' => 'RU',
                'currency_code' => 'RUB',
            ],
            [
                'name' => 'Rwanda',
                'code' => 'RW',
                'currency_code' => 'RWF',
            ],
            [
                'name' => 'Saint Barthelemy',
                'code' => 'BL',
                'currency_code' => 'EUR',
            ],
            [
                'name' => 'Saint Helena',
                'code' => 'SH',
                'currency_code' => 'SHP',
            ],
            [
                'name' => 'Saint Kitts and Nevis',
                'code' => 'KN',
                'currency_code' => 'XCD',
            ],
            [
                'name' => 'Saint Lucia',
                'code' => 'LC',
                'currency_code' => 'XCD',
            ],
            [
                'name' => 'Saint Martin',
                'code' => 'MF',
                'currency_code' => 'EUR',
            ],
            [
                'name' => 'Saint Pierre and Miquelon',
                'code' => 'PM',
                'currency_code' => 'EUR',
            ],
            [
                'name' => 'Saint Vincent and the Grenadines',
                'code' => 'VC',
                'currency_code' => 'XCD',
            ],
            [
                'name' => 'Samoa',
                'code' => 'WS',
                'currency_code' => 'WST',
            ],
            [
                'name' => 'San Marino',
                'code' => 'SM',
                'currency_code' => 'EUR',
            ],
            [
                'name' => 'Sao Tome and Principe',
                'code' => 'ST',
                'currency_code' => 'STD',
            ],
            [
                'name' => 'Saudi Arabia',
                'code' => 'SA',
                'currency_code' => 'SAR',
            ],
            [
                'name' => 'Senegal',
                'code' => 'SN',
                'currency_code' => 'XOF',
            ],
            [
                'name' => 'Serbia',
                'code' => 'RS',
                'currency_code' => 'RSD',
            ],
            [
                'name' => 'Serbia and Montenegro',
                'code' => 'CS',
                'currency_code' => 'RSD',
            ],
            [
                'name' => 'Seychelles',
                'code' => 'SC',
                'currency_code' => 'SCR',
            ],
            [
                'name' => 'Sierra Leone',
                'code' => 'SL',
                'currency_code' => 'SLL',
            ],
            [
                'name' => 'Singapore',
                'code' => 'SG',
                'currency_code' => 'SGD',
            ],
            [
                'name' => 'Sint Maarten',
                'code' => 'SX',
                'currency_code' => 'ANG',
            ],
            [
                'name' => 'Slovakia',
                'code' => 'SK',
                'currency_code' => 'EUR',
            ],
            [
                'name' => 'Slovenia',
                'code' => 'SI',
                'currency_code' => 'EUR',
            ],
            [
                'name' => 'Solomon Islands',
                'code' => 'SB',
                'currency_code' => 'SBD',
            ],
            [
                'name' => 'Somalia',
                'code' => 'SO',
                'currency_code' => 'SOS',
            ],
            [
                'name' => 'South Africa',
                'code' => 'ZA',
                'currency_code' => 'ZAR',
            ],
            [
                'name' => 'South Georgia and the South Sandwich Islands',
                'code' => 'GS',
                'currency_code' => 'GBP',
            ],
            [
                'name' => 'South Sudan',
                'code' => 'SS',
                'currency_code' => 'SSP',
            ],
            [
                'name' => 'Spain',
                'code' => 'ES',
                'currency_code' => 'EUR',
            ],
            [
                'name' => 'Sri Lanka',
                'code' => 'LK',
                'currency_code' => 'LKR',
            ],
            [
                'name' => 'Sudan',
                'code' => 'SD',
                'currency_code' => 'SDG',
            ],
            [
                'name' => 'Suriname',
                'code' => 'SR',
                'currency_code' => 'SRD',
            ],
            [
                'name' => 'Svalbard and Jan Mayen',
                'code' => 'SJ',
                'currency_code' => 'NOK',
            ],
            [
                'name' => 'Sweden',
                'code' => 'SE',
                'currency_code' => 'SEK',
            ],
            [
                'name' => 'Switzerland',
                'code' => 'CH',
                'currency_code' => 'CHF',
            ],
            [
                'name' => 'Syria',
                'code' => 'SY',
                'currency_code' => 'SYP',
            ],
            [
                'name' => 'Taiwan',
                'code' => 'TW',
                'currency_code' => 'TWD',
            ],
            [
                'name' => 'Tajikistan',
                'code' => 'TJ',
                'currency_code' => 'TJS',
            ],
            [
                'name' => 'Tanzania',
                'code' => 'TZ',
                'currency_code' => 'TZS',
            ],
            [
                'name' => 'Thailand',
                'code' => 'TH',
                'currency_code' => 'THB',
            ],
            [
                'name' => 'Timor-Leste',
                'code' => 'TL',
                'currency_code' => 'USD',
            ],
            [
                'name' => 'Togo',
                'code' => 'TG',
                'currency_code' => 'XOF',
            ],
            [
                'name' => 'Tokelau',
                'code' => 'TK',
                'currency_code' => 'NZD',
            ],
            [
                'name' => 'Tonga',
                'code' => 'TO',
                'currency_code' => 'TOP',
            ],
            [
                'name' => 'Trinidad and Tobago',
                'code' => 'TT',
                'currency_code' => 'TTD',
            ],
            [
                'name' => 'Tunisia',
                'code' => 'TN',
                'currency_code' => 'TND',
            ],
            [
                'name' => 'Turkey (Türkiye)',
                'code' => 'TR',
                'currency_code' => 'TRY',
            ],
            [
                'name' => 'Turkmenistan',
                'code' => 'TM',
                'currency_code' => 'TMT',
            ],
            [
                'name' => 'Turks and Caicos Islands',
                'code' => 'TC',
                'currency_code' => 'USD',
            ],
            [
                'name' => 'Tuvalu',
                'code' => 'TV',
                'currency_code' => 'AUD',
            ],
            [
                'name' => 'U.S. Outlying Islands',
                'code' => 'UM',
                'currency_code' => 'USD',
            ],
            [
                'name' => 'Uganda',
                'code' => 'UG',
                'currency_code' => 'UGX',
            ],
            [
                'name' => 'Ukraine',
                'code' => 'UA',
                'currency_code' => 'UAH',
            ],
            [
                'name' => 'United Arab Emirates',
                'code' => 'AE',
                'currency_code' => 'AED',
            ],
            [
                'name' => 'United Kingdom',
                'code' => 'GB',
                'currency_code' => 'GBP',
            ],
            [
                'name' => 'United States',
                'code' => 'US',
                'currency_code' => 'USD',
            ],
            [
                'name' => 'Uruguay',
                'code' => 'UY',
                'currency_code' => 'UYU',
            ],
            [
                'name' => 'Uzbekistan',
                'code' => 'UZ',
                'currency_code' => 'UZS',
            ],
            [
                'name' => 'Vanuatu',
                'code' => 'VU',
                'currency_code' => 'VUV',
            ],
            [
                'name' => 'Vatican City Holy See',
                'code' => 'VA',
                'currency_code' => 'EUR',
            ],
            [
                'name' => 'Venezuela',
                'code' => 'VE',
                'currency_code' => 'VEF',
            ],
            [
                'name' => 'Vietnam',
                'code' => 'VN',
                'currency_code' => 'VND',
            ],
            [
                'name' => 'Virgin Islands, British',
                'code' => 'VG',
                'currency_code' => 'USD',
            ],
            [
                'name' => 'Virgin Islands, U.S',
                'code' => 'VI',
                'currency_code' => 'USD',
            ],
            [
                'name' => 'Wallis and Futuna',
                'code' => 'WF',
                'currency_code' => 'XPF',
            ],
            [
                'name' => 'Western Sahara',
                'code' => 'EH',
                'currency_code' => 'MAD',
            ],
            [
                'name' => 'Yemen',
                'code' => 'YE',
                'currency_code' => 'YER',
            ],
            [
                'name' => 'Zambia',
                'code' => 'ZM',
                'currency_code' => 'ZMW',
            ],
            [
                'name' => 'Zimbabwe',
                'code' => 'ZW',
                'currency_code' => 'ZWL',
            ],
        ];

        foreach ($countries as $country) {
            Country::create([
                'common_name'    => $country['name'] ?? 'Unknown',
                'official_name'  => $country['name'] ?? 'Unknown',
                'country_code'   => $country['code'] ?? 'N/A',
                'currency_code'  => $country['currency_code'] ?? 'N/A',
            ]);
        }
    }

    /**
     * Install currencies for the company.
     *
     *
     */
    private function installCurrencies(): void
    {
        $currencies = [
            // North Africa
            ['currency_name' => 'Algerian Dinar', 'code' => 'DZD', 'symbol' => 'د.ج', 'thousand_separator' => '.', 'decimal_separator' => ',', 'symbol_position' => 'suffix'],
            ['currency_name' => 'Egyptian Pound', 'code' => 'EGP', 'symbol' => '£', 'thousand_separator' => ',', 'decimal_separator' => '.', 'symbol_position' => 'prefix'],
            ['currency_name' => 'Libyan Dinar', 'code' => 'LYD', 'symbol' => 'ل.د', 'thousand_separator' => '.', 'decimal_separator' => ',', 'symbol_position' => 'suffix'],
            ['currency_name' => 'Moroccan Dirham', 'code' => 'MAD', 'symbol' => 'د.م.', 'thousand_separator' => '.', 'decimal_separator' => ',', 'symbol_position' => 'suffix'],
            ['currency_name' => 'Tunisian Dinar', 'code' => 'TND', 'symbol' => 'د.ت', 'thousand_separator' => '.', 'decimal_separator' => ',', 'symbol_position' => 'suffix'],

            // West Africa
            ['currency_name' => 'West African CFA Franc', 'code' => 'XOF', 'symbol' => 'CFA', 'thousand_separator' => '.', 'decimal_separator' => ',', 'symbol_position' => 'suffix'],
            ['currency_name' => 'Nigerian Naira', 'code' => 'NGN', 'symbol' => '₦', 'thousand_separator' => ',', 'decimal_separator' => '.', 'symbol_position' => 'prefix'],
            ['currency_name' => 'Ghanaian Cedi', 'code' => 'GHS', 'symbol' => 'GH₵', 'thousand_separator' => ',', 'decimal_separator' => '.', 'symbol_position' => 'prefix'],

            // Central Africa
            ['currency_name' => 'Central African CFA Franc', 'code' => 'XAF', 'symbol' => 'FCFA', 'thousand_separator' => '.', 'decimal_separator' => ',', 'symbol_position' => 'suffix'],
            ['currency_name' => 'Congolese Franc', 'code' => 'CDF', 'symbol' => 'FC', 'thousand_separator' => '.', 'decimal_separator' => ',', 'symbol_position' => 'suffix'],
            ['currency_name' => 'Rwandan Franc', 'code' => 'RWF', 'symbol' => 'RF', 'thousand_separator' => '.', 'decimal_separator' => ',', 'symbol_position' => 'suffix'],

            // East Africa
            ['currency_name' => 'Kenyan Shilling', 'code' => 'KES', 'symbol' => 'KSh', 'thousand_separator' => ',', 'decimal_separator' => '.', 'symbol_position' => 'prefix'],
            ['currency_name' => 'Ugandan Shilling', 'code' => 'UGX', 'symbol' => 'USh', 'thousand_separator' => ',', 'decimal_separator' => '.', 'symbol_position' => 'prefix'],
            ['currency_name' => 'Rwandan Franc', 'code' => 'RWF', 'symbol' => 'RF', 'thousand_separator' => '.', 'decimal_separator' => ',', 'symbol_position' => 'suffix'],

            // Southern Africa
            ['currency_name' => 'Botswana Pula', 'code' => 'BWP', 'symbol' => 'P', 'thousand_separator' => ',', 'decimal_separator' => '.', 'symbol_position' => 'prefix'],
            ['currency_name' => 'South African Rand', 'code' => 'ZAR', 'symbol' => 'R', 'thousand_separator' => ',', 'decimal_separator' => '.', 'symbol_position' => 'prefix'],
            ['currency_name' => 'Namibian Dollar', 'code' => 'NAD', 'symbol' => '$', 'thousand_separator' => ',', 'decimal_separator' => '.', 'symbol_position' => 'prefix'],

            // Eurozone - Use Euro
            ['currency_name' => 'Euro', 'code' => 'EUR', 'symbol' => '€', 'thousand_separator' => '.', 'decimal_separator' => ',', 'symbol_position' => 'prefix'],

            // Northern Europe
            ['currency_name' => 'Danish Krone', 'code' => 'DKK', 'symbol' => 'kr.', 'thousand_separator' => '.', 'decimal_separator' => ',', 'symbol_position' => 'suffix'],
            ['currency_name' => 'Norwegian Krone', 'code' => 'NOK', 'symbol' => 'kr', 'thousand_separator' => ' ', 'decimal_separator' => ',', 'symbol_position' => 'suffix'],
            ['currency_name' => 'Swedish Krona', 'code' => 'SEK', 'symbol' => 'kr', 'thousand_separator' => ' ', 'decimal_separator' => ',', 'symbol_position' => 'suffix'],
            ['currency_name' => 'British Pound Sterling', 'code' => 'GBP', 'symbol' => '£', 'thousand_separator' => ',', 'decimal_separator' => '.', 'symbol_position' => 'prefix'],

            // Eastern Europe
            ['currency_name' => 'Polish Zloty', 'code' => 'PLN', 'symbol' => 'zł', 'thousand_separator' => ' ', 'decimal_separator' => ',', 'symbol_position' => 'suffix'],
            ['currency_name' => 'Hungarian Forint', 'code' => 'HUF', 'symbol' => 'Ft', 'thousand_separator' => ' ', 'decimal_separator' => ',', 'symbol_position' => 'suffix'],
            ['currency_name' => 'Romanian Leu', 'code' => 'RON', 'symbol' => 'lei', 'thousand_separator' => '.', 'decimal_separator' => ',', 'symbol_position' => 'suffix'],
            ['currency_name' => 'Bulgarian Lev', 'code' => 'BGN', 'symbol' => 'лв.', 'thousand_separator' => ' ', 'decimal_separator' => ',', 'symbol_position' => 'suffix'],
            ['currency_name' => 'Russian Ruble', 'code' => 'RUB', 'symbol' => '₽', 'thousand_separator' => ' ', 'decimal_separator' => ',', 'symbol_position' => 'suffix'],

            // Southern Europe
            ['currency_name' => 'Turkish Lira', 'code' => 'TRY', 'symbol' => '₺', 'thousand_separator' => '.', 'decimal_separator' => ',', 'symbol_position' => 'prefix'],
            ['currency_name' => 'Swiss Franc', 'code' => 'CHF', 'symbol' => 'CHF', 'thousand_separator' => '\'', 'decimal_separator' => '.', 'symbol_position' => 'prefix'],

            // Western Europe (outside Eurozone)
            ['currency_name' => 'Icelandic Krona', 'code' => 'ISK', 'symbol' => 'kr', 'thousand_separator' => '.', 'decimal_separator' => ',', 'symbol_position' => 'suffix'],
            ['currency_name' => 'Croatian Kuna', 'code' => 'HRK', 'symbol' => 'kn', 'thousand_separator' => '.', 'decimal_separator' => ',', 'symbol_position' => 'suffix'],

            // Far East
            ['currency_name' => 'Japanese Yen', 'code' => 'JPY', 'symbol' => '¥', 'thousand_separator' => ',', 'decimal_separator' => '.', 'symbol_position' => 'prefix'],
            ['currency_name' => 'South Korean Won', 'code' => 'KRW', 'symbol' => '₩', 'thousand_separator' => ',', 'decimal_separator' => '.', 'symbol_position' => 'prefix'],
            ['currency_name' => 'Chinese Yuan', 'code' => 'CNY', 'symbol' => '¥', 'thousand_separator' => ',', 'decimal_separator' => '.', 'symbol_position' => 'prefix'],
            ['currency_name' => 'Hong Kong Dollar', 'code' => 'HKD', 'symbol' => '$', 'thousand_separator' => ',', 'decimal_separator' => '.', 'symbol_position' => 'prefix'],
            ['currency_name' => 'Taiwan Dollar', 'code' => 'TWD', 'symbol' => 'NT$', 'thousand_separator' => ',', 'decimal_separator' => '.', 'symbol_position' => 'prefix'],

            // Southeast Asia
            ['currency_name' => 'Thai Baht', 'code' => 'THB', 'symbol' => '฿', 'thousand_separator' => ',', 'decimal_separator' => '.', 'symbol_position' => 'prefix'],
            ['currency_name' => 'Singapore Dollar', 'code' => 'SGD', 'symbol' => '$', 'thousand_separator' => ',', 'decimal_separator' => '.', 'symbol_position' => 'prefix'],
            ['currency_name' => 'Malaysian Ringgit', 'code' => 'MYR', 'symbol' => 'RM', 'thousand_separator' => ',', 'decimal_separator' => '.', 'symbol_position' => 'prefix'],
            ['currency_name' => 'Indonesian Rupiah', 'code' => 'IDR', 'symbol' => 'Rp', 'thousand_separator' => '.', 'decimal_separator' => ',', 'symbol_position' => 'prefix'],
            ['currency_name' => 'Philippine Peso', 'code' => 'PHP', 'symbol' => '₱', 'thousand_separator' => ',', 'decimal_separator' => '.', 'symbol_position' => 'prefix'],

            // South Asia
            ['currency_name' => 'Indian Rupee', 'code' => 'INR', 'symbol' => '₹', 'thousand_separator' => ',', 'decimal_separator' => '.', 'symbol_position' => 'prefix'],
            ['currency_name' => 'Pakistani Rupee', 'code' => 'PKR', 'symbol' => '₨', 'thousand_separator' => ',', 'decimal_separator' => '.', 'symbol_position' => 'prefix'],
            ['currency_name' => 'Bangladeshi Taka', 'code' => 'BDT', 'symbol' => '৳', 'thousand_separator' => ',', 'decimal_separator' => '.', 'symbol_position' => 'prefix'],
            ['currency_name' => 'Sri Lankan Rupee', 'code' => 'LKR', 'symbol' => 'Rs', 'thousand_separator' => ',', 'decimal_separator' => '.', 'symbol_position' => 'prefix'],
            ['currency_name' => 'Afghan Afghani', 'code' => 'AFN', 'symbol' => '؋', 'thousand_separator' => ',', 'decimal_separator' => '.', 'symbol_position' => 'prefix'],

            // North America
            ['currency_name' => 'US Dollar', 'code' => 'USD', 'symbol' => '$', 'thousand_separator' => ',', 'decimal_separator' => '.', 'symbol_position' => 'prefix'],
            ['currency_name' => 'Canadian Dollar', 'code' => 'CAD', 'symbol' => '$', 'thousand_separator' => ',', 'decimal_separator' => '.', 'symbol_position' => 'prefix'],
            ['currency_name' => 'Mexican Peso', 'code' => 'MXN', 'symbol' => '$', 'thousand_separator' => ',', 'decimal_separator' => '.', 'symbol_position' => 'prefix'],

            // Central America
            ['currency_name' => 'Guatemalan Quetzal', 'code' => 'GTQ', 'symbol' => 'Q', 'thousand_separator' => ',', 'decimal_separator' => '.', 'symbol_position' => 'prefix'],
            ['currency_name' => 'Honduran Lempira', 'code' => 'HNL', 'symbol' => 'L', 'thousand_separator' => ',', 'decimal_separator' => '.', 'symbol_position' => 'prefix'],
            ['currency_name' => 'Nicaraguan Cordoba', 'code' => 'NIO', 'symbol' => 'C$', 'thousand_separator' => ',', 'decimal_separator' => '.', 'symbol_position' => 'prefix'],
            ['currency_name' => 'Panamanian Balboa', 'code' => 'PAB', 'symbol' => 'B/.', 'thousand_separator' => ',', 'decimal_separator' => '.', 'symbol_position' => 'prefix'],
            ['currency_name' => 'Belize Dollar', 'code' => 'BZD', 'symbol' => 'BZ$', 'thousand_separator' => ',', 'decimal_separator' => '.', 'symbol_position' => 'prefix'],

            // South America
            ['currency_name' => 'Brazilian Real', 'code' => 'BRL', 'symbol' => 'R$', 'thousand_separator' => '.', 'decimal_separator' => ',', 'symbol_position' => 'prefix'],
            ['currency_name' => 'Argentine Peso', 'code' => 'ARS', 'symbol' => '$', 'thousand_separator' => '.', 'decimal_separator' => ',', 'symbol_position' => 'prefix'],
            ['currency_name' => 'Colombian Peso', 'code' => 'COP', 'symbol' => '$', 'thousand_separator' => '.', 'decimal_separator' => ',', 'symbol_position' => 'prefix'],
            ['currency_name' => 'Peruvian Sol', 'code' => 'PEN', 'symbol' => 'S/.', 'thousand_separator' => ',', 'decimal_separator' => '.', 'symbol_position' => 'prefix'],
            ['currency_name' => 'Venezuelan Bolivar', 'code' => 'VES', 'symbol' => 'Bs.', 'thousand_separator' => '.', 'decimal_separator' => ',', 'symbol_position' => 'prefix'],
            ['currency_name' => 'Uruguayan Peso', 'code' => 'UYU', 'symbol' => '$', 'thousand_separator' => '.', 'decimal_separator' => ',', 'symbol_position' => 'prefix'],
            ['currency_name' => 'Chilean Peso', 'code' => 'CLP', 'symbol' => '$', 'thousand_separator' => '.', 'decimal_separator' => ',', 'symbol_position' => 'prefix'],

            // Caribbean
            ['currency_name' => 'East Caribbean Dollar', 'code' => 'XCD', 'symbol' => '$', 'thousand_separator' => ',', 'decimal_separator' => '.', 'symbol_position' => 'prefix'],
            ['currency_name' => 'Haitian Gourde', 'code' => 'HTG', 'symbol' => 'G', 'thousand_separator' => ',', 'decimal_separator' => '.', 'symbol_position' => 'prefix'],
            ['currency_name' => 'Jamaican Dollar', 'code' => 'JMD', 'symbol' => 'J$', 'thousand_separator' => ',', 'decimal_separator' => '.', 'symbol_position' => 'prefix']
        ];

        foreach ($currencies as $currency) {
            Currency::create($currency);
        }
    }

    /**
     * Install units of measure for the company.
     *
     *
     */
    public function installLanguages() : void
    {
        $languages = [
            ['name' => 'English (US)', 'icon' => 'us', 'locale_code' => 'en_US', 'iso_code' => 'en', 'url_code' => 'en', 'direction' => 'left_to_right', 'separator_format' => '[3,0]', 'decimal_separator' => '.', 'thousand_separator' => ',', 'first_day' => 'sunday', 'is_active' => true, 'is_reference' => true],
            ['name' => 'French / Français', 'icon' => 'fr', 'locale_code' => 'fr_FR', 'iso_code' => 'fr', 'url_code' => 'fr', 'direction' => 'left_to_right', 'separator_format' => '[3,0]', 'decimal_separator' => ',', 'thousand_separator' => '.', 'first_day' => 'monday', 'is_active' => false],
            ['name' => 'Swahili / Kiswahili', 'icon' => '', 'locale_code' => 'sw', 'iso_code' => 'sw', 'url_code' => 'sw', 'direction' => 'left_to_right', 'separator_format' => '[3,0]', 'decimal_separator' => '.', 'thousand_separator' => ',', 'first_day' => 'monday', 'is_active' => false],
            ['name' => 'Hindi / हिंदी', 'icon' => '', 'locale_code' => 'hi_IN', 'iso_code' => 'hi', 'url_code' => 'hi', 'direction' => 'left_to_right', 'separator_format' => '[]', 'decimal_separator' => '.', 'thousand_separator' => ',', 'first_day' => 'sunday', 'is_active' => false],
            ['name' => 'Arabic / الْعَرَبيّة', 'icon' => 'sa', 'locale_code' => 'ar_AR', 'iso_code' => 'ar', 'url_code' => 'ar', 'direction' => 'right_to_left', 'separator_format' => '[3,0]', 'decimal_separator' => '.', 'thousand_separator' => ',', 'first_day' => 'saturday', 'is_active' => false],
            // ['name' => 'Japanese / 日本語', 'icon' => 'jp', 'locale_code' => 'ja_JP', 'iso_code' => 'ja', 'url_code' => 'ja', 'direction' => 'left_to_right', 'separator_format' => '[3,0]', 'decimal_separator' => '.', 'thousand_separator' => ',', 'first_day' => 'sunday', 'is_active' => false],
            // ['name' => 'Russian / русский язык', 'icon' => 'ru', 'locale_code' => 'ru_RU', 'iso_code' => 'ru', 'url_code' => 'ru', 'direction' => 'left_to_right', 'separator_format' => '[3,0]', 'decimal_separator' => ',', 'thousand_separator' => '', 'first_day' => 'monday', 'is_active' => false],
            // Add other languages similarly
        ];

        foreach ($languages as $language) {
            Language::create( $language);
        }

    }

}

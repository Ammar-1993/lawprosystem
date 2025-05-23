<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Config;
use Session;
use App\Model\GeneralSettings;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        

        try {
            DB::connection()->getPdo();
            if (\Schema::hasTable('mailsetups')) {

                $mail = DB::table('mailsetups')->first();
                // dd( $mail );

                if ($mail) //checking if table is not empty
                {
                    $config = array(
                        'driver'     => 'SMTP',
                        'host'       => $mail->mail_host,
                        'port'       => $mail->mail_port,
                        'from'       => array(
                            'address' => $mail->mail_username,
                            'name' => "Advocate"
                        ),
                        'encryption' => $mail->mail_encryption,
                        'username'   => $mail->mail_username,
                        'password'   => $mail->mail_password
                        // 'bcc'        => $mail->bcc_mail
                    );
                    Config::set('mail', $config);
                    // dd(config());
                }
            }
            //set timezone
            if (\Schema::hasTable('general_settings') && \Schema::hasTable('zone')) {

                $time = DB::table('general_settings')->first()->timezone;
                $timezone = DB::table('zone')->where('zone_id', $time)->first()->zone_name;
                // dd( $timezone);
                config::set(['app.timezone' => $timezone]);
                date_default_timezone_set($timezone);
            }
        } catch (\Exception $e) {
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('admin.*', function ($view) {


            if (auth()->guard('admin')->check()) {
                $data['adminHasPermition'] = auth()->guard('admin')->user();
            }



            $date_formet  = GeneralSettings::findOrfail(1)->date_formet;

            if ($date_formet == 1) {
                $date1 = "dd-mm-yyyy";
                $date2 = "d-m-Y";
            } elseif ($date_formet == 2) {
                $date1 = "yyyy-mm-dd";
                $date2 = "Y-m-d";
            } elseif ($date_formet == 3) {
                $date1 = "mm-dd-yyyy";
                $date2 = "m-d-Y";
            }
            // dd( $date);

            $data['date_format_datepiker'] = $date1;
            $data['date_format_laravel'] = $date2;

            $data['image_logo']  = GeneralSettings::findOrfail(1)->first();



            $view->with($data);
        });
    }
}

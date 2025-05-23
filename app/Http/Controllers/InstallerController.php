<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Artisan;
use App\Admin;
use App\Model\GeneralSettings;
use Config;


class InstallerController extends Controller
{
    public function index()
    {
        return view('installer.welcome');
    }
    public function requirements()
    {
        return view('installer.requirements');
    }
    public function install()
    {
        return view('installer.installer');
    }
    /**
     * Calls the method 
     */
    public function runInstaller(Request $request)
    {
        @ini_set('max_execution_time', 0);
        // Test database connection
        $servername = $request->db_host; // "localhost";
        $username = $request->db_username; //"username";
        $password = ($request->db_password != null) ? $request->db_password : ''; //"password";
        $db_database = $request->db_database; //"password";
        $port = $request->db_port; //"password";
        $app_name = $request->app_name; //"password";
        $app_url = $request->app_url; //"password";

        // Create connection

        try {
            // env var val
            $env_update = $this->changeEnv([
                'DB_HOST'       => $servername,
                'DB_USERNAME'   => $username,
                'DB_PASSWORD'   => $password,
                'DB_DATABASE'   => $db_database,
                'DB_PORT'       => $port,
                'APP_NAME'       => '"' . $app_name . '"',
                'APP_URL'       => $app_url,
            ]);

            Config::set("database.connections.mysql", [
                "host" => "$servername",
                "database" => "$db_database",
                "username" => "$username",
                "password" => "$password"
            ]);

            if ($env_update) {

                $impSuccess = $this->importSqlFile($servername, $username, $password, $db_database);

                if ($impSuccess) {
                    // Create connection
                    $conn = mysqli_connect($servername, $username, $password, $db_database);
                    // Check connection
                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }

                    $sql = "INSERT INTO admins (name, email, password,created_at,user_type)
                    VALUES ('" . $request->user_name . "', '" . $request->user_email . "', '" . bcrypt($request->user_pwd) . "','" . date('Y-m-d H:i:s') . "','Admin')";

                    if (mysqli_query($conn, $sql)) {

                        $sqlRole = "INSERT INTO admin_role (admin_id, role_id)
                    VALUES (1, 1)";
                        mysqli_query($conn, $sqlRole);
                        return redirect()->route('install.success');
                    } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }

                    mysqli_close($conn);
                }
            } else {
                dd('Update Fail');
            }
        } catch (\Exception $e) {
            print_r($e->getMessage());
            die("Connection failed: " . mysqli_connect_error());
        }
    }
    public function successInstall()
    {
        \Artisan::call('storage:link');
        unlink(base_path() . '/routes/web.php');
        rename(base_path() . '/routes/web-sample.php', base_path() . '/routes/web.php');

        return view('installer.success');
    }
    protected function importSqlFile($dbHost, $dbUsername, $dbPassword, $dbName)
    {

        $sqlPath = base_path() . '/public/upload/law_off.sql';

        $db = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);
        if (mysqli_connect_error()) {
            die("Connection Error.");
        } else {
            // Temporary variable, used to store current query
            $templine = '';

            // Read in entire file
            $lines = file($sqlPath);

            $error = '';

            // Loop through each line
            foreach ($lines as $line) {
                // Skip it if it's a comment
                if (substr($line, 0, 2) == '--' || $line == '') {
                    continue;
                }

                // Add this line to the current segment
                $templine .= $line;

                // If it has a semicolon at the end, it's the end of the query
                if (substr(trim($line), -1, 1) == ';') {
                    // Perform the query
                    if (!mysqli_query($db, $templine)) {
                        $error .= 'Error performing query "<b>' . $templine . '</b>": ' . $db->error . '<br /><br />';
                    }

                    // Reset temp variable to empty
                    $templine = '';
                }
            }
            return !empty($error) ? $error : true;
        }
    }
    protected function changeEnv($data = array())
    {
        if (count($data) > 0) {

            // Read .env-file
            $env = file_get_contents(base_path() . '/.env');

            // Split string on every " " and write into array
            $env = preg_split('/\s+/', $env);;

            // Loop through given data
            foreach ((array)$data as $key => $value) {

                // Loop through .env-data
                foreach ($env as $env_key => $env_value) {

                    // Turn the value into an array and stop after the first split
                    // So it's not possible to split e.g. the App-Key by accident
                    $entry = explode("=", $env_value, 2);

                    // Check, if new key fits the actual .env-key
                    if ($entry[0] == $key) {
                        // If yes, overwrite it with the new one
                        $env[$env_key] = $key . "=" . $value;
                    } else {
                        // If not, keep the old one
                        $env[$env_key] = $env_value;
                    }
                }
            }

            // Turn the array back to an String
            $env = implode("\n", $env);

            // And overwrite the .env with the new data
            file_put_contents(base_path() . '/.env', $env);

            return true;
        } else {
            return false;
        }
    }
}

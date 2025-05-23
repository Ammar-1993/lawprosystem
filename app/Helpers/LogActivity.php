<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Request;
use App\LogActivity as LogActivityModel;

use App\Model\CourtCase;
use App\Model\AdvocateClient;
use App\Model\Appointment;
use App\Admin;
use App\Model\CaseType;
use App\Model\GeneralSettings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ActivityNotification;
use Carbon\Carbon;


class LogActivity
{

	 public static function commonDateFromat($data) {
	 			 $date_format_type  = GeneralSettings::findOrfail(1)->date_formet; 

			 	if($date_format_type=="3"){
			 	  	$string = str_replace("-", "/", $data);
			 	  	$string = date('Y-m-d',strtotime($string));
			 	}else{
			 	  	$string = date('Y-m-d',strtotime($data));
			 	}
   			 return $string;
	 }

	  public static function commonDateFromatType() {
	  		$date_formet  = GeneralSettings::findOrfail(1)->date_formet; 

		         if($date_formet==1){
		            $date2="d-m-Y";
		         }elseif($date_formet==2){
		             $date2="Y-m-d";
		         }elseif($date_formet==3){
		              $date2="m-d-Y";
		         }

		   return $date2;            
	 			
	 }

	   public static function commonDateFromatTypeCustome() {
	  		$date_formet  = GeneralSettings::findOrfail(1)->date_formet; 

		         if($date_formet==1){
		            $date2="dS M Y"; 
		         }elseif($date_formet==2){
		             $date2="Y M dS";
		         }elseif($date_formet==3){
		              $date2="M Y dS";
		         }

		   return $date2;            
	 			
	 }

	 
	  public static function commonDateFromatTypeCustome1() {
	  		$date_formet  = GeneralSettings::findOrfail(1)->date_formet; 

		         if($date_formet==1){
		            $date2="dS F Y"; 
		         }elseif($date_formet==2){
		             $date2="Y F dS";
		         }elseif($date_formet==3){
		              $date2="F Y dS";
		         }

		   return $date2;            
	 			
	 }


 public static function CheckuserType() {

         $user  = Auth::guard('admin')->user();
         $data['id']=$user->id;
         $data['type']=$user->user_type;
         return $data;
       
	 			
	 }



    public static function addToLog($subject,$activity,$redirect_url)
    {
		if(Auth::guard('admin')->user())
        {
            $id     = Auth::guard('admin')->user()->id;
            $name   = Auth::guard('admin')->user($id);
           
            $userName       =  $name->first_name.' '.$name->last_name;
            $user_id        = $id;
			if($name->is_user_type=='ADVOCATE'){
				$advocate_id    = $name->id;
			}else{
				$advocate_id    = $name->advocate_id;
			}
            
        }else{
            $user_id    = 0;
            $userName  = '';
            $advocate_id    = 0;
        }   
        
    	$log = [];
        $log['advocate_id'] = $advocate_id;
    	$log['subject']     = $subject;
        $log['activity']    = $activity;
    	$log['url']         = Request::fullUrl();
        $log['redirect_url']= $redirect_url;
    	$log['method']      = Request::method();
    	$log['ip']          = Request::ip();
    	$log['agent']       = Request::header('user-agent');
    	$log['user_id']     = $user_id;
        $log['user_name']   = $userName;
		
    	LogActivityModel::create($log);
    }
     public static function getLoginUserId() {

        if(Auth::guard('admin')->user())
        {
			$type = Auth::guard('admin')->user();
			// if($type->is_user_type=='STAFF')
   //          {
   //              return $type->advocate_id;		
   //          }else{
				return $type->id;	
			// }
            
           
        // }elseif(Auth::guard('superadmin')->user()){
        //     return 0;
        // }
			}
    }
    public static function getLoginUserType()
    {
    	if(Auth::guard('admin')->user())
        {
            $type = Auth::guard('admin')->user();
            if($type->is_user_type=='ADVOCATE')
            {
                return 'ADVOCATE';	
            }elseif($type->is_user_type=='STAFF')
            {
                return 'STAFF';	
            }
        }
    }
    public static function getNotifications(){
        $user_id = static::getLoginUserId();
		
		$user = Admin::find($user_id);
        // $court_cases = CourtCase::where('next_date', '=', date('Y-m-d'))->where('advocate_id', $user_id)->where('is_nb', 'No')->count();
        $court_cases = CourtCase::where('next_date', '=', date('Y-m-d'))->where('is_nb', 'No')->count();
		 
        $notify = $user->unreadNotifications;
		$countNotification = 0;
		if (count($notify) > 0)
        {
			foreach($notify as $notification)
            {
				if(!empty($notification->data['appointment_date'])){
					if(date('Y-m-d',strtotime($notification->data['appointment_date']))==date('Y-m-d')){
						$countNotification++;
					}
				}
			}
		}
		$noRecMsg ='';
		if($court_cases > 0 && $countNotification > 0){
			$notifyCount = $countNotification+$court_cases;
		}elseif($court_cases > 0 && $countNotification == 0){
			$notifyCount = $court_cases;
		}elseif($court_cases == 0 && $countNotification > 0){
			$notifyCount = $countNotification;
		}else{
			$notifyCount ='';
			$noRecMsg .='<li>
							<a href="javascript:void(0);">
								<div class="mesge">
									<i class="fa fa-info fa-fw"></i> You dont`t have any notification
								</div>
							</a>
						</li>';
		}
		//if ($court_cases > 0){$caseCount = $court_cases;}else{$court_cases = '';}
		//if (count($notify) > 0){$notifyCount = count($notify)+$caseCount;}else{$notifyCount = '';}
        $html = '<li class="dropdown dropdown-alerts">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span><i class="fa fa-bell-o"></i>
						<span class="label label-warning">'.$notifyCount.'</span>
					</a>';
		
		$html .='<ul id="login-dp" class="dropdown-menu flt-mesege">';
		if($court_cases>0){
			$html .='<li>
						<a href="'.url('admin/dashboard').'">
							<div class="mesge">
							<i class="fa fa-gavel"></i> You have '.$court_cases.' case(s) today							</div>
						</a>
					</li>';
		}
		if (count($notify) > 0)
        {
			//$html .='<li class="header">You have '.count($notify).' notification(s)</li>';
			foreach($notify as $notification)
            {
				if(!empty($notification->data['appointment_date'])){
					if(date('Y-m-d',strtotime($notification->data['appointment_date']))==date('Y-m-d')){
						$html .='<li>
									<a data-href="'.$notification->data['url'].'" data-notif-id="'.$notification->id.'">
										<div class="mesge">
											'.$notification->data['icon'].' You have '.$notification->data['title'].' With '.$notification->data['name'].'
										</div>
									</a>
								</li>';
					}
				}
			}			
			/*$html .='<li>
						<a href="#">
							<div class="text-center link-block">
								<strong>View All Notifications </strong> &nbsp; <i class="fa fa-angle-right"></i>
							</div>
						</a>

					</li>';*/
		}else{
			$html .=$noRecMsg;
		}		
		$html .='	</ul>
		</li>';
        return $html;  
    }
    public static function getAdvocateClientFullName($id)
    {
        $row = AdvocateClient::where('id',$id)->first();
        return $row->first_name.' '.$row->last_name;	
    }
    public static function generateTasks()
    {
      
    /*  if (!$security->isUserExpired())
      {*/
  
        // $advocate_id = static::getLoginUserId();
		 // $court_cases = CourtCase::where('next_date', '<', date('Y-m-d'))->where('advocate_id', $advocate_id)->where('is_nb', 'No')->get();
      	$court_cases = CourtCase::where('next_date', '<', date('Y-m-d'))->where('is_nb', 'No')->get();
         
		 if (count($court_cases) > 0){$caseCount = count($court_cases);}else{$caseCount = '';}
        
		 $html = '<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span><i class="fa fa-tasks"></i>
				<span class="label label-primary">'.$caseCount.'</span>
			</a>';
		
		$html .='<ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">';
		if (count($court_cases) > 0)
        {
			foreach($court_cases as $court_case)
            {
			$name = static::getAdvocateClientFullName($court_case->advo_client_id); 
			$caseType = CaseType::select('case_type_name')->where('id',$court_case->case_types)->first();
			 
			$html .='<li>
						<a href="'.url('admin/case-running/'.$court_case->id).'">
							<div class="mesge">
								<i class="fa fa-user"></i> '.$name.'&nbsp;'.$caseType->case_type_name.'/'.$court_case->registration_number.'
							</div>
						</a>
					</li>';
			}	
			$html .='<li>
						<a href="'.url('admin/case-running/').'">
							<div class="text-center link-block">
								<strong>View All Task </strong> &nbsp; <i class="fa fa-angle-right"></i>
							</div>
						</a>

					</li>';
		}else{
			$html .='<li>
				<a href="javascript:void(0);">
					<div class="mesge">
						<i class="fa fa-info fa-fw"></i> You dont`t have pending case(s)
					</div>
				</a>
			</li>';
		}		
		$html .='	</ul>
		</li>';
        
        return $html;  
    }
	public static function getTrialDaysRemaining()
    {
		$user_id = static::getLoginUserId();
        $row = Admin::findorfail($user_id);
		if($row->is_user_type=='ADVOCATE'){
			
			$expires_at = Carbon::parse($row->expires_at);
			$now = Carbon::now('Asia/Kolkata')->toDateString();

			$diff = $expires_at->diffInDays($now);
			
			$btn = '<a href="'.url('admin/packages').'" class="btn btn-info" style="border-radius: 0;margin-left: 38px;background: #308bd2;border-color: #308bd2;">
					Upgrade
					</a>';
			if($row->current_package=='trial')
			{
				return '<p class="with_background">You have <span class="big">'.$diff.'</span> days left in your trial '.$btn.'</p>';
				
			}else
			{
				if($diff<=7){
					return '<p class="with_background">You have <span class="big">'.$diff.'</span> days left in your plan '.$btn.'</p>';
				}
				
			}
		}
    }
	public static function moneyFormatIndia($number) {
		$explrestunits = "" ;
		if($number<0){
			$added = '-';
			$num = abs($number);
		}else{
			$added = '';
			$num = $number;
		}
		if(strlen($num)>3) {
			$lastthree = substr($num, strlen($num)-3, strlen($num));
			$restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
			$restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
			$expunit = str_split($restunits, 2);
			for($i=0; $i<sizeof($expunit); $i++) {
				// creates each of the 2's group and adds a comma to the end
				if($i==0) {
					$explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
				} else {
					$explrestunits .= $expunit[$i].",";
				}
			}
			$thecash = $explrestunits.$lastthree;
		} else {
			$thecash = $num;
		}
		return $added.$thecash; // writes the final format where $currency is the currency symbol.
	}


	    public static function getTaskStatusList()
    {
        $taskArr = array(
            'not_started' => 'Not Started',
            'in_progress' => 'In Progress',
            'completed' => 'Completed',
            'deferred' => 'Deferred',
            // 'waiting_for_someone' => 'Waiting For Someone',
        );
        return $taskArr;
    }

    public static function getTaskPriorityList()
    {
        $taskPriorityArr = array(
            'low' => 'Low',
            'medium' => 'Medium',
            'high' => 'High',
            'urgent' => 'Urgent',
        );
        return $taskPriorityArr;
    }

    public static function getTicketPriority()
    {
        return [
            'low' => 'Low',
            'medium' => 'Medium',
            'high' => 'High',
            'urgent' => 'Urgent',
        ];
    }

}
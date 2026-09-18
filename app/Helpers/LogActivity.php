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
		 
        $notify = $user ? $user->unreadNotifications : [];
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
		$noRecMsg ='<li class="lp-empty-item">
						<div class="lp-empty-state">
							<i class="fa fa-bell-slash-o"></i>
							<span>'.__('frontend.no_notifications').'</span>
						</div>
					</li>';
		if($court_cases > 0 && $countNotification > 0){
			$notifyCount = $countNotification+$court_cases;
		}elseif($court_cases > 0 && $countNotification == 0){
			$notifyCount = $court_cases;
		}elseif($court_cases == 0 && $countNotification > 0){
			$notifyCount = $countNotification;
		}else{
			$notifyCount ='';
		}
        $html = '<li class="dropdown dropdown-alerts lp-nav-item">
					<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" title="'.__('frontend.notifications').'">
						<i class="fa fa-bell-o"></i>'.($notifyCount ? '<span class="label label-warning">'.$notifyCount.'</span>' : '').'
					</a>';
		
		$html .='<ul id="login-dp" class="dropdown-menu flt-mesege lp-dropdown-menu lp-notifications-dropdown" role="menu">';
		$html .='<li class="lp-dropdown-header">
					<span class="lp-dropdown-title"><i class="fa fa-bell"></i> '.__('frontend.notifications').'</span>
					'.($notifyCount ? '<span class="lp-dropdown-badge">'.$notifyCount.'</span>' : '').'
				 </li>';
		
		$html .='<div class="lp-dropdown-scroll">';
		if($court_cases>0){
			$html .='<li>
						<a href="'.url('admin/dashboard').'" class="lp-dropdown-item">
							<div class="lp-item-icon lp-icon-gavel">
								<i class="fa fa-gavel"></i>
							</div>
							<div class="lp-item-content">
								<div class="lp-item-title">'.__('frontend.cases_today', ['count' => $court_cases]).'</div>
								<div class="lp-item-subtitle">'.date('Y-m-d').'</div>
							</div>
						</a>
					</li>';
		}
		if (count($notify) > 0)
        {
			foreach($notify as $notification)
            {
				if(!empty($notification->data['appointment_date'])){
					if(date('Y-m-d',strtotime($notification->data['appointment_date']))==date('Y-m-d')){
						$icon = !empty($notification->data['icon']) ? $notification->data['icon'] : '<i class="fa fa-calendar"></i>';
						$html .='<li>
									<a data-href="'.($notification->data['url'] ?? '#').'" data-notif-id="'.$notification->id.'" class="lp-dropdown-item">
										<div class="lp-item-icon lp-icon-calendar">
											'.$icon.'
										</div>
										<div class="lp-item-content">
											<div class="lp-item-title">'.($notification->data['title'] ?? '').'</div>
											<div class="lp-item-subtitle">'.($notification->data['name'] ?? '').' &bull; '.date('Y-m-d', strtotime($notification->data['appointment_date'])).'</div>
										</div>
									</a>
								</li>';
					}
				}
			}			
		}elseif($court_cases == 0){
			$html .=$noRecMsg;
		}		
		$html .='</div>'; // close lp-dropdown-scroll
		$html .='<li class="lp-dropdown-footer">
					<a href="'.url('admin/dashboard').'" class="lp-footer-link">
						<span>'.__('frontend.view_all_notifications').'</span>
						<i class="fa fa-angle-left lp-rtl-flip"></i>
					</a>
				 </li>';
		$html .='</ul></li>';
        return $html;  
    }
    public static function getAdvocateClientFullName($id)
    {
        $row = AdvocateClient::where('id',$id)->first();
        return $row ? ($row->first_name.' '.$row->last_name) : '';	
    }
    public static function generateTasks()
    {
      	$court_cases = CourtCase::where('next_date', '<', date('Y-m-d'))->where('is_nb', 'No')->get();
         
		if (count($court_cases) > 0){$caseCount = count($court_cases);}else{$caseCount = '';}
        
		$html = '<li class="dropdown lp-tasks-item lp-nav-item">
			<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" title="'.__('frontend.pending_cases').'">
				<i class="fa fa-tasks"></i>'.($caseCount ? '<span class="label label-primary">'.$caseCount.'</span>' : '').'
			</a>';
		
		$html .='<ul id="menu1" class="dropdown-menu list-unstyled msg_list lp-dropdown-menu lp-tasks-dropdown" role="menu">';
		$html .='<li class="lp-dropdown-header">
					<span class="lp-dropdown-title"><i class="fa fa-tasks"></i> '.__('frontend.pending_cases').'</span>
					'.($caseCount ? '<span class="lp-dropdown-badge">'.$caseCount.'</span>' : '').'
				 </li>';
		
		$html .='<div class="lp-dropdown-scroll">';
		if (count($court_cases) > 0)
        {
			foreach($court_cases as $court_case)
            {
				$name = static::getAdvocateClientFullName($court_case->advo_client_id); 
				$caseType = CaseType::select('case_type_name')->where('id',$court_case->case_types)->first();
				$caseTypeName = $caseType ? $caseType->case_type_name : '';
				$regNumber = $court_case->registration_number;
				 
				$html .='<li>
							<a href="'.url('admin/case-running/'.$court_case->id).'" class="lp-dropdown-item">
								<div class="lp-item-icon lp-icon-case">
									<i class="fa fa-briefcase"></i>
								</div>
								<div class="lp-item-content">
									<div class="lp-item-title">'.$name.'</div>
									<div class="lp-item-subtitle">
										<span class="lp-case-type">'.$caseTypeName.'</span>
										<span class="lp-case-reg">#'.$regNumber.'</span>
									</div>
								</div>
							</a>
						</li>';
			}	
		}else{
			$html .='<li class="lp-empty-item">
						<div class="lp-empty-state">
							<i class="fa fa-check-circle-o"></i>
							<span>'.__('frontend.no_pending_cases').'</span>
						</div>
					</li>';
		}		
		$html .='</div>'; // close lp-dropdown-scroll
		$html .='<li class="lp-dropdown-footer">
					<a href="'.url('admin/case-running/').'" class="lp-footer-link">
						<span>'.__('frontend.view_all_tasks').'</span>
						<i class="fa fa-angle-left lp-rtl-flip"></i>
					</a>
				 </li>';
		$html .='</ul></li>';
        
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
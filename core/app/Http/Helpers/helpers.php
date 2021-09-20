<?php
   
    function getWorkingDays($startDate, $endDate)
    {        
        $begin = strtotime($startDate)+86400;
        $end   = strtotime($endDate);
        if ($begin > $end) 
        {
            // echo "startdate is in the future! <br />";
            return 0;
        } 
        else 
        {
            $no_days  = 0;
            $weekends = 0;
            while ($begin <= $end) 
            {
                $no_days++; // no of days in the given interval      
                $what_day = date("N", $begin);
                if ($what_day > 5) { // 6 and 7 are weekend days
                   $weekends++;
                   // echo $what_day;
                };               
                $begin += 86400;   // +1 day                 
            };
            $working_days = $no_days - $weekends;
            return $working_days;
        }
    }
    
    function getDays($startDate, $endDate)
    {        
        $begin = strtotime($startDate)+86400;
        $end   = strtotime($endDate);
        if ($begin > $end) 
        {
            // echo "startdate is in the future! <br />";
            return 0;
        } 
        else 
        {
            $no_days  = 0;
            $weekends = 0;
            while ($begin <= $end) 
            {
                $no_days++; // no of days in the given interval      
                $what_day = date("N", $begin);
                if ($what_day > 5) { // 6 and 7 are weekend days
                   $weekends++;
                   // echo $what_day;
                };               
                $begin += 86400;   // +1 day                 
            };
            // $working_days = $no_days - $weekends;
            return $no_days;
        }
    }

    function search_user()
    {

        $v = Session::get('val');
        $users_table = App\kyc::where('username', 'like', '%'.$v.'%')->orderby('id', 'desc')->paginate(100);
        Session::forget('val');
        return $users_table;
        
    }

    function search_deposit()
    {

        if(Session::has('val'))
        {
            $v = Session::get('val');
            $deps = App\deposits::where('user_id', 'like', '%'.$v.'%')->orwhere('usn', 'like', '%'.$v.'%')->orwhere('amount', 'like', '%'.$v.'%')->orwhere('bank', 'like', '%'.$v.'%')->orwhere('account_no', 'like', '%'.$v.'%')->orwhere('account_name', 'like', '%'.$v.'%')->orwhere('status', 'like', '%'.$v.'%')->orwhere('created_at', 'like', '%'.$v.'%')->orderby('id', 'desc')->paginate(100);
            Session::forget('val');
        }
        else
        {
            $deps = App\deposits::orderby('id', 'desc')->paginate(50);
        }
        return $deps;
        
    }

    function search_pack()
    {

        if(Session::has('val'))
        {
            $v = Session::get('val');
            $packs = App\packages::where('user_id', $v)->orwhere('amount', $v)->orwhere('bank', $v)->orwhere('account_no', $v)->orwhere('account_name', $v)->orwhere('status', $v)->orwhere('created_at', 'like', '%'.$v.'%')->orderby('id', 'asc')->paginate(100);
            Session::forget('val');
        }
        else
        {
            $packs = App\packages::orderby('id', 'asc')->paginate(100);
        }
        return $packs;
        
    }

    function search_adm()
    {

        if(Session::has('val'))
        {
            $v = Session::get('val');
            $adm_users = App\admin::where('id', $v)->orwhere('email', $v)->orwhere('name', $v)->orwhere('role', $v)->orwhere('status', $v)->orwhere('created_at', 'like', '%'.$v.'%')->orderby('id', 'asc')->paginate(100);
            Session::forget('val');
        }
        else
        {
            $adm_users = App\admin::orderby('id', 'asc')->paginate(100);
        }
        return $adm_users;
        
    }

    function search_users()
    {

        if(Session::has('val'))
        {
            $v = Session::get('val');
            $users_table = App\User::where('id', $v)->orwhere('firstname', 'like', '%'.$v.'%')->orwhere('lastname', 'like', '%'.$v.'%')->orwhere('email', 'like', '%'.$v.'%')->orwhere('phone', 'like', '%'.$v.'%')->orwhere('status', 'like', '%'.$v.'%')->orwhere('username', 'like', '%'.$v.'%')->orwhere('created_at', 'like', '%'.$v.'%')->orderby('id', 'desc')->paginate(100);
            Session::forget('val');
        }
        else
        {
            $users_table = App\User::orderby('id', 'desc')->paginate(100);
        }
        return $users_table;
        
    }

    function search_withdrawal()
    {

        if(Session::has('val'))
        {
            $v = Session::get('val');
            $wd = App\withdrawal::where('user_id', 'like', '%'.$v.'%')->orwhere('usn', 'like', '%'.$v.'%')->orwhere('amount', 'like', '%'.$v.'%')->orwhere('status', 'like', '%'.$v.'%')->orwhere('created_at', 'like', '%'.$v.'%')->orwhere('account', 'like', '%'.$v.'%')->orderby('id', 'desc')->paginate(100);
            Session::forget('val');
        }
        else
        {
            $wd = App\withdrawal::orderby('id', 'desc')->paginate(100);
        }
        return $wd;
        
    }
        

    function user_details_data($id)
    {

        $adm = Session::get('adm');
        $adm = App\admin::find($adm->id);
        Session::put('adm', $adm);  

        // $users = App\User::orderby('id', 'desc')->get();
        $user = App\User::find($id);
        $inv = App\investment::orderby('id', 'desc')->get();
        $deposits = App\deposits::orderby('id', 'desc')->get();
        $wd = App\withdrawal::orderby('id', 'desc')->get();

        $today_wd = App\withdrawal::where('created_at','like','%'.date('Y-m-d').'%')->orderby('id', 'desc')->get();
        $today_dep = App\deposits::where('created_at','like','%'.date('Y-m-d').'%')->orderby('id', 'desc')->get();
        $today_inv = App\investment::where('date_invested', date('Y-m-d'))->orderby('id', 'desc')->get();
         
        $logs =  App\adminLog::orderby('id', 'desc')->get();
        $dt=$user->created_at;

        return ['user' => $user, 'dt' => $dt];
        
    }

    function get_ref_set()
    {
        $ref_set =  App\ref_set::all();
        return $ref_set;
    }
    
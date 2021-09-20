<?php
   
    public function cal_earn()
    {
        $totalEarning = 0;    
        $currentEarning = 0;
        $workingDays = 0;
             
        foreach($actInv as $inv)
        {
            $totalElapse = getDays(date('y-m-d'), $inv->end_date);
            if($totalElapse == 0)
            {
                $lastWD = $inv->last_wd;
                $enddate = ($inv->end_date);
                if($inv->package_id >= 5 && $inv->package_id <= 10)
                {
                  $getDays = getDays($lastWD, $enddate);
                  $currentEarning += $getDays*$inv->interest*$inv->capital;
                }
                else
                {
                  $workingDays = getWorkingDays($lastWD, $enddate);
                  $currentEarning += $workingDays*$inv->interest*$inv->capital;
                }
            }
            else
            {
                $sd = $inv->last_wd;
                $ed = date('Y-m-d');            
                if($inv->package_id >= 5 && $inv->package_id <= 10)
                {
                  $getDays = getDays($sd, $ed);
                  $currentEarning += $getDays*$inv->interest*$inv->capital;
                }
                else
                {
                  $workingDays = getWorkingDays($sd, $ed);
                  $currentEarning += $workingDays*$inv->interest*$inv->capital;
                }
            }
        }
    }

